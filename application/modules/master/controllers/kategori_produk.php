<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori_produk extends MY_Controller {

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
	}

	//public function index()
	//{
	//	$data['konten'] = $this->load->view('kategori_menu/daftar_kategori_menu', NULL, TRUE);
	//	$this->load->view ('main', $data);	
	//}	

    //------------------------------------------ View Data Table----------------- --------------------//

	public function menu()
	{
		$data['aktif']='master';
		$data['konten'] = $this->load->view('master/menu', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function daftar_kategori_produk()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('kategori_produk/daftar_kategori_produk', NULL, TRUE);
		$data['halaman'] = $this->load->view('kategori_produk/menu', $data, TRUE);
		$this->load->view('kategori_produk/main', $data);

		
	}

	public function detail()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('kategori_produk/detail_kategori_produk', NULL, TRUE);
		$data['halaman'] = $this->load->view('kategori_produk/menu', $data, TRUE);
		$this->load->view('kategori_produk/main', $data);


	}

	//------------------------------------------ View Input----------------- --------------------//

	public function tambah()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('kategori_produk/tambah_kategori_produk', NULL, TRUE);
		$data['halaman'] = $this->load->view('kategori_produk/menu', $data, TRUE);
		$this->load->view('kategori_produk/main', $data);


	}

	//------------------------------------------ Proses Simpan----------------- --------------------//
	public function simpan_tambah_kategori_menu()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode_kategori_menu', 'temp', 'required');
		$this->form_validation->set_rules('nama_kategori_menu', 'temp', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
        //jika form validasi berjalan benar maka inputkan data
		else {
			$data = $this->input->post(NULL, TRUE);

			$this->db->insert("master_kategori_menu", $data);

            // ---------------------singkron----------------------------------------------------------------------------------------
			$singkron_query = $this->db->last_query();
			$singkron['jenis_singkron'] = 'tambah';
			$singkron['query'] = $singkron_query;
			$singkron['status'] = 'pending';
			$this->db->insert("singkronasi", $singkron);
			echo '<div class="alert alert-success">Sudah tersimpan.</div>';            
		}
	}

    //------------------------------------------ Proses Update----------------- --------------------//
	public function simpan_edit_kategori_menu() {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'temp', 'required');       

        //jika form validasi berjalan salah maka tampilkan GAGAL
		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
        //jika form validasi berjalan benar maka inputkan data
		else {
			$data = $this->input->post(NULL, TRUE);
			$id   = $this->input->post("id");

			$this->db->update("master_kategori_menu", $data, "id = " . $id);

            // ---------------------singkron----------------------------------------------------------------------------------------
			$singkron_query = $this->db->last_query();
			$singkron['jenis_singkron'] = 'ubah';
			$singkron['query'] = $singkron_query;
			$singkron['status'] = 'pending';
			$this->db->insert("singkronasi", $singkron);
			
			echo '<div class="alert alert-success">Berhasil diubah.</div>';
		}
	}

    //------------------------------------------ Proses Delete----------------- --------------------//
	public function hapus(){
		$kode = $this->input->post('kode_kategori_menu');

        // ---------------------singkron----------------------------------------------------------------------------------------
		$singkron_query = $this->db->last_query();
		$singkron['jenis_singkron'] = 'hapus';
		$singkron['query'] = $singkron_query;
		$singkron['status'] = 'pending';
		$this->db->insert("singkronasi", $singkron);
		$this->db->delete('master_kategori_menu',array('kode_kategori_menu'=>$kode));
	}

	
}
