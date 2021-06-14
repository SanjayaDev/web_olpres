<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forbidden extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->addon->login_security();
  }

  public function index() 
  {
    $data["title"] = "403 Forbidden";
    $data["content"] = "403";
    $data["user_login"] = $this->M_data->get_user_login($this->session->user_id)->data;
    $this->load->view("layout/admin_content", $data);
  }
}