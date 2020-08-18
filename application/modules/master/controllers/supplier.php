<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {

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

	public function index()
	{
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('supplier/daftar_supplier', NULL, TRUE);
		$data['halaman'] = $this->load->view('supplier/menu', $data, TRUE);
		$this->load->view('supplier/main', $data);	
		
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

	public function menu()
	{
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('master/menu', NULL, TRUE);
		$this->load->view ('main', $data);      
	}

	public function supplier()
	{
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('supplier/daftar_supplier', NULL, TRUE);
		$data['halaman'] = $this->load->view('supplier/menu', $data, TRUE);
		$this->load->view('supplier/main', $data);	
	}

	public function tambah()
	{
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('master/supplier/tambah_supplier', NULL, TRUE);
		$data['halaman'] = $this->load->view('supplier/menu', $data, TRUE);
		$this->load->view('supplier/main', $data);	
	}

	public function detail()
	{
		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('master/supplier/detail_supplier', NULL, TRUE);
		$data['halaman'] = $this->load->view('supplier/menu', $data, TRUE);
		$this->load->view('supplier/main', $data);	
	}
	
    	//------------------------------------------ Proses Simpan----------------- --------------------//
	

	public function simpan_tambah_supplier()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode_supplier', 'kode supplier', 'required');
		$this->form_validation->set_rules('kategori_supplier', 'kategori supplier', 'required'); 
		$this->form_validation->set_rules('nama_supplier', 'nama supplier', 'required');
		$this->form_validation->set_rules('alamat_supplier', 'alamat supplier', 'required'); 
		$this->form_validation->set_rules('no_rek', 'no rek', 'required');
		$this->form_validation->set_rules('nama_pic', 'nama pic', 'required');
		$this->form_validation->set_rules('jabatan_pic', 'jabatan pic', 'required');
		$this->form_validation->set_rules('telp_pic', 'no. hp pic', 'required');
		$this->form_validation->set_rules('termin', 'termin', 'required');
		$this->form_validation->set_rules('status_supplier', 'status', 'required'); 
		

        //jika form validasi berjalan salah maka tampilkan GAGAL
		if ($this->form_validation->run() == FALSE) {
			echo warn_msg(validation_errors());
		} 
        //jika form validasi berjalan benar maka inputkan data
		else {
			$data = $this->input->post(NULL, TRUE);

			$this->db->insert("master_supplier", $data);

			// ---------------------singkron----------------------------------------------------------------------------------------
			$singkron_query = $this->db->last_query();
			$singkron['jenis_singkron'] = 'tambah';
			$singkron['query'] = $singkron_query;
			$singkron['status'] = 'pending';
			$this->db->insert("singkronasi", $singkron);

			echo '1';            
		}
	}

	
    //------------------------------------------ Proses Update----------------- --------------------//
	
	public function simpan_edit_supplier()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode_supplier', 'kode supplier', 'required');
		$this->form_validation->set_rules('kategori_supplier', 'kategori supplier', 'required'); 
		$this->form_validation->set_rules('nama_supplier', 'nama supplier', 'required');
		$this->form_validation->set_rules('alamat_supplier', 'alamat supplier', 'required'); 
		$this->form_validation->set_rules('no_rek', 'no rekening', 'required');
		$this->form_validation->set_rules('nama_pic', 'nama pic', 'required');
		$this->form_validation->set_rules('jabatan_pic', 'jabatan pic', 'required');    
		$this->form_validation->set_rules('telp_pic', 'no. hp pic', 'required');
		$this->form_validation->set_rules('status_supplier', 'status', 'required'); 
		

        //jika form validasi berjalan salah maka tampilkan GAGAL
		if ($this->form_validation->run() == FALSE) {
			echo warn_msg(validation_errors());
		} 
        //jika form validasi berjalan benar maka inputkan data
		else {
			$data = $this->input->post(NULL, TRUE);

			$this->db->update("master_supplier", $data, array('id'=>$data['id']));
			
			// ---------------------singkron----------------------------------------------------------------------------------------
			$singkron_query = $this->db->last_query();
			$singkron['jenis_singkron'] = 'ubah';
			$singkron['query'] = $singkron_query;
			$singkron['status'] = 'pending';
			$this->db->insert("singkronasi", $singkron);

			echo '1';            
		}
	}

	public function get_kode()
	{
		$kode_supplier = $this->input->post('kode_supplier');
		$query = $this->db->get_where('master_supplier',array('kode_supplier' => $kode_supplier))->num_rows();

		if($query > 0){
			echo "1";
		}
		else{
			echo "0";
		}
	}
	
    //------------------------------------------ Proses Delete----------------- --------------------//
	public function hapus(){
		$id = $this->input->post('id');
		$this->db->delete('master_supplier',array('id'=>$id));

		// ---------------------singkron----------------------------------------------------------------------------------------
		$singkron_query = $this->db->last_query();
		$singkron['jenis_singkron'] = 'hapus';
		$singkron['query'] = $singkron_query;
		$singkron['status'] = 'pending';
		$this->db->insert("singkronasi", $singkron);
	}

	
}
