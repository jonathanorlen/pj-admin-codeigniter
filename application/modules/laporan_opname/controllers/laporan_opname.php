<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class laporan_opname extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('astrosession') == FALSE) {
			redirect(base_url('authenticate'));			
		}
		$this->load->library('form_validation');
		$this->load->library('session');
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

	public function index()
	{
		redirect(base_url('master/daftar'));
	}

	public function daftar()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/daftar', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}

	public function daftar_spoil()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/daftar_spoil', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}

	public function detail_spoil()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/detail_spoil', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}
	public function menu_laporan()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/menu_laporan', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}

	public function total_opname()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/total_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}


public function total_spoil()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/total_spoil', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}

	
	public function detail()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('setting/detail', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}
	
	
}
