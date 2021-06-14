<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_absen extends CI_Model
{
  private $response;
  protected $table = "`list_absen` la";
  protected $column_order = [NULL, "absen_id", "cabang_id", "absen_status", "absen_date", "absen_week"];
  protected $column_search = ["lu.`user_nama`"];
  protected $order = ["absen_id" => "ASC"];

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Jakarta");
    $this->response = new stdClass();
    $this->response->success = FALSE;
    $this->response->message = "Query failed";
  }

  public function create_absen_dummy()
  {
    $list_user = $this->db->get("list_user")->result();
    $week = $this->db->get("list_setting")->row()->week;
    $data = [];
    $i = 1;
    foreach ($list_user as $item) {
      $values = [
        "user_id" => $item->user_id,
        "absen_date" => date("Y-m-d H:i:s"),
        "absen_week" => $week,
        "absen_note" => "N/a"
      ];
      if ($i <= 200) {
        $values["absen_status_id"] = 1;
      } else if ($i > 200 && $i < 250) {
        $values["absen_status_id"] = 2;
      } else if ($i > 250 && $i < 275) {
        $values["absen_status_id"] = 3;
      } else {
        $values["absen_status_id"] = 4;
      }
      array_push($data, $values);
      $i++;
    }
    if (count($data) == 301) {
      $this->db->insert_batch("list_absen", $data);
    }
  }

  public function insert_absen($user_id = FALSE, $code = FALSE)
  {
    $is_absen = $this->get_setting()->is_absen;
    if ($is_absen == 1) {
      $pekan = $this->get_setting()->week;
      if ($user_id !== FALSE) {
        // Cek apakah dia sudah login atau belum
        $where = [
          "user_id" => $user_id,
          "absen_date" => date("Y-m-d")
        ];
        $query = $this->db->get_where("list_absen", $where);
        if ($query) {
          if ($query->num_rows() == 0) {
            $get_code = $this->get_code_absen($code);
            $cabang_id = $get_code->cabang_id != NULL ? $get_code->cabang_id : NULL;
            // var_dump($get_code);
            $data = [
              "user_id" => $user_id,
              "absen_status_id" => 1,
              "absen_date" => date("Y-m-d H:i"),
              "absen_week" => $pekan,
              "cabang_id" => $cabang_id
            ];
            $query2 = $this->db->insert("list_absen", $data);
            if ($query2) {
              $this->response->success = TRUE;
              $this->response->message = "Terima kasih, anda sudah absen!";
            } else {
              $this->response->message = "Query 2 failed!";
            }
          } else {
            $this->response->message = "Anda sudah melakukan absen!";
          }
        } else {
          $this->response->message = "Query failed!";
        }
      } else {
        $role_id = $this->session->role_id;
        $cabang_id = $this->session->cabang_id;
        $addtional_where_sql = "";
        if (($role_id == 5 || $role_id == 6) && $role_id != NULL) {
          $addtional_where_sql = "AND `cabang_id` = {$this->db->escape($cabang_id)}";
        }
        $now = date("Y-m-d");
        $except_sql = "(SELECT `user_id` FROM `list_absen` "
          .   "WHERE DATE(`absen_date`) = {$this->db->escape($now)})";
        $sql = "SELECT * FROM `list_user` "
          .  "WHERE `user_id` NOT IN ($except_sql) AND `kelas_id` != 1 $addtional_where_sql;";
        $query3 = $this->db->query($sql);
        if ($query3) {
          $data = [];
          $total = 0;
          foreach ($query3->result() as $item) {
            $values = [
              "user_id" => $item->user_id,
              "absen_status_id" => 4,
              "absen_date" => date("Y-m-d H:i"),
              "absen_week" => $pekan
            ];
            array_push($data, $values);
            $total++;
          }
          if (count($data) > 0) {
            $query4 = $this->db->insert_batch("list_absen", $data);
            if ($query4) {
              $this->response->success = TRUE;
              $this->response->message = "Sukses membuat absen! Ada $total siswa yang tidak masuk";
            } else {
              $this->response->message = "Query 4 failed!";
            }
          } else {
            $this->response->success = TRUE;
            $this->response->message = "Sukses membuat absen! Ada $total siswa yang tidak masuk!";
          }
        } else {
          $this->response->message = "Query 3 failed!";
        }
      }
    } else {
      $this->response->message = "Maaf, saat ini sistem tidak bisa membuat absen!";
    }
    return $this->response;
  }

  public function get_code_absen($code = FALSE)
  {
    $role_id = $this->session->role_id;
    if ($role_id <= 2 && $role_id != NULL) {
      $where = ["code_id" => 1];
    } else if (($role_id == 5 || $role_id == 6) && $role_id != NULL) {
      $where = ["cabang_id" => $this->session->cabang_id];
    }
    if ($code !== FALSE) {
      $where["code"] = $code;
    }
    $query = $this->db->get_where("list_code", $where);
    // var_dump($this->db->last_query());
    if ($query) {
      return $query->row();
    } else {
      return FALSE;
    }
  }

  public function generate_absen_code()
  {
    $code = 0;
    $generate = FALSE;
    do {
      $code = rand(0, 100000);
      $query = $this->db->get_where("list_code", ["code" => $code]);
      if ($query) {
        if ($query->num_rows() == 0) {
          $generate = TRUE;
        }
      } else {
        $this->response->success = 201;
        $this->response->message = "Query failed!";
        break;
      }
    } while ($generate === FALSE);

    if ($generate === TRUE) {
      $role_id = $this->session->role_id;
      if ($role_id <= 2) {
        $where = ["code_id" => 1];
      } else if ($role_id == 5 || $role_id == 6) {
        $where = ["cabang_id" => $this->session->cabang_id];
      }
      $query2 = $this->db->update("list_code", ["code" => $code], $where);
      if ($query2) {
        $this->response->success = 200;
        $this->response->message = "Berhasil generate code absen";
        $this->response->code = $this->get_code_absen();
      } else {
        $this->response->success = 201;
        $this->response->message = "Query 2 failed!";
      }
    }
    return $this->response;
  }

  public function query_absen()
  {
    $this->db->from($this->table)
      ->join("`list_user` lu", "lu.`user_id` = la.`user_id`")
      ->join("`list_kelas` lk", "lk.`kelas_id` = lu.`kelas_id`")
      ->join("`list_absen_status` las", "las.`absen_status_id` = la.`absen_status_id`")
      ->join("list_cabang lc", "lc.`cabang_id` = lu.`cabang_id`");
    $i = 1;

    foreach ($this->column_search as $item) {
      if ($_POST["search"]["value"]) {
        if ($i == 1) {
          $this->db->group_start();
          $this->db->like($item, $_POST["search"]["value"]);
        } else {
          $this->db->or_like($item, $_POST["search"]["value"]);
        }
        if (count($this->column_search) == $i) {
          $this->db->group_end();
        }
      }
      $i++;
    }

    if (isset($_POST["order"])) {
      $this->db->order_by($this->column_order[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function get_absen_listed($column = FALSE, $value = FALSE, $date)
  {
    $this->query_absen();
    if ($_POST["length"] != -1) {
      if ($value !== FALSE && is_int($value) && $value != 0) {
        $this->db->where($column, $value);
      }
      $where = "DATE(la.`absen_date`) BETWEEN {$this->db->escape($date->start)} AND {$this->db->escape($date->end)}";
      $this->db->where($where);
      if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
        $this->db->where("lu.`cabang_id`", $this->session->cabang_id);
      }
      $this->db->limit($_POST["length"], $_POST["start"]);
      $query = $this->db->get();
      return $query->result();
    }
  }

  public function count_absen_filtered($column = FALSE, $value = FALSE, $date)
  {
    $this->query_absen();
    if ($value !== FALSE && is_int($value) && $value != 0) {
      $this->db->where($column, $value);
    }
    $where = "DATE(la.`absen_date`) BETWEEN {$this->db->escape($date->start)} AND {$this->db->escape($date->end)}";
    $this->db->where($where);
    if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
      $this->db->where("lu.`cabang_id`", $this->session->cabang_id);
    }
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_absen_all($column = FALSE, $value = FALSE, $date)
  {
    $this->db->from($this->table)
            ->join("list_user lu", "lu.`user_id` = la.`user_id`");
    if ($value !== FALSE && is_int($value) && $value != 0) {
      $this->db->where($column, $value);
    }
    $where = "DATE(la.`absen_date`) BETWEEN {$this->db->escape($date->start)} AND {$this->db->escape($date->end)}";
    $this->db->where($where);
    if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
      $this->db->where("lu.`cabang_id`", $this->session->cabang_id);
    }
    return $this->db->count_all_results();
  }

  public function get_setting()
  {
    $query = $this->db->get("list_setting");
    if ($query) {
      return $query->row();
    } else {
      return FALSE;
    }
  }

  public function get_absen_status_listed()
  {
    return $this->db->get("list_absen_status")->result();
  }

  public function get_absen_detail($id)
  {
    $query = $this->db->select("la.*, lu.`user_nama`, lk.`kelas`")->from("list_absen la")
      ->join("list_user lu", "lu.`user_id` = la.`user_id`")
      ->join("list_kelas lk", "lk.`kelas_id` = lu.`kelas_id`")
      ->where("la.`absen_id`", $id)
      ->get();
    if ($query) {
      $siswa = $query->row()->user_nama;
      $kelas = $query->row()->kelas;
      $this->response->success = 200;
      $this->response->siswa = "$siswa - $kelas";
      $this->response->tanggal = date("d M Y", strtotime($query->row()->absen_date));
      $this->response->pekan = $query->row()->absen_week;
      $this->response->absen_status_id = $query->row()->absen_status_id;
      $this->response->reason = $query->row()->absen_note;
      $this->response->absen_id = $query->row()->absen_id;
    } else {
      $this->response->success = 201;
      $this->response->message = "Query failed!";
    }
    return $this->response;
  }

  public function edit_absen($input)
  {
    $data["absen_status_id"] = $input->absen_status_id;
    if ($input->absen_note != "") {
      $data["absen_note"] = $input->absen_note;
    }
    $where = ["absen_id" => $input->absen_id];
    $query = $this->db->update("list_absen", $data, $where);
    if ($query) {
      $this->response->success = TRUE;
      $this->response->message = "Berhasil mengubah data absen!";
    }
    return $this->response;
  }

  public function get_absen_count_group($week)
  {
    $where = "DATE(la.`absen_date`) BETWEEN {$this->db->escape($week->start)} AND {$this->db->escape($week->end)}";
    if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
      $where .= " AND lu.`cabang_id` = {$this->session->cabang_id}";
    }
    $query = $this->db->select("COUNT(la.`absen_id`) AS `count`, las.`absen_status`")->from("list_absen la")
                      ->join("list_absen_status las", "las.`absen_status_id` = la.`absen_status_id`")
                      ->join("list_user lu", "lu.`user_id` = la.`user_id`")
                      ->where($where)->group_by("las.`absen_status_id`")->get();
    if ($query) {
      // var_dump($this->db->last_query());
      $absen = new stdClass();
      foreach ($query->result() as $item) {
        if ($item->absen_status == "Tidak ada keterangan") {
          $absen->Alpha = $item->count;
        } else {
          $absen->{$item->absen_status} = $item->count;
        }
      }
      $where = [
        "is_active" => 1,
        "kelas_id !=" => 1
      ];
      if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
        $where["cabang_id"] = $this->session->cabang_id;
      }
      $query2 = $this->db->select("COUNT(`user_id`) AS `total`")->from("list_user")->where($where)->get();
      $absen->total = $query2->row()->total;
      if (!property_exists($absen, "Masuk")) {
        $absen->Masuk = 0;
      }
      if (!property_exists($absen, "Izin")) {
        $absen->Izin = 0;
      }
      if (!property_exists($absen, "Sakit")) {
        $absen->Sakit = 0;
      }
      if (!property_exists($absen, "Alpha")) {
        $absen->Alpha = 0;
      }
      return $absen;
    } else {
      return FALSE;
    }
  }
}
