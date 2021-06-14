<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("M_kas", "model");
  }

  public function view_kas_management()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $data = [
      "title" => "Data Kas",
      "content" => "admin/v_kas",
      "user_login" => $this->M_data->get_user_login($this->session->user_id)->data,
      "breadcrumb" => $this->addon->draw_breadcrumb("data_kas", "Kas Management", TRUE)
    ];
    $this->load->view("layout/admin_content", $data);
  }

  public function get_kas_listed()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $list = $this->model->get_kas_listed();
    $data = [];
    $no = $_POST["start"];
    foreach ($list as $item) {
      $no++;
      $row = [];
      $row[] = $no;
      $row[] = $item->user_nama;
      $row[] = date("d M Y", strtotime($item->date_add));
      $row[] = month_ind(date("M", strtotime("2020-$item->month-01")));
      $row[] = $item->week;
      $row[] = "Rp. " . number_format($item->price_kas, "0", ",", ".");
      $row[] = $item->kas_status_id == 1 ? "<span class='badge badge-success'>$item->kas_status</span>" : "<span class='badge badge-danger'>$item->kas_status</span>";
      $button = "<button class='btn btn-primary btn-sm m-1' onclick=\"getKasDetail('" . encrypt_url($item->kas_id) . "')\" data-toggle='modal' data-target='#kasModalEdit'><i class='fas fa-edit fa-sm'></i></button>";
      $button .= "<button class='btn btn-danger btn-sm m-1' onclick=\"deletePrompt('" . base_url("delete_kas?id=" . encrypt_url($item->kas_id)) . "')\"><i class='fas fa-trash fa-sm'></i></button>";
      $row[] = $button;
      $data[] = $row;
    }

    $output = [
      "draw" => $_POST["draw"],
      "recordsTotal" => $this->model->count_kas_all(),
      "recordsFiltered" => $this->model->count_kas_filtered(),
      "data" => $data
    ];

    echo json_encode($output);
  }

  public function process_search_user()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $keyword = html_escape($this->input->post("keyword"));
    $search_user = $this->model->search_user($keyword);

    echo json_encode($search_user);
  }

  public function process_search_user_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $keyword = html_escape($this->input->post("keyword"));
    $search_user = $this->model->search_user($keyword, "Edit");

    echo json_encode($search_user);
  }

  public function validate_kass_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $this->form_validation->set_rules('user_id', 'User', 'required|alpha_numeric_spaces');
    $this->form_validation->set_rules('price_kas', 'Price', 'required|numeric');
    $this->form_validation->set_rules('month', 'Month', 'required|numeric');
    $this->form_validation->set_rules('week', 'Week', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Input not completed!"
      ];
      echo json_encode($data);
    } else {
      $this->process_kas_add();
    }
  }

  private function process_kas_add()
  {
    $input = (object)html_escape($this->input->post());
    $add_kas = $this->model->add_kas($input);
    if ($add_kas->success === TRUE) {
      $data = [
        "success" => 200,
        "message" => $add_kas->message
      ];
    } else {
      $data = [
        "success" => 201,
        "message" => $add_kas->message
      ];
    }
    echo json_encode($data);
  }

  public function get_kas_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $id = html_escape(decrypt_url($this->input->get("id")));
    $get_kas = $this->model->get_kas_detail($id);
    echo json_encode($get_kas);
  }

  public function validate_kas_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], TRUE);
    $this->form_validation->set_rules('kas_id', 'Kas Id', 'required|alpha_numeric_spaces');
    $this->form_validation->set_rules('user_id', 'User', 'required|alpha_numeric_spaces');
    $this->form_validation->set_rules('price_kas', 'Price', 'required|numeric');
    $this->form_validation->set_rules('month', 'Month', 'required|numeric');
    $this->form_validation->set_rules('week', 'Week', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Input not completed!"
      ];
      echo json_encode($data);
    } else {
      $this->process_kas_edit();
    }
  }

  public function process_kas_edit()
  {
    $input = (object)html_escape($this->input->post());
    $edit_kas = $this->model->edit_kas($input);
    if ($edit_kas->success === TRUE) {
      $data = [
        "success" => 200,
        "message" => $edit_kas->message
      ];
    } else {
      $data = [
        "success" => 201,
        "message" => $edit_kas->message
      ];
    }
    echo json_encode($data);
  }

  public function process_kas_delete()
  {
    $id = html_escape(decrypt_url($this->input->get("id")));
    $delete_kas = $this->model->delete_kas($id);
    if ($delete_kas->success === TRUE) {
      $data = [
        "success" => 200,
        "message" => $delete_kas->message
      ];
    } else {
      $data = [
        "success" => 201,
        "message" => $delete_kas->message
      ];
    }
    echo json_encode($data);
  }
}
