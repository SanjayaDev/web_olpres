<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct()
  {
    date_default_timezone_set("Asia/Jakarta");
    parent::__construct();
    $this->addon->login_security();
  }

  public function index()
  {
    $data = [
      "title" => "Dashboard",
      "content" => "admin/v_dashboard",
      "breadcrumb" => $this->addon->draw_breadcrumb("dashboard", "Dashboard", TRUE),
      "user_login" => $this->M_data->get_user_login($this->session->user_id)->data
    ];
    $this->load->view("layout/admin_content", $data);
  }

}