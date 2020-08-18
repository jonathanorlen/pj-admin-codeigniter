<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends MY_Controller {

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
        $data['konten'] = $this->load->view('jabatan/daftar_jabatan', NULL, TRUE);
        $data['halaman'] = $this->load->view('jabatan/menu', $data, TRUE);
        $this->load->view('jabatan/main', $data);  

       /* $data['aktif']='master';
		$data['konten'] = $this->load->view('jabatan/daftar_jabatan', NULL, TRUE);
		$this->load->view ('main', $data);	*/
		
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

    public function menu()
    {
        $data['aktif']='master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $this->load->view ('main', $data);      
    }

	public function hak_akses()
	{
        $data['aktif']='master';
		$data['konten'] = $this->load->view('jabatan/daftar_jabatan', NULL, TRUE);
		$this->load->view ('main', $data);	
	}

	public function tambah()
	{
	    $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('jabatan/tambah_jabatan', NULL, TRUE);
        $data['halaman'] = $this->load->view('jabatan/menu', $data, TRUE);
        $this->load->view('jabatan/main', $data);  
       
        
	}

    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('jabatan/detail_jabatan', NULL, TRUE);
        $data['halaman'] = $this->load->view('jabatan/menu', $data, TRUE);
        $this->load->view('jabatan/main', $data);  
        
         
    }

    public function get_kode()
    {
        $kode_jabatan = $this->input->post('kode_jabatan');
        $query = $this->db->get_where('master_jabatan',array('kode_jabatan' => $kode_jabatan))->num_rows();

        if($query > 0){
            echo "1";
        }
        else{
            echo "0";
        }
    }
    
    	//------------------------------------------ Proses Simpan----------------- --------------------//
   	

    public function simpan_tambah_jabatan()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_jabatan', 'kode_jabatan', 'required');
        $this->form_validation->set_rules('nama_jabatan', 'nama_jabatan', 'required'); 

        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);
            $list_modul = implode('|', $data['modul']);
            $user = array(
                    'kode_jabatan' => $data['kode_jabatan'],
                    'nama_jabatan' => $data['nama_jabatan'],
                    'keterangan' => $data['keterangan'],
                    'modul' =>  $list_modul
            );
            if(!empty($user))$insert = $this->db->insert("master_jabatan",$user);
            if($insert == TRUE){
                echo '<div class="alert alert-success">Sudah tersimpan.</div>'; 
            }         
        }
    }

    
    //------------------------------------------ Proses Update----------------- --------------------//
    
    public function simpan_edit_jabatan()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('kode_jabatan', 'kode_jabatan', 'required');
        $this->form_validation->set_rules('nama_jabatan', 'nama_jabatan', 'required'); 
        
        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);

                      $this->db->where('id',$data['id']);
            $delete = $this->db->delete('master_jabatan');

            if($delete){
                $list_modul = implode('|', $data['modul']);
                $user = array(
                    'kode_jabatan' => $data['kode_jabatan_uri'],
                    'nama_jabatan' => $data['nama_jabatan'],
                    'keterangan' => $data['keterangan'],
                    'modul' =>  $list_modul
                );
                if(!empty($user))$insert = $this->db->insert("master_jabatan",$user);
                //if(!empty($user))$add_user = $this->db->update('master_user',$user,array('id'=>$data['id']));
                echo '<div class="alert alert-success">Sudah tersimpan.</div>';    
            }  
        }
    }

   
    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $id = $this->input->post('id');
        $this->db->delete('master_jabatan',array('kode_jabatan'=>$id));
    }

}
