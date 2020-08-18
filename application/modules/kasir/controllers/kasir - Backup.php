<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class kasir extends MY_Controller {
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
	   $cek_kasir = $this->db->get_where('transaksi_kasir',array('tanggal'=>date("Y-m-d"),'status'=>'open'));
       $hasil_cek_kasir = $cek_kasir->row();
       if(count($hasil_cek_kasir)<1){
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/buka_kasir', NULL, TRUE);
       }else{
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/kasir_meja', NULL, TRUE);
       }
		
		$this->load->view('main', $data);		
	}
    
    public function buka_kasir(){
        $kasir = $this->input->post();
        $this->db->select_max('kode_transaksi');
        $cek_kasir = $this->db->get_where('transaksi_kasir',array('tanggal'=>date("Y-m-d"),'status'=>'close',
        'validasi'=>''));
        $hasil_cek = $cek_kasir->row();
        if(empty($hasil_cek->kode_transaksi)){
       	$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        $kasir['petugas'] = $nama_petugas;
            $this->db->insert('transaksi_kasir',$kasir);
            
        }else{
            echo "belum";    
        }
        
    }
    
    public function tutup_kasir(){
        $data['aktif'] = 'kasir'; 
        $data['konten'] = $this->load->view('kasir/kasir/tutup_kasir', NULL, TRUE);
		$this->load->view('main', $data);
    }
    
    public function dft_transaksi_kasir(){
        $data['aktif'] = 'trx_kasir';
        $data['konten'] = $this->load->view('kasir/kasir/dft_transaksi_kasir', NULL, TRUE);
		$this->load->view('main', $data);
    }
    
    public function simpan_tutup_kasir(){
        $update = $this->input->post();
        $this->db->update('transaksi_kasir',$update,array('kode_transaksi'=>$update['kode_transaksi']));
    }
    
    public function menu_kasir(){
        $data['aktif'] = 'kasir';
   	    $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', NULL, TRUE);
		$this->load->view('main', $data);
    }
    
    public function simpan_validasi_kasir(){
        $kode = $this->input->post('kode_transaksi');
        $update['validasi'] = 'valid';
        $this->db->update('transaksi_kasir',$update,array('kode_transaksi'=>$kode));
    }
    
    public function detail(){
        $data['aktif'] = 'trx_kasir';
        $data['konten'] = $this->load->view('kasir/kasir/detail_kasir', NULL, TRUE);
		$this->load->view('main', $data);
    }
    
    public function bayar_personal(){
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/bayar_personal', NULL, TRUE);
		$this->load->view('main', $data);
            
    }    
            
	public function get_meja(){
	    $this->load->view('kasir/kasir/get_meja');
	}
    
    public function get_member(){
        $kode = $this->input->post('kode_member');
        $member = $this->db->get_where('master_member',array('kode_member'=>$kode));
        $hasil_member = $member->row();
        echo json_encode($hasil_member);
    }
	//------------------------------------------ Proses ----------------- --------------------//
    public function tutup_meja(){
        $id_meja = $this->input->post('id_meja');
        $update['status'] = '0';
        $this->db->update('master_meja',$update,array('no_meja'=>$id_meja));
    }
    public function pesanan_temp(){
        $this->load->view('kasir/kasir/daftar_pesanan_temp');
    }
    public function buka_meja(){
         $id_meja = $this->input->post('id_meja');
        $update['status'] = '1';
        $this->db->update('master_meja',$update,array('no_meja'=>$id_meja));
    }
	public function diskon_tabel()
	{
		$input = $this->input->post('diskon');
        echo $input ;
	}
    public function get_harga(){
        $kode = $this->input->post('id_menu');
        $menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode));
        $hasil_menu = $menu->row();
        echo $hasil_menu->harga_jual;
    }    
    
	public function simpan_pesanan_temp()
	{
	   $masukan = $this->input->post();
       $kode_meja = $masukan['kode_meja'];
       $kode_pembelian = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
       $hasil = $kode_pembelian->row();
       $this->db->group_by('kode_meja');
       $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>@$hasil->kode_penjualan));
       $hasil_cek_gabung = $cek_gabung->result();
       
       if(count($hasil_cek_gabung)<=1){
                   $kode_menu = $masukan['kode_menu'];
                   $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                   $hasil_getmenu = $get_menu->row();
                   $masukan['kategori_menu'] = $hasil_getmenu->kategori_menu;
                   $masukan['nama_menu'] = $hasil_getmenu->nama_menu;
                   $masukan['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
                   $masukan['nama_satuan'] = $hasil_getmenu->satuan_stok;
                   $harga_diskon = $masukan['harga_satuan'] - $masukan['diskon_item'];
                   $masukan['harga_satuan'] = $harga_diskon;
                   $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
                   $masukan['subtotal'] = $subtotal;
                   $this->db->insert('opsi_transaksi_penjualan_temp',$masukan);

                   $update['status'] = '1';
                   $this->db->update('master_meja',$update,array('no_meja'=>$kode_meja));

                   echo "berhasil";
                   if($hasil_getmenu->status_menu=="reguler"){ 
	                   $get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$kode_menu));
	                   $hasil_komposisi = $get_komposisi->result();
	                   	foreach($hasil_komposisi as $daftar){
		                    if($daftar->jenis_bahan=="Bahan Baku"){
		                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
		                        'kode_unit'=>$daftar->kode_unit));
		                        $hasil_baku = $get_baku->row();
		                        $bahan_keluar = $daftar->jumlah_bahan * $masukan['jumlah'];
		                        $pengurangan_bahan = $hasil_baku->real_stock - $bahan_keluar;
		                        $stok['real_stock'] = $pengurangan_bahan;
		                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
		                        'kode_unit'=>$daftar->kode_unit));

		                        echo $this->db->last_query();
                                
		                        $trx_stok['jenis_transaksi']= 'penjualan';
		                        $trx_stok['kode_transaksi'] = $masukan['kode_penjualan'];
		                        $trx_stok['kategori_bahan'] = 'bahan baku';
		                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
		                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
		                        $trx_stok['stok_keluar'] = $bahan_keluar;
		                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
		                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
		                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
		                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
		                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
		                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
		                        $trx_stok['posisi_akhir'] = 'klien';    
		                        $this->db->insert('transaksi_stok',$trx_stok);

		                        echo $this->db->last_query();

		                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                        $this->db->select('*, min(id) id');
					            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					            $id_min = $cek_trx_stok->row()->id ;

					            if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
								}
								else if($stok_tersedia < $bahan_keluar){
									$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

									$data_stok_hpp['sisa_stok'] = 0 ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

									$this->db->select('*, min(id) id');
						            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu,'sisa_stok >' => 0));
									$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
									$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
								}
		                    }
		                    elseif($daftar->jenis_bahan=="Bahan Jadi"){
		                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
		                        'kode_unit'=>$daftar->kode_unit));
		                        $hasil_jadi = $get_jadi->row();
		                        $bahan_keluar = $daftar->jumlah_bahan*$masukan['jumlah'];
		                        $pengurangan_bahan = $hasil_jadi->real_stock - $bahan_keluar;
		                        $stok['real_stock'] = $pengurangan_bahan;
		                        $this->db->update('master_bahan_jadi',$stok,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
		                        'kode_unit'=>$daftar->kode_unit));

		                        echo $this->db->last_query();

		                        $trx_stok['jenis_transaksi']= 'penjualan';
		                        $trx_stok['kode_transaksi'] = $masukan['kode_penjualan'];
		                        $trx_stok['kategori_bahan'] = 'bahan jadi';
		                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
		                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
		                        $trx_stok['stok_keluar'] = $bahan_keluar;
		                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
		                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
		                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
		                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
		                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
		                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
		                        $trx_stok['posisi_akhir'] = 'klien';
		                        $this->db->insert('transaksi_stok',$trx_stok);
		                        
		                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                        $this->db->select('*, min(id) id');
					            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					            $id_min = $cek_trx_stok->row()->id ;

					            if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
								}
								else if($stok_tersedia < $bahan_keluar){
									$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

									$data_stok_hpp['sisa_stok'] = 0 ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

									$this->db->select('*, min(id) id');
						            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
									$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
									$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
								}
		                    }
		               	}
                   }else{
                        $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                        $hasil_konsi = $konsi->row();
                        $bahan_keluar = $masukan['jumlah'];
                        $konsi_keluar = $hasil_konsi->real_stok - $bahan_keluar;
                        $konsi_update['real_stok'] = $konsi_keluar;
                        $this->db->update('master_menu',$konsi_update,array('kode_menu'=>$kode_menu,'unit'=>$hasil_konsi->unit,
                        'rak'=>$hasil_konsi->rak));
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $masukan['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = $hasil_konsi->status_menu;
                        $trx_stok['kode_bahan'] = $hasil_konsi->kode_menu;
                        $trx_stok['nama_bahan'] = $daftar->nama_menu;
                        $trx_stok['stok_keluar'] = $konsi_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['kode_unit_asal'] = $hasil_konsi->unit;
                        $cek_unit = $this->db->get_where('master_unit',array('kode_unit'=>$hasil_konsi->unit));
                        $hasil_cek = $cek_unit->row();
                        $trx_stok['posisi_awal'] = $hasil_cek->nama_unit;
                        $trx_stok['nama_unit_asal'] = $hasil_cek->nama_unit;
                        $trx_stok['kode_rak_asal'] = $hasil_konsi->rak;
                        $trx_stok['nama_rak_asal'] = $hasil_konsi->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);
                        
                   }
       	}
       	elseif(count($hasil_cek_gabung>1)){
            foreach($hasil_cek_gabung as $daftar){
                $kode_menu = $masukan['kode_menu'];
                $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                $hasil_getmenu = $get_menu->row();
                $digabung['kode_penjualan'] = $daftar->kode_penjualan;
                $digabung['kode_meja'] = $daftar->kode_meja;
                $digabung['kode_menu'] = $hasil_getmenu->kode_menu;
                $digabung['jumlah'] = $masukan['jumlah'];
                $harga_diskon = $masukan['harga_satuan'] - $masukan['diskon_item'];
                $digabung['harga_satuan'] = $harga_diskon;
                $digabung['diskon_item'] = $masukan['diskon_item'];
                $digabung['kategori_menu'] = $hasil_getmenu->kategori_menu;
                $digabung['nama_menu'] = $hasil_getmenu->nama_menu;
                $digabung['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
                $digabung['nama_satuan'] = $hasil_getmenu->satuan_stok;
                $subtotal = $masukan['jumlah']*$digabung['harga_satuan'];
                $digabung['subtotal'] = $subtotal;
                $this->db->insert('opsi_transaksi_penjualan_temp',$digabung);
                if($hasil_getmenu->status_menu=="reguler"){
                	$get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$kode_menu));
                   	$hasil_komposisi = $get_komposisi->result();
                   	foreach($hasil_komposisi as $daftar){
	                    if($daftar->jenis_bahan=="Bahan Baku"){
	                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_unit'=>$daftar->kode_unit,
	                        'kode_rak'=>$daftar->kode_rak));
	                        $hasil_baku = $get_baku->row();
	                        $bahan_keluar = $daftar->jumlah_bahan*$masukan['jumlah'];
	                        $pengurangan_bahan = $hasil_baku->real_stock - $bahan_keluar;
	                        $stok['real_stock'] = $pengurangan_bahan;
	                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
	                        'kode_unit'=>$daftar->kode_unit));

	                        echo $this->db->last_query();

	                        $trx_stok['jenis_transaksi']= 'penjualan';
	                        $trx_stok['kode_transaksi'] = $daftar->kode_penjualan;
	                        $trx_stok['kategori_bahan'] = 'bahan baku';
	                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
	                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
	                        $trx_stok['stok_keluar'] = $bahan_keluar;
	                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
	                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
	                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
	                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
	                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
	                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
	                        $trx_stok['posisi_akhir'] = 'klien';
	                        $this->db->insert('transaksi_stok',$trx_stok);

	                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                        $this->db->select('*, min(id) id');
					            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					            $id_min = $cek_trx_stok->row()->id ;

					            if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
								}
								else if($stok_tersedia < $bahan_keluar){
									$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

									$data_stok_hpp['sisa_stok'] = 0 ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

									$this->db->select('*, min(id) id');
						            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu,'jenis_transaksi'=>'pembelian', 'sisa_stok >' => 0));
									$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
									$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
								}
	                        
	                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
	                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
	                        'kode_unit'=>$daftar->kode_unit));
	                        $hasil_jadi = $get_jadi->row();
	                        $bahan_keluar = $daftar->jumlah_bahan*$masukan['jumlah'];
	                        $pengurangan_bahan = $hasil_jadi->real_stock - $bahan_keluar;
	                        $stok['real_stock'] = $pengurangan_bahan;
	                        $this->db->update('master_bahan_jadi',$stok,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
	                        'kode_unit'=>$daftar->kode_unit));

	                        echo $this->db->last_query();

	                        $trx_stok['jenis_transaksi']= 'penjualan';
	                        $trx_stok['kode_transaksi'] = $daftar->kode_penjualan;
	                        $trx_stok['kategori_bahan'] = 'bahan jadi';
	                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
	                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
	                        $trx_stok['stok_keluar'] = $bahan_keluar;
	                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
	                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
	                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
	                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
	                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
	                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
	                        $trx_stok['posisi_akhir'] = 'klien';
	                        $this->db->insert('transaksi_stok',$trx_stok);

	                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                        $this->db->select('*, min(id) id');
					            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					            $id_min = $cek_trx_stok->row()->id ;

					            if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
								}
								else if($stok_tersedia < $bahan_keluar){
									$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

									$data_stok_hpp['sisa_stok'] = 0 ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

									$this->db->select('*, min(id) id');
						            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
									$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
									$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
								}
	                    }
                    }
                }
            }
            
            $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
            $hasil_konsi = $konsi->row();
                if($hasil_konsi->status_menu=="konsinyasi"){
                        $bahan_keluar = $masukan['jumlah'];
                        $konsi_keluar = $hasil_konsi->real_stok - $bahan_keluar;
                        $konsi_update['real_stok'] = $konsi_keluar;
                        $this->db->update('master_menu',$konsi_update,array('kode_menu'=>$kode_menu,'unit'=>$hasil_konsi->unit,
                        'rak'=>$hasil_konsi->rak));
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $masukan['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = $hasil_konsi->status_menu;
                        $trx_stok['kode_bahan'] = $hasil_konsi->kode_menu;
                        $trx_stok['nama_bahan'] = $daftar->nama_menu;
                        $trx_stok['stok_keluar'] = $konsi_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['kode_unit_asal'] = $hasil_konsi->unit;
                        $cek_unit = $this->db->get_where('master_unit',array('kode_unit'=>$hasil_konsi->unit));
                        $hasil_cek = $cek_unit->row();
                        $trx_stok['posisi_awal'] = $hasil_cek->nama_unit;
                        $trx_stok['nama_unit_asal'] = $hasil_cek->nama_unit;
                        $trx_stok['kode_rak_asal'] = $hasil_konsi->rak;
                        $trx_stok['nama_rak_asal'] = $hasil_konsi->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);
                }
                echo $this->db->last_query();
       	}
	}
    
    public function simpan_ubah_pesanan_temp(){
        $update = $this->input->post();
        $harga_diskon = $update['harga_satuan'] - $update['diskon_item'];
        $update['harga_satuan'] = $harga_diskon;
        $subtotal = $update['jumlah']*$update['harga_satuan'];
       $update['subtotal'] = $subtotal;
        $this->db->group_by('kode_menu');
        $cek_trx = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$update['kode_penjualan'],
        'kode_menu'=>$update['kode_menu'],'status !='=>'personal'));
       # echo $this->db->last_query();
        $cek_trx_hasil = $cek_trx->row();
        $jumlah = $this->input->post('jumlah');
        $jumlah_awal =$update['jumlah_awal'];
        echo $jumlah."||".$jumlah_awal;
        if($jumlah > $jumlah_awal){
            if($cek_trx_hasil->status_menu=="reguler"){
           $get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$update['kode_menu']));
                   $hasil_komposisi = $get_komposisi->result();
          # echo $this->db->last_query();
                   	foreach($hasil_komposisi as $daftar){
	                    if($daftar->jenis_bahan=="Bahan Baku"){
	                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
	                        'kode_unit'=>$daftar->kode_unit));
	                        #echo $this->db->last_query();
	                        $hasil_baku = $get_baku->row();
	                        $selisih = $jumlah - $jumlah_awal;
	                        $bahan_keluar = $daftar->jumlah_bahan*$selisih;
	                        echo "Bahan Keluar ".$bahan_keluar;
	                        $pengurangan_bahan = $hasil_baku->real_stock - $bahan_keluar;
	                        $stok['real_stock'] = $pengurangan_bahan;
	                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,'kode_unit'=>$daftar->kode_unit));

	                        #echo $this->db->last_query();
	                        $stok = $this->db->get_where('transaksi_stok',array('kode_transaksi'=>$update['kode_penjualan'],
	                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
	                        $hasil_stok = $stok->row();
	                        # echo $this->db->last_query();
	                        $trx_stok['jenis_transaksi']= 'penjualan';
	                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
	                        $trx_stok['kategori_bahan'] = 'bahan baku';
	                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
	                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
	                        $trx_stok['stok_keluar'] = $hasil_stok->stok_keluar + $bahan_keluar;
	                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
	                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
	                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
	                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
	                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
	                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
	                        $trx_stok['posisi_akhir'] = 'klien';    
	                        $this->db->update('transaksi_stok',$trx_stok,array('kode_transaksi'=>$update['kode_penjualan'],
	                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));

	                       # echo $this->db->last_query();
	                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			                        $this->db->select('*, min(id) id');
						            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu,'jenis_transaksi'=>'pembelian', 'sisa_stok >' => 0));
									$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						            $id_min = $cek_trx_stok->row()->id ;

						            if($stok_tersedia > $bahan_keluar){
							            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
										$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
									}
									else if($stok_tersedia < $bahan_keluar){
										$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

										$data_stok_hpp['sisa_stok'] = 0 ;
										$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

										$this->db->select('*, min(id) id');
							            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
										$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
							            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

							            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
										$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
									}

	                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
	                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
	                        'kode_unit'=>$daftar->kode_unit));
	                        $hasil_jadi = $get_jadi->row();
	                        $selisih = $jumlah - $jumlah_awal;
	                        $bahan_keluar = $daftar->jumlah_bahan*$selisih;
	                        #echo "Bahan Keluar ".$bahan_keluar;
	                        $pengurangan_bahan = $hasil_jadi->real_stock - $bahan_keluar;
	                        echo "Pengurangan Bahan".$pengurangan_bahan;
	                        $stoke['real_stock'] = $pengurangan_bahan;
	                        $this->db->update('master_bahan_jadi',$stoke,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));

	                        $stok = $this->db->get_where('transaksi_stok',array('kode_transaksi'=>$update['kode_penjualan'],
	                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
	                        $hasil_stok = $stok->row();
	                        # echo $this->db->last_query();
	                        $trx_stok['jenis_transaksi']= 'penjualan';
	                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
	                        $trx_stok['kategori_bahan'] = 'bahan jadi';
	                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
	                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
	                        $trx_stok['stok_keluar'] = $hasil_stok->stok_keluar + $bahan_keluar;
	                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
	                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
	                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
	                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
	                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
	                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
	                        $trx_stok['posisi_akhir'] = 'klien';
	                        $this->db->update('transaksi_stok',$trx_stok,array('kode_transaksi'=>$update['kode_penjualan'],
	                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
	                        #echo $this->db->last_query();

	                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			                        $this->db->select('*, min(id) id');
						            $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu,'jenis_transaksi'=>'pembelian', 'sisa_stok >' => 0));
									$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						            $id_min = $cek_trx_stok->row()->id ;

						            if($stok_tersedia > $bahan_keluar){
							            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
										$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
									}
									else if($stok_tersedia < $bahan_keluar){
										$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

										$data_stok_hpp['sisa_stok'] = 0 ;
										$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

										$this->db->select('*, min(id) id');
							            $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
										$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
							            $id_min_kedua = $stok_tersedia_kedua->row()->id ;

							            $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
										$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
									}
	                    }
                   	}
            }
            else{
                        $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                        $hasil_konsi = $konsi->row();
                        $selisih = $jumlah - $jumlah_awal;
                        $konsi_keluar = $hasil_konsi->real_stok - $selisih;
                        $konsi_update['real_stok'] = $konsi_keluar;
                        $this->db->update('master_menu',$konsi_update,array('kode_menu'=>$kode_menu,'unit'=>$hasil_konsi->unit,
                        'rak'=>$hasil_konsi->rak));
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = $hasil_konsi->status_menu;
                        $trx_stok['kode_bahan'] = $hasil_konsi->kode_menu;
                        $trx_stok['nama_bahan'] = $daftar->nama_menu;
                        $trx_stok['stok_keluar'] = $konsi_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['kode_unit_asal'] = $hasil_konsi->unit;
                        $cek_unit = $this->db->get_where('master_unit',array('kode_unit'=>$hasil_konsi->unit));
                        $hasil_cek = $cek_unit->row();
                        $trx_stok['posisi_awal'] = $hasil_cek->nama_unit;
                        $trx_stok['nama_unit_asal'] = $hasil_cek->nama_unit;
                        $trx_stok['kode_rak_asal'] = $hasil_konsi->rak;
                        $trx_stok['nama_rak_asal'] = $hasil_konsi->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);
            }
        }
        elseif($jumlah < $jumlah_awal){
	        if($cek_trx_hasil->status_menu=="reguler"){
	            $get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$update['kode_menu']));
                $hasil_komposisi = $get_komposisi->result();
                foreach($hasil_komposisi as $daftar){
                    if($daftar->jenis_bahan=="Bahan Baku"){
                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
                        'kode_unit'=>$daftar->kode_unit));
                        $hasil_baku = $get_baku->row();
                        $selisih = $jumlah_awal - $jumlah ;
                        $bahan_keluar = $daftar->jumlah_bahan * $selisih;
                        echo "Bahan Keluar ".$bahan_keluar;
                        $pengurangan_bahan = $hasil_baku->real_stock + $bahan_keluar;
                        #echo "bahan keluar".$pengurangan_bahan;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
                        'kode_unit'=>$daftar->kode_unit));

                        #echo $this->db->last_query();
                        $stok = $this->db->get_where('transaksi_stok',array('kode_transaksi'=>$update['kode_penjualan'],
                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
                        $hasil_stok = $stok->row();
                       # echo $this->db->last_query();
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = 'bahan baku';
                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
                        $trx_stok['stok_keluar'] = $hasil_stok->stok_keluar - $bahan_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';    
                        $this->db->update('transaksi_stok',$trx_stok,array('kode_transaksi'=>$update['kode_penjualan'],
                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
                       # echo $this->db->last_query();

                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			              	$this->db->select('*, min(id) id');
						    $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						    $id_min = $cek_trx_stok->row()->id ;
							
							$data_stok_hpp['sisa_stok'] = $stok_tersedia + $bahan_keluar ;
							$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
							
                    }
                    elseif($daftar->jenis_bahan=="Bahan Jadi"){
                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
                        'kode_unit'=>$daftar->kode_unit));
                        $hasil_jadi = $get_jadi->row();
                        $selisih = $jumlah_awal - $jumlah ;
                        $bahan_keluar = $daftar->jumlah_bahan*$selisih;
                        echo "Bahan Keluar ".$bahan_keluar;
                        $pengurangan_bahan = $hasil_jadi->real_stock + $bahan_keluar;
                        $stokw['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_jadi',$stokw,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                        #echo $this->db->last_query();
                        $stok = $this->db->get_where('transaksi_stok',array('kode_transaksi'=>$update['kode_penjualan'],
                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
                        $hasil_stok = $stok->row();
                        # echo $this->db->last_query();
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = 'bahan jadi';
                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
                        $trx_stok['stok_keluar'] = $hasil_stok->stok_keluar - $bahan_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->update('transaksi_stok',$trx_stok,array('kode_transaksi'=>$update['kode_penjualan'],
                        'kode_bahan'=>$daftar->kode_bahan,'kode_rak_asal'=>$daftar->kode_rak));
                        #echo $this->db->last_query();

                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			              	$this->db->select('*, min(id) id');
						    $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						    $id_min = $cek_trx_stok->row()->id ;
							
							$data_stok_hpp['sisa_stok'] = $stok_tersedia + $bahan_keluar ;
							$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
                    }
               	}
            }
            else{
                        $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                        $hasil_konsi = $konsi->row();
                        $selisih =  $jumlah_awal- $jumlah;
                        $konsi_keluar = $hasil_konsi->real_stok + $selisih;
                        $konsi_update['real_stok'] = $konsi_keluar;
                        $this->db->update('master_menu',$konsi_update,array('kode_menu'=>$kode_menu,'unit'=>$hasil_konsi->unit,
                        'rak'=>$hasil_konsi->rak));
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $update['kode_penjualan'];
                        $trx_stok['kategori_bahan'] = $hasil_konsi->status_menu;
                        $trx_stok['kode_bahan'] = $hasil_konsi->kode_menu;
                        $trx_stok['nama_bahan'] = $daftar->nama_menu;
                        $trx_stok['stok_keluar'] = $konsi_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['kode_unit_asal'] = $hasil_konsi->unit;
                        $cek_unit = $this->db->get_where('master_unit',array('kode_unit'=>$hasil_konsi->unit));
                        $hasil_cek = $cek_unit->row();
                        $trx_stok['posisi_awal'] = $hasil_cek->nama_unit;
                        $trx_stok['nama_unit_asal'] = $hasil_cek->nama_unit;
                        $trx_stok['kode_rak_asal'] = $hasil_konsi->rak;
                        $trx_stok['nama_rak_asal'] = $hasil_konsi->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);
                }
        }
        unset($update['jumlah_awal']);
        unset($update['kode_meja']);
        $this->db->update('opsi_transaksi_penjualan_temp',$update,array('kode_penjualan'=>$update['kode_penjualan'],
        'kode_menu'=>$update['kode_menu'],'status !='=>'personal'));
        #echo $this->db->last_query();
    }
	public function simpan_pembayaran()
	{
	   $data = $this->input->post();
       $kode_meja = $data['kode_meja'];
       $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
       $hasil_cek = $cek_gabung->row();
       #$this->db->group_by('kode_meja');
       $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_cek->kode_penjualan));
       $hasil_pesanan = $get_pesanan->result();
       foreach($hasil_pesanan as $daftar){
            $masukkan['kode_kasir'] = $daftar->kode_kasir;
            $masukkan['kode_penjualan'] = $data['kode_penjualan'];
            $masukkan['kode_meja'] = $daftar->kode_meja;
            $masukkan['kategori_menu'] = $daftar->kategori_menu;
            $masukkan['kode_menu'] = $daftar->kode_menu;
            $masukkan['nama_menu'] = $daftar->nama_menu;
            $masukkan['jumlah'] = $daftar->jumlah;
            $masukkan['kode_satuan'] = $daftar->kode_satuan;
            $masukkan['nama_satuan'] = $daftar->nama_satuan;
            $masukkan['harga_satuan'] = $daftar->harga_satuan;
            $masukkan['diskon_item'] = @$daftar->diskon_item;
            $masukkan['subtotal'] = $daftar->subtotal;
            $this->db->insert('opsi_transaksi_penjualan',$masukkan);
       }
       $this->db->group_by('kode_meja');
       $get_pesanan_transaksi = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_cek->kode_penjualan));
       $hasil_pesanan_transaksi = $get_pesanan_transaksi->result();
       $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
       foreach($hasil_pesanan_transaksi as $simpan){
            $transaksi['kode_meja'] = $simpan->kode_meja;
           $transaksi['kode_penjualan'] = $data['kode_penjualan'];
           $transaksi['tanggal_penjualan'] = date("Y-m-d");
           $transaksi['diskon_persen'] = $data['persen'];
           $transaksi['diskon_rupiah'] = $data['rupiah'];
           $transaksi['total_nominal'] = $data['total_pesanan'];
           $transaksi['grand_total'] = $data['grand_total'];
           $transaksi['proses_pembayaran'] = $data['jenis_transaksi'];
           $transaksi['bayar'] = $data['bayar'];
           $transaksi['kembalian'] = $data['kembalian'];
           $transaksi['id_petugas'] = $id_petugas;
           $transaksi['petugas'] = $nama_petugas;
           $transaksi['kode_member'] = $data['kode_member'];
           $transaksi['nama_member'] = $data['nama_member'];
           $this->db->insert('transaksi_penjualan',$transaksi);
        
       }
       $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_cek->kode_penjualan));
       #echo $this->db->last_query();
       $keuangan['kode_jenis_keuangan'] = '1';
       $keuangan['nama_jenis_keuangan'] = 'Pemasukan';
       $keuangan['kode_kategori_keuangan'] = '1.1';
       $keuangan['nama_kategori_keuangan'] = 'Penjualan';
       $kode_sub = '';
       if($data['jenis_transaksi']=='tunai'){
        $kode_sub = '1.1.1';
       }elseif($data['jenis_transaksi']=='debet'){
        $kode_sub ='1.1.2';
       }elseif($data['jenis_transaksi']=='kredit'){
        $kode_sub = '1.1.3';
       }else{
        $kode_sub = '2.6.1';
       }
       if($data['jenis_transaksi']=='compliment'){
            $compliment['kode_jenis_keuangan'] = '2';
            $compliment['nama_jenis_keuangan'] = 'Pengeluaran';
            $compliment['kode_kategori_keuangan'] = '2.6';
            $compliment['nama_kategori_keuangan'] = 'Penjualan';
            $compliment['kode_sub_kategori_keuangan'] = $kode_sub;
           $this->db->select('nama_sub_kategori_akun');
           $kategori = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$kode_sub));
           $hasil_kategori = $kategori->row();
           $compliment['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
           $compliment['nominal'] = $data['grand_total'];
           $compliment['tanggal_transaksi'] = date('Y-m-d');
           $compliment['id_petugas'] = $id_petugas;
           $compliment['petugas'] = $nama_petugas;
           $compliment['kode_referensi'] = $data['kode_penjualan'];
           $this->db->insert('keuangan_keluar',$compliment);
       }else{
         $keuangan['kode_sub_kategori_keuangan'] = $kode_sub;
           $this->db->select('nama_sub_kategori_akun');
           $kategori = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$kode_sub));
           $hasil_kategori = $kategori->row();
           $keuangan['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
           $keuangan['nominal'] = $data['bayar'];
           $keuangan['tanggal_transaksi'] = date('Y-m-d');
           $keuangan['id_petugas'] = $id_petugas;
           $keuangan['petugas'] = $nama_petugas;
           $this->db->insert('keuangan_masuk',$keuangan);
           
           if($data['jenis_transaksi']=='kredit'){
            $piutang['kode_transaksi'] = $data['kode_penjualan'];
            $piutang['kode_customer'] = $data['kode_member'];
            $piutang['nama_customer'] = $data['nama_member'];
            $piutang['nominal_piutang'] = $data['grand_total'] - $data['bayar'];
            $piutang['sisa'] = $data['grand_total'] - $data['bayar'];
            $piutang['tanggal_transaksi'] = date("Y-m-d");
            $piutang['petugas'] = $nama_petugas;
            $this->db->insert('transaksi_piutang',$piutang);
           }
       }
      
	}
    public function pindah_meja(){
        $asal = $this->input->post('meja_asal');
        $tujuan = $this->input->post('meja_akhir');
        $update['kode_meja'] = $tujuan;
        $this->db->update('opsi_transaksi_penjualan_temp',$update,array('kode_meja'=>$asal));
        $update_asal['status'] = 0;
        $this->db->update('master_meja',$update_asal,array('no_meja'=>$asal));
        $update_tujuan['status'] =1;
        $this->db->update('master_meja',$update_tujuan,array('no_meja'=>$tujuan));
        #echo ;
    }
    public function gabung_meja(){
        $kode_meja = $this->input->post('kode_meja');
        $gabungan = $this->input->post('gabungan');
        $cek_meja = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
        $hasil_cek = $cek_meja->result();
        if(count($hasil_cek)<1){
            echo 'belum pesan';
        }else{
            for($i=0;$i < count($gabungan);$i++){
                $gabung_meja = $gabungan[$i];
                $update['status'] = '1';
                $this->db->update('master_meja',$update,array('no_meja'=>$gabung_meja));
                foreach($hasil_cek as $daftar){
                    $pesanan['kode_penjualan'] = $daftar->kode_penjualan;
                    $pesanan['kode_meja'] = $gabung_meja;
                    $pesanan['kategori_menu'] = $daftar->kategori_menu;
                    $pesanan['kode_menu'] = $daftar->kode_menu;
                    $pesanan['nama_menu'] = $daftar->nama_menu;
                    $pesanan['jumlah'] = $daftar->jumlah;
                    $pesanan['kode_satuan'] = $daftar->kode_satuan;
                    $pesanan['nama_satuan'] = $daftar->nama_satuan;
                    $pesanan['harga_satuan'] = $daftar->harga_satuan;
                    $pesanan['diskon_item'] = $daftar->diskon_item;
                    $pesanan['subtotal'] = $daftar->subtotal;
                    $this->db->insert('opsi_transaksi_penjualan_temp',$pesanan);
                }
                
            }
        }
    }
    public function hapus_pesanan_temp(){
        $id = $this->input->post('id');
        $cek = $this->db->get_where('opsi_transaksi_penjualan_temp',array('id'=>$id));
        $hasil_cek = $cek->row();
        
        $this->db->group_by('kode_penjualan');
        $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hasil_cek->kode_menu,
        'kode_penjualan'=>$hasil_cek->kode_penjualan));
        $hasil_cek_gabung = $cek_gabung->result();
        foreach($hasil_cek_gabung as $hapus){
            $cek_menu = $this->db->get_where('master_menu',array('kode_menu'=>$hapus->kode_menu));
            $hasil_cek_menu = $cek_menu->row();
           if($hasil_cek_menu->status_menu=="reguler"){
            
           
            $get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$hapus->kode_menu));
                   $hasil_komposisi = $get_komposisi->result();
                   foreach($hasil_komposisi as $daftar){
                    if($daftar->jenis_bahan=="Bahan Baku"){
                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,
                        'kode_rak'=>$daftar->kode_rak,'kode_unit'=>$daftar->kode_unit));
                        $hasil_baku = $get_baku->row();
                        $bahan_keluar = $daftar->jumlah_bahan * $hapus->jumlah;
                        $pengurangan_bahan = $hasil_baku->real_stock + $bahan_keluar;

                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
                        'kode_unit'=>$daftar->kode_unit));

                        $this->db->delete('transaksi_stok',array('kode_transaksi'=>$hapus->kode_penjualan,'kode_bahan'=>$daftar->kode_bahan,
                        'kategori_bahan'=>'bahan baku','kode_rak_asal'=>$daftar->kode_rak));

                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			              	$this->db->select('*, min(id) id');
						    $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						    $id_min = $cek_trx_stok->row()->id ;
							
							$data_stok_hpp['sisa_stok'] = $stok_tersedia + $bahan_keluar ;
							$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,
                        'kode_rak'=>$daftar->kode_rak,'kode_unit'=>$daftar->kode_unit));
                        $hasil_jadi = $get_jadi->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$hapus->jumlah;
                        $pengurangan_bahan = $hasil_jadi->real_stock + $bahan_keluar;

                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_jadi',$stok,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak,
                        'kode_unit'=>$daftar->kode_unit));

                        $this->db->delete('transaksi_stok',array('kode_transaksi'=>$hapus->kode_penjualan,'kode_bahan'=>$daftar->kode_bahan,
                        'kategori_bahan'=>'bahan jadi','kode_rak_asal'=>$daftar->kode_rak));

                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

			              	$this->db->select('*, min(id) id');
						    $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
						    $id_min = $cek_trx_stok->row()->id ;
							
							$data_stok_hpp['sisa_stok'] = $stok_tersedia + $bahan_keluar ;
							$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
                    }
                   }
                }else{
                        $konsi = $this->db->get_where('master_menu',array('kode_menu'=>$hapus->kode_menu));
                        $hasil_konsi = $konsi->row();
                        $bahan_keluar = $hapus->jumlah;
                        $konsi_keluar = $hasil_konsi->real_stok + $bahan_keluar;
                        $konsi_update['real_stok'] = $konsi_keluar;
                        $this->db->update('master_menu',$konsi_update,array('kode_menu'=>$hapus->kode_menu,'unit'=>$hasil_konsi->unit,
                        'rak'=>$hasil_konsi->rak));
                        $this->db->delete('transaksi_stok',array('kode_transaksi'=>$hapus->kode_penjualan,'kode_bahan'=>$hapus->kode_menu,
                        'kode_rak_asal'=>$hasil_konsi->rak,'kode_unit_asal'=>$hasil_konsi->unit));
                        
                   } 
            $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hapus->kode_menu,'kode_penjualan'=>$hapus->kode_penjualan)); 
        }
        
    }
    public function get_pesanan_temp(){
        $id = $this->input->post('id');
        $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('id'=>$id));
        $hasil_pesanan = $get_pesanan->row();
        $hasil = json_encode($hasil_pesanan);
        /*$get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$hasil_pesanan->kode_menu));
                   $hasil_komposisi = $get_komposisi->result();
                   foreach($hasil_komposisi as $daftar){
                    if($daftar->jenis_bahan=="Bahan Baku"){
                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan));
                        $hasil_baku = $get_baku->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
                        $pengurangan_bahan = $hasil_baku->real_stock + $bahan_keluar;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan));
                        $hasil_jadi = $get_jadi->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
                        $pengurangan_bahan = $hasil_jadi->real_stock + $bahan_keluar;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                    }
                   } 
        $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hasil_pesanan->kode_menu,'kode_penjualan'=>$hasil_pesanan->kode_penjualan));*/
        echo $hasil;
    }
    public function get_total_temp(){
        $no_meja = $this->input->post('no_meja');
        $this->db->select_sum('subtotal','total');
        $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja));
        $hasil = $get_total->row();
        $hasil_total = array("total"=>format_rupiah($hasil->total),"total2"=>$hasil->total);
        echo json_encode($hasil_total);
    }
    public function diskon_persen(){
        $no_meja = $this->input->post('no_meja');
        $diskon = $this->input->post('diskon_persen');
        $this->db->select_sum('subtotal','total');
        $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja));
        $hasil = $get_total->row();
        echo $hasil->total;     
    }
    public function diskon_all(){
        $diskon = $this->input->post('rupiah');
        echo format_rupiah($diskon);
    }
    
    public function diskon_per_item(){
        $diskon = $this->input->post();
        $harga_diskon = $diskon['harga'] - $diskon['diskon'];
        echo $harga_diskon;
    }
    
    public function grand_total(){
        $rupiah = $this->input->post('rupiah');
        $no_meja = $this->input->post('no_meja');
        $this->db->select_sum('subtotal','total');
        $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja));
        $hasil = $get_total->row();
        $total_grand = $hasil->total-$rupiah;
        $totalnya = array('total_grand'=>format_rupiah($total_grand),'total_no'=>$total_grand);
        echo json_encode($totalnya);
    }
    public function kembalian(){
        $dibayar = $this->input->post('dibayar');
        $total = $this->input->post('total');
        $hasil = $dibayar-$total;
        $hasil_kembalian = array("kembalian1"=>format_rupiah($hasil),"kembalian2"=>$hasil);
        echo json_encode($hasil_kembalian);
    }
    public function cek_status(){
        $kode_meja = $this->input->post('kode_meja');
        $status_meja = $this->db->get_where('master_meja',array('no_meja'=>$kode_meja));
        $hasil_status = $status_meja->row();
        if($hasil_status->status==0){
            echo "aktif";
        }else{
            echo "terpakai";
        }
    }
    public function reservasi(){
        $param = $this->uri->segment(3);
        if(!empty($param)){
            $cek_pesan = $this->db->get_where('opsi_transaksi_reservasi',array('kode_reservasi'=>$param));
            $hasil_pesan = $cek_pesan->result();
            foreach($hasil_pesan as $pindah_temp){
                $masuk['kode_reservasi'] = $pindah_temp->kode_reservasi;
                $masuk['kode_meja'] = $pindah_temp->kode_meja;
                $masuk['kategori_menu'] = $pindah_temp->kategori_menu;
                $masuk['kode_menu'] = $pindah_temp->kode_menu;
                $masuk['nama_menu'] = $pindah_temp->nama_menu;
                $masuk['jumlah'] = $pindah_temp->jumlah;
                $masuk['kode_satuan'] = $pindah_temp->kode_satuan;
                $masuk['nama_satuan'] = $pindah_temp->nama_satuan;
                $masuk['harga_satuan'] = $pindah_temp->harga_satuan;
                $masuk['diskon_item'] = $pindah_temp->diskon_item;
                $masuk['subtotal'] = $pindah_temp->subtotal;
                $this->db->insert('opsi_transaksi_reservasi_temp',$masuk);
            }
        }
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/reservasi', NULL, TRUE);
		$this->load->view('main', $data);
    }
    public function dft_reservasi(){
        $data['konten'] = $this->load->view('kasir/kasir/dft_reservasi', NULL, TRUE);
		$this->load->view('main', $data);
    }
    public function detail_reservasi(){
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/detail_reservasi', NULL, TRUE);
		$this->load->view('main', $data);
    }
    
    public function batal(){
        $kode_reservasi = $this->input->post('kode_reservasi');
        $pelanggan = $this->db->get_where('transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
        $hasil_pelanggan = $pelanggan->row();
        $this->db->delete('master_pelanggan',array('kode_pelanggan'=>$hasil_pelanggan->kode_pelanggan));
        $this->db->delete('transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
        $this->db->delete('opsi_transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
        
    }
    
    
    public function pilih_meja(){
        $param = $this->input->post('reserv');
        $ruang = $this->input->post('ruang');
        $meja = $this->db->get_where('master_meja',array('kode_ruang'=>$ruang));
        $hasil_meja = $meja->result();
        foreach($hasil_meja as $daftar){
            if(!empty($param)){
            $cek_meja = $this->db->get_where('transaksi_reservasi',array('kode_reservasi'=>$param,'kode_meja'=>$daftar->no_meja));
            $hasil_cek = $cek_meja->row();
                if(@$hasil_cek->kode_meja==$daftar->no_meja){ 
                echo "<input type='checkbox' checked='true' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
                    }else{
                        echo "<input type='checkbox' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
                    }
            }else{
                echo "<input type='checkbox' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
            }
            
        }
    }
    
    public function simpan_reservasi(){
        $reservasi = $this->input->post();
        @$kode_meja = @$reservasi['kode_meja'];
        unset($reservasi['hapus_meja']);
        $pesane = $this->db->get_where('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$reservasi['kode_reservasi']));
        $hasil_pesanan = $pesane->result();
        if(empty($kode_meja)){
            echo "belum";
        }
        if(count($hasil_pesanan)<1){
            echo 'gagal';
        }else{
            for($i=0; $i<count($kode_meja);$i++){
                $meja = $kode_meja[$i];
                $reservasi['kode_meja'] = $meja;
                #$reservasi['tanggal_transaksi']
                foreach($hasil_pesanan as $daftar){
                $pesanan['kode_reservasi'] = $daftar->kode_reservasi;
                $pesanan['kode_meja'] = $meja;
                $pesanan['kategori_menu'] = $daftar->kategori_menu;
                $pesanan['kode_menu'] = $daftar->kode_menu;
                $pesanan['nama_menu'] = $daftar->nama_menu;
                $pesanan['jumlah'] = $daftar->jumlah;
                $pesanan['kode_satuan'] = $daftar->kode_satuan;
                $pesanan['nama_satuan'] = $daftar->nama_satuan;
                $pesanan['harga_satuan'] = $daftar->harga_satuan;
                $pesanan['subtotal'] = $daftar->subtotal;
                $this->db->insert('opsi_transaksi_reservasi',$pesanan);
                }
                $this->db->delete('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$reservasi['kode_reservasi']));
                $this->db->insert('transaksi_reservasi',$reservasi);
                
             }
        
        
        
            #$this->db->insert('transaksi_reservasi',$reservasi);
            $pelanggan['kode_pelanggan'] = $reservasi['kode_pelanggan'];
            $pelanggan['nama_pelanggan'] = $reservasi['nama_pelanggan'];
            $pelanggan['alamat_pelanggan'] = $reservasi['alamat_pelanggan'];
            $pelanggan['telepon_pelanggan'] = $reservasi['telepon_pelanggan'];
            $this->db->insert('master_pelanggan',$pelanggan);
        }
        #echo $this->db->last_query();   
        
    }
    
    public function simpan_edit_reservasi(){
        $reservasi = $this->input->post();
        $kode_meja = $reservasi['kode_meja'];
        $meja ='';
        unset($reservasi['hapus_meja']);
        for($i=0; $i<count($kode_meja);$i++){
            $meja = $kode_meja[$i];
            $reservasi['kode_meja'] = $meja;
            #$reservasi['tanggal_transaksi']
            $cek_meja = $this->db->get_where('transaksi_reservasi',array('kode_meja'=>$meja,'kode_reservasi'=>$reservasi['kode_reservasi']));
            $hasil_cek = $cek_meja->row();
            if($hasil_cek->kode_meja!=$meja){
                $this->db->insert('transaksi_reservasi',$reservasi);
                $this->db->group_by('kode_menu');
                $cek_pesanan = $this->db->get_where('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$reservasi['kode_reservasi']));
                $hasil_cek_pesanan = $cek_pesanan->result();
                foreach($hasil_cek_pesanan as $pesanku){
                    $pesanan['kode_reservasi'] = $reservasi['kode_reservasi'];
                    $pesanan['kode_meja'] = $reservasi['kode_meja'];
                    $pesanan['kategori_menu'] = $pesanku->kategori_menu;
                    $pesanan['kode_menu'] = $pesanku->kode_menu;
                    $pesanan['nama_menu'] = $pesanku->nama_menu;
                    $pesanan['jumlah'] = $pesanku->jumlah;
                    $pesanan['kode_satuan'] = $pesanku->kode_satuan;
                    $pesanan['nama_satuan'] = $pesanku->nama_satuan;
                    $pesanan['harga_satuan'] = $pesanku->harga_satuan;
                    $pesanan['subtotal'] = $pesanku->subtotal;
                    $this->db->insert('opsi_transaksi_reservasi',$pesanan);
                    }
            }else{
                $this->db->update('transaksi_reservasi',$reservasi,array('kode_reservasi'=>$reservasi['kode_reservasi'],'kode_meja'=>$meja));
                $cek_pesan = $this->db->get_where('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$reservasi['kode_reservasi']));
                $hasil_cek_pesan = $cek_pesan->result();
                foreach($hasil_cek_pesan as $diupdate){
                    $update['kode_reservasi'] = $diupdate->kode_reservasi;
                    $update['kode_meja'] = $diupdate->kode_meja;
                    $update['kategori_menu'] = $diupdate->kategori_menu;
                    $update['kode_menu'] = $diupdate->kode_menu;
                    $update['nama_menu'] = $diupdate->nama_menu;
                    $update['jumlah'] = $diupdate->jumlah;
                    $update['kode_satuan'] = $diupdate->kode_satuan;
                    $update['nama_satuan'] = $diupdate->nama_satuan;
                    $update['harga_satuan'] = $diupdate->harga_satuan;
                    $update['subtotal'] = $diupdate->subtotal;
                    $this->db->update('opsi_transaksi_reservasi',$update,array('kode_reservasi'=>$diupdate->kode_reservasi));
                }
                $this->db->delete('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$diupdate->kode_reservasi));
            
            }
            $hapus_meja = $this->input->post('hapus_meja');
            for($k=0;$k<count($hapus_meja);$k++){
                $hapus = $hapus_meja[$k];
                $cek_meja = $this->db->get_where('transaksi_reservasi',array('kode_reservasi'=>$reservasi['kode_reservasi'],
                'kode_meja'=>$hapus));
                $hasil_cek_meja = $cek_meja->row();
                if(count($hasil_cek_meja)>0){
                    $this->db->delete('transaksi_reservasi',array('kode_reservasi'=>$reservasi['kode_reservasi'],
                    'kode_meja'=>$hasil_cek_meja->kode_meja));
                }
                $cek_hapus_pesan = $this->db->get_where('opsi_transaksi_reservasi',array('kode_reservasi'=>$reservasi['kode_reservasi'],
                'kode_meja'=>$hapus));
                $hasil_cek_hapus = $cek_hapus_pesan->result();
                if(count($hasil_cek_hapus)>0){
                    foreach($hasil_cek_hapus as $dihapus){
                        $this->db->delete('opsi_transaksi_reservasi',array('kode_reservasi'=>$reservasi['kode_reservasi'],
                        'kode_meja'=>$dihapus->kode_meja));
                    }
                }
            }
            echo $meja;
        }
        #$this->db->insert('transaksi_reservasi',$reservasi);
        $pelanggan['nama_pelanggan'] = $reservasi['nama_pelanggan'];
        $pelanggan['alamat_pelanggan'] = $reservasi['alamat_pelanggan'];
        $pelanggan['telepon_pelanggan'] = $reservasi['telepon_pelanggan'];
        $this->db->update('master_pelanggan',$pelanggan,array('kode_pelanggan'=>$reservasi['kode_pelanggan']));
    }
    
    public function batal_edit_reservasi(){
        $kode = $this->input->post('kode_reservasi');
        $this->db->delete('opsi_transaksi_reservasi_temp',array('kode_reservasi'=>$kode));
    }
    
    public function status_selesai_reservasi(){
        $kode = $this->input->post('kode_reservasi');
        $status['status'] = 'selesai';
        $this->db->update('transaksi_reservasi',$status,array('kode_reservasi'=>$kode));
    }
    
    public function pesanan_reservasi_temp(){
        $this->load->view('kasir/kasir/daftar_pesanan_reservasi_temp');
    }
    
    public function simpan_pesanan_reservasi_temp(){
        $reservasi = $this->input->post();
        $subtotal = $reservasi['jumlah']*$reservasi['harga_satuan'];
        $menu = $this->db->get_where('master_menu',array('kode_menu'=>$reservasi['kode_menu']));
        $hasil_menu = $menu->row();
        $reservasi['kategori_menu'] = $hasil_menu->kategori_menu;
        $reservasi['nama_menu'] = $hasil_menu->nama_menu;
        $reservasi['kode_satuan'] = $hasil_menu->kode_satuan_stok;
        $reservasi['nama_satuan'] = $hasil_menu->satuan_stok;
        $reservasi['subtotal'] = $subtotal;
        $this->db->insert('opsi_transaksi_reservasi_temp',$reservasi);
    }
    
    public function get_pesanan_reservasi_temp(){
        $id = $this->input->post('id');
        $get_pesanan = $this->db->get_where('opsi_transaksi_reservasi_temp',array('id'=>$id));
        $hasil_pesanan = $get_pesanan->row();
        $hasil = json_encode($hasil_pesanan);
        /*$get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$hasil_pesanan->kode_menu));
                   $hasil_komposisi = $get_komposisi->result();
                   foreach($hasil_komposisi as $daftar){
                    if($daftar->jenis_bahan=="Bahan Baku"){
                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan));
                        $hasil_baku = $get_baku->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
                        $pengurangan_bahan = $hasil_baku->real_stock + $bahan_keluar;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan));
                        $hasil_jadi = $get_jadi->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
                        $pengurangan_bahan = $hasil_jadi->real_stock + $bahan_keluar;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                    }
                   } */
        $this->db->delete('opsi_transaksi_reservasi_temp',array('kode_menu'=>$hasil_pesanan->kode_menu,'kode_reservasi'=>$hasil_pesanan->kode_reservasi));
        echo $hasil;
    }
    
    public function hapus_pesanan_reservasi_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_reservasi_temp',array('id'=>$id));
    }
    
    public function buka_reservasi(){
        $kode_reservasi = $this->input->post('kode_reservasi');
        $trx['status'] = 'selesai';
        $this->db->update('transaksi_reservasi',$trx,array('kode_reservasi'=>$kode_reservasi));
        $tgl = date("Y-m-d");
        $this->db->select_max('kode_transaksi');
        $kasir = $this->db->get_where('transaksi_kasir',array('tanggal'=>$tgl,'status'=>"open"));
        $hasil_cek_kasir = $kasir->row();
        $this->db->group_by('kode_menu');
        $pesanan = $this->db->get_where('opsi_transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
        $hasil_pesanan = $pesanan->result();
            
            $no_belakang = 0;
            $this->db->select_max('kode_penjualan');
            $kode = $this->db->get_where('transaksi_penjualan',array('tanggal_penjualan'=>$tgl));
            $hasil_kode = $kode->row();;
            $this->db->select('kode_penjualan');
            $kode_penjualan = $this->db->get('master_setting');
            $hasil_kode_penjualan = $kode_penjualan->row();
            if(count($hasil_kode)==0){
            $no_belakang = 1;
            }
            else{
            $pecah_kode = explode("_",$hasil_kode->kode_penjualan);
            $no_belakang = @$pecah_kode[2]+1;
            }
            $kode_penjualan = @$hasil_kode_penjualan->kode_penjualan."_".date("dmyHis")."_".$no_belakang;
        foreach($hasil_pesanan as $dipesan){
            $penjualan['kode_kasir'] = $hasil_cek_kasir->kode_transaksi;
            $penjualan['kode_penjualan'] = $kode_penjualan;
            $penjualan['kode_meja'] = $dipesan->kode_meja;
            $penjualan['kategori_menu'] = $dipesan->kategori_menu;
            $penjualan['kode_menu'] = $dipesan->kode_menu;
            $penjualan['nama_menu'] = $dipesan->nama_menu;
            $penjualan['jumlah'] = $dipesan->jumlah;
            $penjualan['kode_satuan'] = $dipesan->kode_satuan;
            $penjualan['nama_satuan'] = $dipesan->nama_satuan;
            $penjualan['harga_satuan'] = $dipesan->harga_satuan;
            $penjualan['subtotal'] = $dipesan->subtotal;
            $this->db->insert('opsi_transaksi_penjualan_temp',$penjualan);
            $this->db->group_by('no_meja');
            $meja = $this->db->get_where('master_meja',array('no_meja'=>$dipesan->kode_meja));
            $hasil_meja = $meja->row();
            $update['status'] = '1';
            $no_meja = $hasil_meja->no_meja;
            $this->db->update('master_meja',$update,array('no_meja'=>$no_meja));
            
            $get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$dipesan->kode_menu));
            $hasil_komposisi = $get_komposisi->result();
                   foreach($hasil_komposisi as $daftar){
                    if($daftar->jenis_bahan=="Bahan Baku"){
                        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_unit'=>$daftar->kode_unit));
                        $hasil_baku = $get_baku->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$dipesan->jumlah;
                        #echo "bahan keluar ".$bahan_keluar;
                        $pengurangan_bahan = $hasil_baku->real_stock - $bahan_keluar;
                       # echo "pengurangan Bahan ".$pengurangan_bahan;
                        $stoke['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_baku',$stoke,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                        #echo $this->db->last_query();
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $kode_penjualan;
                        $trx_stok['kategori_bahan'] = 'bahan baku';
                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
                        $trx_stok['stok_keluar'] = $bahan_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);

                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                    $this->db->select('*, min(id) id');
					        $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					        $id_min = $cek_trx_stok->row()->id ;

					        if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
							}
							else if($stok_tersedia < $bahan_keluar){
								$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

								$data_stok_hpp['sisa_stok'] = 0 ;
								$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

								$this->db->select('*, min(id) id');
						        $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						        $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						        $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
								$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
							}
                        
                    }elseif($daftar->jenis_bahan=="Bahan Jadi"){
                        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_unit'=>$daftar->kode_unit));
                        $hasil_jadi = $get_jadi->row();
                        $bahan_keluar = $daftar->jumlah_bahan*$dipesan->jumlah;
                        $pengurangan_bahan = $hasil_jadi->real_stock - $bahan_keluar;
                        $stok['real_stock'] = $pengurangan_bahan;
                        $this->db->update('master_bahan_jadi',$stok,array('kode_bahan_jadi'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
                        #echo $this->db->last_query();
                        $trx_stok['jenis_transaksi']= 'penjualan';
                        $trx_stok['kode_transaksi'] = $kode_penjualan;
                        $trx_stok['kategori_bahan'] = 'bahan jadi';
                        $trx_stok['kode_bahan'] = $daftar->kode_bahan;
                        $trx_stok['nama_bahan'] = $daftar->nama_bahan;
                        $trx_stok['stok_keluar'] = $bahan_keluar;
                        $trx_stok['tanggal_transaksi'] = date("Y-m-d");
                        $trx_stok['posisi_awal'] = $daftar->nama_unit;
                        $trx_stok['kode_unit_asal'] = $daftar->kode_unit;
                        $trx_stok['nama_unit_asal'] = $daftar->nama_unit;
                        $trx_stok['kode_rak_asal'] = $daftar->kode_rak;
                        $trx_stok['nama_rak_asal'] = $daftar->nama_rak;
                        $trx_stok['posisi_akhir'] = 'klien';
                        $this->db->insert('transaksi_stok',$trx_stok);
                        
                        $kode_bahan_opsi_menu = $daftar->kode_bahan ;

		                    $this->db->select('*, min(id) id');
					        $cek_trx_stok = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
							$stok_tersedia = $cek_trx_stok->row()->sisa_stok ;
					        $id_min = $cek_trx_stok->row()->id ;

					        if($stok_tersedia > $bahan_keluar){
						            $data_stok_hpp['sisa_stok'] = $stok_tersedia - $bahan_keluar ;
									$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));
							}
							else if($stok_tersedia < $bahan_keluar){
								$sisa_opsi_bahan_menu = $bahan_keluar - $stok_tersedia ;

								$data_stok_hpp['sisa_stok'] = 0 ;
								$this->db->update('transaksi_stok',$data_stok_hpp,array('id'=>$id_min));

								$this->db->select('*, min(id) id');
						        $cek_trx_stok_kedua = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan_opsi_menu, 'sisa_stok >' => 0));
								$stok_tersedia_kedua = $cek_trx_stok_kedua->row()->sisa_stok ;
						        $id_min_kedua = $stok_tersedia_kedua->row()->id ;

						        $data_stok_hpp_kedua['sisa_stok'] = $sisa_opsi_bahan_menu ;
								$this->db->update('transaksi_stok', $data_stok_hpp_kedua, array('id'=>$id_min_kedua));
							}
                    }
                   } 
            $mejaku = $dipesan->kode_meja;
        }
        
        $this->db->delete('opsi_transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
        echo $mejaku;
    }
    
    public function cetak_bill()
    {
		$kode_meja = $this->input->post('kode_meja');
        $setting = $this->db->get('master_setting');
        $hasil_setting = $setting->row();
        $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
        $hasil_pesanan = $pesanan->row();
		$cnt = 40;
		$tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
		$file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
		$handle = fopen($file, 'w');
		//ata  = "1234567890123456789012345678901234567890\n";
		$Data  = align_center($cnt,$hasil_setting->nama_resto)."\n";
		$Data .= align_center($cnt,$hasil_setting->alamat_resto)."\n";
		$Data .= align_center($cnt,$hasil_setting->telp_resto)."\n";
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_center($cnt,"ORDER LIST")."\n";
		$Data .= "\n";

		/*if (isset($idmember) && $idmember!='') {
			$Data .= "Kode MEMBER : ".$idmember."\n";
			$Data .= "Nama MEMBER : ".$member->name."\n";
			$Data .= "Alamat : ".$member->address."\n\n\n";
		}*/

		$Data .= "TANGGAL  : ".tanggalIndo(date("Y-m-d"))."\n";
		$Data .= "MEJA     : ".$hasil_pesanan->kode_meja."\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
        $hasil_menu = $menu->result();
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_left(14,"Menu")."".align_left(3,"Jumlah")."  ".align_left(8,"Harga")." ".align_right(10,"Subtotal")."\n";
		$Data .= cetak_garis($cnt)."\n";
		  foreach ($hasil_menu as $daftar) {
			$Data .= align_left(16,$daftar->nama_menu)."  X ".align_left(3,$daftar->jumlah)."  ".align_left(8,$daftar->harga_satuan).align_right(10,$daftar->subtotal)."\n";
			}
		$Data .= cetak_garis($cnt)."\n";
        $this->db->select_sum('subtotal');
        $total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
        $hasil_total = $total->row();
        $Data .= align_center(10,"TAGIHAN").align_right(20,format_rupiah($hasil_total->subtotal))."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
       # echo $Data;
		#print_r($Data);//exit();
		#$handle = printer_open('\\\192.168.1.100\wien'); 
        $handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_write($handle, $Data); 
		printer_close($handle);
	}
    
    public function cetak_pesanan()
    {
		$kode_meja = $this->input->post('kode_meja');
        $setting = $this->db->get('master_setting');
        $hasil_setting = $setting->row();
        $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
        $hasil_pesanan = $pesanan->row();
		$cnt = 40;
		$tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
		$file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
		$handle = fopen($file, 'w');
		//ata  = "1234567890123456789012345678901234567890\n";
		$Data  = align_center($cnt,$hasil_setting->nama_resto)."\n";
		$Data .= align_center($cnt,$hasil_setting->alamat_resto)."\n";
		$Data .= align_center($cnt,$hasil_setting->telp_resto)."\n";
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_center($cnt,"ORDER LIST")."\n";
		$Data .= "\n";

		/*if (isset($idmember) && $idmember!='') {
			$Data .= "Kode MEMBER : ".$idmember."\n";
			$Data .= "Nama MEMBER : ".$member->name."\n";
			$Data .= "Alamat : ".$member->address."\n\n\n";
		}*/

		$Data .= "TANGGAL  : ".tanggalIndo(date("Y-m-d"))."\n";
		$Data .= "MEJA     : ".$hasil_pesanan->kode_meja."\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
        $hasil_menu = $menu->result();
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_left(14,"Menu")."".align_left(3,"Jumlah")."  ".align_left(8,"Harga")." ".align_right(10,"Subtotal")."\n";
		$Data .= cetak_garis($cnt)."\n";
		  foreach ($hasil_menu as $daftar) {
			$Data .= align_left(16,$daftar->nama_menu)."  X ".align_left(3,$daftar->jumlah)."  ".align_left(8,$daftar->harga_satuan).align_right(10,$daftar->subtotal)."\n";
			}
		$Data .= cetak_garis($cnt)."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
        $Data .= " "."\n";
       # echo $Data;
		#print_r($Data);//exit();
		#$handle = printer_open('\\\192.168.1.100\wien'); 
        $handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_write($handle, $Data); 
		printer_close($handle);
	}
    //------------------------------------------ PERSONAL ----------------- --------------------//
    //----------------------------------------------------------------- --------------------//
    public function get_harga_personal(){
        $kode_menu = $this->input->post('id_menu');
        $kode_meja = $this->input->post('kode_meja');
        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_menu'=>$kode_menu,'kode_meja'=>$kode_meja));
        $hasil_menu = $menu->row();
        echo json_encode($hasil_menu);
    }
    
    public function get_total_personal_temp(){
        $no_meja = $this->input->post('no_meja');
        $this->db->select_sum('subtotal','total');
        $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja,'status'=>'personal'));
        $hasil = $get_total->row();
        $hasil_total = array("total"=>format_rupiah($hasil->total),"total2"=>$hasil->total);
        echo json_encode($hasil_total);
    }
    
    public function grand_total_personal(){
        $rupiah = $this->input->post('rupiah');
        $no_meja = $this->input->post('no_meja');
        $this->db->select_sum('subtotal','total');
        $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja,'status'=>'personal'));
        $hasil = $get_total->row();
        $total_grand = $hasil->total-$rupiah;
        $totalnya = array('total_grand'=>format_rupiah($total_grand),'total_no'=>$total_grand);
        echo json_encode($totalnya);
    }
    
    public function pesanan_personal_temp(){
        $this->load->view('kasir/kasir/daftar_pesanan_personal_temp');
    }
    
    public function simpan_pesanan_personal_temp()
	{
	   $masukan = $this->input->post();
       $kode_meja = $masukan['kode_meja'];
       $kode_pembelian = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
       $hasil = $kode_pembelian->row();
       $this->db->group_by('kode_meja');
       $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil->kode_penjualan));
       $hasil_cek_gabung = $cek_gabung->result();
       
       if(count($hasil_cek_gabung)<=1){
                   $kode_menu = $masukan['kode_menu'];
                   $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                   $hasil_getmenu = $get_menu->row();
                   $masukan['kategori_menu'] = $hasil_getmenu->kategori_menu;
                   $masukan['nama_menu'] = $hasil_getmenu->nama_menu;
                   $masukan['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
                   $masukan['nama_satuan'] = $hasil_getmenu->satuan_stok;
                   $subtotal = $masukan['jumlah']*$masukan['harga_satuan'];
                   $masukan['subtotal'] = $subtotal;
                   $masukan['status'] = 'personal';
                   $this->db->insert('opsi_transaksi_penjualan_temp',$masukan);
                   $personal = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja,'kode_menu'=>$kode_menu));
                   $hasil_personal = $personal->row();
                   #if($hasil_personal->jumlah > $masukan['jumlah']){
                        $qty['jumlah'] = $hasil_personal->jumlah - $masukan['jumlah'];
                        $qty['subtotal'] = $hasil_personal->subtotal - ($hasil_personal->harga_satuan*$masukan['jumlah']);
                        $this->db->update('opsi_transaksi_penjualan_temp',$qty,array('id'=>$hasil_personal->id));
                  # }elseif($hasil_personal->jumlah==$masukan['jumlah']){
                        #$this->db->delete('opsi_transaksi_penjualan_temp',array('id'=>$hasil_personal->id));
                  # }
                   echo "berhasil";
       }elseif(count($hasil_cek_gabung>1)){
            foreach($hasil_cek_gabung as $daftar){
                $kode_menu = $masukan['kode_menu'];
                $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
                $hasil_getmenu = $get_menu->row();
                $digabung['kode_penjualan'] = $daftar->kode_penjualan;
                $digabung['kode_meja'] = $daftar->kode_meja;
                $digabung['kode_menu'] = $hasil_getmenu->kode_menu;
                $digabung['jumlah'] = $masukan['jumlah'];
                $digabung['harga_satuan'] = $masukan['harga_satuan'];
                $digabung['diskon_item'] = $masukan['diskon_item'];
                $digabung['kategori_menu'] = $hasil_getmenu->kategori_menu;
                $digabung['nama_menu'] = $hasil_getmenu->nama_menu;
                $digabung['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
                $digabung['nama_satuan'] = $hasil_getmenu->satuan_stok;
                $subtotal = $masukan['jumlah']*$masukan['harga_satuan'];
                $digabung['subtotal'] = $subtotal;
                $this->db->insert('opsi_transaksi_penjualan_temp',$digabung);
                $personal = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja,'kode_menu'=>$kode_menu));
                   $hasil_personal = $personal->row();
                   if($hasil_personal->jumlah > $masukan['jumlah']){
                        $qty['jumlah'] = $hasil_personal->jumlah - $masukan['jumlah'];
                        $this->db->update('opsi_transaksi_penjualan_temp',$qty,array('id'=>$hasil_personal->id));
                   }elseif($hasil_personal->jumlah==$masukan['jumlah']){
                        $this->db->delete('opsi_transaksi_penjualan_temp',array('id'=>$hasil_personal->id));
                   } 

            }
          
                #echo $this->db->last_query();
           
       }
       
	}
    
    public function get_pesanan_personal_temp(){
        $id = $this->input->post('id');
        $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('id'=>$id));
        $hasil_pesanan = $get_pesanan->row();
        $hasil = json_encode($hasil_pesanan);
        
        $menu =$this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_pesanan->kode_penjualan,
                            'kode_meja'=>$hasil_pesanan->kode_meja,'kode_menu'=>$hasil_pesanan->kode_menu,'status !='=>'personal'));
        $hasil_menu = $menu->row();
        $jumlah['jumlah'] = $hasil_pesanan->jumlah + $hasil_menu->jumlah;
        $jumlah['subtotal'] = $hasil_pesanan->subtotal + $hasil_menu->subtotal;
        $this->db->update('opsi_transaksi_penjualan_temp',$jumlah,array('kode_penjualan'=>$hasil_pesanan->kode_penjualan,
                            'kode_meja'=>$hasil_pesanan->kode_meja,'kode_menu'=>$hasil_pesanan->kode_menu,'status !='=>'personal'));
        $this->db->delete('opsi_transaksi_penjualan_temp',array('id'=>$id));
        echo $hasil;
    }
    
    public function hapus_pesanan_personal_temp(){
        $id = $this->input->post('id');
        $cek = $this->db->get_where('opsi_transaksi_penjualan_temp',array('id'=>$id));
        $hasil_cek = $cek->row();
        
        $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hasil_cek->kode_menu,
        'kode_penjualan'=>$hasil_cek->kode_penjualan,'status'=>'personal'));
        $hasil_cek_gabung = $cek_gabung->result();
        foreach($hasil_cek_gabung as $hapus){
            $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hapus->kode_menu,'kode_penjualan'=>$hapus->kode_penjualan,'status'=>'personal'));
            $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('status !='=>'personal','kode_menu'=>$hapus->kode_menu,'kode_penjualan'=>$hapus->kode_penjualan));
            $hasil_menu = $menu->row();
            $update['jumlah'] = $hapus->jumlah+$hasil_menu->jumlah;
            $update['subtotal'] = ($hapus->jumlah+$hasil_menu->jumlah)*$hasil_menu->harga_satuan;
            
            $this->db->update('opsi_transaksi_penjualan_temp',$update,array('status !='=>'personal','kode_penjualan'=>$hasil_menu->kode_penjualan,'kode_menu'=>$hasil_menu->kode_menu));
            
        }
        
    }
    
    public function simpan_pembayaran_personal(){
	   $data = $this->input->post();
       $kode_meja = $data['kode_meja'];
       $cek_personal = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja,'status'=>'personal'));
       $hasil_personal = $cek_personal->result_array();
       #$this->db->group_by('kode_meja');
       foreach($hasil_personal as $daftar){
            $masukkan['kode_penjualan'] = $data['kode_penjualan'];
            $masukkan['kode_meja'] = $daftar['kode_meja'];
            $masukkan['kategori_menu'] = $daftar['kategori_menu'];
            $masukkan['kode_menu'] = $daftar['kode_menu'];
            $masukkan['nama_menu'] = $daftar['nama_menu'];
            $masukkan['jumlah'] = $daftar['jumlah'];
            $masukkan['kode_satuan'] = $daftar['kode_satuan'];
            $masukkan['nama_satuan'] = $daftar['nama_satuan'];
            $masukkan['harga_satuan'] = $daftar['harga_satuan'];
            $masukkan['diskon_item'] = @$daftar['diskon_item'];
            $masukkan['subtotal'] = $daftar['subtotal'];
            $this->db->insert('opsi_transaksi_penjualan',$masukkan);
            $cek_menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$daftar['kode_meja'],
                        'kode_menu'=>$daftar['kode_menu'],'kode_penjualan'=>$daftar['kode_penjualan'],
                        'jumlah'=>'0','status !='=>'personal'));
            $hasil_menu = $cek_menu->result();
            foreach($hasil_menu as $dihapus){
               
                    $this->db->delete('opsi_transaksi_penjualan_temp',array('id'=>$dihapus->id));
                
            }
       }
       $this->db->group_by('kode_meja');
       $get_pesanan_transaksi = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_personal[0]['kode_penjualan'],'status'=>'personal'));
       $hasil_pesanan_transaksi = $get_pesanan_transaksi->result();
       echo $this->db->last_query();
       $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
       foreach($hasil_pesanan_transaksi as $simpan){
            $transaksi['kode_meja'] = $simpan->kode_meja;
           $transaksi['kode_penjualan'] = $data['kode_penjualan'];
           $transaksi['tanggal_penjualan'] = date("Y-m-d");
           $transaksi['diskon_persen'] = $data['persen'];
           $transaksi['diskon_rupiah'] = $data['rupiah'];
           $transaksi['total_nominal'] = $data['total_pesanan'];
           $transaksi['grand_total'] = $data['grand_total'];
           $transaksi['proses_pembayaran'] = $data['jenis_transaksi'];
           $transaksi['bayar'] = $data['bayar'];
           $transaksi['kembalian'] = $data['kembalian'];
           $transaksi['id_petugas'] = $id_petugas;
           $transaksi['petugas'] = $nama_petugas;
           $this->db->insert('transaksi_penjualan',$transaksi);
        
       }
       $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja,'status'=>'personal'));
       #echo $this->db->last_query();
       $kode_sub = '';
       if($data['jenis_transaksi']=='tunai'){
        $kode_sub = '1.1.1';
       }elseif($data['jenis_transaksi']=='debet'){
        $kode_sub ='1.1.2';
       }elseif($data['jenis_transaksi']=='kredit'){
        $kode_sub = '1.1.3';
       }
       $keuangan['kode_jenis_keuangan'] = '1';
       $keuangan['kode_kategori_keuangan'] = '1.1';
       $keuangan['kode_sub_kategori_keuangan'] = $kode_sub;
       $kategori = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>$kode_sub));
       $hasil_kategori = $kategori->row();
       $keuangan['nama_kategori_keuangan'] = $hasil_kategori->nama_kategori_akun;
       $keuangan['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
        $keuangan['nama_jenis_keuangan'] = $hasil_kategori->nama_jenis_akun;
       $keuangan['nominal'] = $data['grand_total'];
       $keuangan['tanggal_transaksi'] = date('Y-m-d');
        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        $keuangan['id_petugas'] = $id_petugas;
        $keuangan['petugas'] =$nama_petugas;
       $this->db->insert('keuangan_masuk',$keuangan);
	}
        
}