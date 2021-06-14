<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kas extends CI_Model
{
  protected $column_order_kas = [NULL, "lu.`user_nama`", "MONTH(lk.`date_add`)", "lk.`date_add`", "lk.`week`", "lk.`kas_status_id`"];
  protected $column_search_kas = ["lu.`user_nama`", "MONTH(lk.`date_add`)", "lk.`date_add`", "lk.`week`"];
  protected $order_kas = ["kas_id" => "ASC"];

  private function query_kas_listed()
  {
    $this->db->select("*")->from("list_kas lk")->join("list_user lu", "lu.`user_id` = lk.`user_id`")->join("list_kas_status lks", "lks.`kas_status_id` = lk.`kas_status_id`");
    $i = 1;
    foreach ($this->column_search_kas as $item) {
      if ($_POST["search"]["value"]) {
        if ($i == 1) {
          $this->db->group_start();
          $this->db->like($item, $_POST["search"]["value"]);
        } else {
          $this->db->or_like($item, $_POST["search"]["value"]);
        }
        if (count($this->column_search_kas) == $i) {
          $this->db->group_end();
        }
      }
      $i++;
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($this->column_order_kas[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function get_kas_listed()
  {
    $this->query_kas_listed();
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
      $query = $this->db->get();
      // var_dump($this->db->last_query());
      return $query->result();
    }
  }

  public function count_kas_all()
  {
    $this->query_kas_listed();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_kas_filtered()
  {
    $this->db->select("*")->from("list_kas lk")->join("list_user lu", "lu.`user_id` = lk.`user_id`")->join("list_kas_status lks", "lks.`kas_status_id` = lk.`kas_status_id`");
    return $this->db->count_all_results();
  }

  public function search_user($keyword, $option = "Add")
  {
    $html = "";
    $query = $this->db->select("lu.`user_id`, lu.`user_nama`, lk.`kelas`, lc.`cabang`")->from("list_user lu")->join("list_kelas lk", "lk.`kelas_id` = lu.`kelas_id`")
      ->join("list_cabang lc", "lc.`cabang_id` = lu.`cabang_id`")->where("lk.`kelas_id` != 1")->group_start()
      ->like("lu.`user_nama`", $keyword)->or_like("lk.`kelas`", $keyword)->or_like("lc.`cabang`", $keyword)->group_end()->limit(10)->get();
    if ($query) {
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $item) {
          $action = $option == "Add" ? "addUser" : "addUserEdit";
          $user_id = encrypt_url($item->user_id);
          $html .= "<p onclick=\"$action('$user_id', '$item->user_nama - $item->kelas - $item->cabang')\">$item->user_nama - $item->kelas - $item->cabang </p>";
        }
      } else {
        $html .= "<p>Not Found</p>";
      }
    } else {
      $html .= "<p>Query Failed!</p>";
    }
    return $html;
  }

  public function add_kas($input)
  {
    $response = create_response();
    $error = FALSE;
    $this->db->trans_begin();

    if (isset($input->is_debt) && $input->is_debt == 1) {
      $total_payment = $input->price_kas;
      $where = [
        "user_id" => decrypt_url($input->user_id),
        "kas_status_id" => 2
      ];
      $query = $this->db->get_where("list_kas", $where);
      if ($query) {
        foreach ($query->result() as $item) {
          if ($total_payment > 0) {
            $payment = $total_payment >= 2000 ? 2000 : $item->price_kas + $total_payment;
            $kas_status = $payment == 2000 ? 1 : 2;
            $values = [
              "price_kas" => $payment,
              "kas_status_id" => $kas_status
            ];
            $query2 = $this->db->update("list_kas", $values, ["kas_id" => $item->kas_id]);
            if (!$query2) {
              $error = TRUE;
              $response->message = "Query 2 failed!";
              break;
            }
            $total_payment -= $payment;
          }
        }
      } else {
        $error = TRUE;
        $response->message = "Query failed!";
      }
    } else {
      $kas_status = $input->price_kas == 2000 ? 1 : 2;
      $data = [
        "user_id" => decrypt_url($input->user_id),
        "date_add" => date("Y-m-d H:i:s"),
        "month" => $input->month,
        "week" => $input->week,
        "price_kas" => $input->price_kas,
        "kas_status_id" => $kas_status
      ];
      $query3 = $this->db->insert("list_kas", $data);
      if (!$query3) {
        $error = TRUE;
        $response->message = "Query 3 failed!";
      }
    }
    // var_dump($this->db->last_query());
    if ($error === FALSE && $this->db->trans_status() === TRUE) {
      $this->db->trans_commit();
      $response->success = TRUE;
      $response->message = "Sukses menambahkan data kas!";
    } else {
      $this->db->trans_rollback();
    }
    return $response;
  }

  public function get_kas_detail($id)
  {
    $response = new stdClass();
    $query = $this->db->select("*")->from("list_kas lk")->join("list_user lu", "lu.`user_id` = lk.`user_id`")
              ->join("list_kas_status lks", "lks.`kas_status_id` = lk.`kas_status_id`")
              ->join("list_kelas lkl", "lkl.`kelas_id` = lu.`kelas_id`")
              ->join("list_cabang lc", "lc.`cabang_id` = lu.`cabang_id`")->where("lk.`kas_id`", $id)->get();
    if ($query) {
      $data = $query->row();
      $response->id = encrypt_url($data->kas_id);
      $response->userId = encrypt_url($data->user_id);
      $response->userNama = "$data->user_nama - $data->kelas - $data->cabang";
      $response->priceKas = $data->price_kas;
      $response->week = $data->week;
      $response->month = $data->month;
      $response->kasStatusId = $data->kas_status_id;
    } else {
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function edit_kas($input)
  {
    $response = create_response();
    $data = [
      "user_id" => decrypt_url($input->user_id),
      "month" => $input->month,
      "week" => $input->week,
      "price_kas" => $input->price_kas,
      "kas_status_id" => $input->kas_status_id
    ];
    $query = $this->db->update("list_kas", $data, ["kas_id" => decrypt_url($input->kas_id)]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Success updated data kas!";
    } else {
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function delete_kas($id)
  {
    $response = create_response();
    $query = $this->db->delete("list_kas", ["kas_id" => $id]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses menghapus data kas!";
    } else {
      $response->message = "Query failed!";
    }
    return $response;
  }
}
