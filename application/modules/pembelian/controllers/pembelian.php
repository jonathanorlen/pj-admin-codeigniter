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
	}	

    //------------------------------------------ View Data Table----------------- --------------------//

	public function daftar_pembelian()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/daftar_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);
		$this->db->truncate('opsi_transaksi_pembelian_temp');		
	}

	public function tambah()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/tambah_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function tambah_supplier()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/tambah_supplier', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	public function pembayaran()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/tambah_pembayaran', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function coba()
	{
		$data['aktif']='coba';
		$data['konten'] = $this->load->view('pembelian/pembelian/coba', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);
	}

	public function get_form_coba(){
		@$id = $this->input->post('id');
		@$data['id'] = @$id ;
		$this->load->view('pembelian/pembelian/form_penyesuaian',$data);
	}

	public function cari_pembelian()
	{
		
		$this->load->view('pembelian/pembelian/cari_pembelian');		
	}

	public function detail($kode)
	{
		$data['aktif']='pembelian';
		$data['kode'] = $kode;
		$data['konten'] = $this->load->view('pembelian/pembelian/detail_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tabel_temp_data_transaksi($kode)
	{
		$data['diskon'] = $this->diskon_tabel();
		$data['kode'] = $kode ;
		$this->load->view ('pembelian/pembelian/tabel_transaksi_temp',$data);		
	}

	public function get_pembelian($kode){
		$data['kode'] = $kode ;
		$this->load->view('pembelian/pembelian/tabel_transaksi_temp',$data);
	}
	public function table_pembelian($kode){
		$data['kode'] = $kode ;
		$this->load->view('pembelian/pembelian/table_transaksi',$data);
	}
	//------------------------------------------ Proses ----------------- --------------------//

	public function get_kode_nota()
	{
		$nomor_nota = $this->input->post('nomor_nota');
		$query = $this->db->get_where('transaksi_pembelian',array('nomor_nota' => $nomor_nota, 'tanggal_pembelian'=> date('Y-m-d') ))->num_rows();

		if($query > 0){
			echo "1";
		}
		else{

			echo "0";
		}
	}
	public function get_kode_po()
	{
		$kode_po = $this->input->post('kode_po');
		$kode_pembelian = $this->input->post('kode_pembelian');
		$query = $this->db->get_where('transaksi_po',array('kode_transaksi' => $kode_po,'status' =>'menunggu'));
		$data=$query->row();
		$jumlah = count($data);
		if($jumlah > 0){
			$pembelian = $this->db->get_where('opsi_transaksi_po',array('kode_po'=>$data->kode_po));
			$list_pembelian = $pembelian->result();
			foreach($list_pembelian as $daftar){ 
				$masukan['kode_pembelian'] = $kode_pembelian;
				$masukan['kategori_bahan'] = $daftar->kategori_bahan;
				$masukan['kode_bahan'] = $daftar->kode_bahan;
				$masukan['nama_bahan'] = $daftar->nama_bahan; 
				$masukan['jumlah'] = $daftar->jumlah; 
				$masukan['kode_satuan'] = $daftar->kode_satuan;
				$masukan['nama_satuan'] = $daftar->nama_satuan;
				$bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'nama_bahan_baku'=>$daftar->nama_bahan));
				$hasil_bahan = $bahan->row();
				$masukan['harga_satuan'] = $hasil_bahan->hpp;
                    //$masukan['diskon_item'] = $daftar->diskon_item;
                    //$masukan['kode_supplier'] = $daftar->kode_supplier; 
                    //$masukan['nama_supplier'] = $daftar->nama_supplier; 
				$masukan['subtotal'] = $hasil_bahan->hpp * $daftar->jumlah;

				$input = $this->db->insert('opsi_transaksi_pembelian_temp',$masukan);
			}
			echo "1|".$data->kode_po.'|'.$data->kode_supplier;
		}
		else{
			
			echo "0";
		}
	}

	public function temp_data_transaksi()
	{
		$kode_pembelian = $this->input->post('kode_pembelian');

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));
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
		$kode_pembelian = $this->input->post('kode_pembelian');
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		echo $input ;
	}

	public function simpan_item_temp()
	{
		$kode_pembelian = $this->input->post('kode_pembelian');
		$kategori_bahan = $this->input->post('kategori_bahan');
		$kode_bahan = $this->input->post('kode_bahan');
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		if(empty($data)){
			$masukan = $this->input->post();
			$nama_suplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$masukan['kode_supplier']));
			$hasil_nama_supplier = $nama_suplier->row();
			$masukan['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
			if($masukan['jenis_diskon'] == 'persen'){
				$masukan['diskon_item'] = $masukan['diskon_item'];
				$harga_diskon = (($masukan['jumlah'] * $masukan['harga_satuan']) * $masukan['diskon_item']) / 100;
				$masukan['harga_satuan'] = $masukan['harga_satuan'];
				$subtotal = ($masukan['jumlah'] * $masukan['harga_satuan']) - $harga_diskon;
				echo 'persen';
			} else{
				$masukan['diskon_rupiah'] = $masukan['diskon_rupiah'];
				$masukan['harga_satuan'] = $masukan['harga_satuan'];
				$subtotal = ($masukan['jumlah'] * $masukan['harga_satuan']) - $masukan['diskon_rupiah'];
				echo 'rupiah';
			}
			$masukan['subtotal'] = $subtotal;
			$masukan['position'] ='gudang';
			$this->db->insert('opsi_transaksi_pembelian_temp',$masukan);
			echo "sukses";
		}
		else{
			$masukan = $this->input->post();
			$nama_suplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$masukan['kode_supplier']));
			$hasil_nama_supplier = $nama_suplier->row();
			$masukan['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
			if($masukan['jenis_diskon'] == 'persen'){
				$masukan['diskon_item'] = $masukan['diskon_item'];
				$harga_diskon = (($masukan['jumlah'] * $masukan['harga_satuan']) * $masukan['diskon_item']) / 100;
				$masukan['harga_satuan'] = $masukan['harga_satuan'];
				$subtotal = ($masukan['jumlah'] * $masukan['harga_satuan']) - $harga_diskon;
				echo 'persen';
			} else{
				$masukan['diskon_rupiah'] = $masukan['diskon_rupiah'];
				$masukan['harga_satuan'] = $masukan['harga_satuan'];
				$subtotal = ($masukan['jumlah'] * $masukan['harga_satuan']) - $masukan['diskon_rupiah'];
				echo 'rupiah';
			}
			$masukan['subtotal'] = $subtotal;
			$masukan['position'] ='gudang';
			$temp = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian,'kategori_bahan'=>$kategori_bahan,'kode_bahan'=>$kode_bahan));
			$hasil_temp=$temp->row();
			$cek_temp = $temp->num_rows();
			if($cek_temp==1){
				$update['jumlah']=$hasil_temp->jumlah + $this->input->post('jumlah');
				$update['jenis_diskon'] = $masukan['jenis_diskon'];
				if($masukan['jenis_diskon'] == 'persen'){
					$update['diskon_item'] = $masukan['diskon_item'];
					$update['harga_satuan'] = $masukan['harga_satuan'];
					$harga_diskon = ((($update['jumlah']) * $update['harga_satuan']) * $update['diskon_item']) / 100;
					$subtotal = (($update['jumlah']) * $update['harga_satuan']) - $harga_diskon;
				} else{
					$update['diskon_rupiah'] = $masukan['diskon_rupiah'];
					$update['harga_satuan'] = $masukan['harga_satuan'];
					$subtotal = (($update['jumlah']) * $update['harga_satuan']) - $update['diskon_rupiah'];
				}
				$update['subtotal'] = $subtotal;
				$update['harga_satuan'] = $this->input->post('harga_satuan');
				$this->db->update( "opsi_transaksi_pembelian_temp", $update, array('kode_pembelian'=>$kode_pembelian,'kategori_bahan'=>$kategori_bahan,'kode_bahan'=>$kode_bahan) );
			}else{
				$this->db->insert('opsi_transaksi_pembelian_temp',$masukan);	
			}
			
			echo "sukses";

		}
		 //else{
		// 	echo 1;
		// }
		
		

	}

	public function update_item_temp(){
		$update = $this->input->post();
		if($update['jenis_diskon'] == 'persen'){
			$update['diskon_item'] = $update['diskon_item'];
			$harga_diskon = (($update['jumlah'] * $update['harga_satuan']) * $update['diskon_item']) / 100;
			$update['harga_satuan'] = $update['harga_satuan'];
			$subtotal = ($update['jumlah'] * $update['harga_satuan']) - $harga_diskon;
			echo 'persen';
		} else{
			$update['diskon_rupiah'] = $update['diskon_rupiah'];
			$update['harga_satuan'] = $update['harga_satuan'];
			$subtotal = ($update['jumlah'] * $update['harga_satuan']) - $update['diskon_rupiah'];
			echo 'rupiah';
		}
		$subtotal = $subtotal;
		$update['subtotal'] = $subtotal;
		$this->db->update('opsi_transaksi_pembelian_temp',$update,array('id'=>$update['id']));
		echo "sukses";
	}
	public function update_item_opsi(){
		$update = $this->input->post();
		
		//$update_bahan['hpp']=$update['harga_satuan'];
		$update_bahan['harga_jual_1']=$update['harga_jual_1'];
		$update_bahan['harga_jual_2']=$update['harga_jual_2'];
		
		$this->db->update('master_bahan_baku',$update_bahan,array('kode_bahan_baku' =>$update['kode_bahan'] ));
		
		$update_opsi_pembelian['jumlah']=$update['jumlah'];
		$update_opsi_pembelian['harga_satuan']=$update['harga_satuan'];
		$update_opsi_pembelian['subtotal']=$update['jumlah'] * $update['harga_satuan'];
		
		$cek_retur=$this->db->get_where('opsi_transaksi_pembelian',array('id'=>$update['id'],'kode_bahan' =>$update['kode_bahan'] ));
		$list_retur = $cek_retur->row();
		if(!empty($list_retur)){
			$update_opsi_pembelian['subtotal_retur']=$list_retur->jumlah_retur * $update['harga_satuan'];
		}


		
		$this->db->update('opsi_transaksi_pembelian',$update_opsi_pembelian,array('id'=>$update['id']));
		$pembelian = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$update['kode_pembelian']));
		$list_pembelian = $pembelian->result();
		$total = 0;
		
		foreach($list_pembelian as $daftar){ 
			@$total = $total + (@$daftar->subtotal - @$daftar->subtotal_retur);
		}
		$update_pembelian['grand_total']=@$total;
		$this->db->update('transaksi_pembelian',$update_pembelian,array('kode_pembelian'=>$update['kode_pembelian']));
		echo '<div class="alert alert-success">Sudah Tersimpan.</div>';         
	}

	public function simpan_transaksi()
	{
		$input = $this->input->post();
		$kode_pembelian = $input['kode_pembelian'];
		$kode_po = @$input['kode_po'];
		$proses_bayar = @$input['proses_pembayaran'];

		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		$grand_total = $data->grand_total ;
		@$tot_pembelian = @$grand_total - $input['diskon_rupiah'];

		$input_jdwl['kode_transaksi'] = $input['kode_pembelian'];
		$input_jdwl['kode_po'] = $input['kode_po2'];
		$input_jdwl['keterangan'] = $input['keterangan'];
		$input_jdwl['tanggal_barang_datang'] = $input['tgl_barang_datang'];
		$input_jdwl['pembayaran'] = $input['pembayaran'];
		$input_jdwl['jatuh_tempo'] = $input['jatuh_tempo'];
		$this->db->insert("input_jadwal_barang_datang", $input_jdwl);
		echo $this->db->last_query();

		// ---------------------singkron----------------------------------------------------------------------------------------
		$singkron_query = $this->db->last_query();
		$singkron['jenis_singkron'] = 'tambah';
		$singkron['query'] = $singkron_query;
		$singkron['status'] = 'pending';
		$this->db->insert("singkronasi", $singkron);

		unset($input['kode_po2']);
		unset($input['keterangan']);
		unset($input['tgl_barang_datang']);
		unset($input['pembayaran']);
		$kode_supplier = $input['kode_supplier'];

		// if($input['dibayar'] < $tot_pembelian && $proses_bayar != 'credit'){
		// 	echo '0|<div class="alert alert-danger">Periksa nilai pembayaran.</div>';  
		// }
		// else{
		$this->db->select('*') ;
		$query_pembelian_temp = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$get_supplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$kode_supplier));
		$hasil_nama_supplier = $get_supplier->row();

		$total = 0;
		foreach ($query_pembelian_temp->result() as $item){
			$data_opsi['kode_pembelian'] = $item->kode_pembelian;
			$data_opsi['kode_po'] = $kode_po;
			$data_opsi['kategori_bahan'] = $item->kategori_bahan;
			$data_opsi['kode_bahan'] = $item->kode_bahan;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$data_opsi['jumlah'] = $item->jumlah;
			$data_opsi['kode_satuan'] = $item->kode_satuan;
			$data_opsi['nama_satuan'] = $item->nama_satuan;
			$data_opsi['harga_satuan'] = $item->harga_satuan;
			$data_opsi['jenis_diskon'] = $item->jenis_diskon;
			$data_opsi['diskon_item'] = $item->diskon_item;
			$data_opsi['diskon_rupiah'] = $item->diskon_rupiah;
			$data_opsi['kode_supplier'] = $input['kode_supplier'];
			$data_opsi['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
			$data_opsi['subtotal'] = $item->subtotal;
			$data_opsi['position'] = 'gudang';

			$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_pembelian", $data_opsi);

			// ---------------------singkron----------------------------------------------------------------------------------------
			$singkron_query = $this->db->last_query();
			$singkron['jenis_singkron'] = 'tambah';
			$singkron['query'] = $singkron_query;
			$singkron['status'] = 'pending';
			$this->db->insert("singkronasi", $singkron);

			$grand_total = $total + $item->subtotal;
			$harga_satuan = $item->harga_satuan;
			$nama_bahan = $item->nama_bahan;
			$stok_masuk = $item->jumlah;
			$kode_pembelian = $item->kode_pembelian;
			$kategori_bahan = $item->kategori_bahan;
			$kode_bahan = $item->kode_bahan;
			$nama_supplier = $item->nama_supplier;
			$kode_supplier = $item->kode_supplier;
			$hpp_pembelian=$item->harga_satuan;
			//echo $kategori_bahan;
			if($kategori_bahan=='stok'){
				$kode_default = $this->db->get('setting_gudang');
				$hasil_kode_default = $kode_default->row();

				$this->db->select('*') ;
				$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
				$stok_real = $real_stock->row()->real_stock ;
				$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

				if(empty($stok_real)){
					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$hpp = $hpp->row()->hpp ;

					$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
					$hpp_hasil = $hpp->row()->hpp ;

					$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
					$hpp_baru['harga_beli_akhir']= $harga_satuan;
					$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
					echo $this->db->last_query();

				}
				else{
					$this->db->select('*') ;
					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$hpp = $hpp->row()->hpp ;
					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;



					$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit_default;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
					$hpp_hasil = $hpp->row()->hpp ;

					$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
					$hpp_baru['harga_beli_akhir']= $harga_satuan;
					$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
					echo $this->db->last_query();

				}
			}

			if($kategori_bahan==''){
				$kode_default = $this->db->get('setting_gudang');
				$hasil_kode_default = $kode_default->row();

				$this->db->select('*') ;
				$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
				$stok_real = $real_stock->row()->real_stock ;
				$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

				if(empty($stok_real)){
					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$hpp = $hpp->row()->hpp ;

					$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
					$hpp_hasil = $hpp->row()->hpp ;

					$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
					$hpp_baru['harga_beli_akhir']= $harga_satuan;
					$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
					echo $this->db->last_query();

				}
				else{
					$this->db->select('*') ;
					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$hpp = $hpp->row()->hpp ;
					$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;



					$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit_default;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
					$hpp_hasil = $hpp->row()->hpp ;

					$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
					$hpp_baru['harga_beli_akhir']= $harga_satuan;
					$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
					echo $this->db->last_query();

				}
			}

			if($kategori_bahan=='barang'){
				$kode_default = $this->db->get('setting_gudang');
				$hasil_kode_default = $kode_default->row();

				$this->db->select('*') ;
				$real_stock = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
				$stok_real = $real_stock->row()->real_stok ;
				$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

				if(empty($stok_real)){

					$data_stok['real_stok'] = $stok_masuk * $konversi_stok;
					//$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					@$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

				}
				else{
					$this->db->select('*') ;
					$jumlah_stok = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
					$jumlah_stok = $jumlah_stok->row()->real_stok ;

					$data_stok['real_stok'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
					//$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

					$this->db->select('kode_unit');
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok = $harga_satuan / $konversi_stok;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

					$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

				}
			}

			if($kategori_bahan=='bahan jadi'){
				$this->db->select('*') ;
				$real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
				$stok_real = $real_stock->row()->real_stock ;
				$kode_konversi_stok_bahan_jadi = $real_stock->row()->kode_satuan_stok ;


				$konversi_stok_bahan_jadi = $this->db->get_where('master_satuan',array('kode'=>$kode_konversi_stok_bahan_jadi));
				$konversi_stok_bahan_jadi = $konversi_stok_bahan_jadi->row()->acuan ;

				if(empty($stok_real)){

					$data_stok['real_stock'] = $stok_masuk;
					//$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

					$this->db->select('kode_unit_default,kode_rak_default');
					$kode_default = $this->db->get('master_setting');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit_default;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

				}
				else{
					$this->db->select('*') ;
					$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
					$jumlah_stok = $jumlah_stok->row()->real_stock ;

					$data_stok['real_stock'] = $stok_masuk + $jumlah_stok;
					//$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

					$this->db->select('kode_unit_default,kode_rak_default');
					$kode_default = $this->db->get('master_setting');
					$hasil_kode_default = $kode_default->row();
					$kode_unit = @$hasil_kode_default->kode_unit_default;
					$kode_rak = @$hasil_kode_default->kode_rak_default;

					$this->db->select('nama_unit');
					$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
					$hasil_master_unit = $master_unit->row();
					$nama_unit = @$hasil_master_unit->nama_unit;

					$this->db->select('nama_rak');
					$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
					$hasil_master_rak = $master_rak->row();
					$nama_rak = @$hasil_master_rak->nama_rak;

					$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

					$stok['jenis_transaksi'] = 'pembelian' ;
					$stok['kode_transaksi'] = $kode_pembelian ;
					$stok['kategori_bahan'] = $kategori_bahan ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $nama_bahan ;
					$stok['stok_keluar'] = '';
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'supplier';
					$stok['posisi_akhir'] = 'gudang';
					$stok['hpp'] = $harga_satuan_stok ;
					$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
					$stok['kode_unit_tujuan'] = $kode_unit;
					$stok['nama_unit_tujuan'] = $nama_unit;
					$stok['kode_rak_tujuan'] = $kode_rak;
					$stok['nama_rak_tujuan'] = $nama_rak;
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

				}
			}
		}

			//if($transaksi_stok){
		unset($input['kategori_bahan']);
		unset($input['kode_bahan']);
		unset($input['nama_bahan']);
		unset($input['jumlah']);
		unset($input['kode_satuan']);
		unset($input['nama_satuan']);
		unset($input['harga_satuan']);
		unset($input['id_item']);
		unset($input['jatuh_tempo']);

		$this->db->select('*') ;
		@$query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$input['kode_sub']))->row();
		@$kode_sub = $query_akun->kode_sub_kategori_akun;
		@$nama_sub = $query_akun->nama_sub_kategori_akun;
		@$kode_kategori = $query_akun->kode_kategori_akun;
		@$nama_kategori = $query_akun->nama_kategori_akun;
		@$kode_jenis = $query_akun->kode_jenis_akun;
		@$nama_jenis = $query_akun->nama_jenis_akun;

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		$grand_total = $data->grand_total ;

		unset($input['kode_sub']);
		unset($input['diskon_item']);
		unset($input['kode_edit_penjualan']);

		$this->db->select_max('urut');
		$result = $this->db->get_where('transaksi_pembelian');
		$hasil = @$result->result();
		if($result->num_rows()) $no = ($hasil[0]->urut)+1;
		else $no = 1;

		if($no<10)$no = '000'.$no;
		else if($no<100)$no = '00'.$no;
		else if($no<1000)$no = '0'.$no;
		else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
		$code = $no;

		$this->db->select('kode_pembelian');
		$get_kode_pembelian = $this->db->get('master_setting');
		$hasil_kode_pembelian = $get_kode_pembelian->row();


		unset($input['jenis_diskon']);
		$input['tanggal_pembelian'] = date("Y-m-d") ;
		$input['total_nominal'] = $grand_total ;
		@$input['grand_total'] = @$grand_total - $input['diskon_rupiah'];
		$input['petugas'] = $nama_petugas ;
		$input['id_petugas'] = $id_petugas;
		$input['keterangan'] = '' ;
		$input['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
		$input['status'] = 'belum divalidasi';
		$input['position'] = 'gudang' ;
		$input['kode_transaksi'] = @$hasil_kode_pembelian->kode_pembelian."_".date("dmYhis")."_".$code;
		$input['urut'] = $no;
		$tabel_transaksi_pembelian = $this->db->insert("transaksi_pembelian", $input);

		// ---------------------singkron----------------------------------------------------------------------------------------
		$singkron_query = $this->db->last_query();
		$singkron['jenis_singkron'] = 'tambah';
		$singkron['query'] = $singkron_query;
		$singkron['status'] = 'pending';
		$this->db->insert("singkronasi", $singkron);

		if($tabel_transaksi_pembelian){

			if(@$input['proses_pembayaran'] == 'cash'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
				$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
				$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
				$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
				$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
				$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
				$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;

						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
			}
			else if(@$input['proses_pembayaran'] == 'debet'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
				$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
				$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
				$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
				$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
				$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
				$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;

						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
			}
			else if(@$input['proses_pembayaran'] == 'credit'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $input['dibayar'];
				$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
				$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
				$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
				$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
				$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
				$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;

						//$keuangan = $this->db->insert("keuangan_keluar", $data_keu);

				$data_hutang['kode_transaksi'] = $kode_pembelian ;
				$data_hutang['kode_supplier'] = $kode_supplier ;
				$data_hutang['nama_supplier'] = $nama_supplier ;
				$data_hutang['nominal_hutang'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'];
				$data_hutang['angsuran'] = '' ;
				$data_hutang['sisa'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'] ;
				$data_hutang['tanggal_transaksi'] = date("Y-m-d") ;
				$data_hutang['petugas'] = $nama_petugas ;
				$data_hutang['id_petugas'] = $id_petugas;

						//$hutang = $this->db->insert("transaksi_hutang", $data_hutang);

			}
			$this->db->delete( 'opsi_transaksi_pembelian_temp', array('kode_pembelian' => $kode_pembelian) );

				    //$this->db->truncate('opsi_transaksi_pembelian_temp');
			echo '1|<div class="alert alert-success">Berhasil Melakukan Pembelian.</div>';  
		}
		else{
			echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (Trx_pmbelian) .</div>';  
		}
			//}else{
				//echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (update_stok).</div>';  
			//}

	}

	public function simpan_transaksi_pembayaran()
	{

		$input = $this->input->post();
		unset($input['harga_jual_1']);
		unset($input['harga_jual_2']);
		$kode_pembelian = $input['kode_pembelian'];
		$kode_po = $input['kode_po2'];
		$proses_bayar = $input['proses_pembayaran'];

		$status_po['status']='selesai';
		$this->db->update('transaksi_po',$status_po,array('kode_transaksi'=>$kode_po));


		$get_id_petugas = $this->session->userdata('astrosession');
		$id_petugas = $get_id_petugas->id;
		$nama_petugas = $get_id_petugas->uname;

		$this->db->select('*, SUM(subtotal)as grand_total, SUM(subtotal_retur)as grand_total_retur') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		$grand_total = $data->grand_total;
		$grand_total_retur = $data->grand_total_retur;
		$tot_pembelian = $grand_total - $input['diskon_rupiah'];


		unset($input['kode_po2']);
		unset($input['keterangan']);
		unset($input['tgl_barang_datang']);
		unset($input['tanggal_termin']);


		if($input['dibayar'] < $tot_pembelian && $proses_bayar != 'credit'){
			echo '0|<div class="alert alert-danger">Periksa nilai pembayaran.</div>';  
		}
		else{
			$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
				$data_opsi['kode_pembelian'] = $item->kode_pembelian;
				$data_opsi['kode_po'] = $kode_po;
				$data_opsi['kategori_bahan'] = $item->kategori_bahan;
				$data_opsi['kode_bahan'] = $item->kode_bahan;
				$data_opsi['nama_bahan'] = $item->nama_bahan;
				$data_opsi['jumlah'] = $item->jumlah;
				$data_opsi['kode_satuan'] = $item->kode_satuan;
				$data_opsi['nama_satuan'] = $item->nama_satuan;
				$data_opsi['harga_satuan'] = $item->harga_satuan;
		     	//$data_opsi['diskon_item'] = $item->diskon_item;
				$data_opsi['kode_supplier'] = $input['kode_supplier'];
				$data_opsi['nama_supplier'] =$item->nama_supplier;	
				$data_opsi['subtotal'] = $item->subtotal;
				$data_opsi['position'] = 'gudang';
				$hpp_pembelian=$item->harga_satuan;
			//$tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_pembelian", $data_opsi);

				$grand_total = $total + $item->subtotal;
				$harga_satuan = $item->harga_satuan;
				$nama_bahan = $item->nama_bahan;
				$stok_masuk = $item->jumlah;
				$kode_pembelian = $item->kode_pembelian;
				$kategori_bahan = $item->kategori_bahan;
				$kode_bahan = $item->kode_bahan;
				$nama_supplier = $item->nama_supplier;
				$kode_supplier = $item->kode_supplier;

				if($kategori_bahan=='stok'){
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();

					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
					$stok_real = $real_stock->row()->real_stock ;
					$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

					if(empty($stok_real)){

						$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
						// $hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
						// $hpp_hasil = $hpp->row()->hpp ;
						
						$hpp_baru['hpp']=$hpp_pembelian;
						$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
						echo $this->db->last_query();
					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$hasil_kode_default->kode_unit));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
					//$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
						$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
						$hpp_hasil = $hpp->row()->hpp ;
						echo $hpp_hasil;
						
						$hasil_hpp_baru=($hpp_hasil + $hpp_pembelian) / 2 ;

						$angka = $hasil_hpp_baru;
						$angka_format =round($angka,2);
						//echo $angka_format;
						$hpp_baru['hpp']= $angka_format;
						$hpp_baru['harga_beli_akhir']= $hpp_pembelian;
						$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
						//echo $this->db->last_query();
					}
				}





				if($kategori_bahan=='barang'){
					$kode_default = $this->db->get('setting_gudang');
					$hasil_kode_default = $kode_default->row();

					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
					$stok_real = $real_stock->row()->real_stok ;
					$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

					if(empty($stok_real)){

						$data_stok['real_stok'] = $stok_masuk * $konversi_stok;
					//$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan,'position'=>$hasil_kode_default->kode_unit));
						$jumlah_stok = $jumlah_stok->row()->real_stok ;

						$data_stok['real_stok'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
					//$this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan));

						$this->db->select('kode_unit');
						$kode_default = $this->db->get('setting_gudang');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok = $harga_satuan / $konversi_stok;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
				}

				if($kategori_bahan==''){
					$this->db->select('*') ;
					$real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
					$stok_real = $real_stock->row()->real_stock ;
					$kode_konversi_stok_bahan_jadi = $real_stock->row()->kode_satuan_stok ;


					$konversi_stok_bahan_jadi = $this->db->get_where('master_satuan',array('kode'=>$kode_konversi_stok_bahan_jadi));
					$konversi_stok_bahan_jadi = $konversi_stok_bahan_jadi->row()->acuan ;

					if(empty($stok_real)){

						$data_stok['real_stock'] = $stok_masuk;
					//$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

						$this->db->select('kode_unit_default,kode_rak_default');
						$kode_default = $this->db->get('master_setting');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;
						/*$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
						$hpp_hasil = $hpp->row()->hpp ;
						
						$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
						$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
						echo $this->db->last_query();*/
						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
						$this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = $stok_masuk + $jumlah_stok;
					//$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

						$this->db->select('kode_unit_default,kode_rak_default');
						$kode_default = $this->db->get('master_setting');
						$hasil_kode_default = $kode_default->row();
						$kode_unit = @$hasil_kode_default->kode_unit_default;
						$kode_rak = @$hasil_kode_default->kode_rak_default;

						$this->db->select('nama_unit');
						$master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
						$hasil_master_unit = $master_unit->row();
						$nama_unit = @$hasil_master_unit->nama_unit;

						$this->db->select('nama_rak');
						$master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
						$hasil_master_rak = $master_rak->row();
						$nama_rak = @$hasil_master_rak->nama_rak;

						$harga_satuan_stok =$harga_satuan / $konversi_stok_bahan_jadi;

						$stok['jenis_transaksi'] = 'pembelian' ;
						$stok['kode_transaksi'] = $kode_pembelian ;
						$stok['kategori_bahan'] = $kategori_bahan ;
						$stok['kode_bahan'] = $kode_bahan ;
						$stok['nama_bahan'] = $nama_bahan ;
						$stok['stok_keluar'] = '';
						$stok['stok_masuk'] = $stok_masuk ;
						$stok['posisi_awal'] = 'supplier';
						$stok['posisi_akhir'] = 'gudang';
						$stok['hpp'] = $harga_satuan_stok ;
						$stok['sisa_stok'] = $stok_masuk * $konversi_stok ;
						$stok['kode_unit_tujuan'] = $kode_unit;
						$stok['nama_unit_tujuan'] = $nama_unit;
						$stok['kode_rak_tujuan'] = $kode_rak;
						$stok['nama_rak_tujuan'] = $nama_rak;
						$stok['id_petugas'] = $id_petugas;
						$stok['nama_petugas'] = $nama_petugas;
						$stok['tanggal_transaksi'] = date("Y-m-d") ;

						/*$hpp = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
						$hpp_hasil = $hpp->row()->hpp ;
						
						$hpp_baru['hpp']= ($hpp_hasil + $hpp_pembelian) /2 ;
						$this->db->update('master_bahan_baku',$hpp_baru,array('kode_bahan_baku'=>$kode_bahan));
						echo $this->db->last_query();*/
						//$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
				}
			}

			//if($transaksi_stok){
			unset($input['kategori_bahan']);
			unset($input['kode_bahan']);
			unset($input['nama_bahan']);
			unset($input['jumlah']);
			unset($input['kode_satuan']);
			unset($input['nama_satuan']);
			unset($input['harga_satuan']);
			unset($input['id_item']);
			unset($input['termin']);

			$this->db->select('*') ;
			$query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$input['kode_sub']))->row();
			$kode_sub = $query_akun->kode_sub_kategori_akun;
			$nama_sub = $query_akun->nama_sub_kategori_akun;
			$kode_kategori = $query_akun->kode_kategori_akun;
			$nama_kategori = $query_akun->nama_kategori_akun;
			$kode_jenis = $query_akun->kode_jenis_akun;
			$nama_jenis = $query_akun->nama_jenis_akun;

			$this->db->select('*, SUM(subtotal)as grand_total') ;
			$query = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));
			$data = $query->row();
			$grand_total = $data->grand_total ;

			unset($input['kode_sub']);
			unset($input['kode_po']);
			unset($input['tgl_jatuh_tempo']);

			$input['total_nominal'] = $grand_total ;
			$input['grand_total'] = $grand_total - $input['diskon_rupiah'];


		//$tabel_transaksi_pembelian = $this->db->update("transaksi_pembelian", $input);
			$tabel_transaksi_pembelian = $this->db->update("transaksi_pembelian", $input, array('kode_pembelian'=>$kode_pembelian));

		//if($tabel_transaksi_pembelian){

			if($input['proses_pembayaran'] == 'cash'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
				$data_keu['kode_jenis_keuangan'] = '2' ;
				$data_keu['nama_jenis_keuangan'] = 'Pengeluaran' ;
				$data_keu['kode_kategori_keuangan'] = '2.1' ;
				$data_keu['nama_kategori_keuangan'] = 'Pembelian' ;
				$data_keu['kode_sub_kategori_keuangan'] = '2.1.1' ;
				$data_keu['nama_sub_kategori_keuangan'] = 'Pembelian Tunai' ;

				$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
			}
			else if($input['proses_pembayaran'] == 'debet'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $grand_total - $input['diskon_rupiah'];
				$data_keu['kode_jenis_keuangan'] = '2' ;
				$data_keu['nama_jenis_keuangan'] = 'Pengeluaran' ;
				$data_keu['kode_kategori_keuangan'] = '2.1' ;
				$data_keu['nama_kategori_keuangan'] = 'Pembelian' ;
				$data_keu['kode_sub_kategori_keuangan'] = '2.1.2' ;
				$data_keu['nama_sub_kategori_keuangan'] = 'Pembelian Debit' ;

				$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
			}
			else if($input['proses_pembayaran'] == 'credit'){
				$data_keu['id_petugas'] = $id_petugas;
				$data_keu['petugas'] = $nama_petugas ;
				$data_keu['kode_referensi'] = $kode_pembelian ;
				$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keu['keterangan'] = 'pembelian' ;
				$data_keu['nominal'] = $input['dibayar'];
				$data_keu['kode_jenis_keuangan'] = '2' ;
				$data_keu['nama_jenis_keuangan'] = 'Pengeluaran' ;
				$data_keu['kode_kategori_keuangan'] = '2.1' ;
				$data_keu['nama_kategori_keuangan'] = 'Pembelian' ;
				$data_keu['kode_sub_kategori_keuangan'] = '2.1.3' ;
				$data_keu['nama_sub_kategori_keuangan'] = 'Pembelian Kredit' ;

				$keuangan = $this->db->insert("keuangan_keluar", $data_keu);

				$tgl_jatuh_tempo = $this->input->post('tgl_jatuh_tempo');
				$data_hutang['kode_transaksi'] = $kode_pembelian ;
				$data_hutang['kode_supplier'] = $kode_supplier ;
				$data_hutang['nama_supplier'] = $nama_supplier ;
				$data_hutang['nominal_hutang'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'];
				$data_hutang['angsuran'] = '' ;
				$data_hutang['sisa'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'];
				$data_hutang['tanggal_transaksi'] = date("Y-m-d") ;
				$data_hutang['petugas'] = $nama_petugas ;
				$data_hutang['id_petugas'] = $id_petugas;
				$data_hutang['tanggal_jatuh_tempo'] = $tgl_jatuh_tempo;

				$this->db->select('kode_pembelian');
				$get_kode_ro = $this->db->get('master_setting');
				$hasil_kode_ro = $get_kode_ro->row();

				$this->db->select_max('urut');
				$result = $this->db->get_where('transaksi_hutang');
				$hasil = @$result->result();
				if($result->num_rows()) $no = ($hasil[0]->urut)+1;
				else $no = 1;

				if($no<10)$no = '000'.$no;
				else if($no<100)$no = '00'.$no;
				else if($no<1000)$no = '0'.$no;
				else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
				$code = $no;
				$data_hutang['kode_hutang'] = @$hasil_kode_ro->kode_pembelian."_".$code;
				$data_hutang['urut'] = $no;
				$hutang = $this->db->insert("transaksi_hutang", $data_hutang);

			}
			//$this->db->delete( 'opsi_transaksi_pembelian_temp', array('kode_pembelian' => $kode_pembelian) );
				    //$this->db->truncate('opsi_transaksi_pembelian_temp');
			echo '1|<div class="alert alert-success">Berhasil Melakukan Pembelian.</div>';  
		//}else{
			//echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (Trx_pmbelian) .</div>';  
		//}
			// }else{
			// 	echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (update_stok).</div>';  
			// }
		}
		
	}

	public function hapus_bahan_temp(){
		$id = $this->input->post('id');
		$this->db->delete('opsi_transaksi_pembelian_temp',array('id'=>$id));
	}

	public function get_rupiah(){
		$dibayar = $this->input->post('dibayar');
		$hasil = format_rupiah($dibayar);
		$kode_pembelian = $this->input->post('kode_pembelian');
		$grand = $this->input->post('grand');

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		$grand_total = $data->grand_total ;

		if($dibayar == $grand){
			echo 'Kembali '.format_rupiah(0).'|'.$hasil;
		}
		else if($dibayar > $grand){
			echo 'Kembali '.format_rupiah($dibayar - $grand).'|'.$hasil;
		}
		else if($dibayar < $grand){
			echo 'Kurang '.format_rupiah($grand - $dibayar).'|'.$hasil;
		}

	}

	public function get_rupiah_kredit(){
		$dibayar = $this->input->post('dibayar');
		$hasil = format_rupiah($dibayar);
		$kode_pembelian = $this->input->post('kode_pembelian');
		$grand = $this->input->post('grand');

		$this->db->select('*, SUM(subtotal)as grand_total') ;
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		$data = $query->row();
		$grand_total = $data->grand_total ;

		if($dibayar == $grand){
			echo 'Hutang '.format_rupiah(0).'|'.$hasil;
		}
		else if($dibayar > $grand){
			echo 'Tidak Boleh melebihi Grand Total |'.$hasil;
		}
		else if($dibayar < $grand){
			echo 'Hutang '.format_rupiah($grand - $dibayar).'|'.$hasil;
		}

	}

	public function get_bahan()
	{
		$param = $this->input->post();
		$jenis = $param['jenis_bahan'];
		$unit = $this->db->get('setting_gudang');
		$hasil_unit = $unit->row(); 
		if($jenis == 'bahan baku'){
			$opt = '';
			$query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> $hasil_unit->kode_unit));
			$opt = '<option value="">--Pilih Bahan Baku--</option>';
			foreach ($query->result() as $key => $value) {
				$opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
			}
			echo $opt;

		}else if ($jenis == 'bahan jadi') {
			$opt = '';
			$query = $this->db->get_where('master_bahan_jadi',array('kode_unit'=> $hasil_unit->kode_unit_default));
			$opt = '<option value="">--Pilih Bahan Jadi--</option>';
			foreach ($query->result() as $key => $value) {
				$opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
			}
			echo $opt;
		}else if ($jenis == 'barang') {
			$opt = '';
			$query = $this->db->get_where('master_barang',array('position'=> $hasil_unit->kode_unit));
			$opt = '<option value="">--Pilih Barang--</option>';
			foreach ($query->result() as $key => $value) {
				$opt .= '<option value="'.$value->kode_barang.'">'.$value->nama_barang.'</option>';  
			}
			echo $opt;
		}
	}

	public function get_satuan()
	{
		$kode_bahan = $this->input->post('kode_bahan');
		//$jenis_bahan = $this->input->post('jenis_bahan');
		//if($jenis_bahan=='bahan baku'){
		$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan));
		$hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
		/*}elseif($jenis_bahan=='bahan jadi'){
			$nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan));
			$hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
		}elseif($jenis_bahan=='barang'){
			$nama_bahan = $this->db->get_where('master_barang',array('kode_barang' => $kode_bahan));
			$hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
		}*/
		echo json_encode($hasil_bahan);

	}

	public function get_temp_pembelian(){
		$id = $this->input->post('id');
		$pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('id'=>$id));
		$hasil_pembelian = $pembelian->row();
		echo json_encode($hasil_pembelian);
	}
	public function get_opsi_pembelian(){
		$id = $this->input->post('id');
		$pembelian = $this->db->get_where('opsi_transaksi_pembelian',array('id'=>$id));
		$hasil_pembelian = $pembelian->row();
		
		$bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$hasil_pembelian->kode_bahan));
		$hasil_bahan_baku = $bahan_baku->row();
		echo "|".$hasil_pembelian->id."|".$hasil_pembelian->jumlah."|".$hasil_bahan_baku->kode_bahan_baku."|".$hasil_bahan_baku->nama_bahan_baku."|".$hasil_bahan_baku->hpp."|".$hasil_bahan_baku->harga_jual_1."|".$hasil_bahan_baku->harga_jual_2."|";
		//echo json_encode($hasil_pembelian);
	}

	public function keterangan()
	{
		$data = $this->input->post();
		$hutang = $this->db->insert("setting_pembelian", $data);		
	}

	public function get_termin(){
		$data = $this->input->post();
		$po = $this->db->get_where('transaksi_po',array('kode_transaksi'=>$data['kode_po']));
		$hasil_po = $po->row();

		@$supplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$hasil_po->kode_supplier));
		@$hasil_supplier = @$supplier->row();

		if (empty($hasil_supplier->termin)){
			$tgl_default=date('Y-m-d');
        	//echo $tgl_default;
			echo "<input type='date' name='jatuh_tempo' class='form-control' id='jatuh_tempo' value='$tgl_default' />";
		}else{

			@$jatuh_tempo=date('Y-m-d', strtotime(date("Y-m-d") . "+ $hasil_supplier->termin day "));

			echo "<input type='date' name='jatuh_tempo' class='form-control' id='jatuh_tempo' value='$jatuh_tempo' />";
		}



	}

}
