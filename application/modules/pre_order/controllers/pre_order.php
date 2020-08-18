	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pre_order extends MY_Controller {

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

    //------------------------------------------ View Data Table----------------- --------------------//
	public function cari_order(){
		$this->load->view('setting/cari_order');

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
	public function edit()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/edit', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function tambah_produk()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form_tambah_produk', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function detail($kode)
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}

	public function print_po()
	{
		$this->load->view('pre_order/setting/print_po');
		//$this->load->view ('main_no_bar', $data);		
	}
	public function print_po_transaksi()
	{
		$this->load->view('pre_order/setting/print_po_transaksi');
		//$this->load->view ('main_no_bar', $data);		
	}
	public function print_po_transaksi_blm_dtg()
	{
		$this->load->view('pre_order/setting/print_po_transaksi_blm_dtg');
		//$this->load->view ('main_no_bar', $data);		
	}

	public function tabel_temp_data_transaksi($kode)
	{
		$data['diskon'] = $this->diskon_tabel();
		$data['kode'] = $kode ;
		$this->load->view ('pre_order/setting/tabel_transaksi_temp',$data);		
	}

	public function get_po($kode){
		$data['kode'] = $kode ;
		$this->load->view('pre_order/setting/tabel_transaksi_temp',$data);
	}
	public function get_po_belum_dtg($kode){
		$data['kode'] = $kode ;
		$this->load->view('pre_order/setting/tabel_transaksi_belum_dtg_temp',$data);
	}
	

	//------------------------------------------ Proses ----------------- --------------------//

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

	public function simpan_item_temp()
	{
		$masukan = $this->input->post();
		$get_temp = $this->db->get_where('opsi_transaksi_po_temp',array('kode_bahan'=>$masukan['kode_bahan'],'position'=>$masukan['position']));
		$cek_temp=$get_temp->num_rows();
		if($cek_temp==1){
			$update['jumlah']=$get_temp->row()->jumlah+$masukan['jumlah'];
			$this->db->update( "opsi_transaksi_po_temp", $update, array('kode_bahan'=>$masukan['kode_bahan'],'position'=>$masukan['position']) );
		}else{ 
			$this->db->insert('opsi_transaksi_po_temp',$masukan);
		}
		echo "sukses";				 				
	}
	public function simpan_po_stokmin_temp()
	{
		$input=$this->input->post('bahan_stokmin');
		$tgl = date("Y-m-d");
		$no_belakang = 0;
		$this->db->select_max('kode_po');
		$kode = $this->db->get_where('transaksi_po',array('tanggal_input'=>$tgl));
		$hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
		$this->db->select('kode_po');
		$kode_ro = $this->db->get('master_setting');
		$hasil_kode_ro = $kode_ro->row();

		if(count($hasil_kode)==0){
			$no_belakang = 1;
		}
		else{
			$pecah_kode = explode("_",$hasil_kode->kode_po);
			$no_belakang = @$pecah_kode[2]+1;
		}
		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$param=$hasil_unit->kode_unit;
		
		foreach ($input as $value) {
			//echo $value;
			$bahan=$this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$value));
			$hasil_bahan=$bahan->row();
			$data['kode_po']=@$hasil_kode_ro->kode_po."_".date("dmy")."_".$param."_".$no_belakang;
			$data['kode_bahan']=$hasil_bahan->kode_bahan_baku;
			$data['nama_bahan']=$hasil_bahan->nama_bahan_baku;
			$data['kategori_bahan']=$hasil_bahan->jenis_bahan;
			$data['position']=$hasil_bahan->kode_unit;
			$data['jumlah']=0;
			
			$this->db->insert('opsi_transaksi_po_temp',$data);

		}
	}

	public function get_temp_po(){
		$id = $this->input->post('id');
		$po = $this->db->get_where('opsi_transaksi_po_temp',array('id'=>$id));
		$hasil_po = $po->row();
		echo json_encode($hasil_po);
	}

	public function hapus_bahan_temp(){
		$id = $this->input->post('id');
		$this->db->delete('opsi_transaksi_po_temp',array('id'=>$id));
	}

	public function get_bahan()
	{
		$param = $this->input->post();
		$jenis = $param['jenis_bahan'];
		echo $jenis;

		// if($jenis == 'bahan baku'){
		$opt = '';
		//$query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> 'U001','status_produk'=>'produk'));
		$query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> 'U001'));
		$opt = '<option value="">--Pilih Produk--</option>';
		foreach ($query->result() as $key => $value) {
			$opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
		}
		echo $opt;

	// 	}else if ($jenis == 'barang') {
	// 		$opt = '';
	// 		$query = $this->db->get_where('master_barang',array('position'=> 'U001'));
	// 		$opt = '<option value="">--Pilih Barang--</option>';
	// 		foreach ($query->result() as $key => $value) {
	// 			$opt .= '<option value="'.$value->kode_barang.'">'.$value->nama_barang.'</option>';  
	// 		}
	// 		echo $opt;
	// 	}
	}

	public function update_item_temp(){
		$update = $this->input->post();
		$data_update['jumlah']=$update['jumlah'];
		$data_update['keterangan']=$update['keterangan'];
		$this->db->update('opsi_transaksi_po_temp',$data_update,array('id'=>$update['id'],'kode_bahan'=>$update['kode_bahan']));
		
		echo "sukses";
	}

	public function temp_data_transaksi()
	{
		$kode_pembelian = $this->input->post('kode_pembelian');

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		echo $data->grand_total ;
        #echo $this->db->last_query();
	}

	public function diskon_tabel()
	{
		$input = $this->input->post('diskon');
		echo $input ;
	}

	

	public function item_bahan_baku()
	{
		$kode_po = $this->input->post('kode_po');
		$query = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_po));
		$data = $query->row();
		echo $input ;
	}
	



	public function simpan_transaksi()
	{
		$input = $this->input->post();

		$this->db->select_max('id');
		$get_max_po = $this->db->get('transaksi_po');
		$max_po = $get_max_po->row();

		$this->db->where('id', $max_po->id);
		$get_po = $this->db->get('transaksi_po');
		$po = $get_po->row();
		$tahun = substr(@$po->kode_transaksi, 3,4);
		if(date('Y')==$tahun){
			$nomor = substr(@$po->kode_transaksi, 8);
			$nomor = $nomor + 1;
			$string = strlen($nomor);
			if($string == 1){
				$kode_trans = 'PO_'.date('Y').'_00000'.$nomor;
			} else if($string == 2){
				$kode_trans = 'PO_'.date('Y').'_0000'.$nomor;
			} else if($string == 3){
				$kode_trans = 'PO_'.date('Y').'_000'.$nomor;
			} else if($string == 4){
				$kode_trans = 'PO_'.date('Y').'_00'.$nomor;
			} else if($string == 5){
				$kode_trans = 'PO_'.date('Y').'_0'.$nomor;
			} else if($string == 6){
				$kode_trans = 'PO_'.date('Y').'_'.$nomor;
			}
		} else {
			$kode_trans = 'PO_'.date('Y').'_000001';
		}

		$tgl = date("Y-m-d");
		$no_belakang = 0;
		$this->db->select_max('kode_po');
		$kode = $this->db->get_where('transaksi_po',array('tanggal_input'=>$tgl));
		$hasil_kode = $kode->row();

		$this->db->select('kode_po');
		$get_kode_ro = $this->db->get('master_setting');
		$hasil_kode_ro = $get_kode_ro->row();

		if(count($hasil_kode)==0){
			$no_belakang = 1;
		}
		else{
			$pecah_kode = explode("_",$hasil_kode->kode_transaksi);
			$no_belakang = @$pecah_kode[3]+1;
		}
		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$param=$hasil_unit->kode_unit;
		$kode_po = $input['kode_po'];
		$kode_unit = $input['kode_unit'];
		$ko_ro_baru = @$hasil_kode_ro->kode_po."_".date("dmyHis")."_".$param."_".$no_belakang;
		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;



		$this->db->select_max('urut');
		$result = $this->db->get_where('transaksi_po');
		$hasil = @$result->result();
		if($result->num_rows()) $no = ($hasil[0]->urut)+1;
		else $no = 1;

		if($no<10)$no = '000'.$no;
		else if($no<100)$no = '00'.$no;
		else if($no<1000)$no = '0'.$no;
		else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
		$code = $no;

		$this->db->select('*') ;
		$query_pembelian_temp = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_trans));

		$total = 0;
		foreach ($query_pembelian_temp->result() as $item){
			$data_opsi['kode_po'] = $ko_ro_baru;
			$data_opsi['kategori_bahan'] = $item->kategori_bahan;
			$data_opsi['kode_bahan'] = $item->kode_bahan;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $item->kode_bahan));
			$hasil_bahan = $nama_bahan->row();
			$data_opsi['kode_satuan'] = $hasil_bahan->id_satuan_pembelian;
			$data_opsi['nama_satuan'] = $hasil_bahan->satuan_pembelian;
			$data_opsi['harga_satuan'] = $hasil_bahan->hpp;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$data_opsi['jumlah'] = $item->jumlah;
			$data_opsi['keterangan'] = $item->keterangan;
			$data_opsi['position'] = $kode_unit;

			$data_opsi['subtotal'] = $item->jumlah * $hasil_bahan->hpp;
			$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_po", $data_opsi);
		}
		$tgl = date("Y-m-d");
		$no_belakang = 0;
		$this->db->select_max('kode_pembelian');
		$kode = $this->db->get_where('transaksi_pembelian',array('tanggal_pembelian'=>$tgl));
		$hasil_kode = $kode->row();

		$this->db->select('kode_pembelian');
		$kode_pembelian = $this->db->get('master_setting');
		$hasil_kode_pembelian = $kode_pembelian->row();

		if(count($hasil_kode)==0){
			$no_belakang = 1;
		}
		else{
			$pecah_kode = explode("_",$hasil_kode->kode_pembelian);
			$no_belakang = @$pecah_kode[2]+1;
		}

		$this->db->select_max('id');
		$get_max_po = $this->db->get('transaksi_pembelian');
		$max_po = $get_max_po->row();

		$this->db->where('id', $max_po->id);
		$get_po = $this->db->get('transaksi_pembelian');
		$po = $get_po->row();
		$tahun = substr(@$po->kode_pembelian, 4,4);
		if(date('Y')==$tahun){
			$nomor = substr(@$po->kode_pembelian, 9);
			$nomor = $nomor + 1;
			$string = strlen($nomor);
			if($string == 1){
				$kode_trans_pem = 'PEM_'.date('Y').'_00000'.$nomor;
			} else if($string == 2){
				$kode_trans_pem = 'PEM_'.date('Y').'_0000'.$nomor;
			} else if($string == 3){
				$kode_trans_pem = 'PEM_'.date('Y').'_000'.$nomor;
			} else if($string == 4){
				$kode_trans_pem = 'PEM_'.date('Y').'_00'.$nomor;
			} else if($string == 5){
				$kode_trans_pem = 'PEM_'.date('Y').'_0'.$nomor;
			} else if($string == 6){
				$kode_trans_pem = 'PEM_'.date('Y').'_'.$nomor;
			}
		} else {
			$kode_trans_pem = 'PEM_'.date('Y').'_000001';
		}
		$input_jdwl['kode_transaksi'] = $kode_trans_pem;
		$input_jdwl['kode_po'] = $input['kode_po'];
		$input_jdwl['keterangan'] = $input['keterangan_po'];
		$input_jdwl['tanggal_barang_datang'] = $input['tgl_barang_datang'];
		$input_jdwl['pembayaran'] = $input['pembayaran'];
		$input_jdwl['jatuh_tempo'] = $input['jatuh_tempo'];
		$this->db->insert("input_jadwal_barang_datang", $input_jdwl);
		//echo $this->db->last_query();

		if($tabel_opsi_transaksi_pembelian){

			$data_po['kode_po'] = $ko_ro_baru;
			$data_po['tanggal_input'] = date('Y-m-d');
			$data_po['petugas'] = $nama_petugas;
			$data_po['status'] = "menunggu";
			$data_po['position'] = $kode_unit;
			$data_po['urut'] = $no;
			$data_po['kode_transaksi'] = $kode_trans;
			$data_po['kode_supplier'] = $input['supplier'];
			$data_po['keterangan'] = $input['keterangan_po'];

			$this->db->where('kode_supplier', $input['supplier']);
			$get_suplier=$this->db->get('master_supplier');
			$hasil=$get_suplier->row();

			$data_po['nama_supplier'] = $hasil->nama_supplier;
			$data_po['status_validasi'] = 'belum divalidasi';
			$insert_transaksi_po = $this->db->insert("transaksi_po", $data_po);
			$this->db->truncate('opsi_transaksi_po_temp');
			echo '0|<div class="alert alert-success">Berhasil melakukan PO.</div>';  
		}
		else{
			echo '1|<div class="alert alert-danger">Gagal Melakukan PO (rincian barang).</div>';  
		}		
	}
	public function simpan_edit_transaksi()
	{
		$input = $this->input->post();

		$kode_po=$input['kode_po'];
		$po=$this->db->get_where('transaksi_po',array('kode_transaksi' => $kode_po));
		$hasil_po=$po->row();
		$kode_po_baru=$hasil_po->kode_po;

		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;



		$this->db->select('*') ;
		$query_pembelian_temp = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_po));

		
		$kode_unit = $input['kode_unit'];
		$total = 0;
		foreach ($query_pembelian_temp->result() as $item){
			$data_opsi['kode_po'] = $kode_po_baru;
			$data_opsi['kategori_bahan'] = $item->kategori_bahan;
			$data_opsi['kode_bahan'] = $item->kode_bahan;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $item->kode_bahan));
			$hasil_bahan = $nama_bahan->row();
			$data_opsi['kode_satuan'] = $hasil_bahan->id_satuan_pembelian;
			$data_opsi['nama_satuan'] = $hasil_bahan->satuan_pembelian;
			$data_opsi['harga_satuan'] = $hasil_bahan->hpp;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$data_opsi['jumlah'] = $item->jumlah;
			$data_opsi['keterangan'] = $item->keterangan;
			$data_opsi['position'] = $kode_unit;

			$data_opsi['subtotal'] = $item->jumlah * $hasil_bahan->hpp;
			$cek_opsi=$this->db->get_where('opsi_transaksi_po',array('kode_po' => $kode_po_baru,'kode_bahan' =>$item->kode_bahan));
			$hasil_cek_opsi=$cek_opsi->row();
			$jml_opsi=count($hasil_cek_opsi);
			if($jml_opsi > 0){
				//$tabel_opsi_transaksi_pembelian =$this->db->update("opsi_transaksi_po", $data_opsi,array('kode_po' => $kode_po_baru,'kode_bahan' =>$item->kode_bahan,'status' =>'Belum Datang')); 
				$tabel_opsi_transaksi_pembelian =$this->db->update("opsi_transaksi_po", $data_opsi,array('kode_po' => $kode_po_baru,'kode_bahan' =>$item->kode_bahan,'status !=' =>'Sudah Datang')); 
				$isi='update'; 
			}else{
				//$data_opsi['status'] = 'Belum Datang';
				$data_opsi['validasi'] = 'validasi2';
				$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_po", $data_opsi);
				$isi='insert'; 
			}
		}

		$tgl = date("Y-m-d");
		$no_belakang = 0;
		$this->db->select_max('kode_pembelian');
		$kode = $this->db->get_where('transaksi_pembelian',array('tanggal_pembelian'=>$tgl));
		$hasil_kode = $kode->row();

		$this->db->select('kode_pembelian');
		$kode_pembelian = $this->db->get('master_setting');
		$hasil_kode_pembelian = $kode_pembelian->row();

		if(count($hasil_kode)==0){
			$no_belakang = 1;
		}
		else{
			$pecah_kode = explode("_",$hasil_kode->kode_pembelian);
			$no_belakang = @$pecah_kode[2]+1;
		}

		$this->db->select_max('id');
		$get_max_po = $this->db->get('transaksi_pembelian');
		$max_po = $get_max_po->row();

		$this->db->where('id', $max_po->id);
		$get_po = $this->db->get('transaksi_pembelian');
		$po = $get_po->row();
		$tahun = substr(@$po->kode_pembelian, 4,4);
		if(date('Y')==$tahun){
			$nomor = substr(@$po->kode_pembelian, 9);
			$nomor = $nomor + 1;
			$string = strlen($nomor);
			if($string == 1){
				$kode_trans_pem = 'PEM_'.date('Y').'_00000'.$nomor;
			} else if($string == 2){
				$kode_trans_pem = 'PEM_'.date('Y').'_0000'.$nomor;
			} else if($string == 3){
				$kode_trans_pem = 'PEM_'.date('Y').'_000'.$nomor;
			} else if($string == 4){
				$kode_trans_pem = 'PEM_'.date('Y').'_00'.$nomor;
			} else if($string == 5){
				$kode_trans_pem = 'PEM_'.date('Y').'_0'.$nomor;
			} else if($string == 6){
				$kode_trans_pem = 'PEM_'.date('Y').'_'.$nomor;
			}
		} else {
			$kode_trans_pem = 'PEM_'.date('Y').'_000001';
		}
		$input_jdwl['kode_transaksi'] = $kode_trans_pem;
		$input_jdwl['kode_po'] = $kode_po;
		$input_jdwl['keterangan'] = $input['keterangan_po'];
		$input_jdwl['tanggal_barang_datang'] = $input['tgl_barang_datang'];
		// $input_jdwl['pembayaran'] = $input['pembayaran'];
		// $input_jdwl['jatuh_tempo'] = $input['jatuh_tempo'];
		$this->db->insert("input_jadwal_barang_datang", $input_jdwl);

		if($tabel_opsi_transaksi_pembelian){


			$this->db->truncate('opsi_transaksi_po_temp');
			echo '0|<div class="alert alert-success">Berhasil melakukan PO.</div>'.$isi;  
		}
		else{
			echo '1|<div class="alert alert-danger">Gagal Melakukan PO (rincian barang).</div>';  
		}		
	}


	public function get_satuan()
	{
		$kode_bahan = $this->input->post('kode_bahan');
		$jenis_bahan = $this->input->post('jenis_bahan');

		$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan));
		$hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;

		echo json_encode($hasil_bahan);

	}


}
