<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class retur extends MY_Controller {

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
    public function cari_reture()
    {
        $this->load->view('pembelian/retur/cari_reture');       
    }
	public function daftar_retur_pembelian()
	{
        $data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/retur/daftar_retur_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tambah()
	{
        $data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/retur/tambah_retur_pembelian', NULL, TRUE);
		$data['halaman'] = $this->load->view('menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function tabel_item_pembelian($kode)
	{
		$data['kode'] = $kode;
		$this->load->view ('pembelian/retur/tabel_item_pembelian',$data);		
	}

	public function tabel_item_retur($kode)
	{
		$data['kode'] = $kode;
		$this->load->view ('pembelian/retur/tabel_item_retur',$data);		
	}

    public function detail($kode)
    {
        $data['kode'] = $kode;
        $data['aktif']='pembelian';
        $data['konten'] = $this->load->view('pembelian/retur/detail_item_retur', $data,TRUE);
        $data['halaman'] = $this->load->view('menu', $data, TRUE);
        $this->load->view('main', $data);       
    }

    public function proses($kode)
    {
        $data['kode'] = $kode;
        $data['aktif']='pembelian';
        $data['konten'] = $this->load->view('pembelian/retur/proses_terima_retur', $data, TRUE);
        $data['halaman'] = $this->load->view('menu', $data, TRUE);
        $this->load->view('main', $data);       
    }

    public function tabel_item_terima_retur($kode)
    {
        $data['kode'] = $kode;
        $this->load->view ('pembelian/retur/tabel_item_terima_retur', $data);      
    }
	
	//------------------------------------------ Proses ----------------- --------------------//

	public function cari_nota()
	{
		$nomor_nota = $this->input->post('nota');
		$kode_supplier = $this->input->post('kode_supplier');
		$tanggal_pembelian = $this->input->post('tanggal_pembelian');
        $kode_retur = $this->input->post('kode_retur');

				 $this->db->select('*') ;
		$query = $this->db->get_where('transaksi_pembelian',array('nomor_nota'=>$nomor_nota, 'kode_supplier'=>$kode_supplier,'tanggal_pembelian'=>$tanggal_pembelian ));
        $data = $query->row();
        $num_row = $query->num_rows();
        if($num_row < 1){
        	$hasil = 0;
        	$nota = '';
        	$kode = '' ;
        }
        else{
        	$hasil = 1;
        	$nota = $nomor_nota ;
        	$kode = $data->kode_pembelian;

            $pembelian = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode));
            $list_pembelian = $pembelian->result();
                foreach($list_pembelian as $daftar){ 
                    $masukan['kode_retur'] = $kode_retur;
                    $masukan['kategori_bahan'] = $daftar->kategori_bahan;
                    $masukan['kode_bahan'] = $daftar->kode_bahan;
                    $masukan['nama_bahan'] = $daftar->nama_bahan; 
                    $masukan['jumlah'] = $daftar->jumlah; 
                    $masukan['kode_satuan'] = $daftar->kode_satuan;
                    $masukan['nama_satuan'] = $daftar->nama_satuan;
                    $masukan['harga_satuan'] = $daftar->harga_satuan;
                    $masukan['diskon_item'] = $daftar->diskon_item;
                    $masukan['kode_supplier'] = $daftar->kode_supplier; 
                    $masukan['nama_supplier'] = $daftar->nama_supplier; 
                    $masukan['subtotal'] = $daftar->subtotal; 

                    $input = $this->db->insert('opsi_transaksi_retur_temp',$masukan);
                }
        }
        echo $hasil.'|'.$nota.'|'.$kode.'|'.$kode_supplier ;
	}

    public function cek_status_retur()
    {
        $param = $this->input->post();
        $kode_retur = $param['kode_retur'];

        $this->db->select('*') ;
        $query = $this->db->get_where('transaksi_retur',array('kode_retur'=>$kode_retur));
        $data = $query->row();
        $status = $data->status_retur;

        echo $status;
    }

	public function get_bahan()
    {
        $param = $this->input->post();
        $jenis = $param['jenis_bahan'];

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get('master_bahan_baku');
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'bahan jadi') {
            $opt = '';
            $query = $this->db->get('master_bahan_jadi');
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
        }elseif($jenis_bahan=='bahan jadi'){
            $nama_bahan = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi' => $kode_bahan));
            $hasil_bahan = $nama_bahan->row();
        }
        
        echo json_encode($hasil_bahan);
    }

    public function simpan_item_retur_temp()
	{
	   $masukan = $this->input->post();
       $this->load->library('form_validation');
            $this->form_validation->set_rules('kategori_bahan', 'Jenis Bahan', 'required');
            $this->form_validation->set_rules('kode_bahan', 'Nama Bahan', 'required');
            $this->form_validation->set_rules('jumlah', 'Qty ', 'required');
            $this->form_validation->set_rules('harga_satuan', 'Harga ', 'required');
            $this->form_validation->set_rules('kode_supplier', 'Supplier ', 'required');

        if ($this->form_validation->run() == FALSE) {
                echo "0|".warn_msg(validation_errors());
        } else {
           $nama_suplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$masukan['kode_supplier']));
           $hasil_nama_supplier = $nama_suplier->row();
           
           $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
           $masukan['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
           $masukan['subtotal'] = $subtotal;

           $input = $this->db->insert('opsi_transaksi_retur_temp',$masukan);
           echo "1|";
       	}
	}

    public function ubah_item_retur_temp()
    {
       $masukan = $this->input->post();
        
           $nama_suplier = $this->db->get_where('master_supplier',array('kode_supplier'=>$masukan['kode_supplier']));
           $hasil_nama_supplier = $nama_suplier->row();
           
           $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
           $masukan['nama_supplier'] = $hasil_nama_supplier->nama_supplier;
           $masukan['subtotal'] = $subtotal;

                            $this->db->select('*') ;
           $cek_transaksi = $this->db->get_where('transaksi_pembelian',array('nomor_nota'=>$masukan['nomor_nota']));
           $hasil_cek_transaksi = $cek_transaksi->row();
           $kode_pembelian = $hasil_cek_transaksi->kode_pembelian;

                                 $this->db->select('*') ;
           $cek_opsi_transaksi = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));
           $hasil_cek_opsi_transaksi = $cek_opsi_transaksi->row();
           $jumlah_item_opsi = $hasil_cek_opsi_transaksi->jumlah;

           $qty = $masukan['jumlah'];
           $qty_beli = $jumlah_item_opsi;
           if($qty > $qty_beli){
                echo '0|Jumlah terlalu besar';  
           }
           else{
                unset($masukan['nomor_nota']);
                $input = $this->db->update('opsi_transaksi_retur_temp',$masukan, array('id'=> $masukan['id']));
                echo "1|";
           }
    }

    public function ubah_item_terima_retur()
    {
       $masukan = $this->input->post();
        $kode_retur = $masukan['kode_retur'];

                                 $this->db->select('*') ;
           $cek_opsi_transaksi = $this->db->get_where('opsi_transaksi_retur',array('id'=> $masukan['id']));
           $hasil_cek_opsi_transaksi = $cek_opsi_transaksi->row();
           $jumlah_item_opsi = $hasil_cek_opsi_transaksi->jumlah;
           $harga_satuan = $hasil_cek_opsi_transaksi->harga_satuan;
           $qty = $masukan['jumlah'];
           
           $subtotal = $qty  * $harga_satuan;
           $masukan['subtotal'] = $subtotal;
           if($qty > $jumlah_item_opsi){
                echo '0|<div class="alert alert-danger">Jumlah terlalu besar.</div>';  
           }
           else{
                $input = $this->db->update('opsi_transaksi_retur',$masukan, array('id'=> $masukan['id']));
                echo "1|";
           }
    }

	public function hapus_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_retur_temp',array('id'=>$id));
    }

    public function get_temp_retur(){
        $id = $this->input->post('id');
        $retur = $this->db->get_where('opsi_transaksi_retur_temp',array('id'=>$id));
        $hasil_retur = $retur->row();
        echo json_encode($hasil_retur);
    }

    public function get_item_terima_retur(){
        $id = $this->input->post('id');
        $retur = $this->db->get_where('opsi_transaksi_retur',array('id'=>$id));
        $hasil_retur = $retur->row();
        echo json_encode($hasil_retur);
    }

    public function simpan_retur()
    {
        $input = $this->input->post();
        $kode_retur = $input['kode_retur'];

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

                                $this->db->select('*') ;
        $query_retur_temp = $this->db->get_where('opsi_transaksi_retur_temp',array('kode_retur'=>$kode_retur));

        $total = 0;
        foreach ($query_retur_temp->result() as $item){
            $data_opsi['kode_retur'] = $item->kode_retur;
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
            
            $tabel_opsi_transaksi_retur = $this->db->insert("opsi_transaksi_retur", $data_opsi);

            //$grand_total = $total + $item->subtotal;
            $nama_bahan = $item->nama_bahan;
            $stok_keluar = $item->jumlah;
            $kode_retur = $item->kode_retur;
            $kategori_bahan = $item->kategori_bahan;
            $kode_bahan = $item->kode_bahan;
            $harga_satuan = $item->harga_satuan;
            $nama_supplier = $item->nama_supplier;

            //-------------------------------------- Melihat Kode Default Unit dan Rak -------------------------------//
                                    $this->db->select('kode_unit');
                    $kode_default = $this->db->get('setting_gudang');
                    $hasil_kode_default = $kode_default->row();
                    $kode_unit = $hasil_kode_default->kode_unit;
                    @$kode_rak = @$hasil_kode_default->kode_rak_default;
            //----------------------------------------------------------------------------------------------------------//
            
            if($kategori_bahan=='bahan baku'){
                          $this->db->select('*') ;
            $real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
            $stok_real = $real_stock->row()->real_stock ;
            $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

                if(!empty($stok_real)){

                                   $this->db->select('*') ;
                    $jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                    $jumlah_stok = $jumlah_stok->row()->real_stock ;

                    $data_stok['real_stock'] = $jumlah_stok - ($stok_keluar * $konversi_stok)  ;
                    $this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                   $this->db->select('nama_unit');
                    $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                    $hasil_master_unit = $master_unit->row();
                    $nama_unit = $hasil_master_unit->nama_unit;

                                  $this->db->select('nama_rak');
                    $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>@$kode_rak));
                    @$hasil_master_rak = $master_rak->row();
                    @$nama_rak = @$hasil_master_rak->nama_rak;
                    @$nama_rak = @$real_stock->row()->nama_rak;


                                   $this->db->select('*, min(id) id');
                    $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                    $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                    $cek_id_stok_hpp = $cek_hpp->row()->id;

                    $stok['jenis_transaksi'] = 'retur' ;
                    $stok['kode_transaksi'] = $kode_retur ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = $stok_keluar * $konversi_stok;
                    $stok['stok_masuk'] =  '';
                    $stok['posisi_awal'] = 'gudang';
                    $stok['posisi_akhir'] = 'supplier';
                    $stok['hpp'] = $harga_satuan ;
                    $stok['sisa_stok'] = '' ;
                    $stok['kode_unit_asal'] = $kode_unit;
                    $stok['nama_unit_asal'] = @$nama_unit;
                    $stok['kode_rak_asal'] = @$kode_rak;
                    $stok['nama_rak_asal'] = @$nama_rak;
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                    $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp - ($stok_keluar * $konversi_stok);
                    $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                }
            }
            if($kategori_bahan=='barang'){
                          $this->db->select('*') ;
            $real_stock = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan, 'position'=>$kode_unit));
            $stok_real = $real_stock->row()->real_stok ;
            $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

                if(!empty($stok_real)){

                                   $this->db->select('*') ;
                    $jumlah_stok = $this->db->get_where('master_barang',array('kode_barang'=>$kode_bahan, 'position'=>$kode_unit));
                    $jumlah_stok = $jumlah_stok->row()->real_stok ;

                    $data_stok['real_stok'] = $jumlah_stok - ($stok_keluar * $konversi_stok)  ;
                    $this->db->update('master_barang',$data_stok,array('kode_barang'=>$kode_bahan, 'position'=>$kode_unit));

                                   $this->db->select('nama_unit');
                    $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                    $hasil_master_unit = $master_unit->row();
                    $nama_unit = $hasil_master_unit->nama_unit;

                                  $this->db->select('nama_rak');
                    $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>@$kode_rak));
                    $hasil_master_rak = $master_rak->row();
                    @$nama_rak = @$hasil_master_rak->nama_rak;
                    @$nama_rak = @$real_stock->row()->nama_rak;
                                   $this->db->select('*, min(id) id');
                    $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                    $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                    $cek_id_stok_hpp = $cek_hpp->row()->id;

                    $stok['jenis_transaksi'] = 'retur' ;
                    $stok['kode_transaksi'] = $kode_retur ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = $stok_keluar * $konversi_stok;
                    $stok['stok_masuk'] =  '';
                    $stok['posisi_awal'] = 'gudang';
                    $stok['posisi_akhir'] = 'supplier';
                    $stok['hpp'] = $harga_satuan ;
                    $stok['sisa_stok'] = '' ;
                    $stok['kode_unit_asal'] = $kode_unit;
                    $stok['nama_unit_asal'] = $nama_unit;
                    $stok['kode_rak_asal'] = @$kode_rak;
                    $stok['nama_rak_asal'] = @$nama_rak;
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);
                    
                    $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp - ($stok_keluar * $konversi_stok);
                    $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                }
            }


            if($kategori_bahan=='bahan jadi'){
                          $this->db->select('*') ;
            $real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
            $stok_real = $real_stock->row()->real_stock ;

                if(!empty($stok_real)){

                                   $this->db->select('*') ;
                    $jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                    $jumlah_stok = $jumlah_stok->row()->real_stock ;

                    $data_stok['real_stock'] = $jumlah_stok - ($stok_keluar * $konversi_stok);
                    $this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                   $this->db->select('nama_unit');
                    $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                    $hasil_master_unit = $master_unit->row();
                    $nama_unit = $hasil_master_unit->nama_unit;

                                  $this->db->select('nama_rak');
                    $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
                    $hasil_master_rak = $master_rak->row();
                    $nama_rak = $hasil_master_rak->nama_rak;

                               $this->db->select('*, min(id) id');
                    $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                    $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                    $cek_id_stok_hpp = $cek_hpp->row()->id;

                    $stok['jenis_transaksi'] = 'retur' ;
                    $stok['kode_transaksi'] = $kode_retur ;
                    $stok['kategori_bahan'] = $kategori_bahan ;
                    $stok['kode_bahan'] = $kode_bahan ;
                    $stok['nama_bahan'] = $nama_bahan ;
                    $stok['stok_keluar'] = $stok_keluar * $konversi_stok ;
                    $stok['stok_masuk'] = '' ;
                    $stok['posisi_awal'] = 'gudang';
                    $stok['posisi_akhir'] = 'supplier';
                    $stok['hpp'] = $harga_satuan ;
                    $stok['sisa_stok'] = '' ;
                    $stok['kode_unit_asal'] = $kode_unit;
                    $stok['nama_unit_asal'] = $nama_unit;
                    $stok['kode_rak_asal'] = $kode_rak;
                    $stok['nama_rak_asal'] = $nama_rak;
                    $stok['id_petugas'] = $id_petugas;
                    $stok['nama_petugas'] = $nama_petugas;
                    $stok['tanggal_transaksi'] = date("Y-m-d") ;

                    $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                    $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp - ($stok_keluar * $konversi_stok);
                    $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                }
            }            
        }

        if($transaksi_stok){
            unset($input['kategori_bahan']);
            unset($input['kode_bahan']);
            unset($input['jumlah']);
            unset($input['nama_satuan']);
            unset($input['nama_bahan']);
            unset($input['harga_satuan']);
            unset($input['id_item_temp']);
            unset($input['kode_satuan']);

                     $this->db->select('*, SUM(subtotal)as grand_total') ;
            $query = $this->db->get_where('opsi_transaksi_retur_temp',array('kode_retur'=>$kode_retur));
            $data = $query->row();
            $grand_total = $data->grand_total ;

            $input['tanggal_retur_keluar'] = date("Y-m-d") ;
            $input['tanggal_retur_masuk'] = '' ;
            $input['total_nominal'] = '' ;
            $input['sisa_nominal'] = '' ;
            $input['potongan'] = '' ;
            $input['total_nominal'] = $grand_total ;
            $input['grand_total'] = $grand_total;
            $input['petugas'] = $nama_petugas ;
            $input['id_petugas'] = $id_petugas ;
            $input['nama_supplier'] = $nama_supplier ;
            $input['proses_pembayaran'] = 'cash' ;
            $input['status_retur'] = 'menunggu' ;

            $tabel_transaksi_retur = $this->db->insert("transaksi_retur", $input);
            if($tabel_transaksi_retur){
                echo '<div class="alert alert-success">Berhasil Melakukan retur.</div>';  
                $delete_temp = $this->db->delete("opsi_transaksi_retur_temp", array('kode_retur'=>$kode_retur));
            }
            else{
                echo '<div class="alert alert-danger">Gagal Melakukan retur (Trx_retur) .</div>';  
            }
        }
        else{
            echo '<div class="alert alert-danger">Gagal Melakukan retur (update_stok).</div>';  
        }
    }

    public function simpan_terima_retur()
    {
        $input = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;

        if ($this->form_validation->run() == FALSE) {
                echo "0|".warn_msg(validation_errors());
        } else {
            $kode_retur = $input['kode_retur'];

                        $this->db->select('*') ;
            $cek_item = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode_retur));

            $total = 0;
            foreach ($cek_item->result() as $item){
     
                $grand_total = $total + $item->subtotal;
                $nama_bahan = $item->nama_bahan;
                $stok_masuk = $item->jumlah;
                $kode_retur = $item->kode_retur;
                $kategori_bahan = $item->kategori_bahan;
                $kode_bahan = $item->kode_bahan;
                $nama_supplier = $item->nama_supplier;
                $harga_satuan = $item->harga_satuan;

                //-------------------------------------- Melihat Kode Default Unit dan Rak -------------------------------//
                                    $this->db->select('kode_unit_default,kode_rak_default');
                    $kode_default = $this->db->get('master_setting');
                    $hasil_kode_default = $kode_default->row();
                    $kode_unit = $hasil_kode_default->kode_unit_default;
                    $kode_rak = $hasil_kode_default->kode_rak_default;
                //----------------------------------------------------------------------------------------------------------//

                if($kategori_bahan=='bahan baku'){
                              $this->db->select('*') ;
                $real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                $stok_real = $real_stock->row()->real_stock ;
                $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

                    if(!empty($stok_real)){

                                       $this->db->select('*') ;
                        $jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                        $jumlah_stok = $jumlah_stok->row()->real_stock ;

                        $data_stok['real_stock'] = $jumlah_stok + ($stok_masuk * $konversi_stok);
                        $this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                       $this->db->select('nama_unit');
                        $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                        $hasil_master_unit = $master_unit->row();
                        $nama_unit = $hasil_master_unit->nama_unit;

                                      $this->db->select('nama_rak');
                        $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
                        $hasil_master_rak = $master_rak->row();
                        $nama_rak = $hasil_master_rak->nama_rak;

                                   $this->db->select('*, min(id) id');
                        $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                        $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                        $cek_id_stok_hpp = $cek_hpp->row()->id;

                        $stok['jenis_transaksi'] = 'retur' ;
                        $stok['kode_transaksi'] = $kode_retur ;
                        $stok['kategori_bahan'] = $kategori_bahan ;
                        $stok['kode_bahan'] = $kode_bahan ;
                        $stok['nama_bahan'] = $nama_bahan ;
                        $stok['stok_keluar'] = '';
                        $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                        $stok['posisi_awal'] = 'supplier';
                        $stok['posisi_akhir'] = 'gudang';
                        $stok['hpp'] = $harga_satuan ;
                        $stok['sisa_stok'] = '' ;
                        $stok['kode_unit_tujuan'] = $kode_unit;
                        $stok['nama_unit_tujuan'] = $nama_unit;
                        $stok['kode_rak_tujuan'] = $kode_rak;
                        $stok['nama_rak_tujuan'] = $nama_rak;
                        $stok['id_petugas'] = $id_petugas;
                        $stok['nama_petugas'] = $nama_petugas;
                        $stok['tanggal_transaksi'] = date("Y-m-d") ;

                        $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                        $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp + ($stok_masuk * $konversi_stok);
                        $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                    }
                }

                if($kategori_bahan=='bahan jadi'){
                              $this->db->select('*') ;
                $real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                $stok_real = $real_stock->row()->real_stock ;
                $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

                    if(!empty($stok_real)){

                                       $this->db->select('*') ;
                        $jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                        $jumlah_stok = $jumlah_stok->row()->real_stock ;

                        $data_stok['real_stock'] = $jumlah_stok + ($stok_masuk * $konversi_stok) ;
                        $this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                       $this->db->select('nama_unit');
                        $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                        $hasil_master_unit = $master_unit->row();
                        $nama_unit = $hasil_master_unit->nama_unit;

                                      $this->db->select('nama_rak');
                        $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
                        $hasil_master_rak = $master_rak->row();
                        $nama_rak = $hasil_master_rak->nama_rak;
                                
                                   $this->db->select('*, min(id) id');
                        $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                        $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                        $cek_id_stok_hpp = $cek_hpp->row()->id;

                        $stok['jenis_transaksi'] = 'retur' ;
                        $stok['kode_transaksi'] = $kode_retur ;
                        $stok['kategori_bahan'] = $kategori_bahan ;
                        $stok['kode_bahan'] = $kode_bahan ;
                        $stok['nama_bahan'] = $nama_bahan ;
                        $stok['stok_keluar'] = '' ;
                        $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                        $stok['posisi_awal'] = 'supplier';
                        $stok['posisi_akhir'] = 'gudang';
                        $stok['hpp'] = $harga_satuan ;
                        $stok['sisa_stok'] = '' ;
                        $stok['kode_unit_tujuan'] = $kode_unit;
                        $stok['nama_unit_tujuan'] = $nama_unit;
                        $stok['kode_rak_tujuan'] = $kode_rak;
                        $stok['nama_rak_tujuan'] = $nama_rak;
                        $stok['id_petugas'] = $id_petugas;
                        $stok['nama_petugas'] = $nama_petugas;
                        $stok['tanggal_transaksi'] = date("Y-m-d") ;

                        $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                        $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp + ($stok_masuk * $konversi_stok);
                        $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                    }
                }                  
            }

            if($transaksi_stok){
                $status['status_retur'] = 'selesai' ;
                $status['tanggal_retur_masuk'] = date("Y-m-d") ;
                $tabel_transaksi_retur = $this->db->update("transaksi_retur", $status, array('kode_retur'=>$kode_retur));
                $delete_terima_temp = $this->db->delete("opsi_transaksi_terima_retur_temp", array('kode_retur'=>$kode_retur));
                echo '1|<div class="alert alert-success">Berhasil Menerima Retur.</div>';
            }
            else{
                echo '0|<div class="alert alert-danger">Gagal Menerima Retur (update_stok).</div>';  
            }
        }
    }

    public function simpan_terima_retur_tidak_sesuai()
    {
        $input = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        
        if ($this->form_validation->run() == FALSE) {
                echo "0|".warn_msg(validation_errors());
        } else {

            $kode_retur = $input['kode_retur'];

                                $this->db->select('*') ;
            $cek_item = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode_retur));

            $total = 0;
            foreach ($cek_item->result() as $item){
     
                $grand_total = $total + $item->subtotal;
                $nama_bahan = $item->nama_bahan;
                $stok_masuk = $item->jumlah;
                $kode_retur = $item->kode_retur;
                $kategori_bahan = $item->kategori_bahan;
                $kode_bahan = $item->kode_bahan;
                $nama_supplier = $item->nama_supplier;
                $harga_satuan = $item->harga_satuan;

                //-------------------------------------- Melihat Kode Default Unit dan Rak -------------------------------//
                                    $this->db->select('kode_unit_default,kode_rak_default');
                    $kode_default = $this->db->get('master_setting');
                    $hasil_kode_default = $kode_default->row();
                    $kode_unit = $hasil_kode_default->kode_unit_default;
                    $kode_rak = $hasil_kode_default->kode_rak_default;
                //----------------------------------------------------------------------------------------------------------//

                if($kategori_bahan=='bahan baku'){
                              $this->db->select('*') ;
                $real_stock = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                $stok_real = $real_stock->row()->real_stock ;
                $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;

                    if(!empty($stok_real)){

                                       $this->db->select('*') ;
                        $jumlah_stok = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                        $jumlah_stok = $jumlah_stok->row()->real_stock ;

                        $data_stok['real_stock'] = $jumlah_stok + ($stok_masuk * $konversi_stok) ;
                        $this->db->update('master_bahan_baku',$data_stok,array('kode_bahan_baku'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                       $this->db->select('nama_unit');
                        $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                        $hasil_master_unit = $master_unit->row();
                        $nama_unit = $hasil_master_unit->nama_unit;

                                      $this->db->select('nama_rak');
                        $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
                        $hasil_master_rak = $master_rak->row();
                        $nama_rak = $hasil_master_rak->nama_rak;

                                   $this->db->select('*, min(id) id');
                        $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                        $num_row_hpp = $cek_hpp->num_row();
                        $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                        $cek_id_stok_hpp = $cek_hpp->row()->id;

                        if($num_row_hpp > 0){
                            $stok['jenis_transaksi'] = 'retur' ;
                            $stok['kode_transaksi'] = $kode_retur ;
                            $stok['kategori_bahan'] = $kategori_bahan ;
                            $stok['kode_bahan'] = $kode_bahan ;
                            $stok['nama_bahan'] = $nama_bahan ;
                            $stok['stok_keluar'] = '';
                            $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                            $stok['posisi_awal'] = 'supplier';
                            $stok['posisi_akhir'] = 'gudang';
                            $stok['hpp'] = $harga_satuan ;
                            $stok['kode_unit_tujuan'] = $kode_unit;
                            $stok['nama_unit_tujuan'] = $nama_unit;
                            $stok['kode_rak_tujuan'] = $kode_rak;
                            $stok['nama_rak_tujuan'] = $nama_rak;
                            $stok['id_petugas'] = $id_petugas;
                            $stok['nama_petugas'] = $nama_petugas;
                            $stok['tanggal_transaksi'] = date("Y-m-d") ;

                            $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                            $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp + ($stok_masuk * $konversi_stok);
                            $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                        }
                        else{
                            $stok['jenis_transaksi'] = 'retur' ;
                            $stok['kode_transaksi'] = $kode_retur ;
                            $stok['kategori_bahan'] = $kategori_bahan ;
                            $stok['kode_bahan'] = $kode_bahan ;
                            $stok['nama_bahan'] = $nama_bahan ;
                            $stok['stok_keluar'] = '';
                            $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                            $stok['posisi_awal'] = 'supplier';
                            $stok['posisi_akhir'] = 'gudang';
                            $stok['hpp'] = $harga_satuan ;
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

                if($kategori_bahan=='bahan jadi'){
                              $this->db->select('*') ;
                $real_stock = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                $stok_real = $real_stock->row()->real_stock ;
                $konversi_stok = $real_stock->row()->jumlah_dalam_satuan_pembelian ;
                
                    if(!empty($stok_real)){

                                       $this->db->select('*') ;
                        $jumlah_stok = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));
                        $jumlah_stok = $jumlah_stok->row()->real_stock ;

                        $data_stok['real_stock'] = $jumlah_stok + ($stok_masuk * $konversi_stok) ;
                        $this->db->update('master_bahan_jadi',$data_stok,array('kode_bahan_jadi'=>$kode_bahan, 'kode_unit'=>$kode_unit));

                                       $this->db->select('nama_unit');
                        $master_unit = $this->db->get_where('master_unit', array('kode_unit'=>$kode_unit));
                        $hasil_master_unit = $master_unit->row();
                        $nama_unit = $hasil_master_unit->nama_unit;

                                      $this->db->select('nama_rak');
                        $master_rak = $this->db->get_where('master_rak', array('kode_rak'=>$kode_rak));
                        $hasil_master_rak = $master_rak->row();
                        $nama_rak = $hasil_master_rak->nama_rak;

                                   $this->db->select('*, min(id) id');
                        $cek_hpp = $this->db->get_where('transaksi_stok', array('kode_bahan'=>$kode_bahan, 'hpp'=>$harga_satuan));
                        $num_row_hpp = $cek_hpp->num_row();
                        $cek_sisa_stok_hpp = $cek_hpp->row()->sisa_stok;
                        $cek_id_stok_hpp = $cek_hpp->row()->id;

                        if($num_row_hpp > 0){
                            $stok['jenis_transaksi'] = 'retur' ;
                            $stok['kode_transaksi'] = $kode_retur ;
                            $stok['kategori_bahan'] = $kategori_bahan ;
                            $stok['kode_bahan'] = $kode_bahan ;
                            $stok['nama_bahan'] = $nama_bahan ;
                            $stok['stok_keluar'] = '';
                            $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                            $stok['posisi_awal'] = 'supplier';
                            $stok['posisi_akhir'] = 'gudang';
                            $stok['hpp'] = $harga_satuan ;
                            $stok['kode_unit_tujuan'] = $kode_unit;
                            $stok['nama_unit_tujuan'] = $nama_unit;
                            $stok['kode_rak_tujuan'] = $kode_rak;
                            $stok['nama_rak_tujuan'] = $nama_rak;
                            $stok['id_petugas'] = $id_petugas;
                            $stok['nama_petugas'] = $nama_petugas;
                            $stok['tanggal_transaksi'] = date("Y-m-d") ;

                            $transaksi_stok = $this->db->insert("transaksi_stok", $stok);

                            $data_trx_stok['sisa_stok'] = $cek_sisa_stok_hpp + ($stok_masuk * $konversi_stok);
                            $this->db->update('transaksi_stok',$data_trx_stok,array('id'=>$cek_id_stok_hpp));

                        }
                        else{
                            $stok['jenis_transaksi'] = 'retur' ;
                            $stok['kode_transaksi'] = $kode_retur ;
                            $stok['kategori_bahan'] = $kategori_bahan ;
                            $stok['kode_bahan'] = $kode_bahan ;
                            $stok['nama_bahan'] = $nama_bahan ;
                            $stok['stok_keluar'] = '';
                            $stok['stok_masuk'] = $stok_masuk * $konversi_stok ;
                            $stok['posisi_awal'] = 'supplier';
                            $stok['posisi_akhir'] = 'gudang';
                            $stok['hpp'] = $harga_satuan ;
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
            }

            if($transaksi_stok){
                            $this->db->select('*,SUM(subtotal) subtotal') ;
                $cek_sum = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode_retur));
                $data_cek_sum = $cek_sum->row();
                $subtotal = $data_cek_sum->subtotal;

                $data_retur['total_nominal'] = $subtotal ;
                $data_retur['grand_total'] = $subtotal ;
                $data_retur['status_retur'] = 'selesai' ;
                $data_retur['tanggal_retur_masuk'] = date("Y-m-d") ;
                $data_retur['sisa_nominal'] = $input['sisa_nominal'] ;
                $data_retur['potongan'] = $input['potongan'];
                
                $transaksi_retur = $this->db->update("transaksi_retur", $data_retur, array('kode_retur'=>$kode_retur));
                $delete_terima_temp = $this->db->delete("opsi_transaksi_terima_retur_temp", array('kode_retur'=>$kode_retur));

                if($input['sisa_nominal'] < $input['potongan']){
                    $this->db->select('*') ;
                    $query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'2.4.1'))->row();
                    $kode_sub = $query_akun->kode_sub_kategori_akun;
                    $nama_sub = $query_akun->nama_sub_kategori_akun;
                    $kode_kategori = $query_akun->kode_kategori_akun;
                    $nama_kategori = $query_akun->nama_kategori_akun;
                    $kode_jenis = $query_akun->kode_jenis_akun;
                    $nama_jenis = $query_akun->nama_jenis_akun;

                    $data_keu['id_petugas'] = $id_petugas ;
                    $data_keu['petugas'] = $nama_petugas ;
                    $data_keu['kode_referensi'] = $kode_retur ;
                    $data_keu['tanggal_transaksi'] = date("Y-m-d") ;
                    $data_keu['keterangan'] = 'terima_barang_retur' ;
                    $data_keu['nominal'] = ($input['potongan'] - $input['sisa_nominal']) ;
                    $data_keu['kode_jenis_keuangan'] = $kode_jenis ;
                    $data_keu['nama_jenis_keuangan'] = $nama_jenis ;
                    $data_keu['kode_kategori_keuangan'] = $kode_kategori ;
                    $data_keu['nama_kategori_keuangan'] =  $nama_kategori ;
                    $data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
                    $data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
                    
                    $keuangan = $this->db->insert("keuangan_keluar", $data_keu);
                }
                else if($input['sisa_nominal'] > $input['potongan']){
                    $this->db->select('*') ;
                    $query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=>'1.2.1'))->row();
                    $kode_sub = $query_akun->kode_sub_kategori_akun;
                    $nama_sub = $query_akun->nama_sub_kategori_akun;
                    $kode_kategori = $query_akun->kode_kategori_akun;
                    $nama_kategori = $query_akun->nama_kategori_akun;
                    $kode_jenis = $query_akun->kode_jenis_akun;
                    $nama_jenis = $query_akun->nama_jenis_akun;
                    
                    $data_keu['id_petugas'] = $id_petugas ;
                    $data_keu['petugas'] = $nama_petugas ;
                    $data_keu['kode_referensi'] = $kode_retur ;
                    $data_keu['tanggal_transaksi'] = date("Y-m-d") ;
                    $data_keu['keterangan'] = 'terima_barang_retur' ;
                    $data_keu['nominal'] = ($input['sisa_nominal'] - $input['potongan']);
                    $data_keu['kode_jenis_keuangan'] =  $kode_jenis;
                    $data_keu['nama_jenis_keuangan'] = $nama_jenis ;
                    $data_keu['kode_kategori_keuangan'] = $kode_kategori ;
                    $data_keu['nama_kategori_keuangan'] = $nama_kategori ;
                    $data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
                    $data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
                    
                    $keuangan = $this->db->insert("keuangan_masuk", $data_keu);
                }

                echo '1|<div class="alert alert-success">Berhasil Menerima Retur.</div>';
            }
            else{
                echo '0|<div class="alert alert-danger">Gagal Menerima Retur (update_stok).</div>';  
            }
        }
    }

}
