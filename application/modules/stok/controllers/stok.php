<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stok extends MY_Controller {

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
		$data['halaman'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);
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
	public function get_penjualan()
	{
		$kode_stok_out = $this->input->post('kode_stok_out');
		$kode_penjualan = $this->input->post('kode_penjualan');
		$query = $this->db->get_where('transaksi_penjualan_jasa',array('kode_penjualan' => $kode_penjualan,'validasi' =>'valid'));
		$data=$query->row();
		$jumlah = count($data);
		if($jumlah > 0){
			$pembelian = $this->db->get_where('opsi_transaksi_penjualan_jasa',array('kode_penjualan'=>$data->kode_penjualan));
			$list_pembelian = $pembelian->result();
			foreach($list_pembelian as $daftar){ 
				$masukan['kode_stok_out'] = $kode_stok_out;
				$masukan['kategori_bahan'] = 'stok';
				$masukan['kode_bahan'] = $daftar->kode_menu;
				$masukan['nama_bahan'] = $daftar->nama_menu; 
				$masukan['jumlah'] = $daftar->jumlah; 
				
				$bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_menu,'nama_bahan_baku'=>$daftar->nama_menu));
				$hasil_bahan = $bahan->row();
				$masukan['stok_awal'] = $hasil_bahan->real_stock;
                   
				$masukan['sub_total'] = $daftar->harga_satuan * $daftar->jumlah;

				$input = $this->db->insert('opsi_transaksi_stok_out_temp',$masukan);
			}
			echo "1|".$kode_penjualan;
		}
		else{
			
			echo "0";
		}
	}
	public function get_jenis_filter()
	{
		$kategori_filter = $this->input->post('kategori_filter');

		if($kategori_filter=='kategori'){
			$jenis_filter = $this->db->get('master_kategori_menu');
			$hasil_jenis_filter = $jenis_filter->result();
			echo "<option value=''>Pilih Kategori Produk</option>";
			foreach ($hasil_jenis_filter as  $value) {
				echo "<option value=".$value->kode_kategori_menu.">".$value->nama_kategori_menu."</option>";
			}

		}elseif($kategori_filter=='blok'){
			$jenis_filter = $this->db->get('master_rak');
			$hasil_jenis_filter = $jenis_filter->result();
			echo "<option value=''>Pilih Blok</option>";
			foreach ($hasil_jenis_filter as  $value) {
				echo "<option value=".$value->kode_rak.">".$value->nama_rak."</option>";
			}
		}


	}

	public function cari_stok(){

		$this->load->view('stok/daftar_stok/cari_stok');

	}

	public function cari_stok_out(){

		$this->load->view('stok/daftar_stok_out/cari_stok_out');

	}

	public function simpan_po_stokmin_temp()
	{
		$input=$this->input->post('bahan_stokmin');
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

	// $tgl = date("Y-m-d");
	// $no_belakang = 0;
	// $this->db->select_max('kode_po');
	// $kode = $this->db->get_where('transaksi_po',array('tanggal_input'=>$tgl));
	// $hasil_kode = $kode->row();

	// $this->db->select('kode_po');
	// $get_kode_ro = $this->db->get('master_setting');
	// $hasil_kode_ro = $get_kode_ro->row();

	// if(count($hasil_kode)==0){
	// 	$no_belakang = 1;
	// }
	// else{
	// $kode_default = $this->db->get('setting_gudang');
	// $hasil_unit =$kode_default->row();
	// $param=$hasil_unit->kode_unit;
	// $ko_ro_baru = @$hasil_kode_ro->kode_po."_".date("dmyHis")."_".$param."_".$no_belakang;
	// 	$pecah_kode = explode("_",$hasil_kode->kode_po);
	// 	$no_belakang = @$pecah_kode[3]+1;
	// }

		foreach ($input as $value) {
			//echo $value;
			$bahan=$this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$value));
			$hasil_bahan=$bahan->row();
			$data['kode_po']=$kode_trans;
			$data['kode_bahan']=$hasil_bahan->kode_bahan_baku;
			$data['nama_bahan']=$hasil_bahan->nama_bahan_baku;
			$data['kategori_bahan']=$hasil_bahan->jenis_bahan;
			$data['position']=$hasil_bahan->kode_unit;
			$data['jumlah']=0;

			$this->db->insert('opsi_transaksi_po_temp',$data);

		}
	}

	public function daftar()
	{
		$data['halaman'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function daftar_produk()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/daftar_produk', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}





//P Dion
	public function daftar_stok_out()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok_out/daftar_stok_out', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok_out/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function tambah_stok_out()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok_out/tambah_stok_out', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok_out/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function detail_stok_out()
	{
		$data['aktif'] = 'detail';
		$data['konten'] = $this->load->view('daftar_stok_out/detail_stok_out', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok_out/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function get_satuan()
	{
		$kode_bahan = $this->input->post('kode_bahan');
		$nama_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $kode_bahan));
		$hasil_bahan = $nama_bahan->row();
                #$bahan = $hasil_bahan->satuan_pembelian;
		echo json_encode($hasil_bahan);

	}

	public function update_item_temp(){
		$update = $this->input->post();
		$data_update['jumlah']=$update['jumlah'];
		$data_update['keterangan']=$update['keterangan'];
		$data_update['sub_total']=$update['sub_total'];
		$this->db->update('opsi_transaksi_stok_out_temp',$data_update,array('kode_stok_out'=>$update['kode_stok_out'],'kode_bahan'=>$update['kode_bahan']));
		echo $this->db->last_query();

		echo "sukses";
	}


	public function simpan_item_temp()
	{
	//Insert Opsi Transaksi Stok Out Temp
		$masukan = $this->input->post();
		$get_temp = $this->db->get_where('opsi_transaksi_stok_out_temp',array('kode_bahan'=>$masukan['kode_bahan']));
		$cek_temp=$get_temp->num_rows();
		if($cek_temp==1){
			$update['jumlah']=$get_temp->row()->jumlah+$masukan['jumlah'];
			$this->db->update( "opsi_transaksi_stok_out_temp", $update, array('kode_bahan'=>$masukan['kode_bahan']) );
		}else{ 
			$this->db->insert('opsi_transaksi_stok_out_temp',$masukan);
		}
		echo "sukses";				 				
	}

	public function get_stok_out($kode){
		$data['kode'] = $kode ;
		$this->load->view('stok/daftar_stok_out/tabel_transaksi_temp',$data);
	}

	public function get_temp_stok_out(){
		$id = $this->input->post('id');
		$temp = $this->db->get_where('opsi_transaksi_stok_out_temp',array('id'=>$id));
		$hasil_temp = $temp->row();
		echo json_encode($hasil_temp);
	}

	public function simpan_stok_out()
	{	
		$user=$this->session->userdata('astrosession');
		$masukan = $this->input->post();
		$get_temp = $this->db->get_where('opsi_transaksi_stok_out_temp',array('kode_stok_out'=>$masukan['kode_stok_out']));
		$hasil_get_temp=$get_temp->result();

		$total_nominal=0;
		foreach ($hasil_get_temp as $item ) {
			$total_nominal +=$item->sub_total; 

		//Insert Opsi Transaksi Stok Out
			$data_opsi['kode_stok_out'] = $item->kode_stok_out;
			$data_opsi['kategori_bahan'] = $item->kategori_bahan;
			$data_opsi['kode_bahan'] = $item->kode_bahan;
			$data_opsi['nama_bahan'] = $item->nama_bahan;
			$data_opsi['jumlah'] = $item->jumlah;
			$data_opsi['keterangan'] = $item->keterangan;
			$data_opsi['stok_awal'] = $item->stok_awal;
			$data_opsi['sub_total'] = $item->sub_total;
			$insert_opsi = $this->db->insert("opsi_transaksi_stok_out", $data_opsi);

		//Insert Transaksi Stok
			$transaksi_stok['jenis_transaksi'] = 'stok out';
			$transaksi_stok['kode_transaksi'] =  $item->kode_stok_out;
			$transaksi_stok['kategori_bahan'] = $item->kategori_bahan;
			$transaksi_stok['kode_bahan'] = $item->kode_bahan;
			$transaksi_stok['nama_bahan'] = $item->nama_bahan;

			$get_hpp=$this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$item->kode_bahan));
			$hasil_get_hpp=$get_hpp->row();

			$transaksi_stok['hpp'] = $hasil_get_hpp->hpp;
			$transaksi_stok['stok_keluar'] = $item->jumlah;
			$sisa_stok=$item->stok_awal - $item->jumlah;
			$transaksi_stok['sisa_stok'] = $sisa_stok;
			$transaksi_stok['id_petugas'] = $user->id;
			$transaksi_stok['nama_petugas'] = $user->nama;
			$transaksi_stok['tanggal_transaksi'] = date('Y-m-d');
			$insert_transaksi_stok = $this->db->insert("transaksi_stok", $transaksi_stok);

		//Update Stok Di Master Bahan Baku
			$update_stok['real_stock'] = $sisa_stok;
			$this->db->update("master_bahan_baku", $update_stok,array('kode_bahan_baku' => $item->kode_bahan));
			$this->db->truncate('opsi_transaksi_stok_out_temp');
		}
	//Input Transaksi Stok Out
		$insert['kode_stok_out'] = $masukan['kode_stok_out'];
		$insert['tanggal_input'] = date('Y-m-d');
		$insert['id_petugas'] = $user->id;
		$insert['petugas'] = $user->nama;
		$insert_stok_out = $this->db->insert("transaksi_stok_out", $insert);

	//Insert Keungan Keluar
		$get_keungan=$this->db->get_where('keuangan_kategori_akun',array('kode_kategori_akun'=>'2.5'));
		$hasil_keuangan=$get_keungan->row();
		$insert_keuangan_keluar['kode_jenis_keuangan']=$hasil_keuangan->kode_jenis_akun;
		$insert_keuangan_keluar['nama_jenis_keuangan']=$hasil_keuangan->nama_jenis_akun;
		$insert_keuangan_keluar['kode_kategori_keuangan']=$hasil_keuangan->kode_kategori_akun;
		$insert_keuangan_keluar['nama_kategori_keuangan']=$hasil_keuangan->nama_kategori_akun;

		$get_sub_keungan=$this->db->get_where('keuangan_sub_kategori_akun',array('kode_kategori_akun'=>$hasil_keuangan->kode_kategori_akun,'kode_sub_kategori_akun'=>'2.5.2'));
		$hasil_sub_keuangan=$get_sub_keungan->row();
		$insert_keuangan_keluar['kode_sub_kategori_keuangan']=$hasil_sub_keuangan->kode_sub_kategori_akun;
		$insert_keuangan_keluar['nama_sub_kategori_keuangan']=$hasil_sub_keuangan->nama_sub_kategori_akun;

		$insert_keuangan_keluar['nominal']=$total_nominal;
		$insert_keuangan_keluar['keterangan']='stok out';
		$insert_keuangan_keluar['tanggal_transaksi']=date('Y-m-d');
		$insert_keuangan_keluar['kode_referensi']=$masukan['kode_stok_out'];
		$insert_keuangan_keluar['id_petugas']=$user->id;
		$insert_keuangan_keluar['petugas']=$user->nama;
		$insert_keluar = $this->db->insert("keuangan_keluar", $insert_keuangan_keluar);
	// echo $this->db->last_query();
		if($insert_keluar){
			echo '<div class="alert alert-success">Berhasil Menyimpan Transaksi.</div>';  
		}else{
			echo '<div class="alert alert-danger">Gagal Menyimpan Transaksi.</div>';
		}	


	}
	public function hapus_bahan_temp(){
		$id = $this->input->post('id');
		$this->db->delete('opsi_transaksi_stok_out_temp',array('id'=>$id));
	}
//End P. DIon

	public function gudang()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/daftar_stok_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function kitchen()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function bar()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function server()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function tambah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/form', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function ubah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/form', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);			
	}

	public function detail()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/detail_stok', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);				
	}


	public function hapus(){
		$kode = $this->input->post("key");
		$this->db->delete( 'master_barang', array('kode_barang' => $kode) );
		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}

	public function detail_stok_gudang(){
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_stok/detail_stok_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_stok/menu', $data, TRUE);
		$this->load->view('main', $data);	
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
	public function get_temp_pembelian(){
		$id = $this->input->post('id');
		$pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('id'=>$id));
		$hasil_pembelian = $pembelian->row();
		echo json_encode($hasil_pembelian);
	}

	public function simpan_tambah()

	{
		$data['kode_barang'] = $this->input->post("kode_barang");
		$data['nama_barang'] = $this->input->post("nama_barang");
		$data['kode_supplier'] = $this->input->post("supplier");
		$parameter = $this->input->post("supplier");
		$get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
		$hasil_master_supplier = $get_master_supplier->row();
		$item = $hasil_master_supplier;
		$data['nama_supplier'] = $item->nama_supplier;

		$data['stok'] = $this->input->post("stok");
		$data['position'] = $this->input->post("position");

		$insert = $this->db->insert("master_barang", $data); 
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['kode_barang']);
	}

	public function simpan_ubah()

	{
		$data['kode_barang'] = $this->input->post("kode_barang");
		$data['nama_barang'] = $this->input->post("nama_barang");
		$data['kode_supplier'] = $this->input->post("supplier");
		$parameter = $this->input->post("supplier");
		$get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
		$hasil_master_supplier = $get_master_supplier->row();
		$item = $hasil_master_supplier;
		$data['nama_supplier'] = $item->nama_supplier;

		$data['stok'] = $this->input->post("stok");
		$data['position'] = $this->input->post("position");

		$update = $this->db->update("master_barang", $data, array('kode_barang' => $data['kode_barang'])); 
		echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		$this->session->set_flashdata('message', $data['kode_barang']);
	}

	public function get_table()
	{
		$kode_default = $this->db->get('setting_gudang');
		$hasil_unit =$kode_default->row();
		$param =$hasil_unit->kode_unit;
		$start = (100*$this->input->post('page'));
		$this->db->limit(100, $start);
		$get_stok = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param));
		$hasil_stok = $get_stok->result_array();
		foreach ($hasil_stok as $item) {

			$kode_bahan = $item['kode_bahan_baku']; 
			$this->db->select_max('id');                       
			$get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
			$hasil_hpp_bahan = $get_kode_bahan->row();

			$get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
			$hasil_get_hpp = $get_hpp->row();

			$get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
			$hasil_stok_min = $get_stok_min->row();
			?>   
			<tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal){echo'class="danger"';}?>>
				<td><?php echo $item['kode_bahan_baku'];?></td>
				<td><?php echo $item['nama_bahan_baku'];?></td>
				<td><?php echo $item['nama_rak'];?></td>
				<td align="right"><?php

				$jumlah_stok =  round($item['real_stock'] / $item['jumlah_dalam_satuan_pembelian'],2);

				$pecah_stok = explode(".", $jumlah_stok);
				echo $pecah_stok[0];

				?> <?php echo $item['satuan_pembelian'];

				?>

			</td>
			<td align="right"><?php echo $item['stok_minimal'];?> <?php echo $item['satuan_stok'];?></td>
			<td><?php echo format_rupiah(@$hasil_get_hpp->hpp);?></td>
			<td><?php echo format_rupiah(($item['real_stock'] <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item['real_stock']));?></td>
			<td align="center"><?php echo get_detail($item['id']); ?></td>
		</tr>

		<?php 
	}
}

function get_table_stok_out(){
	$start = (100*$this->input->post('page'));
	$this->db->limit(100, $start);
	$get_transaksi_stok_out=$this->db->get('transaksi_stok_out');
	$hasil_get_transaksi_stok_out=$get_transaksi_stok_out->result();
	$no=1;
	foreach ($hasil_get_transaksi_stok_out as $list) { ?>


	<tr>
		<td><?php echo $no++; ?></td>
		<td><?php echo $list->kode_stok_out; ?></td>
		<td><?php echo $list->tanggal_input; ?></td>
		<td><?php echo $list->petugas ?></td>
		<td><?php echo get_detail($list->id) ?></td>
	</tr>
	<?php }
}

}
