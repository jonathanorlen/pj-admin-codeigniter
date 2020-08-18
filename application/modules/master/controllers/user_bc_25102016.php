<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller {
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
		$data['konten'] = $this->load->view('user/daftar_user', NULL, TRUE);
		$data['halaman'] = $this->load->view('user/menu', $data, TRUE);
		$this->load->view('user/main', $data);		
	}	
    //------------------------------------------ View Data Table----------------- --------------------//
    public function menu()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/menu', NULL, TRUE);
        $this->load->view ('main', $data);      
    }
	public function user()
	{
        $data['aktif'] = 'master';
		$data['konten'] = $this->load->view('user/daftar_user', NULL, TRUE);
		$data['halaman'] = $this->load->view('user/menu', $data, TRUE);
		$this->load->view('user/main', $data);		
	}
	public function tambah()
	{
        $data['aktif'] = 'master';
		$data['konten'] = $this->load->view('master/user/tambah_user', NULL, TRUE);
		$data['halaman'] = $this->load->view('user/menu', $data, TRUE);
		$this->load->view('user/main', $data);		
	}
    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/user/detail_user', NULL, TRUE);
        $data['halaman'] = $this->load->view('user/menu', $data, TRUE);
        $this->load->view('user/main', $data);      
    }
    	//------------------------------------------ Proses Simpan----------------- --------------------//
    public function simpan_tambah_user()
    {
        
        $this->form_validation->set_rules('uname', 'username', 'required');
        $this->form_validation->set_rules('upass', 'password', 'required'); 
        $this->form_validation->set_rules('jabatan', 'jabatan', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        #$this->form_validation->set_rules('modul', 'modul', 'required'); 
        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);
            $data['upass'] = paramEncrypt($data['upass']);

            $list_modul = implode('|', $data['modul']);
            $user = array(
                    'uname' => $data['uname'],
                    'upass' => $data['upass'],
                    'jabatan' => $data['jabatan'],
                    'modul' =>  $list_modul,
                    'status' => $data['status']
            );
            if(!empty($user))$add_user = $this->db->insert('master_user',$user);
            echo '<div class="alert alert-success">Sudah tersimpan.</div>';                 
        }
    }
    //------------------------------------------ Proses Update----------------- --------------------//
    public function simpan_edit_user()
    {
        $this->form_validation->set_rules('uname', 'username', 'required');
        $this->form_validation->set_rules('upass', 'password', 'required'); 
        $this->form_validation->set_rules('jabatan', 'jabatan', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('id', 'id', 'required');  
        //jika form validasi berjalan salah maka tampilkan GAGAL
        if ($this->form_validation->run() == FALSE) {
            echo warn_msg(validation_errors());
        } 
        //jika form validasi berjalan benar maka inputkan data
        else {
            $data = $this->input->post(NULL, TRUE);
            $upass = $data['upass'] = paramEncrypt($data['upass']);
            $uname = $data['uname'] ;

                      $this->db->where('uname',$uname);
                      $this->db->where('upass',$upass);
            $delete = $this->db->delete('master_user');

            if($delete){
                $list_modul = implode('|', $data['modul']);
                $user = array(
                        'uname' => $data['uname'],
                        'upass' => $data['upass'],
                        'jabatan' => $data['jabatan'],
                        'modul' =>  $list_modul,
                        'status' => $data['status']
                );
                if(!empty($user))$add_user = $this->db->insert('master_user',$user);
                echo '<div class="alert alert-success">Sudah tersimpan.</div>';    
            }           
        }
    }
    //------------------------------------------ Proses Delete----------------- --------------------//
    public function hapus(){
        $id = $this->input->post('id');
        $this->db->delete('master_user',array('id'=>$id));
    }
}