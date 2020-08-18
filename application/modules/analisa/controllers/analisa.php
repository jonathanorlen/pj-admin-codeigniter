<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class analisa extends MY_Controller {

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
		$data['konten'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);
	}

	public function daftar()
	{
		$data['konten'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function laporan_grafik()
	{

		$data['aktif'] = 'Laporan Grafik';
		$data['konten'] = $this->load->view('setting/menu_laporan_grafik', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);
	}

	public function grafik_pembelian()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('setting/grafik_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);
		
	}

	public function cari_grafik_pembelian()
	{

		$this->load->view('setting/cari_grafik_pembelian');
		
	}

	public function grafik_penjualan()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('setting/grafik_penjualan', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);

	}
	public function cari_grafik_penjualan()
	{

		$this->load->view('setting/cari_grafik_penjualan');
		
	}
	

	public function grafik_faktur()
	{
		
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('setting/grafik_faktur', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);		
	}
	

	public function cari_grafik_faktur()
	{

		$this->load->view('setting/cari_grafik_faktur');
		
	}
	public function grafik_laba_rugi()
	{
		

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('setting/grafik_laba_rugi', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);
	}

	public function cari_grafik_laba_rugi()
	{

		$this->load->view('setting/cari_grafik_laba_rugi');
		
	}




	


	

	
}
