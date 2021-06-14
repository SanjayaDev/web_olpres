<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{
  private $date, $week;

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Jakarta");
    $this->load->model("M_absen", "ma");
    $this->addon->login_security();
    $this->date = new stdClass();
    $this->week = get_week_now();
    $this->date->start = $this->input->get_post("start_date") !== NULL ? html_escape($this->input->get_post("start_date")) : $this->week->start;
    $this->date->end = $this->input->get_post("end_date") !== NULL ? html_escape($this->input->get_post("end_date")) : $this->week->end;
  }

  public function view_absensi_management()
  {
    // $this->ma->create_absen_dummy();
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $data = [
      "title" => "Absensi",
      "content" => "admin/v_absen",
      "breadcrumb" => $this->addon->draw_breadcrumb("absen", "Absensi", TRUE),
      "user_login" => $this->M_data->get_user_login($this->session->user_id)->data,
      "code" => $this->ma->get_code_absen()->code,
      "is_absen" => $this->ma->get_setting()->is_absen,
      "pekan" => $this->ma->get_setting()->week,
      "start_date" => $this->date->start,
      "end_date" => $this->date->end,
      "count_absen" => $this->ma->get_absen_count_group($this->date),
      "list_absen_status" => $this->ma->get_absen_status_listed()
    ];
    $this->load->view("layout/admin_content", $data);
  }

  public function get_absen_listed()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $value = $this->input->get("value") !== NULL ? (int)html_escape($this->input->get("value")) : FALSE;
    $column = "la.`absen_status_id`";
    $list = $this->ma->get_absen_listed($column, $value, $this->date);
    $data = [];
    $no = $_POST["start"];
    if (count($list) > 0) {
      foreach ($list as $item) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = "<a href='" . base_url("user_detail?id=" . encrypt_url($item->user_id)) . "' class='text-muted'>$item->user_nama</a>";
        $row[] = $item->kelas;
        $row[] = $item->cabang;
        if ($item->absen_status_id == 1) {
          $row[] = "<span class='badge badge-success'>$item->absen_status</span>";
        } else if ($item->absen_status_id == 2 || $item->absen_status_id == 3) {
          $row[] = "<span class='badge badge-warning'>$item->absen_status</span>";
        } else {
          $row[] = "<span class='badge badge-danger'>$item->absen_status</span>";
        }
        $row[] = date("d M Y", strtotime($item->absen_date));
        $row[] = "Pekan ke- $item->absen_week";
        $row[] = $item->absen_note;
        $button = "<button class='btn btn-info btn-sm m-1' data-toggle='modal' data-target='#editAbsen' onclick='getAbsen($item->absen_id)'><i class='fas fa-edit'></i></button>";
        $row[] = $button;
        $data[] = $row;
      }
    }

    $output = [
      "draw" => $_POST["draw"],
      "recordsTotal" => $this->ma->count_absen_all($column, $value, $this->date),
      "recordsFiltered" => $this->ma->count_absen_filtered($column, $value, $this->date),
      "data" => $data
    ];

    echo json_encode($output);
  }

  public function generate_absen_code()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $check = $this->ma->generate_absen_code();
    echo json_encode($check);
  }

  public function process_absen_create()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $check = $this->ma->insert_absen();
    if ($check->success === TRUE) {
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
    } else {
      $this->session->set_flashdata("pesan", "<script>sweet('error', 'Gagal!', '$check->message')</script>");
    }
    redirect("absen");
  }

  public function get_absen_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $id = (int)html_escape($this->input->get("id"));
    if (is_int($id) && $id != 0) {
      $check = $this->ma->get_absen_detail($id);
      echo json_encode($check);
    } else {
      $data = [
        "success" => 201,
        "message" => "Maaf, data yang anda kirim tidak valid!"
      ];
      echo json_encode($data);
    }
  }

  public function validate_absen_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $this->form_validation->set_rules('absen_id', 'Absen', 'trim|required|numeric');
    $this->form_validation->set_rules('absen_status_id', 'Absen', 'trim|required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Data yang anda kirim tidak valid!"
      ];
      echo json_encode($data);
    } else {
      $this->process_absen_edit();
    }
  }

  private function process_absen_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $input = (object) html_escape($this->input->post());
    $check = $this->ma->edit_absen($input);
    if ($check->success === TRUE) {
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
      echo json_encode(["success" => 200]);
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
      echo json_encode($data);
    }
  }
}
