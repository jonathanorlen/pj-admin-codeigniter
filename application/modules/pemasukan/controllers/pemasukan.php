<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pemasukan extends MY_Controller {

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

	public function cari_pemasukan()
	{
		$this->load->view('setting/cari_pemasukan');	
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
    
    public function get_kategori_akun()
    {
        $kode_kategori_akun = $this->input->post('kode_kategori_akun');

                         $this->db->select('*') ;
        $kategori_akun = $this->db->get_where('keuangan_kategori_akun',array('kode_kategori_akun'=>$kode_kategori_akun));
        $get_kategori_akun = $kategori_akun->row();

		$query = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_kategori_akun'=>$kode_kategori_akun));
		$opt = '';
        $opt = '<option value="">--Pilih Sub Kategori--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_sub_kategori_akun.'">'.$value->nama_sub_kategori_akun.'</option>';  
                }

        echo $get_kategori_akun->nama_kategori_akun.'|'.$opt;
    }

    public function get_sub_kategori_akun()
    {
        $kode_sub_kategori_akun = $this->input->post('kode_sub_kategori_akun');

        				 $this->db->select('*') ;
        $sub_kategori_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$kode_sub_kategori_akun));
        $get_sub_kategori_akun = $sub_kategori_akun->row();

        echo $get_sub_kategori_akun->nama_sub_kategori_akun.'|'.$get_sub_kategori_akun->kode_jenis_akun.'|'.$get_sub_kategori_akun->nama_jenis_akun;
    }

    public function get_rupiah()
    {
        $nominal = $this->input->post('nominal');
        $hasil = format_rupiah($nominal);

        echo $hasil;
        				 
    }
	

    //------------------------------------------ Proses --------------------------------------//

    public function simpan_pemasukan()
    {
        $data = $this->input->post();

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

        $data['tanggal_transaksi'] = date('Y-m-d');
        $data['petugas'] = $nama_petugas;
        $data['id_petugas'] = $id_petugas;
        $masuk = $this->db->insert("keuangan_masuk", $data);
        if($masuk){
                echo '<div class="alert alert-success">Berhasil disimpan.</div>';  
        }
        else{
                echo '<div class="alert alert-danger">Gagal disimpan.</div>';  
        }
        				 
    }


	
}
