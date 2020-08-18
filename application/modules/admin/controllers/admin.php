<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends MY_Controller {


	public function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('astrosession') == FALSE) {
			redirect(base_url('authenticate'));			
		}
	}

	public function index()
	{
		redirect(base_url('admin/template'));
		
	}
	public function template()
	{
		$this->load->view('admin/template');
	}	

	public function change_password()
	{
		$data['aktif'] = 'master';
        $data['konten'] = $this->load->view('admin/change_password', null, true);
        $data['halaman'] = $this->load->view('admin/menu', $data, true);
        $this->load->view('admin/main2', $data);


			
	}

	public function simpan_change_password()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('pass_baru', 'temp', 'required');		
		
		$id = $this->input->post("id");
		$data['upass'] = paramEncrypt($this->input->post("pass_baru"));
		
		$this->db->update("atombizz_employee", $data, "id = " . $id);
		echo '<div class="toast toast-success"><div class="toast-title">Notifications</div><div class="toast-message">Berhasil merubah password.</div></div>';          
	}

	public function dasboard()
	{
		$data['konten'] = $this->load->view('dasboard', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function logout()
	{
		$this->session->unset_userdata('astrosession');
		$this->session->sess_destroy();
		clearstatcache();
		redirect($this->cname);
	}
}
