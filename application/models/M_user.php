<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
  protected $table = "`list_user` lu";
  protected $column_order = [NULL, "lu.`user_username`", "lu.`user_email`", "lu.`is_active`", "lu.`role_id`", "lu.`last_login`", "lu.`kelas_id`"];
  protected $column_search = ["lu.`user_username`", "lu.`user_email`"];
  protected $order = ["lu.`user_id`" => "ASC"];

  public function create_user_dummy()
  {
    $data = [];
    $insert = FALSE;
    for ($i = 1; $i < 301; $i++) {
      $values = [
        "user_nama" => "User$i",
        "user_username" => "User$i",
        "user_password" => "admin$i",
        "user_email" => "mail$i@mail.com",
        "is_active" => 1,
        "role_id" => 8,
        "angkatan_id" => 1
      ];

      if ($i <= 100) {
        $values["kelas_id"] = 2;
      } else if ($i > 100 && $i <= 200) {
        $values["kelas_id"] = 3;
      } else {
        $values["kelas_id"] = 5;
      }
      $modulus = $i % 2;
      if ($modulus == 0) {
        $values["user_gender"] = "Laki-laki";
      } else {
        $values["user_gender"] = "Perempuan";
      }
      if ($i <= 50) {
        $values["cabang_id"] = 2;
      } else if ($i > 50 && $i < 100) {
        $values["cabang_id"] = 3;
      } else if ($i > 100 && $i <= 175) {
        $values["cabang_id"] = 4;
      } else {
        $values["cabang_id"] = 1;
      }
      array_push($data, $values);
      if ($i == 300) {
        $insert = TRUE;
      }
    }
    // var_dump(count($data));
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    if ($insert) {
      $this->db->insert_batch("list_user", $data);
    }
    // var_dump($this->db->last_query());
  }

  private function query_user_listed()
  {
    $this->db->from($this->table)
      ->join("`list_role` lr", "lr.`role_id` = lu.`role_id`")
      ->join("`list_divisi` ld", "ld.`divisi_id` = lr.`divisi_id`")
      ->join("`list_kelas` lk", "lk.`kelas_id` = lu.`kelas_id`")
      ->join("`list_kelas_kategori` lkk", "lkk.`kategori_id` = lk.`kategori_id`")
      ->join("`list_cabang` lc", "lc.`cabang_id` = lu.`cabang_id`");
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

  public function get_user_listed($column, $value)
  {
    $this->query_user_listed();
    if ($_POST["length"] != -1) {
      $this->db->where($column, $value);
      $this->db->where("lu.`is_active`", 1);
      if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
        $this->db->where("lc.`cabang_id`", $this->session->cabang_id);
      }
      $this->db->limit($_POST["length"], $_POST["start"]);
      $query = $this->db->get();
      // var_dump($this->db->last_query());
      return $query->result();
    }
  }

  public function count_user_filtered($column, $value)
  {
    $this->query_user_listed();
    $this->db->where($column, $value);
    $this->db->where("lu.`is_active`", 1);
    if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
      $this->db->where("lc.`cabang_id`", $this->session->cabang_id);
    }
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_user_all($column, $value)
  {
    $this->db->from($this->table)
    ->join("`list_kelas` lk", "lk.`kelas_id` = lu.`kelas_id`")
    ->join("`list_kelas_kategori` lkk", "lkk.`kategori_id` = lk.`kategori_id`");
    $this->db->where($column, $value);
    if ($this->session->admin_level == 70 || $this->session->admin_level == 60) {
      $this->db->where("lc.`cabang_id`", $this->session->cabang_id);
    }
    return $this->db->count_all_results();
  }

  public function get_kelas_listed()
  {
    $query = $this->db->get("list_kelas");
    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  public function get_cabang_listed()
  {
    $query = $this->db->get("list_cabang");
    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  public function get_angkatan_listed()
  {
    $query = $this->db->get("list_angkatan");
    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  public function get_role_listed()
  {
    $query = $this->db->select("*")->from("`list_role` lr")
                      ->join("`list_divisi` ld", "ld.`divisi_id` = lr.`divisi_id`")
                      ->get();
    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  public function add_user($input)
  {
    $response = new stdClass();
    $upload_image = TRUE;
    $input->image = "";
    if ($_FILES["user_image"]["name"] != "") {
      $file_name = $this->check_name_photo($_FILES["user_image"]["name"]);
      if ($file_name->success === TRUE) {
        $_FILES["user_image"]["name"] = $file_name->name;
        $config['upload_path']          = './assets/img/user/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library("upload");
        $this->upload->initialize($config);

        if (!$this->upload->do_upload("user_image")) {
          $upload_image = FALSE;
          // var_dump($this->upload->display_errors());
        } else {
          $input->image = $file_name->name;
        }
      } else {
        $upload_image = FALSE;
      }
    }
    if ($upload_image) {
      $data = [
        "user_nama" => $input->user_nama,
        "user_email" => $input->user_email,
        "user_username" => $input->user_username,
        "user_password" => password_hash($input->user_password, PASSWORD_DEFAULT),
        "is_active" => $input->is_active,
        "role_id" => $input->role_id,
        "kelas_id" => $input->kelas_id,
        "angkatan_id" => $input->angkatan_id,
        "cabang_id" => $input->cabang_id
      ];
      if ($input->image != "") {
        $data["user_image"] = base_url("assets/img/user/" . $input->image);
      }
      $query = $this->db->insert("list_user", $data);
      if ($query) {
        $response->success = TRUE;
        $response->message = "Berhasil menambahkan user!";
      } else {
        $response->success = FALSE;
        $response->message = "Query failed!";
      }
    } else {
      $response->success = FALSE;
      $response->message = "Gagal mengupload gambar!";
    }
    return $response;
  }

  private function check_name_photo($file_name)
  {
    $response = new stdClass();
    $duplicate = TRUE;
    $extension = pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION);
    $file = "";
    $link = base_url("assets/img/user/" . str_replace([" ", "-"], "_", $_FILES["user_image"]["name"]));
    $loop = 0;
    do {
      $sql = "SELECT `user_image` "
          .  "FROM `list_user` "
          .  "WHERE `user_image` LIKE '%$link%' "
          .  "ORDER BY `user_id` DESC "
          .  "LIMIT 1 "
          .  "FOR UPDATE;";
      $query = $this->db->query($sql);
      if ($query) {
        if ($query->num_rows() > 0) {
          // var_dump($this->db->last_query());
          // var_dump("Masuk");
          $array = explode('/', $query->row()->user_image);
          $array2 = explode(".", end($array));
          $array3 = explode("_", $array2[0]);
          // var_dump($query->row()->user_image);
          $index = (int)end($array3);
          // var_dump($index);
          $index++;
          $index = "0000$index";
          $file = "USER_PHOTO_" . substr($index, -3) . "." . $extension;
          // var_dump($file);
        } else {
          $file_name = str_replace([" ", "-"], "_", $file_name);
          $file = $file_name;
        }
        $check_duplicate = $this->db->get_where("list_user", ["user_image" => base_url("assets/img/user/$file")]);
        // var_dump($this->db->last_query());
        if ($check_duplicate->num_rows() == 0) {
          $duplicate = FALSE;
          $response->success = TRUE;
          $response->name = $file;
        } else {
          $loop++;
          $response->success = FALSE;
          if ($loop > 0) {
            $link = "USER_PHOTO_";
          }
        }
        // $response->name = $file;
        // $response->success = TRUE;
        // $duplicate = FALSE;
      } else {
        $response->success = FALSE;
        $response->message = "Query failed!";
        $duplicate = FALSE;
      }
    } while ($duplicate === TRUE);

    return $response;
  }

  public function get_user_detail($id)
  {
    $response = new stdClass();
    $query = $this->db->select("lu.`user_nama`, lu.`user_email`, lu.`user_username`, lu.`role_id`, lr.`level_title`, ld.`division_name`, lu.`user_image`, lu.`last_login`, lu.`is_active`, lk.*, lc.*, la.*")
      ->from("`list_user` lu")
      ->join("`list_role` lr", "lr.`role_id` = lu.`role_id`")
      ->join("`list_divisi` ld", "ld.`divisi_id` = lr.`divisi_id`")
      ->join("`list_kelas` lk", "lk.`kelas_id` = lu.`kelas_id`")
      ->join("`list_cabang` lc", "lc.`cabang_id` = lu.`cabang_id`")
      ->join("`list_angkatan` la", "la.`angkatan_id` = lu.`angkatan_id`")
      ->where("lu.`user_id`", $id)
      ->get();
    if ($query) {
      $response->success = TRUE;
      $response->data = $query->row();
      $response->user_id = $this->get_id_item("list_user", "user_id", $id);
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }
    return $response;
  }

  private function get_id_item($table, $column, $id)
  {
    $query = $this->db->get_where($table, [$column => $id]);
    if ($query) {
      return $query->row()->$column;
    } else {
      return FALSE;
    }
  }

  public function edit_user($input)
  {
    $response = new stdClass();
    $upload_image = FALSE;
    $update_image = FALSE;
    $input->image = "";
    $id = decrypt_url(html_escape($input->user_id));
    if ($_FILES["user_image"]["name"] != "") {
      $old_data = $this->get_user_detail($id)->data;
      $file_name = $this->check_name_photo($_FILES["user_image"]["name"]);
      if ($file_name->success === TRUE) {
        // var_dump($file_name->name);
        $_FILES["user_image"]["name"] = $file_name->name;
        $config['upload_path']          = './assets/img/user/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library("upload");
        $this->upload->initialize($config);
        $input->image = $file_name->name;
        if (!$this->upload->do_upload("user_image")) {
          $upload_image = FALSE;
          // var_dump($this->upload->display_errors());
        } else {
          $update_image = TRUE;
          $upload_image = TRUE;
          $input->image = $file_name->name;
        }
      } else {
        // var_dump($upload_image);
        $upload_image = FALSE;
      }
    } else {
      $upload_image = TRUE;
    }
    // var_dump($upload_image);
    if ($upload_image) {
      $data = [
        "user_nama" => $input->user_nama,
        "user_email" => $input->user_email,
        "user_username" => $input->user_username,
        "is_active" => $input->is_active,
        "role_id" => $input->role_id,
        "kelas_id" => $input->kelas_id,
        "angkatan_id" => $input->angkatan_id,
        "cabang_id" => $input->cabang_id
      ];
      if ($input->user_password != "") {
        $data["user_password"] = password_hash($input->user_password, PASSWORD_DEFAULT);
      }
      if ($update_image === TRUE) {
        $data["user_image"] = base_url("assets/img/user/" . $input->image);
      }
      $query = $this->db->update("list_user", $data, ["user_id" => $id]);
      if ($query) {
        if ($update_image === TRUE) {
          if ($old_data->user_image != "") {
            $array = explode("/", $old_data->user_image);
            $link = "./assets/img/user/" . end($array);
            unlink($link);
          }
        }
        $response->success = TRUE;
        $response->message = "Berhasil mengedit user!";
      } else {
        $response->success = FALSE;
        $response->message = "Query failed!";
      }
    } else {
      $response->success = FALSE;
      $response->message = "Gagal mengupload gambar!";
    }
    return $response;
  }

  public function delete_user($id)
  {
    $response = new stdClass();
    $old_data = $this->get_user_detail($id)->data;
    $query = $this->db->delete("list_user", ["user_id" => $id]);
    if ($query) {
      if ($old_data->user_image != NULL || $old_data->user_image != "") {
        $array = explode("/", $old_data->user_image);
        $link = "./assets/img/user/" . end($array);
        unlink($link);
      }
      $response->success = TRUE;
      $response->message = "Berhasil menghapus user!";
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function get_count_user_group_by()
  {
    $response = new stdClass();
    $where = [
      "lu.`is_active`" => 1,
      "lu.`kelas_id` !=" => 1
    ];
    $query = $this->db->select("COUNT(lu.`user_id`) AS `count`, lkk.`kategori`")->from("`list_user` lu")->where($where)
                      ->join("`list_kelas` lk", "lk.`kelas_id` = lu.`kelas_id`")
                      ->join("`list_kelas_kategori` lkk", "lkk.`kategori_id` = lk.`kategori_id`")
                      ->group_by("lkk.`kategori_id`")->get();
    if ($query) {
      foreach ($query->result() as $item) {
        $response->{$item->kategori} = $item->count;
      }

      $query2 = $this->db->select("COUNT(lu.`user_id`) AS `count`, lc.`cabang`")->from("`list_user` lu")->where($where)
                      ->join("`list_cabang` lc", "lc.`cabang_id` = lu.`cabang_id`")
                      ->group_by("lc.`cabang_id`")->get();
      if ($query2) {
        foreach ($query2->result() as $item) {
          $response->{$item->cabang} = $item->count;
        }
      } 
    } else {
      $response->message = "Query 1 failed!";
    }
    return $response;
  }

  public function get_is_register()
  {
    return $this->db->select("`is_register`")->from("list_setting")->get()->row()->is_register;
  }

  public function generate_register_code()
  {
    $response = new stdClass();
    $code = "";
    $generate = FALSE;
    do {
      $code = rand(1, 1000000);
      $query = $this->db->from("list_code")->where(["code" => $code])->get();
      if ($query) {
        if ($query->num_rows() == 0) {
          $generate = TRUE;
        }
      } else {
        $generate = TRUE;
        $response->success = 201;
        $response->message = "Query failed!";
      }
    } while ($generate === FALSE);

    if ($generate) {
      $query2 = $this->db->update("list_code", ["code" => $code], ["code_id" => 2]);
      if ($query2) {
        $response->success = 200;
        $response->message = "Berhasil generate code register!";
        $response->code = $code;
      } else {
        $response->success = 201;
        $response->message = "Query 2 failed!";
      }
    }
    return $response;
  }

  public function get_code_register()
  {
    return $this->db->select("code")->from("list_code")->where(["code_id" => 2])->get()->row()->code;
  }
}
