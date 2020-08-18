<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class top_produk extends MY_Controller {

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
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function coba()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/coba', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}


	public function daftar()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}

	public function tambah()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	
	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
    
    public function search_aktifitas(){
        $data['konten'] = $this->load->view('setting/search_aktifitas');	
    }
    
    public function detail_pembelian()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_pembelian', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function detail_po()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_po', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
    
    public function detail_retur_pembelian()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_retur_pembelian', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
    
    public function detail_mutasi()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_mutasi', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}
    public function detail_spoil()
    {
        $data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_spoil', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
    }
    public function detail_opname()
    {
        $data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_opname', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
    }
    
    public function detail_penjualan()
    {
        $data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_penjualan', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
    }
    public function detail_ro()
    {
        $data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_ro', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);
    }

	
}
