<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data extends CI_Model {

  public function get_user_login($id = FALSE)
  {
    $response = new stdClass();
    if ($id === FALSE) {
      $id = $this->session->user_id;
    }
    $query = $this->db->select("lu.`user_nama`, lu.`user_email`, lu.`user_username`, lu.`role_id`, lr.`level_title`, ld.`division_name`, lu.`user_image`, lu.`last_login`, lu.`is_active`, ")
                      ->from("`list_user` lu")
                      ->join("`list_role` lr", "lr.`role_id` = lu.`role_id`")
                      ->join("`list_divisi` ld", "ld.`divisi_id` = lr.`divisi_id`")
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

  public function get_class_list()
  {
    return $this->db->from("`list_kelas` lk")->where("lk.`kelas_id` != 1")->get()->result();
  }

  public function get_angkatan_list()
  {
    return $this->db->from("`list_angkatan`")->get()->result();
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

  public function get_cabang_list()
  {
    return $this->db->get("list_cabang")->result();
  }
}