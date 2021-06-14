<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends CI_Model {
  private $response;

  public function __construct()
  {
    parent::__construct();
    $this->response = new stdClass();
    $this->response->success = FALSE;
    $this->response->data = NULL;
  }

  public function get_kelas_kategori_listed()
  {
    $query = $this->db->get("list_kelas_kategori");

    if ($query) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  public function get_kelas_listed()
  {
    $query = $this->db->join("`list_kelas_kategori` lkk", "lkk.`kategori_id` = lk.`kategori_id`")->get("`list_kelas` lk");
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

  public function add_kelas($input)
  {
    $response = new stdClass();
    $data = ["kelas" => $input->kelas, "kategori_id" => $input->kategori_id];
    $query = $this->db->insert("list_kelas", $data);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses menambahkan kelas!";
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!!";
    }
    return $response;
  }

  public function get_kelas_detail($id)
  {
    $response = new stdClass();
    $query = $this->db->select("`kelas`, `kategori_id`")->get_where("`list_kelas` lk", ["kelas_id" => $id]);
    if ($query) {
      $response->data = $query->row();
      $response->id = encrypt_url($this->get_id_item("list_kelas", "kelas_id", $id));
      return $response;
    } else {
      return FALSE;
    }
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

  public function edit_kelas($input)
  {
    $response = new stdClass();
    $query = $this->db->update("list_kelas", ["kelas" => $input->kelas, "kategori_id" => $input->kategori_id], ["kelas_id" => decrypt_url($input->kelas_id)]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses mengubah kelas!";
    } else {
      $response->success = TRUE;
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function delete_kelas($id)
  {
    $response = new stdClass();
    $query = $this->db->delete("list_kelas", ["kelas_id" => $id]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses menghapus kelas!";
    } else {
      $response->success = TRUE;
      $response->message = "Query failed!";
    }
    return $response;
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

  public function add_angkatan($angkatan)
  {
    $response = new stdClass();
    $query = $this->db->insert("list_angkatan", ["angkatan" => $angkatan]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses menambahkan angkatan!";
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function get_detail_angkatan($id)
  {
    $response = new stdClass();
    $query = $this->db->get_where("list_angkatan", ["angkatan_id" => $id]);
    if ($query) {
      $response->success = 200;
      $response->angkatan = $query->row()->angkatan;
      $response->angkatan_id = encrypt_url($query->row()->angkatan_id);
    } else {
      $response->success = 201;
      $response->message = "Query Error!";
    }
    return $response;
  }

  public function edit_angkatan($input)
  {
    $response = new stdClass();
    $query = $this->db->update("list_angkatan", ["angkatan" => $input->angkatan], ["angkatan_id" => decrypt_url($input->angkatan_id)]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses mengubah angkatan!";
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!!";
    }
    return $response;
  }

  public function delete_angkatan($id)
  {
    $response = new stdClass();
    $query = $this->db->delete("list_angkatan", ["angkatan_id" => $id]);
    if ($query) {
      $response->success = TRUE;
      $response->message = "Sukses menghapus angkatan!";
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }
    return $response;
  }

  public function add_cabang($cabang)
  {
    $query = $this->db->insert("list_cabang", ["cabang" => $cabang]);
    if ($query) {
      $this->response->success = TRUE;
      $this->response->message = "Sukses menambahkan cabang!";
    } else {
      $this->response->message = "Query failed!";
    }
    return $this->response;
  }

  public function get_cabang_detail($id)
  {
    $query = $this->db->get_where("list_cabang", ["cabang_id" => $id]);
    if ($query) {
      $this->response->success = 200;
      $this->response->cabang = $query->row()->cabang;
      $this->response->cabang_id = encrypt_url($query->row()->cabang_id);
    } else {
      $this->response->success = 201;
      $this->response->message = "Query failed!";
    }
    return $this->response;
  }

  public function edit_cabang($input)
  {
    $query = $this->db->update("list_cabang", ["cabang" => $input->cabang], ["cabang_id" => decrypt_url($input->cabang_id)]);
    if ($query) {
      $this->response->success = TRUE;
      $this->response->message = "Sukses mengubah data cabang!";
    } else {
      $this->response->message = "Query failed!";
    }
    return $this->response;
  }

  public function delete_cabang($id)
  {
    $query = $this->db->delete("list_cabang", ["cabang_id" => $id]);
    if ($query) {
      $this->response->success = TRUE;
      $this->response->message = "Sukses menghapus cabang!";
    } else {
      $this->response->message = "Query failed!";
    }
    return $this->response;
  }
}