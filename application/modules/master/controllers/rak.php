<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rak extends MY_Controller {

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
        $data['konten'] = $this->load->view('rak/daftar_rak', NULL, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $this->load->view('rak/main', $data);       
        
    }	

    public function menu()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $this->load->view('rak/main', $data);       
    }

    public function rak()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('rak/daftar_rak', NULL, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $this->load->view('rak/main', $data);       
    }

    public function tambah()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/rak/tambah_rak', NULL, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $this->load->view('rak/main', $data);       
    }
    
    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/rak/detail_rak', NULL, TRUE);
        $data['halaman'] = $this->load->view('rak/menu', $data, TRUE);
        $this->load->view('rak/main', $data);       
    }

    public function simpan_rak()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_rak', 'Kode rak', 'required');
        $this->form_validation->set_rules('nama_rak', 'Nama rak', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);
            $unit = $this->db->get_where('master_unit',array('kode_unit'=>$data['kode_unit']));
            $hasil_unit = $unit->row();
            $data['nama_unit'] = $hasil_unit->nama_unit;
            $data['status'] = '1';
            $this->db->insert("master_rak", $data);

            // ---------------------singkron----------------------------------------------------------------------------------------
            $singkron_query = $this->db->last_query();
            $singkron['jenis_singkron'] = 'tambah';
            $singkron['query'] = $singkron_query;
            $singkron['status'] = 'pending';
            $this->db->insert("singkronasi", $singkron);

            echo 'sukses';            
        }
    }    

    public function simpan_edit_rak(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_rak', 'Kode rak', 'required');
        $this->form_validation->set_rules('id', 'id', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);
            $unit = $this->db->get_where('master_unit',array('kode_unit'=>$data['kode_unit']));
            $hasil_unit = $unit->row();
            $data['nama_unit'] = $hasil_unit->nama_unit;

            $this->db->update("master_rak",$data,array('kode_rak'=>$data['kode_rak']));

            // ---------------------singkron----------------------------------------------------------------------------------------
            $singkron_query = $this->db->last_query();
            $singkron['jenis_singkron'] = 'ubah';
            $singkron['query'] = $singkron_query;
            $singkron['status'] = 'pending';
            $this->db->insert("singkronasi", $singkron);

            echo 'sukses';            
        }
    }

    public function get_kode()
    {
        $kode_rak = $this->input->post('kode_rak');
        $query = $this->db->get_where('master_rak',array('kode_rak' => $kode_rak))->num_rows();

        if($query > 0){
            echo "1";
        }
        else{
            echo "0";
        }
    }

    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $kode = $this->input->post('kode_rak');
        $this->db->delete('master_rak',array('kode_rak'=>$kode));

        // ---------------------singkron----------------------------------------------------------------------------------------
        $singkron_query = $this->db->last_query();
        $singkron['jenis_singkron'] = 'hapus';
        $singkron['query'] = $singkron_query;
        $singkron['status'] = 'pending';
        $this->db->insert("singkronasi", $singkron);
    }

    
}
