<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mutasi extends MY_Controller {

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
	 *s
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
	 public function cari_mutasi()
    {
        $this->load->view('daftar_mutasi/cari_mutasi');       
    }
     public function cari_mutasi_kitchen()
    {
        $this->load->view('daftar_mutasi/cari_mutasi_kitchen');       
    }
	public function index()
	{
		$data['halaman'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);
	}

	public function daftar()
	{
		$data['halaman'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function gudang()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_mutasi/daftar_mutasi_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function detail_mutasi_gudang()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_mutasi/detail_mutasi_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function detail_mutasi_kitchen()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_mutasi/detail_mutasi_kitchen', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function kitchen()
	{
		$data['aktif'] = 'kitchen';
		$data['konten'] = $this->load->view('daftar_mutasi/daftar_mutasi_kitchen', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function bar()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_mutasi/daftar_mutasi_bar', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function server()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_mutasi/daftar_mutasi_server', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_mutasi/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function tambah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/form', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function ubah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/form', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function detail()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);				
	}


	public function hapus(){
		$kode = $this->input->post("key");
		$this->db->delete( 'master_barang', array('kode_barang' => $kode) );
		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}
    
    public function detail_stok_gudang(){
        $data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/detail_stok_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);	
    }

	public function get_temp_pembelian(){
		$id = $this->input->post('id');
		$pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('id'=>$id));
		$hasil_pembelian = $pembelian->row();
		echo json_encode($hasil_pembelian);
	}

	public function simpan_tambah()

	{
		$data['kode_barang'] = $this->input->post("kode_barang");
		$data['nama_barang'] = $this->input->post("nama_barang");
		$data['kode_supplier'] = $this->input->post("supplier");
		$parameter = $this->input->post("supplier");
		$get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
		$hasil_master_supplier = $get_master_supplier->row();
		$item = $hasil_master_supplier;
		$data['nama_supplier'] = $item->nama_supplier;

		$data['stok'] = $this->input->post("stok");
		$data['position'] = $this->input->post("position");

		$insert = $this->db->insert("master_barang", $data); 
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['kode_barang']);
	}

	public function simpan_ubah()

	{
		$data['kode_barang'] = $this->input->post("kode_barang");
		$data['nama_barang'] = $this->input->post("nama_barang");
		$data['kode_supplier'] = $this->input->post("supplier");
		$parameter = $this->input->post("supplier");
		$get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
		$hasil_master_supplier = $get_master_supplier->row();
		$item = $hasil_master_supplier;
		$data['nama_supplier'] = $item->nama_supplier;

		$data['stok'] = $this->input->post("stok");
		$data['position'] = $this->input->post("position");

		$update = $this->db->update("master_barang", $data, array('kode_barang' => $data['kode_barang'])); 
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['kode_barang']);
	}
}
