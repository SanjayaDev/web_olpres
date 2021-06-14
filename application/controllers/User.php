<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  public function __construct()
  {
    date_default_timezone_set("Asia/Jakarta");
    parent::__construct();
    $this->load->model("M_user");
    $this->addon->login_security();
  }

  public function view_user_management()
  {
    // $this->M_user->create_user_dummy();
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $data = [
      "title" => "User Management",
      "content" => "admin/v_user",
      "breadcrumb" => $this->addon->draw_breadcrumb("user", "User Management", TRUE),
      "user_login" => $this->M_data->get_user_login($this->session->user_id)->data,
      "list_kelas" => $this->M_user->get_kelas_listed(),
      "list_cabang" => $this->M_user->get_cabang_listed(),
      "list_angkatan" => $this->M_user->get_angkatan_listed(),
      "list_role" => $this->M_user->get_role_listed(),
      "count_user" => $this->M_user->get_count_user_group_by(),
      "is_register" => $this->M_user->get_is_register(),
      "code_register" => $this->M_user->get_code_register()
    ];
    $this->load->view("layout/admin_content", $data);
  }

  public function get_user()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $type = html_escape($this->input->get("type"));
    $value = html_escape($this->input->get("value"));
    $column = "";
    if ($type == "kelas") {
      $column = "lkk.`kategori_id`";
    } else {
      $column = "lu.`cabang_id`";
    }

    $list = $this->M_user->get_user_listed($column, $value);
    $data = [];
    $no = $_POST["start"];
    if (count($list) > 0) {
      foreach ($list as $item) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $item->user_username;
        $row[] = $item->user_email;
        if ($item->is_active == 1) {
          $row[] = "<span class='badge badge-success'>Active</span>";
        } else {
          $row[] = "<span class='badge badge-danger'>No Active</span>";
        }
        $row[] = $item->division_name;
        $row[] = $item->level_title;
        $row[] = $item->kelas;
        if ($item->last_login != NULL) {
          $row[] = date("d M Y H:i", strtotime($item->last_login));
        } else {
          $row[] = "Belum melakukan login";
        }

        $button = "";
        if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
          $button .= "<button class='btn btn-primary btn-sm m-1' data-toggle='modal' data-target='#editUser' onclick=\"getUserDetail('" . encrypt_url($item->user_id) . "')\"><i class='fas fa-edit fa-sm'></i></button>";
          $button .= "<a href='" . base_url("user_detail?id=" . encrypt_url($item->user_id)) . "' class='btn btn-info btn-sm m-1'><i class='fas fa-eye fa-sm'></i></a>";
          $button .= "<button class='btn btn-danger btn-sm m-1' onclick=\"promptDelete('" . base_url("delete_user?id=" . encrypt_url($item->user_id)) . "')\"><i class='fas fa-trash fa-sm'></i></button>";
        }
        $row[] = $button;
        $data[] = $row;
      }
    }

    $output = [
      "draw" => $_POST["draw"],
      "recordsTotal" => $this->M_user->count_user_all($column, $value),
      "recordsFiltered" => $this->M_user->count_user_filtered($column, $value),
      "data" => $data
    ];

    echo json_encode($output);
  }

  public function validate_user_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $this->form_validation->set_rules('user_nama', 'User', 'required');
    $this->form_validation->set_rules('user_email', 'User', 'required|valid_email');
    $this->form_validation->set_rules('user_username', 'User', 'required');
    $this->form_validation->set_rules('user_password', 'User', 'required');
    $this->form_validation->set_rules('is_active', 'User', 'required');
    $this->form_validation->set_rules('role_id', 'User', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Data input tidak lengkap!"
      ];
      echo json_encode($data);
    } else {
      $check_unique = $this->addon->check_unique("list_user", "user_email", $this->input->post("user_email"));
      if ($check_unique === FALSE) {
        $this->process_user_add();
      } else {
        $data = [
          "success" => 201,
          "message" => "Email anda sudah didaftarkan!"
        ];
        echo json_encode($data);
      }
    }
  }

  private function process_user_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $data = [];
    $input = (object)$this->input->post();
    $check = $this->M_user->add_user($input);
    if ($check->success === TRUE) {
      $data = [
        "success" => 200
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function view_user_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"], FALSE);
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_user->get_user_detail($id);
    if ($check->success === TRUE) {
      $data = [
        "user" => $check->data,
        "title" => "User Detail",
        "user_id" => $check->user_id,
        "breadcrumb" => $this->addon->draw_breadcrumb("user_detail?id=" . encrypt_url($id), "User Detail", FALSE),
        "user_login" => $this->M_data->get_user_login($this->session->user_id)->data,
        "list_kelas" => $this->M_user->get_kelas_listed(),
        "list_cabang" => $this->M_user->get_cabang_listed(),
        "list_angkatan" => $this->M_user->get_angkatan_listed(),
        "list_role" => $this->M_user->get_role_listed(),
        "content" => "admin/v_user_detail"
      ];
      $this->load->view("layout/admin_content", $data);
    } else {
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
      redirect("user");
    }
  }

  public function get_user_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_user->get_user_detail($id);
    echo json_encode(["data" => $check->data, "user_id" => encrypt_url($check->user_id)]);
  }

  public function validate_user_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $this->form_validation->set_rules('user_nama', 'User', 'required');
    $this->form_validation->set_rules('user_email', 'User', 'required|valid_email');
    $this->form_validation->set_rules('user_username', 'User', 'required');
    $this->form_validation->set_rules('user_id', 'User', 'required');
    $this->form_validation->set_rules('is_active', 'User', 'required|numeric');
    $this->form_validation->set_rules('role_id', 'User', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Data input tidak lengkap!"
      ];
      echo json_encode($data);
    } else {
      $id = decrypt_url(html_escape($this->input->post("user_id")));
      $email = html_escape($this->input->post("user_email"));
      $check_other_unique = $this->addon->check_other_unique("list_user", "user_email", $email, "user_id", $id);
      if ($check_other_unique === FALSE) {
        $this->process_user_edit();
      } else {
        $data = [
          "success" => 201,
          "message" => "Email anda sudah didaftarkan!"
        ];
        echo json_encode($data);
      }
    }
  }

  private function process_user_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $data = [];
    $input = (object)html_escape($this->input->post());
    $check = $this->M_user->edit_user($input);
    if ($check->success === TRUE) {
      $data = [
        "success" => 200
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function process_user_delete()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1", "Struktural Cabang|60|1"]);
    $data = [];
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_user->delete_user($id);
    if ($check->success === TRUE) {
      $data = [
        "success" => 200
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses!', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function process_generate_register_code()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|85|1"]);
    $check = $this->M_user->generate_register_code();
    echo json_encode($check);
  }
}
