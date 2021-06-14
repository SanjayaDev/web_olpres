<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends CI_Model {
  private $response;

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Jakarta");
    $this->response = new stdClass();
    $this->response->success = FALSE;
    $this->response->message = "Query failed!";
  }

  public function switch_absen($type)
  {
    if ($type == 1) {
      $is_absen = 1;
    } else {
      $is_absen = 0;
    }
    $query = $this->db->update("list_setting", ["is_absen" => $is_absen], ["setting_id" => 1]);
    if ($query) {
      $this->response->success = 200;
      $this->response->message = "Sukses mengubah setting absen!";
    } else {
      $this->response->success = 201;
      $this->response->message = "Query failed!!";
    }
    return $this->response;
  }

  public function change_week($week)
  {
    $data = ["week" => $week];
    $where = ["setting_id" => 1];
    $query = $this->db->update("list_setting", $data, $where);
    if ($query) {
      $this->response->success = 200;
      $this->response->message = "Sukses mengubah setting absen!";
    } else {
      $this->response->success = 201;
      $this->response->message = "Query failed!!";
    }
    return $this->response;
  }

  public function change_is_register($type)
  {
    $response = new stdClass();
    if ($type == 1) {
      $data = ["is_register" => 1];
    } else if ($type == 2) {
      $data = ["is_register" => 0];
    }
    $query = $this->db->update("list_setting", $data, ["setting_id" => 1]);
    if ($query) {
      $response->success = 200;
      $response->message = "Berhasil ubah setting register!";
    } else {
      $response->success = 201;
      $response->message = "Query failed!";
    }
    return $response;
  }
}