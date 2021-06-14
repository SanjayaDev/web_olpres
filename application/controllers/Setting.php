<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->addon->login_security();
    $this->load->model("M_setting", "ms");
  }

  public function process_switch_absen()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $type = (int)html_escape($this->input->get("type"));
    if (is_int($type) && $type !== 0) {
      $check = $this->ms->switch_absen($type);
      echo json_encode($check);
    } else {
      $data = [
        "success" => 201,
        "message" => "Data yang anda kirim tidak valid!"
      ];
      echo json_encode($data);
    }
  }

  public function process_week_change()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $week = (int)html_escape($this->input->get("week"));
    if (is_int($week) && $week !== 0) {
      $check = $this->ms->change_week($week);
      echo json_encode($check);
    } else {
      $data = [
        "success" => 201,
        "message" => "Data yang anda kirim tidak valid!"
      ];
      echo json_encode($data);
    }
  }

  public function process_switch_register()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1"]);
    $type = (int)html_escape($this->input->get("type"));
    if (is_int($type) && $type !== 0) {
      $check = $this->ms->change_is_register($type);
      echo json_encode($check);
    } else {
      $data = [
        "success" => 201,
        "message" => "Data yang anda kirim tidak valid!"
      ];
      echo json_encode($data);
    }
  }
}