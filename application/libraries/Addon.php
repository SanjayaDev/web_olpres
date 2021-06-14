<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addon
{

  protected $ci;

  public function __construct()
  {
    $this->ci = &get_instance();
    $this->ci->load->model("M_data");
  }

  public function login_security()
  {
    if ($this->ci->session->login !== TRUE) {
      $this->ci->session->set_flashdata('pesan', '<script>sweet("error", "Gagal!", "Anda wajib login dahulu!")</script>');
      redirect(base_url());
    }
  }

  public function htaccess($access, $action = [], $is_ajax = TRUE)
  {
    $forbidden = TRUE;
    if ($access == "WHITE_LIST") {
      if (is_array($action)) {
        // var_dump("Masuk");
        for ($i = 0; $i < count($action); $i++) {
          $rule = explode("|", $action[$i]);
          $delimiter = "";
          if (end($rule) == 1) {
            $delimiter = ">=";
          } else {
            $delimiter = "=";
          }
          $admin_level = $rule[1];
          $sql  = "SELECT * FROM `list_role` lr "
            .  "JOIN `list_divisi` ld ON ld.`divisi_id` = lr.`divisi_id` "
            .  "WHERE ld.`division_name` = ? AND lr.`admin_level` $delimiter $admin_level;";
          $query = $this->ci->db->query($sql, [$rule[0]]);
          if ($query) {
            foreach ($query->result() as $item) {
              if ($this->ci->session->admin_level == $item->admin_level) {
                $forbidden = FALSE;
              }
            }
          }
        }
      } else if (is_string($action)) {
        if ($action == "ALL") {
          $divisi_id = $this->ci->session->divisi_id;
          $role_id = $this->ci->session->role_id;
          $user_id = $this->ci->session->user_id;

          $query = $this->ci->db->select("lr.*")
                            ->from("`list_user` lu")
                            ->join("`list_role` lr", "lr.`role_id` = lu.`role_id`")
                            ->where("lr.`divisi_id`", $divisi_id)->where("lr.`role_id`", $role_id)->where("lu.`user_id`", $user_id)
                            ->get();
          if ($query) {
            if ($query->num_rows() > 0) {
              $forbidden = FALSE;
            }
          }
        }
      }
    }
    if ($forbidden === TRUE) {
      if ($is_ajax === TRUE) {
        $data = [
          "success" => 403,
          "link" => base_url("forbidden")
        ];
        echo json_encode($data);
        exit;
      } else {
        redirect("forbidden");
      }
    }
  }

  public function check_unique($table, $column, $value)
  {
    $query = $this->ci->db->get_where($table, [$column => $value]);
    if ($query) {
      if ($query->num_rows() == 0) {
        return FALSE;
      } else {
        return TRUE;
      }
    } else {
      return "Query failed!";
    }
  }

  public function draw_breadcrumb($link = "", $title = "", $delete = "")
  {
    if ($delete === TRUE) {
      $breadcrumb = [[
        "title" => $title,
        "link" => $link
      ]];
      $this->ci->session->unset_userdata("breadcrumb");
      $this->ci->session->set_userdata("breadcrumb", $breadcrumb);
    } else {
      $breadcrumb = [];
      foreach ($this->ci->session->userdata("breadcrumb") as $item) {
        if ($item["title"] != $title) {
          array_push($breadcrumb, ["title" => $item["title"], "link" => $item["link"]]);
        }
      }
      array_push($breadcrumb, ["title" => $title, "link" => $link]);
      $this->ci->session->unset_userdata("breadcrumb");
      $this->ci->session->set_userdata("breadcrumb", $breadcrumb);
    }
    $data = $this->ci->session->userdata("breadcrumb");
    $last = count($data) - 1;
    // var_dump($this->ci->session->userdata("breadcrumb"));
    $html = "<nav aria-label='breadcrumb'>";
    $html .= "<ol class='breadcrumb'>";
    for ($i = 0; $i < count($data); $i++) {
      if ($i != $last) {
        $html .= "<li class='breadcrumb-item'><a href='" . $data[$i]["link"] . "'>" . $data[$i]["title"] . "</a></li>";
      } else {
        $html .= "<li class='breadcrumb-item active'>" . $data[$i]["title"] . "</li>";
      }
    }
    $html .= "</ol>";
    $html .= "</nav>";
    return $html;
  }

  public function check_other_unique($table, $column, $value, $except_column, $except_value)
  {
    $query = $this->ci->db->select("*")
      ->from($table)
      ->where($column, $value)
      ->where("$except_column != $except_value")
      ->get();
    if ($query) {
      if ($query->num_rows() == 0) {
        return FALSE;
      } else if ($query->num_rows() > 0) {
        return TRUE;
      }
    } else {
      return "Query failed!";
    }
  }
}
