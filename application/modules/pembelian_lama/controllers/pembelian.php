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
    
    public function index()
	{
		$data['konten'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);
	}
	public function daftar_pembelian()
	{
	    $data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/daftar_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('pembelian/menu', $data, TRUE);
		$this->load->view('pembelian/main', $data);		
	}

	public function tambah()
	{
        $data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/pembelian/tambah_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('pembelian/pembelian/menu', $data, TRUE);
		$this->load->view('main', $data);		
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
		$kode_pembelian = $this->input->post('kode_pembelian');
		$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
        $data = $query->row();
        echo $input ;
	}

	public function simpan_item_temp()
	{
	   $masukan = $this->input->post();
       $nama_suplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$masukan['kode_supplier']));
       $hasil_nama_supplier = $nama_suplier->row();
       $masukan['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
       $subtotal = $masukan['jumlah']*$masukan['harga_satuan'];
       $masukan['subtotal'] = $subtotal;
       $masukan['position'] ='gudang';
       $this->db->insert('opsi_transaksi_pembelian_temp',$masukan);
       echo "sukses";
		
				 				
	}
    
    public function update_item_temp(){
        $update = $this->input->post();
        $subtotal = $update['jumlah']*$update['harga_satuan'];
       $update['subtotal'] = $subtotal;
        $this->db->update('opsi_transaksi_pembelian_temp',$update,array('id'=>$update['id']));
        echo "sukses";
    }

	public function simpan_transaksi()
	{
		$input = $this->input->post();
		$kode_pembelian = $input['kode_pembelian'];
		$proses_bayar = $input['proses_pembayaran'];

		$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        
			$this->db->select('*, SUM(subtotal)as grand_total') ;
			$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
	        $data = $query->row();
	        $grand_total = $data->grand_total ;
	    	$tot_pembelian = $grand_total - $input['diskon_rupiah'];

	    if($input['dibayar'] < $tot_pembelian && $proses_bayar != 'credit'){
	    	echo '0|<div class="alert alert-danger">Periksa nilai pembayaran.</div>';  
	    }
	    else{
					 				$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
		     	$data_opsi['kode_pembelian'] = $item->kode_pembelian;
		     	$data_opsi['kategori_bahan'] = $item->kategori_bahan;
		     	$data_opsi['kode_bahan'] = $item->kode_bahan;
		     	$data_opsi['nama_bahan'] = $item->nama_bahan;
		     	$data_opsi['jumlah'] = $item->jumlah;
		     	$data_opsi['kode_satuan'] = $item->kode_satuan;
		     	$data_opsi['nama_satuan'] = $item->nama_satuan;
		     	$data_opsi['harga_satuan'] = $item->harga_satuan;
		     	//$data_opsi['diskon_item'] = $item->diskon_item;
		     	$data_opsi['kode_supplier'] = $item->kode_supplier;
		     	$data_opsi['nama_supplier'] = $item->nama_supplier;
		     	$data_opsi['subtotal'] = $item->subtotal;
		     	$data_opsi['position'] = 'gudang';
	            
	            $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_pembelian", $data_opsi);

	            $grand_total = $total + $item->subtotal;
	            $harga_satuan = $item->harga_satuan;
	            $nama_bahan = $item->nama_bahan;
	            $stok_masuk = $item->jumlah;
	            $kode_pembelian = $item->kode_pembelian;
	            $kategori_bahan = $item->kategori_bahan;
	            $kode_bahan = $item->kode_bahan;
	            $nama_supplier = $item->nama_supplier;
	            $kode_supplier = $item->kode_supplier;
	            
	            if($kategori_bahan=='bahan baku'){
	            			  $this->db->select('*') ;
				$real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
				$stok_real = $real_stock->row()->real_stock ;
				$konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

					if(empty($stok_real)){

						$data_stok['real_stock'] = $stok_masuk * $konversi_stok;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

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

					}
					else{
									   $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = ($stok_masuk * $konversi_stok)  + $jumlah_stok;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan));

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
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

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

						$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
					else{
									   $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan));
						$jumlah_stok = $jumlah_stok->row()->real_stock ;

						$data_stok['real_stock'] = $stok_masuk + $jumlah_stok;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan));

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

						$transaksi_stok = $this->db->insert("transaksi_stok", $stok);

					}
	            }
		    }

		    if($transaksi_stok){
				unset($input['kategori_bahan']);
				unset($input['kode_bahan']);
	            unset($input['nama_bahan']);
				unset($input['jumlah']);
				unset($input['kode_satuan']);
	            unset($input['nama_satuan']);
				unset($input['harga_satuan']);
	            unset($input['id_item']);

	            	$this->db->select('*') ;
					$query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$input['kode_sub']))->row();
					$kode_sub = $query_akun->kode_sub_kategori_akun;
		        	$nama_sub = $query_akun->nama_sub_kategori_akun;
		        	$kode_kategori = $query_akun->kode_kategori_akun;
		        	$nama_kategori = $query_akun->nama_kategori_akun;
		        	$kode_jenis = $query_akun->kode_jenis_akun;
		        	$nama_jenis = $query_akun->nama_jenis_akun;

						 $this->db->select('*, SUM(subtotal)as grand_total') ;
				$query = $this->db->get_where('opsi_transaksi_pembelian_temp',array('kode_pembelian'=>$kode_pembelian));
		        $data = $query->row();
		        $grand_total = $data->grand_total ;

		        unset($input['kode_sub']);

				$input['tanggal_pembelian'] = date("Y-m-d") ;
		    	$input['total_nominal'] = $grand_total ;
		    	$input['grand_total'] = $grand_total - $input['diskon_rupiah'];
		    	$input['petugas'] = $nama_petugas ;
		    	$input['id_petugas'] = $id_petugas;
		    	$input['keterangan'] = '' ;
		    	$input['nama_supplier'] = $nama_supplier ;
		    	$input['position'] = 'gudang' ;

				$tabel_transaksi_pembelian = $this->db->insert("transaksi_pembelian", $input);
				if($tabel_transaksi_pembelian){
					
					if($input['proses_pembayaran'] == 'cash'){
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
						
						$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
					}
					else if($input['proses_pembayaran'] == 'debet'){
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
						
						$keuangan = $this->db->insert("keuangan_keluar", $data_keu);
					}
					else if($input['proses_pembayaran'] == 'credit'){
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
						
						$keuangan = $this->db->insert("keuangan_keluar", $data_keu);

						$data_hutang['kode_transaksi'] = $kode_pembelian ;
						$data_hutang['kode_supplier'] = $kode_supplier ;
						$data_hutang['nama_supplier'] = $nama_supplier ;
						$data_hutang['nominal_hutang'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'];
						$data_hutang['angsuran'] = '' ;
						$data_hutang['sisa'] = ($grand_total - $input['diskon_rupiah']) - $input['dibayar'] ;
						$data_hutang['tanggal_transaksi'] = date("Y-m-d") ;
						$data_hutang['petugas'] = $nama_petugas ;
						$data_hutang['id_petugas'] = $id_petugas;

						$hutang = $this->db->insert("transaksi_hutang", $data_hutang);

					}
					$this->db->delete( 'opsi_transaksi_pembelian_temp', array('kode_pembelian' => $kode_pembelian) );
				    //$this->db->truncate('opsi_transaksi_pembelian_temp');
					echo '1|<div class="alert alert-success">Berhasil Melakukan Pembelian.</div>';  
				}
				else{
					echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (Trx_pmbelian) .</div>';  
				}
			}
			else{
				echo '1|<div class="alert alert-danger">Gagal Melakukan Pembelian (update_stok).</div>';  
			}
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
        $unit = $this->db->get('master_setting');
        $hasil_unit = $unit->row(); 
        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> $hasil_unit->kode_unit_default));
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

    public function get_temp_pembelian(){
        $id = $this->input->post('id');
        $pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('id'=>$id));
        $hasil_pembelian = $pembelian->row();
        echo json_encode($hasil_pembelian);
    }

    public function keterangan()
	{
		$data = $this->input->post();
		$hutang = $this->db->insert("setting_pembelian", $data);		
	}
	
}
