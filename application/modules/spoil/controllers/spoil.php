<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class spoil extends MY_Controller {

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
		redirect(base_url('spoil/daftar_spoil'));
		
	}
	 public function cari_spoil()
    {
        $this->load->view('spoil/setting/cari_spoil');       
    }
     public function cari_spoil_kitchen()
    {
        $this->load->view('spoil/setting/cari_spoil_kitchen');       
    }
	public function gudang()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/daftar_spoil_gudang', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function kitchen()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/daftar', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function bar()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/daftar', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}
	public function server()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/daftar', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);
	}

    //------------------------------------------ View Data Table----------------- --------------------//
    
	public function menu_stok()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/menu_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_stok()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/daftar_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function list_stock(){
		$kode_unit = $this->input->post('kode_unit');
		$kode_rak = $this->input->post('kode_rak');
		
		$get_stok = $this->db->query("SELECT * from master_bahan_baku where kode_rak='$kode_rak'");

		#echo $this->db->last_query();
        $table = '';
	    foreach ($get_stok->result() as $key => $value) {
	    	$kode_bahan = $value->kode_bahan_baku; 
            $this->db->select('*, min(id) id');                       
            $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
            $hasil_hpp_bahan = $get_kode_bahan->row();
            $get_stok_min = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan));
            $hasil_stok_min = $get_stok_min->row();
             if ($value->real_stock <= $hasil_stok_min->stok_minimal){
            	$table.='<tr class="danger">';
            }else{
            	$table.='<tr>';
            }
	        $table .= 
	        '<td>'.$value->kode_bahan_baku.'</td>
	        <td>'.$value->nama_bahan_baku.'</td>
	        <td>'.$value->kode_rak.'</td>
	        <td>'.$value->nama_rak.'</td>
	        <td>'.$value->real_stock.'</td>
            <td>'.$value->satuan_stok.'</td>
	        <td>'.format_rupiah($hasil_hpp_bahan->hpp).'</td>
            <td>'.format_rupiah($hasil_hpp_bahan->hpp * $value->real_stock).'</td>
	        <td>'.get_detail_stok($kode_unit,$value->kode_rak,$value->kode_bahan_baku).'</td>
	    </tr>';
		}
		  echo $table; 
	}

	public function detail()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/detail_stok', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_opname()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/daftar_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tambah_opname()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/tambah_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function detail_opname()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/detail_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tabel_temp_data_opname()
	{
		//$data['diskon'] = $this->diskon_tabel();
		$this->load->view ('stok/stok/tabel_opname_temp');		
	}

	public function get_opname(){
        $this->load->view('stok/stok/tabel_opname_temp');
    }

    public function validasi_opname()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/stok/validasi_opname', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

    public function simpan_item_opname_temp()
	{
	   $masukan = $this->input->post();
	   $jenis_bahan = $masukan['jenis_bahan'];
	   $kode_unit = $masukan['kode_unit'];
	   $kode_rak = $masukan['kode_rak'];

	   if ($jenis_bahan == 'bahan baku') {
	   	$kode_bahan = $masukan['kode_bahan'];
	   	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
		$jumlah_stok = $jumlah_stok->row()->real_stock ;

		$masukan['stok_awal'] = $jumlah_stok;
		$selisih = $jumlah_stok - $masukan['stok_akhir'];

		if($selisih == 0){
    		$status = 'cocok';
    	} elseif ($selisih > 0) {
    		$status = 'kurang';
    	} else {
    		$status = 'lebih';
    	}

        $masukan['selisih'] = abs($selisih);
        $masukan['status'] = $status;

	   } 

	   if ($jenis_bahan == 'bahan jadi') {
	   	$kode_bahan = $masukan['kode_bahan'];
	   	$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
		$jumlah_stok = $jumlah_stok->row()->real_stock ;

		$masukan['stok_awal'] = $jumlah_stok;
		$selisih = $jumlah_stok - $masukan['stok_akhir'];

		if($selisih == 0){
    		$status = 'cocok';
    	} elseif ($selisih > 0) {
    		$status = 'kurang';
    	} else {
    		$status = 'lebih';
    	}

        $masukan['selisih'] = abs($selisih);
        $masukan['status'] = $status;

	   } 
	   
       $this->db->insert('opsi_transaksi_opname_temp',$masukan);
       echo "sukses";
		
				 				
	}

	public function update_item_opname_temp(){
        $update = $this->input->post();
        $jenis_bahan = $update['jenis_bahan'];
	   	$kode_rak = $update['kode_rak'];
        $kode_unit = $this->uri->segment(4);

		   if ($jenis_bahan == 'bahan baku') {
		   	$kode_bahan = $update['kode_bahan'];
		   	$kode_unit = $this->uri->segment(4);
		   	$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$jumlah_stok = $jumlah_stok->row()->real_stock ;

			$update['stok_awal'] = $jumlah_stok;
			$selisih = $jumlah_stok - $update['stok_akhir'];

			if($selisih == 0){
	    		$status = 'cocok';
	    	} elseif ($selisih > 0) {
	    		$status = 'kurang';
	    	} else {
	    		$status = 'lebih';
	    	}

	        $update['selisih'] = abs($selisih);
	        $update['status'] = $status;

		   } 

		   if ($jenis_bahan == 'bahan jadi') {
		   	$kode_bahan = $update['kode_bahan'];
		   	$kode_unit = $this->uri->segment(4);
		   	$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$jumlah_stok = $jumlah_stok->row()->real_stock ;

			$update['stok_awal'] = $jumlah_stok;
			$selisih = $jumlah_stok - $update['stok_akhir'];

			if($selisih == 0){
	    		$status = 'cocok';
	    	} elseif ($selisih > 0) {
	    		$status = 'kurang';
	    	} else {
	    		$status = 'lebih';
	    	}

	        $update['selisih'] = abs($selisih);
	        $update['status'] = $status;

		   }
        $this->db->update('opsi_transaksi_opname_temp',$update,array('id'=>$update['id']));
        echo "sukses";
    }

    public function simpan_opname()
    {
    	$input = $this->input->post();
		$kode_opname = $input['kode_opname'];

		$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

		$this->db->select('*') ;
		$query_opname_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_opname'=>$kode_opname));

		$total = 0;
		foreach ($query_opname_temp->result() as $item){
	     	$data_opsi['kode_opname'] = $item->kode_opname;
	     	$data_opsi['jenis_bahan'] = $item->jenis_bahan;
	     	$data_opsi['kode_bahan'] = $item->kode_bahan;
	     	$data_opsi['nama_bahan'] = $item->nama_bahan;
	     	$data_opsi['kode_unit'] = $item->kode_unit;
	     	$data_opsi['nama_unit'] = $item->nama_unit;
	     	$data_opsi['kode_rak'] = $item->kode_rak;
	     	$data_opsi['nama_rak'] = $item->nama_rak;
	     	$data_opsi['stok_awal'] = $item->stok_awal;
	     	$data_opsi['stok_akhir'] = $item->stok_akhir;
	     	$data_opsi['selisih'] = $item->selisih;
	     	$data_opsi['status'] = $item->status;
	     	$data_opsi['keterangan'] = $item->keterangan;
            
            $tabel_opsi_transaksi_opname = $this->db->insert("opsi_transaksi_opname", $data_opsi);
	    }

	    if($tabel_opsi_transaksi_opname){
			unset($input['jenis_bahan']);
			unset($input['kode_bahan']);
            unset($input['nama_bahan']);
			unset($input['stok_akhir']);
			unset($input['kode_rak']);
            unset($input['nama_rak']);
			unset($input['keterangan']);
            unset($input['id_item']);

			$kode_opname = $input['kode_opname'];

			$this->db->select('*') ;
			$query_opname_temp = $this->db->get_where('opsi_transaksi_opname_temp',array('kode_opname'=>$kode_opname));
			$opname_temp = $query_opname_temp->row();

			$kode_rak = $opname_temp->kode_rak;
			$get_rak = $this->db->get_where('master_rak',array('kode_rak'=>$kode_rak));
			$get_rak = $get_rak->row();

			$kode_unit = $get_rak->kode_unit;
			$nama_unit = $get_rak->nama_unit;

			$input['kode_opname'] = $kode_opname;
			$input['tanggal_opname'] = date("Y-m-d") ;
	    	$input['petugas'] = $nama_petugas ;
	    	$input['keterangan'] = $opname_temp->keterangan ;
	    	$input['kode_unit'] = $kode_unit ;
	    	$input['nama_unit'] = $nama_unit ;
	    	$input['validasi'] = 'confirm' ;

			$tabel_transaksi_opname = $this->db->insert("transaksi_opname", $input);
			if($tabel_transaksi_opname){
			     $this->db->truncate('opsi_transaksi_opname_temp');
				echo '<div class="alert alert-success">Berhasil Melakukan Opname.</div>';  
			}
			else{
				echo '<div class="alert alert-danger">Gagal Melakukan Opname (Trx_opname) .</div>';  
			}
		}
		else{
			echo '<div class="alert alert-danger">Gagal Melakukan Opname (update_stok).</div>';  
		}
    }

    public function jangan_sesuaikan()
    {
        $param = $this->input->post();
        $kode_opname = $param['kode_opname'];

		$update['validasi'] = 'confirmed';
        $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));
        echo '<div class="alert alert-success">Berhasil, tidak menyesuaikan stok opname.</div>';
    }

    public function sesuaikan()
    {
        $param = $this->input->post();
        $kode_opname = $param['kode_opname'];

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

		$update['validasi'] = 'confirmed';
        $update_opname = $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));

        if($update_opname == TRUE){
            $data = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname ));
            foreach ($data->result_array() as $item) {

                if ($item['jenis_bahan'] == 'bahan baku') {
                	if($item['status']=='kurang'){
	                    $stok_keluar = $item['selisih'];
	                    $stok_masuk = 0;

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                } elseif ($item['status']=='lebih') {
	                    $stok_keluar = 0;
	                    $stok_masuk = $item['selisih'];

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                } elseif ($item['status']=='cocok') {
	                    $stok_keluar = $stok_masuk = 0;

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                }

                	$kode_bahan = $item['kode_bahan'];

                	$this->db->select('*, min(id) id');
		            $harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];;
					$stok['nama_unit_asal'] = $item['nama_unit'];;
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
                }

                if ($item['jenis_bahan'] == 'bahan jadi') {
                	if($item['status']=='kurang'){
	                    $stok_keluar = $item['selisih'];
	                    $stok_masuk = 0;

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                } elseif ($item['status']=='lebih') {
	                    $stok_keluar = 0;
	                    $stok_masuk = $item['selisih'];

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                } elseif ($item['status']=='cocok') {
	                    $stok_keluar = $stok_masuk = 0;

	                    $kode_rak = $item['kode_rak'];
	                    //$get_unit = $this->db->get_where('master_bahan_baku',array('kode_rak'=>$kode_rak));
						//$get_unit = $get_unit->row();

						$kode_unit = $item['kode_unit'];

	                    $kode_bahan = $item['kode_bahan'];
	                    $this->db->select('*') ;
						$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
						$jumlah_stok = $jumlah_stok->row()->real_stock;

	                	$data_stok['real_stock'] = $jumlah_stok + $stok_masuk + $stok_keluar;
						$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
	                }

                	$kode_bahan = $item['kode_bahan'];

                	$this->db->select('*, min(id) id');
		            $harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
					$harga_satuan = $harga_satuan->row()->hpp ;

					$stok['jenis_transaksi'] = 'opname' ;
					$stok['kode_transaksi'] = $kode_opname ;
					$stok['kategori_bahan'] = $item['jenis_bahan'] ;
					$stok['kode_bahan'] = $kode_bahan ;
					$stok['nama_bahan'] = $item['nama_bahan'] ;
					$stok['stok_keluar'] = $stok_keluar;
					$stok['stok_masuk'] = $stok_masuk ;
					$stok['posisi_awal'] = 'gudang';
					$stok['posisi_akhir'] = '';
					$stok['hpp'] = $harga_satuan ;
					$stok['kode_unit_asal'] = $item['kode_unit'];
					$stok['nama_unit_asal'] = $item['nama_unit'];
					$stok['kode_rak_asal'] = $item['kode_rak'];
					$stok['nama_rak_asal'] = $item['nama_rak'];
					$stok['id_petugas'] = $id_petugas;
					$stok['nama_petugas'] = $nama_petugas;
					$stok['tanggal_transaksi'] = date("Y-m-d") ;
                }
            }

            $transaksi_stok = $this->db->insert("transaksi_stok", $stok);
            if($transaksi_stok == TRUE){
                echo '<div class="alert alert-success">Berhasil, menyesuaikan stok opname.</div>';
            } else {
                echo '<div class="alert alert-danger">Gagal, menyesuaikan stok opname .</div>'; 
            }
        } else {
            echo '<div class="alert alert-danger">Gagal, update data approve.</div>'; 
        }
    }

    public function hapus_bahan_opname_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_opname_temp',array('id'=>$id));
    }

	public function get_temp_opname(){
        $id = $this->input->post('id');
        $opname = $this->db->get_where('opsi_transaksi_opname_temp',array('id'=>$id));
        $hasil_opname = $opname->row();
        echo json_encode($hasil_opname);
    }

	public function daftar_spoil()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/daftar', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	
	public function tambah_spoil()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/form', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function detail_spoil()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/detail', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
    
    public function detail_spoil_gudang()
	{
		$data['aktif'] = 'spoil';
		$data['konten'] = $this->load->view('spoil/setting/detail_spoil_gudang', NULL, TRUE);
		$data['halaman'] = $this->load->view('spoil/setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tabel_temp_data_transaksi()
	{
		//$data['diskon'] = $this->diskon_tabel();
		$this->load->view ('stok/stok/tabel_transaksi_temp');		
	}

	public function get_spoil(){
        $this->load->view('stok/stok/tabel_transaksi_temp');
    }

	public function get_bahan()
    {
        $param = $this->input->post();
        $kode_unit = $this->uri->segment(4);
        //echo $kode_unit;
        $jenis = $param['jenis_bahan'];

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit' => $kode_unit));
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'bahan jadi') {
            $opt = '';
            $query = $this->db->get_where('master_bahan_jadi',array('kode_unit' => $kode_unit));
                $opt = '<option value="">--Pilih Bahan Jadi--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
                }
            echo $opt;
        }
    }

    public function get_nama_bahan()
    {
        $kode_bahan = $this->input->post('kode_bahan');
        $jenis_bahan = $this->input->post('jenis_bahan');
        $kode_unit = $this->uri->segment(4);
        //echo $kode_unit;
        if($jenis_bahan=='bahan baku'){
                $nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan, 'kode_unit' => $kode_unit));
                $hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
        }elseif($jenis_bahan=='bahan jadi'){
            $nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan, 'kode_unit' => $kode_unit));
            $hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
        }
        echo json_encode($hasil_bahan);

    }

	public function simpan_item_temp()
	{
       $masukan = $this->input->post();
		
		$kode_bahan = $this->input->post('kode_bahan');
		$kode_unit = $this->input->post('kode_unit');
		$kode_rak = $this->input->post('kode_rak');
		$jumlah = $this->input->post('jumlah');
		$jenis_bahan = $this->input->post('jenis_bahan');

		if ($jenis_bahan == 'bahan baku') {
			$get_bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$kesalahan = 0;
			foreach ($get_bahan_baku->result() as $get_bahan_baku) {
				$kode_bahan_baku = $get_bahan_baku->kode_bahan_baku;
				$kode_unit_bahan_baku = $get_bahan_baku->kode_unit;
				$kode_rak_bahan_baku = $get_bahan_baku->kode_rak;

				$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan_baku,'kode_unit'=>$kode_unit_bahan_baku,'kode_rak'=>$kode_rak_bahan_baku));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				if ($jumlah_stok < $jumlah) {
					$kesalahan = $kesalahan+1;
				}

			}
		} 
		
		if ($jenis_bahan == 'bahan jadi') {
			$get_bahan_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$kesalahan = 0;
			foreach ($get_bahan_jadi->result() as $get_bahan_jadi) {
				$kode_bahan_jadi = $get_bahan_jadi->kode_bahan_jadi;
				$kode_unit_bahan_jadi = $get_bahan_jadi->kode_unit;
				$kode_rak_bahan_jadi = $get_bahan_jadi->kode_rak;

				$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan_jadi,'kode_unit'=>$kode_unit_bahan_jadi,'kode_rak'=>$kode_rak_bahan_jadi));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				if ($jumlah_stok < $jumlah) {
					$kesalahan = $kesalahan+1;
				}

			}
		}

		if ($kesalahan > 0) {
			echo '<div class="alert alert-danger">Bahan tidak mencukupi</div>';		
		}else{
			$this->db->insert('opsi_transaksi_spoil_temp',$masukan);
			echo '<div class="alert alert-success">Berhasil menambahkan data.</div>';
		}
		
				 				
	}

	public function update_item_temp(){
        $update = $this->input->post();
		
		$kode_bahan = $this->input->post('kode_bahan');
		$kode_unit = $this->input->post('kode_unit');
		$kode_rak = $this->input->post('kode_rak');
		$jumlah = $this->input->post('jumlah');
		$jenis_bahan = $this->input->post('jenis_bahan');

		if ($jenis_bahan == 'bahan baku') {
			$get_bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$kesalahan = 0;
			foreach ($get_bahan_baku->result() as $get_bahan_baku) {
				$kode_bahan_baku = $get_bahan_baku->kode_bahan_baku;
				$kode_unit_bahan_baku = $get_bahan_baku->kode_unit;
				$kode_rak_bahan_baku = $get_bahan_baku->kode_rak;

				$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan_baku,'kode_unit'=>$kode_unit_bahan_baku,'kode_rak'=>$kode_rak_bahan_baku));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				if ($jumlah_stok < $jumlah) {
					$kesalahan = $kesalahan+1;
				}

			}
		} 
		
		if ($jenis_bahan == 'bahan jadi') {
			$get_bahan_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
			$kesalahan = 0;
			foreach ($get_bahan_jadi->result() as $get_bahan_jadi) {
				$kode_bahan_jadi = $get_bahan_jadi->kode_bahan_jadi;
				$kode_unit_bahan_jadi = $get_bahan_jadi->kode_unit;
				$kode_rak_bahan_jadi = $get_bahan_jadi->kode_rak;

				$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan_jadi,'kode_unit'=>$kode_unit_bahan_jadi,'kode_rak'=>$kode_rak_bahan_jadi));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				if ($jumlah_stok < $jumlah) {
					$kesalahan = $kesalahan+1;
				}

			}
		}
		

		if ($kesalahan > 0) {
			echo '<div class="alert alert-danger">Bahan tidak mencukupi</div>';		
		}else{
			$this->db->update('opsi_transaksi_spoil_temp',$update,array('id'=>$update['id']));
			echo '<div class="alert alert-success">Berhasil menambahkan data.</div>';
		}
    }

    public function hapus_bahan_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_spoil_temp',array('id'=>$id));
    }

	public function get_temp_spoil(){
        $id = $this->input->post('id');
        $spoil = $this->db->get_where('opsi_transaksi_spoil_temp',array('id'=>$id));
        $hasil_spoil = $spoil->row();
        echo json_encode($hasil_spoil);
    }

    public function simpan_spoil()
	{
		$input = $this->input->post();
		$kode_spoil = $input['kode_spoil'];

		$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        
		$this->db->select('*') ;
		$query_spoil_temp = $this->db->get_where('opsi_transaksi_spoil_temp',array('kode_spoil'=>$kode_spoil));

		$grand_total_harga_satuan = 0;
		foreach ($query_spoil_temp->result() as $item){
	     	$data_opsi['kode_spoil'] = $item->kode_spoil;
	     	$data_opsi['jenis_bahan'] = $item->jenis_bahan;
	     	$data_opsi['kode_bahan'] = $item->kode_bahan;
	     	$data_opsi['nama_bahan'] = $item->nama_bahan;
	     	$data_opsi['jumlah'] = $item->jumlah;
	     	$data_opsi['kode_unit'] = $item->kode_unit;
	     	$data_opsi['nama_unit'] = $item->nama_unit;
	     	$data_opsi['kode_rak'] = $item->kode_rak;
	     	$data_opsi['nama_rak'] = $item->nama_rak;
	     	$data_opsi['keterangan'] = $item->keterangan;
            
            $kode_spoil = $item->kode_spoil;
            $kode_bahan = $item->kode_bahan;
			$nama_bahan = $item->nama_bahan;
			$kode_unit = $item->kode_unit;
			$nama_unit = $item->nama_unit;
			$kode_rak = $item->kode_rak;
			$nama_rak = $item->nama_rak;
			$jenis_bahan = $item->jenis_bahan;
			$stok_keluar = $item->jumlah;

			if ($jenis_bahan == 'bahan baku') {
				$this->db->select('*') ;
				$jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
				$this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));

				$this->db->select('*, min(id) id');
	            $harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
				$harga_satuan = $harga_satuan->row()->hpp ;

				$total_harga_satuan = $stok_keluar * $harga_satuan;

				$stok['jenis_transaksi'] = 'spoil' ;
				$stok['kode_transaksi'] = $kode_spoil ;
				$stok['kategori_bahan'] = $jenis_bahan ;
				$stok['kode_bahan'] = $kode_bahan ;
				$stok['nama_bahan'] = $nama_bahan ;
				$stok['stok_keluar'] = $stok_keluar;
				$stok['stok_masuk'] = '' ;
				$stok['posisi_awal'] = 'gudang';
				$stok['posisi_akhir'] = '';
				$stok['hpp'] = $harga_satuan ;
				$stok['kode_unit_asal'] = $kode_unit;
				$stok['nama_unit_asal'] = $nama_unit;
				$stok['kode_rak_asal'] = $kode_rak;
				$stok['nama_rak_asal'] = $nama_rak;
				$stok['id_petugas'] = $id_petugas;
				$stok['nama_petugas'] = $nama_petugas;
				$stok['tanggal_transaksi'] = date("Y-m-d") ;

				$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
			} 

			if ($jenis_bahan == 'bahan jadi') {
				$this->db->select('*') ;
				$jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));
				$jumlah_stok = $jumlah_stok->row()->real_stock ;

				$data_stok['real_stock'] = $jumlah_stok - $stok_keluar;
				$this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan,'kode_unit'=>$kode_unit,'kode_rak'=>$kode_rak));

				$this->db->select('*, min(id) id');
	            $harga_satuan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan));
				$harga_satuan = $harga_satuan->row()->hpp ;

				$total_harga_satuan = $stok_keluar * $harga_satuan;

				$stok['jenis_transaksi'] = 'spoil' ;
				$stok['kode_transaksi'] = $kode_spoil ;
				$stok['kategori_bahan'] = $jenis_bahan ;
				$stok['kode_bahan'] = $kode_bahan ;
				$stok['nama_bahan'] = $nama_bahan ;
				$stok['stok_keluar'] = $stok_keluar;
				$stok['stok_masuk'] = '' ;
				$stok['posisi_awal'] = 'gudang';
				$stok['posisi_akhir'] = '';
				$stok['hpp'] = $harga_satuan ;
				$stok['kode_unit_asal'] = $kode_unit;
				$stok['nama_unit_asal'] = $nama_unit;
				$stok['kode_rak_asal'] = $kode_rak;
				$stok['nama_rak_asal'] = $nama_rak;
				$stok['id_petugas'] = $id_petugas;
				$stok['nama_petugas'] = $nama_petugas;
				$stok['tanggal_transaksi'] = date("Y-m-d") ;

				$transaksi_stok = $this->db->insert("transaksi_stok", $stok);
			}

			$tabel_opsi_transaksi_spoil = $this->db->insert("opsi_transaksi_spoil", $data_opsi); 

			$grand_total_harga_satuan += $total_harga_satuan;
	    }

	    if($transaksi_stok){
			unset($input['jenis_bahan']);
			unset($input['kode_bahan']);
            unset($input['nama_bahan']);
            unset($input['jumlah']);
            unset($input['kode_unit_temp']);
			unset($input['kode_rak_temp']);
			unset($input['kode_rak']);
			unset($input['satuan']);
			unset($input['nama_rak']);
			unset($input['nama_satuan']);
            unset($input['id_item']);

			$kode_spoil = $input['kode_spoil'];

			$this->db->select('*') ;
			$query_spoil_temp = $this->db->get_where('opsi_transaksi_spoil_temp',array('kode_spoil'=>$kode_spoil));
			$spoil_temp = $query_spoil_temp->row();

			$input['kode_spoil'] = $kode_spoil;
			$input['tanggal_spoil'] = date("Y-m-d") ;
	    	$input['id_petugas'] = $id_petugas ;
	    	$input['petugas'] = $nama_petugas ;
	    	$input['keterangan'] = $spoil_temp->keterangan;
	    	$input['kode_unit'] = $spoil_temp->kode_unit;
	    	$input['nama_unit'] = $spoil_temp->nama_unit;

			$tabel_transaksi_spoil = $this->db->insert("transaksi_spoil", $input);

			if($tabel_transaksi_spoil){
				$get_keuangan_sub_kategori_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'2.5.1'));
				$get_keuangan_sub_kategori_akun = $get_keuangan_sub_kategori_akun->row();

				$data_keuangan['petugas'] = $nama_petugas ;
				$data_keuangan['kode_referensi'] = $kode_spoil ;
				$data_keuangan['tanggal_transaksi'] = date("Y-m-d") ;
				$data_keuangan['keterangan'] = 'spoil' ;
				$data_keuangan['nominal'] = $total_harga_satuan;
				$data_keuangan['kode_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->kode_jenis_akun;
				$data_keuangan['nama_jenis_keuangan'] = $get_keuangan_sub_kategori_akun->nama_jenis_akun;
				$data_keuangan['kode_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_kategori_akun;
				$data_keuangan['nama_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_kategori_akun;
				$data_keuangan['kode_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->kode_sub_kategori_akun;
				$data_keuangan['nama_sub_kategori_keuangan'] = $get_keuangan_sub_kategori_akun->nama_sub_kategori_akun;
				
				$keuangan = $this->db->insert("keuangan_keluar", $data_keuangan);

			    $this->db->truncate('opsi_transaksi_spoil_temp');

				echo '<div class="alert alert-success">Berhasil Melakukan Spoil.</div>';  
			}
			else{
				echo '<div class="alert alert-danger">Gagal Melakukan Spoil (Trx_spoil) .</div>';  
			}
		}
		else{
			echo '<div class="alert alert-danger">Gagal Melakukan Spoil (update_stok).</div>';  
		}
	}

	public function mutasi()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/mutasi/mutasi', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function daftar_mutasi()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/mutasi/daftar_mutasi', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function detail_mutasi()
	{
		$data['aktif'] = 'stok';
		$data['konten'] = $this->load->view('stok/mutasi/detail_mutasi', NULL, TRUE);
		$data['halaman'] = $this->load->view('stok/stok/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
	//------------------------------------------ PROSES ----------------- --------------------//
	

	
}
