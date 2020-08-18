<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembelian extends MY_Controller {

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

	public function pendaftaran()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function ubah()
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


	public function hapus(){
		$kode = $this->input->post("key");
		$this->db->delete( 'anggota', array('nomor_anggota' => $kode) );
		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}

	public function simpan_tambah()

	{
		$data['no_transaksi']      = 'TR_'.date('ymdHis');
		$data['nomor_anggota']	   = 'TR_'.date('ymdHis');
		$data2['no_anggota']	   = 'TR_'.date('ymdHis');//fild no transaksi
		$data['nama'] 			   = $this->input->post("nama_anggota");
		$data['tempat_lahir'] 	   = $this->input->post("tempat_lahir");//fild nama anggota
		$data['tanggal_lahir'] 	   = $this->input->post("tanggal_lahir");
		$data['no_ktp']            = $this->input->post("no_ktp");//fild nama ktp	
		$data['alamat']            = $this->input->post("alamat");
		$data['validasi']            = 'belum_divalidasi';

		$tipe_sapi = $this->db->get('tipe_sapi');
		$hasil_tipe_sapi = $tipe_sapi->result_array();

		$insert_opsi = $this->db->insert("opsi_sapi_anggota", $data2);
		foreach($hasil_tipe_sapi as $item){
			$tipe_sapi = str_replace(" ","_",$item['tipe']);
			$milik_sendiri = $tipe_sapi.'_milik_sendiri';
			$rumatan = $tipe_sapi.'_rumatan';

			$input_milik_sendiri = 'milik_sendiri'.$tipe_sapi;
			$input_rumatan = 'rumatan'.$tipe_sapi;
			$input_jumlah = 'jumlah'.$tipe_sapi;
			$total = @$total + $this->input->post($input_jumlah);

			$data2['jumlah_sapi'] = $total;
			$data2[$milik_sendiri] = $this->input->post($input_milik_sendiri);
			$data2[$rumatan] = $this->input->post($input_rumatan);
			$data2['kondisi_kandang'] = $this->input->post("kondisi_kandang");
			
			$query=$this->db->update( "opsi_sapi_anggota", $data2, array('no_anggota' => $data2['no_anggota']) );
		}
		
		$insert = $this->db->insert("anggota", $data); 
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['no_transaksi']);
	}

	public function simpan_ubah()

	{
		$data['no_transaksi']      = $this->input->post("no_transaksi");
		$data['nomor_anggota']	   = $this->input->post("nomor_anggota");
		$data2['no_anggota']	   = $this->input->post("nomor_anggota");
		$data['nama'] 			   = $this->input->post("nama_anggota");
		$data['tempat_lahir'] 	   = $this->input->post("tempat_lahir");//fild nama anggota
		$data['tanggal_lahir'] 	   = $this->input->post("tanggal_lahir");
		$data['no_ktp']            = $this->input->post("no_ktp");//fild nama ktp	
		$data['alamat']            = $this->input->post("alamat");
		//$data['validasi']            = 'belum_divalidasi';

		$tipe_sapi = $this->db->get('tipe_sapi');
		$hasil_tipe_sapi = $tipe_sapi->result_array();

		$insert_opsi = $this->db->update( "opsi_sapi_anggota", $data2, array('no_anggota' => $data2['no_anggota']) );
		foreach($hasil_tipe_sapi as $item){
			$tipe_sapi = str_replace(" ","_",$item['tipe']);
			$milik_sendiri = $tipe_sapi.'_milik_sendiri';
			$rumatan = $tipe_sapi.'_rumatan';

			$input_milik_sendiri = 'milik_sendiri'.$tipe_sapi;
			$input_rumatan = 'rumatan'.$tipe_sapi;
			$input_jumlah = 'jumlah'.$tipe_sapi;
			$total = @$total + $this->input->post($input_jumlah);

			$data2['jumlah_sapi'] = $total;
			$data2[$milik_sendiri] = $this->input->post($input_milik_sendiri);
			$data2[$rumatan] = $this->input->post($input_rumatan);
			$data2['kondisi_kandang'] = $this->input->post("kondisi_kandang");
			
			$query=$this->db->update( "opsi_sapi_anggota", $data2, array('no_anggota' => $data2['no_anggota']) );
		}
		
		$insert = $this->db->update( "anggota", $data, array('no_transaksi' => $data['no_transaksi']) );
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['no_transaksi']);
	}

	function simpan_edit(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required'); 
		$this->form_validation->set_rules('alamat', 'Alamat', 'required'); 
		$this->form_validation->set_rules('no_transaksi_anggota', 'No Transaksi Anggota', 'required'); 
		$this->form_validation->set_rules('no_ktp', 'No KTP Anggota', 'required'); 
		$this->form_validation->set_rules('kode_jenis_anggota', 'Kode Jenis Anggota', 'required'); 
		$this->form_validation->set_rules('kode_kelompok', 'Kode Kelompok', 'required');
		$this->form_validation->set_rules('jabatan_anggota', 'Jabatan Anggota', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required'); 

		if ($this->form_validation->run() == FALSE) {
			echo '<div class="alert alert-warning">Gagal tersimpan.</div>';
		} 
		else {
			$kode = $this->input->post("nomor_anggota");
			$data['no_transaksi'] = $this->input->post("no_transaksi_anggota");
			$data['nama'] = $this->input->post("nama_anggota");
			$data['alamat'] = $this->input->post("alamat");
			$data['no_ktp'] = $this->input->post("no_ktp");
			$data['kode_jenis_anggota'] = $this->input->post("kode_jenis_anggota");
			$kode_jenis_anggota = $this->input->post("kode_jenis_anggota");
			$ambil_kode_jenis_anggota = $this->db->query(" SELECT * FROM jenis_anggota where kode_jenis_anggota='$kode_jenis_anggota' ");
			$hasil_ambil_kode_jenis_anggota = $ambil_kode_jenis_anggota->row();
			$data['nama_jenis_anggota'] = $hasil_ambil_kode_jenis_anggota->nama_jenis_anggota;

			$data['kode_kelompok'] = $this->input->post("kode_kelompok");
			$kode_kelompok = $this->input->post("kode_kelompok");
			$ambil_kode_kelompok= $this->db->query(" SELECT * FROM kelompok where kode_kelompok='$kode_kelompok' ");
			$hasil_ambil_kode_kelompok = $ambil_kode_kelompok->row();
			$data['nama_pos_penampungan_susu'] = $hasil_ambil_kode_kelompok->nama_pos_penampungan_susu;
			$data['kode_pos_penampungan_susu'] = $hasil_ambil_kode_kelompok->kode_pos_penampungan_susu;
			$data['nama_kelompok'] 		= $hasil_ambil_kode_kelompok->nama_kelompok;
			$data['kode_cooling_unit']  = $hasil_ambil_kode_kelompok->kode_cooling_unit;
			$data['nama_cooling_unit']  = $hasil_ambil_kode_kelompok->nama_cooling_unit;
			$data['jabatan'] = $this->input->post("jabatan_anggota");
			$data['status'] = $this->input->post("status");
			$query=$this->db->update( "anggota", $data, array('nomor_anggota' => $kode) );
			$this->session->set_flashdata('message', $data['no_transaksi']);  
			echo '<div class="alert alert-success">Sudahe Tersimpan.</div>';         
		}

	}

	
	
}
