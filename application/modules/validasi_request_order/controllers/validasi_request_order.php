<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class validasi_request_order extends MY_Controller {

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

	public function cari_validasi_request_order()
	{
		$this->load->view('setting/cari_validasi_request_order');	
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

	public function validasi()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function detail()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail_validasi', $data, TRUE);
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
	public function update_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		$data['status']='2';
		$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		echo $this->db->last_query();
		
	}
	public function panding_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		$data['status']='0';
		$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		echo $this->db->last_query();
		
	}
		public function proses_transaksi(){
		$kode_ro=$this->input->post("kode_ro");
		#$data['status']='1';
		#$query=$this->db->update( "transaksi_ro", $data, array('kode_ro' => $kode_ro) );
		//echo $this->db->last_query();
		$update['status_validasi'] = 'proses';
		$this->db->update('opsi_transaksi_ro',$update,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung'));
		$this->db->delete('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
	}

	public function batal_ro(){
		$kode_ro=$this->input->post("kode_ro");
		$update['status_validasi'] = 'batal';
		$this->db->update('opsi_transaksi_ro',$update,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung'));
		$this->db->delete('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
		echo '<div class="alert alert-danger">Berhasil Membatalkan Request Order</div>';
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
		$data['jabatan']		   = $this->input->post("jabatan");
		$data['kode_kelompok']	   = $this->input->post("kelompok");

		$cari_data_kelompok = $this->db->get_where('kelompok_anggota', array('kode_kelompok'=>$data['kode_kelompok']));
		$hasil_data_kelompok = $cari_data_kelompok->row();

		$data['nama_kelompok']= $hasil_data_kelompok->nama_kelompok;
		$data['kode_pos_penampungan_susu']= $hasil_data_kelompok->kode_pos_penampungan_susu;
		$data['nama_pos_penampungan_susu']= $hasil_data_kelompok->nama_pos_penampungan_susu;

		$data['kode_jenis_anggota']= $this->input->post("jenis_anggota");
		$cari_data_jenis_anggota = $this->db->get_where('jenis_anggota', array('kode_jenis_anggota'=>$data['kode_jenis_anggota']));
		$hasil_data_jenis_anggota = $cari_data_jenis_anggota->row();
		
		$data['nama_jenis_anggota']= $hasil_data_jenis_anggota->nama_jenis_anggota;


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

	public function get_po($kode){
    	$data['kode'] = $kode ;
        $this->load->view('validasi_request_order/setting/tabel_transaksi_opsi',$data);
    }
    public function get_kode_nota()
	{
		$nomor_nota = $this->input->post('nomor_nota');
        $query = $this->db->get_where('transaksi_po',array('nomor_nota' => $nomor_nota, 'tanggal_input'=> date('Y-m-d') ))->num_rows();

        if($query > 0){
            echo "1";
        }
        else{
            echo "0";
        }
	}

	    public function get_bahan()
    {
        $param = $this->input->post();
        echo $param;
        $jenis = $param['jenis_bahan'];

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> 'U002'));
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'bahan jadi') {
            $opt = '';
            $query = $this->db->get_where('master_bahan_jadi',array('kode_unit'=> '01'));
                $opt = '<option value="">--Pilih Bahan Jadi--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
                }
            echo $opt;
        }
    }
     public function get_satuan()
    {
        $kode_bahan = $this->input->post('kode_bahan');
        $jenis_bahan = $this->input->post('jenis_bahan');
        if($jenis_bahan=='bahan baku'){
                $nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan));
                $hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
        }elseif($jenis_bahan=='bahan jadi'){
            $nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan));
            $hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
        }
        echo json_encode($hasil_bahan);

    }

        public function print_ro($kode)
	{
		$session = $this->session->userdata('astrosession');
		$setting = $this->db->get('master_setting')->row();
		$po = $this->db->get_where('transaksi_ro',array('kode_ro' => $kode))->row();

		$data['kode'] = $kode;
		$data['session'] = $session;
		$data['setting'] = $setting ;
		$data['po'] = $po ;

		$data['konten'] = $this->load->view('request_order/setting/print_ro', $data, TRUE);
		//$this->load->view ('main_no_bar', $data);		
	}

    	public function simpan_validasi()
	{
		$input = $this->input->post();
		$kode_ro = $input['kode_ro'];
		$get_id_petugas = $this->session->userdata('astrosession');
		
       
        $nama_petugas = $get_id_petugas->uname;

	    	$cek_validasi_ro = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
	    	$hasil_ro = $cek_validasi_ro->result();
	    	echo count($hasil_ro);
	    	if(count($hasil_ro)<1){
				$query_pembelian_temp = $this->db->get_where('opsi_transaksi_ro',array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung','status_validasi !='=>'selesai','status_validasi !='=>'batal'));

				$total = 0;
				foreach ($query_pembelian_temp->result() as $item){
			     	$data_opsi['kode_ro'] = $item->kode_ro;
			     	$data_opsi['kategori_bahan'] = $item->kategori_bahan;
			     	$data_opsi['kode_bahan'] = $item->kode_bahan;
			     	$data_opsi['nama_bahan'] = $item->nama_bahan;
			     	$data_opsi['jumlah'] = $item->jumlah;
			     	$data_opsi['jenis_bahan'] = $item->jenis_bahan;
			     	$data_opsi['kode_satuan'] = $item->kode_satuan;
			     	$data_opsi['nama_satuan'] = $item->nama_satuan;
			     	$data_opsi['keterangan'] = $item->keterangan;
			     	$data_opsi['position'] = $item->position;
			     	$data_opsi['status_validasi'] = $item->status_validasi;
			     	// $data_opsi['status'] = '0';
		            
		            $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_validasi_ro_temp", $data_opsi);
			    }

	    	}else{

	    	}
			
		 //    if($tabel_opsi_transaksi_pembelian){

		 //    	$data_po['kode_ro'] = $kode_ro;
		 //    	$data_po['tanggal_input'] = date('Y-m-d');
		 //    	$data_po['petugas'] = $nama_petugas;
		 //    	//$data_po['id_petugas'] = $id_petugas;
		 //    	$data_po['position'] = 'kitchen';
			// 	$insert_transaksi_po = $this->db->insert("transaksi_ro", $data_po);
			// 	$this->db->truncate('opsi_transaksi_ro_temp');
			// 	echo '0|<div class="alert alert-success">Berhasil melakukan PO.</div>';  
			// }
			// else{
			// 	echo '1|<div class="alert alert-danger">Gagal Melakukan PO (rincian barang).</div>';  
			// }		
	}

    public function print_ro_1($kode)
	{
		$session = $this->session->userdata('astrosession');
		$setting = $this->db->get('master_setting')->row();
		$po = $this->db->get_where('transaksi_ro',array('kode_ro' => $kode))->row();

		$data['kode'] = $kode;
		$data['session'] = $session;
		$data['setting'] = $setting ;
		$data['po'] = $po ;

		$data['konten'] = $this->load->view('request_order/setting/print_ro', $data, TRUE);
		//$this->load->view ('main_no_bar', $data);		
	}

    	public function simpan_transaksi()
	{
		$input = $this->input->post();

		$kode_ro = $input['kode_ro'];

		$get_id_petugas = $this->session->userdata('astrosession');
		
       
        $nama_petugas = $get_id_petugas->uname;

	    
			/*$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
		     	$data_opsi['kode_ro'] = $item->kode_ro;
		     	$data_opsi['kategori_bahan'] = $item->kategori_bahan;
		     	$data_opsi['kode_bahan'] = $item->kode_bahan;
		     	$data_opsi['nama_bahan'] = $item->nama_bahan;
		     	$data_opsi['jumlah'] = $item->jumlah;
		     	$data_opsi['keterangan'] = $item->keterangan;
		     	$data_opsi['position'] = 'kitchen';
	            $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_validasi_ro", $data_opsi);
	            $this->db->truncate('opsi_transaksi_validasi_ro_temp');
		    }*/
		  $query_pembelian_temp = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
		  $total = 0;

		  
		    	foreach ($query_pembelian_temp->result() as $item){

		    		$unit = $this->db->get_where('master_unit',array('kode_unit'=>$item->position));
		    		$hasil_unit = $unit->row();
		    		$hasil_nama_unit = $hasil_unit->nama_unit;

		    		$server = $this->db->get('setting_server');
		    		$hasil_server = $server->row();

		    		if($item->position==$hasil_server->kode_unit){

		    			$cek_stok = $this->db->get_where('master_barang',array('kode_barang'=>$item->kode_bahan,'position'=>"U001"));
			     $hasil_cek_stok = $cek_stok->row();
			     //echo $this->db->last_query();
		    		if(@$hasil_cek_stok->real_stok < $item->jumlah ){

		    			$update_status['status_validasi'] = 'proses';
			     $this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'kode_bahan'=>$item->kode_bahan,
			     	'jenis_bahan'=>'stok','position'=>$item->position));
			     echo "Stok Tidak mencukupi silahkan melakukan Request Order";

		     			
		     	}else{


			     
			     $update_gudang['real_stok'] = $hasil_cek_stok->real_stok - $item->jumlah;
			     $this->db->update('master_barang',$update_gudang,array('kode_barang'=>$item->kode_bahan,'position'=>"U001"));
			     $cek_stok_kithcen = $this->db->get_where('master_barang',array('kode_barang'=>$item->kode_bahan,'position'=>$item->position));
			     $hasil_cek_kitchen = $cek_stok_kithcen->row();
			     // echo $this->db->last_query();
			     // echo"$hasil_cek_kitchen->real_stok + $item->jumlah;";
			     $update_kitchen['real_stok'] = $hasil_cek_kitchen->real_stok + $item->jumlah;
			      $this->db->update('master_barang',$update_kitchen,array('kode_barang'=>$item->kode_bahan,'position'=>$item->position));

			    $update_status['status_validasi'] = 'selesai';
			     $this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'kode_bahan'=>$item->kode_bahan,
			     	'jenis_bahan'=>'stok','position'=>$item->position));

			    
			     $transaksi_stok_keluar['jenis_transaksi'] = "request_order";
			     $transaksi_stok_keluar['kode_transaksi'] = $item->kode_ro;
			     $transaksi_stok_keluar['kategori_bahan'] = "bahan baku";
			     $transaksi_stok_keluar['kode_bahan'] = $item->kode_bahan;
			     $transaksi_stok_keluar['nama_bahan'] = $item->nama_bahan;
			     $transaksi_stok_keluar['stok_keluar'] = $item->jumlah;
			     $transaksi_stok_keluar['id_petugas'] =  $get_id_petugas->id;
			     $transaksi_stok_keluar['nama_petugas'] = $nama_petugas;
			     $transaksi_stok_keluar['tanggal_transaksi'] = date("Y-m-d");
			     $transaksi_stok_keluar['posisi_awal'] = "Server";
			     $transaksi_stok_keluar['kode_unit_asal'] = $item->position;
			     $transaksi_stok_keluar['kode_rak_asal'] = "101";
			     $transaksi_stok_keluar['nama_rak_asal'] = "bahan baku gudang";
			     $transaksi_stok_keluar['posisi_akhir'] = $hasil_nama_unit;
			     $transaksi_stok_keluar['kode_unit_tujuan'] = $item->position;
			     $transaksi_stok_keluar['nama_unit_tujuan'] = $hasil_nama_unit;
			    # $transaksi_stok_keluar['kode_rak_tujuan'] = "102";
			     #$transaksi_stok_keluar['nama_rak_tujuan'] = "bahan baku kitchen";
			     $this->db->insert('transaksi_stok',$transaksi_stok_keluar);

			     $transaksi_stok_masuk['jenis_transaksi'] = "request_order";
			     $transaksi_stok_masuk['kode_transaksi'] = $item->kode_ro;
			     $transaksi_stok_masuk['kategori_bahan'] = "bahan baku";
			     $transaksi_stok_masuk['kode_bahan'] = $item->kode_bahan;
			     $transaksi_stok_masuk['nama_bahan'] = $item->nama_bahan;
			     $transaksi_stok_masuk['stok_masuk'] = $item->jumlah;
			     $transaksi_stok_masuk['id_petugas'] =  $get_id_petugas->id;
			     $transaksi_stok_masuk['nama_petugas'] = $nama_petugas;
			     $transaksi_stok_masuk['tanggal_transaksi'] = date("Y-m-d");
			     $transaksi_stok_masuk['posisi_awal'] = "Server";
			     $transaksi_stok_masuk['kode_unit_asal'] = "U001";
			     $transaksi_stok_masuk['kode_rak_asal'] = "101";
			     $transaksi_stok_masuk['nama_rak_asal'] = "bahan baku gudang";
			     $transaksi_stok_masuk['posisi_akhir'] = $hasil_nama_unit;
			     $transaksi_stok_masuk['kode_unit_tujuan'] = $item->position;
			     $transaksi_stok_masuk['nama_unit_tujuan'] = $hasil_nama_unit;
			    # $transaksi_stok_masuk['kode_rak_tujuan'] = "102";
			     #$transaksi_stok_masuk['nama_rak_tujuan'] = "bahan baku kitchen";
			     $this->db->insert('transaksi_stok',$transaksi_stok_masuk);

			     echo '<div style="font-size:1.5em" class="alert alert-success">Berhasil Validasi Request Order.</div>';
			    }
		    		}else{
				    			$cek_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$item->kode_bahan,'kode_unit'=>"U001"));
					     $hasil_cek_stok = $cek_stok->row();

				    		if($hasil_cek_stok->real_stock < $item->jumlah ){
				    			$update_status['status_validasi'] = 'proses';
					     $this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'kode_bahan'=>$item->kode_bahan,
					     	'jenis_bahan'=>'stok','position'=>$item->position));
					     echo "<div style='font-size:1.5em' class='alert alert-danger'>Stok Tidak mencukupi silahkan melakukan Request Order bahan</div>";
					     echo $hasil_cek_stok->real_stock;

				     			
				     	}else{


					     
					     $update_gudang['real_stock'] = $hasil_cek_stok->real_stock - $item->jumlah;
					     $this->db->update('master_bahan_baku',$update_gudang,array('kode_bahan_baku'=>$item->kode_bahan,'kode_unit'=>"U001"));
					     $cek_stok_kithcen = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$item->kode_bahan,'kode_unit'=>$item->position));
					     $hasil_cek_kitchen = $cek_stok_kithcen->row();
					     $update_kitchen['real_stock'] = $hasil_cek_kitchen->real_stock + $item->jumlah;
					      $this->db->update('master_bahan_baku',$update_kitchen,array('kode_bahan_baku'=>$item->kode_bahan,'kode_unit'=>$item->position));

					    $update_status['status_validasi'] = 'selesai';
					     $this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'kode_bahan'=>$item->kode_bahan,
					     	'jenis_bahan'=>'stok','position'=>$item->position));

					    
					     $transaksi_stok_keluar['jenis_transaksi'] = "request_order";
					     $transaksi_stok_keluar['kode_transaksi'] = $item->kode_ro;
					     $transaksi_stok_keluar['kategori_bahan'] = "bahan baku";
					     $transaksi_stok_keluar['kode_bahan'] = $item->kode_bahan;
					     $transaksi_stok_keluar['nama_bahan'] = $item->nama_bahan;
					     $transaksi_stok_keluar['stok_keluar'] = $item->jumlah;
					     $transaksi_stok_keluar['id_petugas'] =  $get_id_petugas->id;
					     $transaksi_stok_keluar['nama_petugas'] = $nama_petugas;
					     $transaksi_stok_keluar['tanggal_transaksi'] = date("Y-m-d");
					     $transaksi_stok_keluar['posisi_awal'] = $hasil_cek_stok->nama_unit;
					     $transaksi_stok_keluar['kode_unit_asal'] = $item->position;
					     $transaksi_stok_keluar['kode_rak_asal'] = "101";
					     $transaksi_stok_keluar['nama_rak_asal'] = "bahan baku gudang";
					     $transaksi_stok_keluar['posisi_akhir'] = $hasil_nama_unit;
					     $transaksi_stok_keluar['kode_unit_tujuan'] = $item->position;
					     $transaksi_stok_keluar['nama_unit_tujuan'] = $hasil_nama_unit;
					    # $transaksi_stok_keluar['kode_rak_tujuan'] = "102";
					     #$transaksi_stok_keluar['nama_rak_tujuan'] = "bahan baku kitchen";
					     $this->db->insert('transaksi_stok',$transaksi_stok_keluar);

					     $transaksi_stok_masuk['jenis_transaksi'] = "request_order";
					     $transaksi_stok_masuk['kode_transaksi'] = $item->kode_ro;
					     $transaksi_stok_masuk['kategori_bahan'] = "bahan baku";
					     $transaksi_stok_masuk['kode_bahan'] = $item->kode_bahan;
					     $transaksi_stok_masuk['nama_bahan'] = $item->nama_bahan;
					     $transaksi_stok_masuk['stok_masuk'] = $item->jumlah;
					     $transaksi_stok_masuk['id_petugas'] =  $get_id_petugas->id;
					     $transaksi_stok_masuk['nama_petugas'] = $nama_petugas;
					     $transaksi_stok_masuk['tanggal_transaksi'] = date("Y-m-d");
					     $transaksi_stok_masuk['posisi_awal'] = $hasil_cek_stok->nama_unit;
					     $transaksi_stok_masuk['kode_unit_asal'] = "U001";
					     $transaksi_stok_masuk['kode_rak_asal'] = "101";
					     $transaksi_stok_masuk['nama_rak_asal'] = "bahan baku gudang";
					     $transaksi_stok_masuk['posisi_akhir'] = $hasil_nama_unit;
					     $transaksi_stok_masuk['kode_unit_tujuan'] = $item->position;
					     $transaksi_stok_masuk['nama_unit_tujuan'] = $hasil_nama_unit;
					    # $transaksi_stok_masuk['kode_rak_tujuan'] = "102";
					     #$transaksi_stok_masuk['nama_rak_tujuan'] = "bahan baku kitchen";
					     $this->db->insert('transaksi_stok',$transaksi_stok_masuk);

					       echo '<div style="font-size:1.5em" class="alert alert-success">Berhasil Validasi Request Order.</div>';
			    }
		    		}

		    		
			}
				
			    $this->db->delete('opsi_transaksi_validasi_ro_temp',array('kode_ro'=>$kode_ro));
			
//echo $this->db->last_query();

			  
		    

		 $get_transaksi_ro = $this->db->get_where('opsi_transaksi_ro',array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung'));
		 $hasil_get_transaksi_ro = $get_transaksi_ro->result();
		 foreach ($hasil_get_transaksi_ro as $daftar) {
		 	$update['status_validasi'] = 'selesai';
		 	$this->db->update('opsi_transaksi_ro',$update,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung'));
		 }

		   
	}

	public function simpan_item_temp()
	{
	   $masukan = $this->input->post(); 
	    print_r($masukan);  
       $this->db->insert('opsi_transaksi_validasi_ro_temp',$masukan);
       echo "sukses";				 				
	}

	public function get_temp_ro(){
        $id = $this->input->post('id');
        $po = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
        $hasil_po = $po->row();
        echo json_encode($hasil_po);
    }

    public function update_item_temp(){
        $update = $this->input->post();
        $this->db->update('opsi_transaksi_validasi_ro_temp',$update,array('id'=>$update['id']));
        echo "sukses";
    }
     public function hapus_bahan_opsi(){
        $id = $this->input->post('id');
        $kode_ro = $this->input->post('kode_ro');
        $get_bahan = $this->db->get_where('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
        $hasil_bahan = $get_bahan->row();

        $update_status['status_validasi'] = "batal";
        $this->db->update('opsi_transaksi_ro',$update_status,array('kode_ro'=>$kode_ro,'jenis_bahan'=>'langsung','kode_bahan'=>$hasil_bahan->kode_bahan));

        $this->db->delete('opsi_transaksi_validasi_ro_temp',array('id'=>$id));
    }

	
	
}
