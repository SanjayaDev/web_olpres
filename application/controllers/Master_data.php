<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_data extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->addon->login_security();
    $this->load->model("M_master");
  }

  public function index()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"], FALSE);
    $data = [
      "title" => "Master data olpres",
      "content" => "admin/v_master",
      "user_login" => $this->M_data->get_user_login($this->session->user_id)->data,
      "list_kelas_kategori" => $this->M_master->get_kelas_kategori_listed(),
      "list_kelas" => $this->M_master->get_kelas_listed(),
      "list_angkatan" => $this->M_master->get_angkatan_listed(),
      "list_cabang" => $this->M_master->get_cabang_listed(),
      "breadcrumb" => $this->addon->draw_breadcrumb("master_data", "Master data", TRUE)
    ];
    $this->load->view("layout/admin_content", $data);
  }

  public function validate_kelas_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('kelas', 'Kelas', 'required');
    $this->form_validation->set_rules('kategori_id', 'Kelas', 'required|numeric');
    
    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Input data tidak lengkap!"
      ];
      echo json_encode($data);
    } else {
      $this->process_kelas_add();
    }  
  }

  private function process_kelas_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $data = [];
    $kelas = (object)html_escape($this->input->post());
    $check = $this->M_master->add_kelas($kelas);
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

  public function get_kelas_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_master->get_kelas_detail($id);
    echo json_encode($check);
  }

  public function validate_kelas_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('kelas', 'Kelas', 'required');
    $this->form_validation->set_rules('kelas_id', 'Kelas', 'required|alpha_numeric');
    $this->form_validation->set_rules('kategori_id', 'Kelas', 'required|numeric');
    
    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Input data tidak lengkap!"
      ];
      echo json_encode($data);
    } else {
      $this->process_kelas_edit();
    }
  }

  private function process_kelas_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $data = [];
    $input = (object)html_escape($this->input->post());
    $check = $this->M_master->edit_kelas($input);
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

  public function process_kelas_delete()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = (int) decrypt_url(html_escape($this->input->get("id")));
    if (is_int($id) && $id !== 0) {
      $check = $this->M_master->delete_kelas($id);
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
    } else {
      $data = [
        "success" => 201,
        "message" => "Ada data yang tidak valid!"
      ];
      echo json_encode($data);
    }
  }

  public function validate_angkatan_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('angkatan', 'Angkatan', 'trim|required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Isi data dengan benar & lengkap!"
      ];
      echo json_encode($data);
    } else {
      $this->process_angkatan_add();
    }
  }

  private function process_angkatan_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $angkatan = html_escape($this->input->post("angkatan"));
    $check = $this->M_master->add_angkatan($angkatan);
    $data = [];
    if ($check->success == TRUE) {
      $data = [
        "success" => 200,
        "message" => $check->message
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function get_angkatan_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_master->get_detail_angkatan($id);
    echo json_encode($check);
  }

  public function validate_angkatan_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('angkatan_id', 'Angkatan', 'trim|required');
    $this->form_validation->set_rules('angkatan', 'Angkatan', 'trim|required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Isi data dengan benar & lengkap!"
      ];
      echo json_encode($data);
    } else {
      $this->process_angkatan_edit();
    }
  }

  public function process_angkatan_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $Input = (object)html_escape($this->input->post());
    $check = $this->M_master->edit_angkatan($Input);
    $data = [];
    if ($check->success === TRUE) {
      $data = [
        "success" => 200,
        "message" => $check->message
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function process_angkatan_delete()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = (int) decrypt_url(html_escape($this->input->get("id")));
    if (is_int($id) && $id !== 0) {
      $check = $this->M_master->delete_angkatan($id);
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
    } else {
      $data = [
        "success" => 201,
        "message" => "Ada data yang tidak valid!"
      ];
      echo json_encode($data);
    }
  }

  public function validate_cabang_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('cabang', 'Cabang', 'required|alpha');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Data yang dimasukan tidak valid!"
      ];
      echo json_encode($data);
    } else {
      $this->process_cabang_add();
    }        
  }

  private function process_cabang_add()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $cabang = html_escape($this->input->post("cabang"));
    $check = $this->M_master->add_cabang($cabang);
    if ($check->success === TRUE) {
      $data = [
        "success" => 200
      ];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function get_cabang_detail()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = decrypt_url(html_escape($this->input->get("id")));
    $check = $this->M_master->get_cabang_detail($id);
    echo json_encode($check);
  }

  public function validate_cabang_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $this->form_validation->set_rules('cabang', 'Cabang', 'required|alpha');
    $this->form_validation->set_rules('cabang_id', 'Cabang', 'required|alpha_numeric');
    
    if ($this->form_validation->run() == FALSE) {
      $data = [
        "success" => 201,
        "message" => "Data yang dimasukan tidak valid!"
      ];
      echo json_encode($data);
    } else {
      $this->process_cabang_edit();
    }
  }

  private function process_cabang_edit()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $input = (object)html_escape($this->input->post());
    $check = $this->M_master->edit_cabang($input);
    if ($check->success === TRUE) {
      $data = ["success" => 200];
      $this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses', '$check->message')</script>");
    } else {
      $data = [
        "success" => 201,
        "message" => $check->message
      ];
    }
    echo json_encode($data);
  }

  public function process_cabang_delete()
  {
    $this->addon->htaccess("WHITE_LIST", ["Super Admin|100|0", "Struktural Olpres|80|1"]);
    $id = (int) decrypt_url(html_escape($this->input->get("id")));
    if (is_int($id) && $id !== 0) {
      $check = $this->M_master->delete_cabang($id);
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
    } else {
      $data = [
        "success" => 201,
        "message" => "Ada data yang tidak valid!"
      ];
      echo json_encode($data);
    }
  }
}
