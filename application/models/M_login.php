<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

  public function __construct()
  {
    date_default_timezone_set("Asia/Jakarta");
    $this->load->model("M_absen", "ma");
  }

  public function login_check($input)
  {
    $response = new stdClass();
    $response->success = FALSE;
    $query = $this->db->select("*")->from("`list_user` lu")
      ->join("`list_role` lr", "lr.`role_id` = lu.`role_id`")
      ->join("`list_divisi` ld", "ld.`divisi_id` = lr.`divisi_id`")
      ->where("lu.`user_username`", $input->user_username)
      ->get();
    if ($query) {
      if ($query->num_rows() == 1) {
        $data = $query->row();
        if ($data->is_active == 1) {
          if (password_verify($input->user_password, $data->user_password)) {
            if ($data->kelas_id != 1 || ($data->kelas_id == 1 && $data->user_id == 1)) {
              if ($data->admin_level >= 50) {
                $session = [
                  "user_id" => $data->user_id,
                  "login" => TRUE,
                  "divisi_id" => $data->divisi_id,
                  "role_id" => $data->role_id,
                  "admin_level" => $data->admin_level,
                  "cabang_id" => $data->cabang_id
                ];
                $this->session->set_userdata($session);
                $this->update_last_login($data->user_id);
                if ($input->code != "" && $data->kelas_id != 1) {
                  $check_code = $this->check_code_absen($input->code);
                  if ($check_code->success === TRUE) {
                    $absen = $this->ma->insert_absen($data->user_id);
                    if ($absen->success !== TRUE) {
                      $response->message = $absen->message;
                      return $response;
                    }
                  } else {
                    $response->message = $check_code->message;
                    return $response;
                  }
                }
                $response->success = TRUE;
                if ($data->divisi_id <= 3) {
                  $response->url = "dashboard";
                }
              } else {
                $check_code = $this->check_code_absen($input->code);
                if ($check_code->success === TRUE) {
                  $check_status_absen = $this->get_status_absen($data->user_id);
                  if ($check_status_absen === TRUE) {
                    $absen = $this->ma->insert_absen($data->user_id, $input->code);
                    if ($absen->success === TRUE) {
                      $response->success = TRUE;
                      $response->message = $absen->message;
                    } else {
                      $response->message = $absen->message;
                    }
                  } else {
                    $response->message = "Maaf, anda sudah melakukan absen hari ini!";
                  }
                } else {
                  $response->message = $check_code->message;
                }
              }
            } else {
              $response->message = "Maaf, kakak alumni tidak di izinkan masuk :)";
            }
          } else {
            $response->message = "Password anda salah!";
          }
        } else if ($data->admin_status_id == 0) {
          $response->message = "Akun anda belum di aktifkan oleh administrator!";
        } else {
          $response->message = "Akun anda telah disuspend!";
        }
      } else {
        $response->message = "Akun anda tidak ditemukan";
      }
    } else {
      $response->message = "Query 1 Failed!";
    }
    return $response;
  }

  private function get_status_absen($user_id)
  {
    $where = [
      "user_id" => $user_id,
      "absen_date" => date("Y-m-d H:i:00")
    ];
    $query = $this->db->get_where("list_absen", $where);
    if ($query) {
      // var_dump($this->db->last_query());
      if ($query->num_rows() == 0) {
        return TRUE;
      } else {
        return FALSE;
      }
    } else {
      return FALSE;
    }
  }

  private function update_last_login($user_id)
  {
    $data = ["last_login" => date("Y-m-d H:i:s")];
    $where = ["user_id" => $user_id];
    $this->db->update("list_user", $data, $where);
  }

  private function check_code_absen($code)
  {
    $response = new stdClass();
    $query = $this->db->get_where("list_code", ["code" => $code]);
    if ($query) {
      if ($query->num_rows() == 0) {
        $response->success = FALSE;
        $response->message = "Maaf, code anda tidak benar!";
      } else {
        $response->success = TRUE;
      }
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }

    return $response;
  }

  public function register(object $input)
  {
    $response = new stdClass();
    $query = $this->db->select("is_register")->from("list_setting")->where("setting_id", 1)->get();
    if ($query) {
      $is_register = $query->row()->is_register;
      if ($is_register == 1) {
        $query2 = $this->db->select("code")->from("list_code")->where(["code_id" => 2])->get();
        // var_dump($this->db->last_query());
        if ($query2) {
          $code = $query2->row()->code;
          if ($code == $input->code_reference) {
            $data = [
              "user_nama" => $input->user_nama,
              "user_gender" => $input->user_gender,
              "user_username" => $input->user_username,
              "user_password" => password_hash($input->password, PASSWORD_DEFAULT),
              "user_email" => $input->user_email,
              "is_active" => 0,
              "user_image" => "default.jpg",
              "role_id" => 8,
              "kelas_id" => $input->kelas_id,
              "angkatan_id" => $input->angkatan_id,
              "cabang_id" => $input->cabang_id
            ];
            $query3 = $this->db->insert("list_user", $data);
            if ($query3) {
              $response->success = TRUE;
              $response->message = "Registrasi berhasil! Silahkan login!";
            } else {
              $response->success = FALSE;
              $response->message = "Query 3 failed!";
            }
          } else {
            $response->success = FALSE;
            $response->message = "Kode anda salah!";
          }
        } else {
          $response->success = FALSE;
          $response->message = "Query 2 failed!";
        }
      } else {
        $response->success = FALSE;
        $response->message = "Maaf saat ini sedang tidak bisa untuk registrasi!";
      }
    } else {
      $response->success = FALSE;
      $response->message = "Query failed!";
    }
    return $response;
  }
}
