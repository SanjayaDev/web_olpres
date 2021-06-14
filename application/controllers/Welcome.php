<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->session->unset_userdata('login');
		$this->load->model("M_login");
	}

	public function index()
	{
		$this->form_validation->set_rules('user_username', 'Username', 'trim|required|alpha_numeric_spaces', [
			"trim" => "Username tidak boleh mengandung spasi!",
			"required" => "Wajib masukan username!",
			"alpha_numeric_spaces" => "Data yang anda masukan tidak valid!"
		]);
		$this->form_validation->set_rules('user_password', 'Password', 'required|alpha_numeric_spaces', [
			"required" => "Wajib masukan password!",
			"alpha_numeric_spaces" => "Data yang anda masukan tidak valid!"
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_home');
		} else {
			$this->process_login();
		}
	}

	private function process_login()
	{
		$input = (object)html_escape($this->input->post());
		$check = $this->M_login->login_check($input);
		if ($check->success === TRUE) {
			if (isset($check->url)) {
				redirect($check->url);
			} else {
				$this->session->set_flashdata('pesan', '<script>sweet("success", "Sukses!", "' . $check->message . '")</script>');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("error", "Gagal!", "' . $check->message . '")</script>');
			redirect(base_url());
		}
	}

	public function view_register_page()
	{
		$this->form_validation->set_rules('user_username', 'Username', 'trim|required|min_length[5]|is_unique[list_user.user_username]|alpha_numeric', [
			"trim" => "Username tidak boleh mengandung spasi!",
			"required" => "Wajib masukan username",
			"min_length" => "Masukan minimal 5 karakter!",
			"is_unique" => "Username sudah digunakan!",
			"alpha_numeric" => "Username hanya boleh huruf atau angka!"
		]);
		$this->form_validation->set_rules('user_nama', 'Nama', 'required|is_unique[list_user.user_nama]|alpha', [
			"required" => "Wajib masukan nama",
			"is_unique" => "Nama sudah digunakan!",
			"alpha" => "Nama tidak boleh mengandung angka!"
		]);
		$this->form_validation->set_rules('user_gender', 'Jenis Kelamin', 'required|alpha_dash', [
			"required" => "Wajib masukan jenis kelamin",
			"alpha" => "Data jenis kelamin anda tidak benar!"
		]);
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[list_user.user_email]', [
			"required" => "Wajib masukan Email",
			"valid_email" => "Masukan format email dengan benar!",
			"is_unique" => "Email sudah pernah didaftarkan!"
		]);
		$this->form_validation->set_rules('kelas_id', 'Kelas', 'required|numeric', [
			"required" => "Wajib masukan Kelas",
			"numeric" => "Data kelas anda tidak benar!"
		]);
		$this->form_validation->set_rules('angkatan_id', 'angkatan', 'required|numeric', [
			"required" => "Wajib masukan Angkatan",
			"numeric" => "Data angkatan anda tidak benar!"
		]);
		$this->form_validation->set_rules('cabang_id', 'cabang', 'required|numeric', [
			"required" => "Wajib masukan Cabang",
			"numeric" => "Data cabang anda tidak benar!"
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|matches[password_verif]|alpha_numeric', [
			"required" => "Wajib masukan Password",
			"matches" => "Password tidak sesuai!",
			"alpha_numeric" => "Password hanya boleh huruf atau angka!"
		]);
		$this->form_validation->set_rules('password_verif', 'Password', 'required|matches[password]|alpha_numeric', [
			"required" => "Wajib masukan Ulangi Password",
			"matches" => "Password tidak sesuai!",
			"alpha_numeric" => "Ulangi password hanya boleh huruf atau angka!"
		]);
		$this->form_validation->set_rules('code_reference', 'cabang', 'required|numeric', [
			"required" => "Wajib masukan Code register",
			"numeric" => "Code wajib angka!"
		]);

		if ($this->form_validation->run() == FALSE) {
			$data["list_kelas"] = $this->M_data->get_class_list();
			$data["list_angkatan"] = $this->M_data->get_angkatan_list();
			$data["list_cabang"] = $this->M_data->get_cabang_list();
			$this->load->view('v_register', $data);
		} else {
			$this->process_register_add();
		}
	}

	private function process_register_add()
	{
		$input = (object) html_escape($this->input->post());
		$check = $this->M_login->register($input);
		if ($check->success === TRUE) {
			$this->session->set_flashdata("pesan", "<script>sweet('success', 'Sukses', '$check->message')</script>");
			redirect(base_url());
		} else {
			$this->session->set_flashdata("pesan", "<script>sweet('error', 'Gagal', '$check->message')</script>");
			redirect(base_url("register"));
		}
	}
}
