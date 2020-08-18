<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting_harga extends MY_Controller {

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

	

	public function index()
	{

		$data['aktif'] = 'master';
		$data['konten'] = $this->load->view('setting_harga/form_setting', NULL, TRUE);
		$data['halaman'] = $this->load->view('setting_harga/menu', $data, TRUE);
		$this->load->view('kategori_produk/main', $data);

		
	}
    
    public function simpan_harga(){
        $this->load->library('form_validation');   
        $this->form_validation->set_rules('kode_kategori_produk', 'temp', 'required');    

        //jika form validasi berjalan salah maka tampilkan GAGAL
		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		}else{
		  	$data = $this->input->post(NULL, TRUE);
            if($data['harga_jual_1']!=0){
                $harga1['harga_jual_1'] = $data['harga_jual_1'];
                $this->db->update("master_bahan_baku",$harga1,array('kode_kategori_produk'=>$data['kode_kategori_produk']));
            }
            if($data['harga_jual_2']!=0){
                 $harga2['harga_jual_2'] = $data['harga_jual_2'];
                $this->db->update("master_bahan_baku",$harga2,array('kode_kategori_produk'=>$data['kode_kategori_produk']));
            }
            
		} 
    }

	
}
