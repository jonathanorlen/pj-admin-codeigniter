<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class laporan extends MY_Controller {

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
		$data['halaman'] = $this->load->view('menu', NULL, TRUE);
		$this->load->view ('main', $data);	
	}

	public function laporan_penjualan()
	{
		$data['aktif'] = 'laporan_penjualan';
		$data['konten'] = $this->load->view('setting/laporan_penjualan', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}

	public function laporan_ritase()
	{
		$data['aktif'] = 'laporan_penjualan';
		$data['konten'] = $this->load->view('laporan_ritase/daftar_laporan_ritase', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}
	public function cari_laporan_ritase()
	{
		
		$this->load->view('laporan_ritase/cari_laporan_ritase');
		
	}

	
	public function detail_laporan_ritase()
	{
		$data['aktif'] = 'laporan_penjualan';
		$data['konten'] = $this->load->view('laporan_ritase/detail_laporan_ritase', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}

	public function detail_laporan_per_ritase()
	{
		$data['aktif'] = 'laporan_penjualan';
		$data['konten'] = $this->load->view('laporan_ritase/detail_per_ritase', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}

	


	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_laporan_penjualan', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}

	public function detail_retur()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_retur_penjualan', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}
	public function search_retur()
	{
		$this->load->view('setting/search_retur');	
	}
	public function laporan_menu()
	{
		$data['aktif'] = 'laporan_menu';
		$data['konten'] = $this->load->view('setting/laporan_menu', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}
	public function laporan_retur()
	{
		$data['aktif'] = 'laporan_menu';
		$data['konten'] = $this->load->view('setting/laporan_retur', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}
	public function laporan_retur_pembelian()
	{
		$data['aktif'] = 'laporan_menu';
		$data['konten'] = $this->load->view('setting/laporan_retur_pembelian', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}


	public function detail_menu()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_laporan_menu', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}
	public function detail_retur_pembelian()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_retur_pembelian', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('setting/main', $data);	
	}

	
	public function search_laporan()
	{
		$this->load->view('setting/search_penjualan');
	}
	public function search_laporan_menu()
	{
		$this->load->view('setting/search_menu');
	}
	public function search_retur_pembelian()
	{
		$this->load->view('setting/search_retur_pembelian');
	}

	

	
}
