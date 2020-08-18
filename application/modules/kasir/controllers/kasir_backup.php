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
        //$data['konten'] = $this->load->view('kasir/kasir/kasir_meja', NULL, TRUE);
      $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', NULL, TRUE);
    }

    $this->load->view('main', $data);		
  }

  public function buka_kasir(){
    $this->form_validation->set_rules('saldo_awal', 'Saldo','required');
    if ($this->form_validation->run() == FALSE) {
      echo "kosong";           
    }else{
      $kasir = $this->input->post();
            #$this->db->select_max('kode_transaksi');

      $cek_kasir = $this->db->get_where('transaksi_kasir',array('validasi'=>''));
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
    $update['selisih'] = $update['saldo_sebenarnya'] - $update['saldo_akhir'];
    $this->db->update('transaksi_kasir',$update,array('kode_transaksi'=>$update['kode_transaksi']));
  }

  public function menu_kasir(){
    $data['aktif'] = 'kasir';
    $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', NULL, TRUE);
    $this->load->view('main', $data);
  }

  public function search_kasir(){
    $data['konten'] = $this->load->view('kasir/kasir/search_kasir');
  }

  public function sold_out(){
    $data['aktif'] = 'kasir';
    $data['konten'] = $this->load->view('kasir/kasir/sold_out', NULL, TRUE);
    $this->load->view('main', $data);
  }

  public function daftar_sold_out(){
    $this->load->view('kasir/kasir/daftar_sold_out');
  }

  public function simpan_sold_out(){
    $kode_menu = $this->input->post('kode_menu');
    $update['status'] = '0';
    $this->db->update('master_menu',$update,array('kode_menu'=>$kode_menu));
  }

  public function simpan_tersedia(){
    $kode_menu = $this->input->post('kode_menu');
    $update['status'] = '1';
    $this->db->update('master_menu',$update,array('kode_menu'=>$kode_menu));
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
public function keterangan()
{
  $data = $this->input->post();
  $this->db->insert('setting_kasir', $data);
}

public function tutup_meja(){
  $id_meja = $this->input->post('id_meja');
  $cek_meja = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$id_meja));
  $hasil_cek = $cek_meja->result();
  if(count($hasil_cek)>0){
    echo 'gagal';
  }else{
    $update['status'] = '0';
    $this->db->update('master_meja',$update,array('no_meja'=>$id_meja));
    echo 'berhasil';
  }

}
public function pesanan_temp(){
  @$kode = $this->uri->segment(4);
  @$data['kode'] = @$kode ;
  $this->load->view('kasir/kasir/daftar_pesanan_temp',$data);
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

public function get_produk(){
  $kode = $this->input->post('id_menu');
  $menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode));
  $hasil_menu = $menu->row();
  echo $hasil_menu->harga_jual.'|'.$hasil_menu->nama_menu;


}  
public function get_produk_manual(){
  $kode = $this->input->post('id_menu');
  $menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode));
  $hasil_menu = $menu->row();
  echo '
  <input type="text" name="id_penjualan" id="id_penjualan" value="" hidden/>

  <select name="menu" onchange="get_harga()" id="menu" class="form-control select2">


   <option value="'.$hasil_menu->kode_menu.'" selected="true">'.$hasil_menu->nama_menu.'</option>

 </select>
 ';


}  
public function simpan_pesanan_temp()
{
 $masukan = $this->input->post();
 $kode_meja = $masukan['kode_meja'];
 $kode_pembelian = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
 $hasil = $kode_pembelian->row();
 if(count($hasil)>0){
  $masukan['kode_penjualan'] = $hasil->kode_penjualan;
}
$this->db->group_by('kode_meja');
$cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>@$hasil->kode_penjualan));
$hasil_cek_gabung = $cek_gabung->result();

if(count($hasil_cek_gabung)<=1){
 $kode_menu = $masukan['kode_menu'];
 $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
 $hasil_getmenu = $get_menu->row();
 $cek_tipe = $this->db->get_where('tipe_menu',array('nama_tipe'=>$hasil_getmenu->status_menu,'status'=>'1'));
 $hasil_tipe = $cek_tipe->row();
 if($hasil_tipe->non_stok=='0'){

   $masukan['kategori_menu'] = $hasil_getmenu->kategori_menu;
   $masukan['nama_menu'] = $hasil_getmenu->nama_menu;
   $masukan['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
   $masukan['nama_satuan'] = $hasil_getmenu->satuan_stok;
   $harga_diskon = ($masukan['harga_satuan'] * $masukan['diskon_item'])/100;
   $masukan['harga_satuan'] = $masukan['harga_satuan'] - $harga_diskon;
   $masukan['diskon_item'] = $masukan['diskon_item'];
   $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
   $masukan['subtotal'] = $subtotal;
   $masukan['status_menu'] = $hasil_getmenu->status_menu;
   $masukan['keterangan'] = $masukan['keterangan'];
   $this->db->insert('opsi_transaksi_penjualan_temp',$masukan);
 }
 $update['status'] = '1';
 $this->db->update('master_meja',$update,array('no_meja'=>$kode_meja));

 echo "berhasil";


}
elseif(count($hasil_cek_gabung>1)){
  foreach($hasil_cek_gabung as $daftar){
    $kode_menu = $masukan['kode_menu'];
    $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$kode_menu));
    $hasil_getmenu = $get_menu->row();

    $cek_tipe = $this->db->get_where('tipe_menu',array('nama_tipe'=>$hasil_getmenu->status_menu,'status'=>'1'));
    $hasil_tipe = $cek_tipe->row();
    if($hasil_tipe->non_stok=='0'){
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
      $digabung['status_menu'] = $hasil_getmenu->status_menu;
      $digabung['keterangan'] = $masukan['keterangan'];
      $this->db->insert('opsi_transaksi_penjualan_temp',$digabung);
    }


  }
}
}

public function simpan_ubah_pesanan_temp(){
  $update = $this->input->post();

  $harga_diskon = ($update['harga_satuan'] * $update['diskon_item'])/100;
  $update['harga_satuan'] = $update['harga_satuan'] - $harga_diskon;
  $update['diskon_item'] = $update['diskon_item'];
  $subtotal = $update['jumlah'] * $update['harga_satuan'];
  $update['subtotal'] = $subtotal;

  $this->db->group_by('kode_menu');
  $cek_trx = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$update['kode_penjualan'],
    'kode_menu'=>$update['kode_menu'],'status !='=>'personal'));
       # echo $this->db->last_query();
  $cek_trx_hasil = $cek_trx->row();

  $get_menu = $this->db->get_where('master_menu',array('kode_menu'=>$update['kode_menu']));
  $hasil_getmenu = $get_menu->row();

  $jumlah = $this->input->post('jumlah');
  $jumlah_awal = $update['jumlah_awal'];
  echo $jumlah."||".$jumlah_awal;


  unset($update['jumlah_awal']);
  unset($update['kode_meja']);
  $cek_tipe = $this->db->get_where('tipe_menu',array('nama_tipe'=>$hasil_getmenu->status_menu,'status'=>'1'));
  $hasil_tipe = $cek_tipe->row();
  if($hasil_tipe->non_stok=='0'){
    $this->db->update('opsi_transaksi_penjualan_temp',$update,array('kode_penjualan'=>$update['kode_penjualan'],
      'kode_menu'=>$update['kode_menu'],'status !='=>'personal'));
  }

        #echo $this->db->last_query();
}
public function simpan_pembayaran()
{
  $data = $this->input->post();
  //$kode_meja = $data['kode_meja'];
  $kode_penjualan = $data['kode_penjualan'];
  $get_id_petugas = $this->session->userdata('astrosession');
  $id_petugas = $get_id_petugas->id;
  $nama_petugas = $get_id_petugas->uname;
  //$cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
  //$hasil_cek = $cek_gabung->row();
       #$this->db->group_by('kode_meja');
  //$get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$hasil_cek->kode_penjualan));
  $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
  $hasil_pesanan = $get_pesanan->result();

  foreach($hasil_pesanan as $daftar){
    $get_opsi_penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan,'kode_menu'=>$daftar->kode_menu));
    $hasil_opsi_penjualan = $get_opsi_penjualan->result();
    $total_opsi_penjualan = count($hasil_opsi_penjualan);
    if ($total_opsi_penjualan <= 0) {
      $masukkan['kode_kasir'] = $daftar->kode_kasir;
      $masukkan['kode_penjualan'] = $data['kode_penjualan'];
    //$masukkan['kode_meja'] = $daftar->kode_meja;
    //$masukkan['kategori_menu'] = $daftar->kategori_menu;
      $masukkan['kode_menu'] = $daftar->kode_menu;
      $masukkan['nama_menu'] = $daftar->nama_menu;
      $masukkan['jumlah'] = $daftar->jumlah;
    //$masukkan['kode_satuan'] = $daftar->kode_satuan;
    //$masukkan['nama_satuan'] = $daftar->nama_satuan;
      $masukkan['harga_satuan'] = $daftar->harga_satuan;
      $masukkan['diskon_item'] = @$daftar->diskon_item;
      $masukkan['subtotal'] = $daftar->subtotal;
      $masukkan['hpp'] = $daftar->hpp;
    //$masukkan['status_menu'] = $daftar->status_menu;
      $masukkan['tanggal_transaksi'] = date('Y-m-d');
    //$masukkan['waiter'] = $data['waiter'];
    //$masukkan['keterangan'] = $daftar->keterangan;
      $this->db->insert('opsi_transaksi_penjualan',$masukkan);

      $produk = $this->db->get_where('master_menu',array('kode_menu'=>$daftar->kode_menu));
      $hasil_produk = $produk->row();

      $stok['real_stok'] = $hasil_produk->real_stok - $daftar->jumlah;
      $this->db->update('master_menu',$stok,array('kode_menu'=>$daftar->kode_menu));

      $transaksi_stok['jenis_transaksi'] = 'Penjualan';
      $transaksi_stok['kode_transaksi'] = $data['kode_penjualan'];
      $transaksi_stok['kode_bahan'] = $daftar->kode_menu;
      $transaksi_stok['nama_bahan'] = $daftar->nama_menu;
      $transaksi_stok['stok_keluar'] = $daftar->jumlah;
      $transaksi_stok['hpp'] = $daftar->hpp;
                #$transaksi_stok['sisa_stok'] = $daftar->jumlah_konversi;
      $transaksi_stok['id_petugas'] = $id_petugas;
      $transaksi_stok['nama_petugas'] = $nama_petugas;
      $transaksi_stok['tanggal_transaksi'] = date('Y-m-d');
      $transaksi_stok['posisi_awal'] = 'gudang';
      $transaksi_stok['posisi_akhir'] = 'costumer';

      $this->db->insert('transaksi_stok',$transaksi_stok);
    } else {

    }
    
  }
  //$this->db->group_by('kode_meja');
  $get_pesanan_transaksi = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
  $hasil_pesanan_transaksi = $get_pesanan_transaksi->row();

  $get_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan));
  $hasil_get_penjualan = $get_penjualan->row();
  $total_get_penjualan = count($hasil_get_penjualan);

  if ($total_get_penjualan <= 0) {
    //foreach($hasil_pesanan_transaksi as $simpan){
    //$transaksi['kode_meja'] = $simpan->kode_meja;
    $transaksi['kode_penjualan'] = $data['kode_penjualan'];
    $transaksi['tanggal_penjualan'] = date("Y-m-d");
    $transaksi['diskon_persen'] = $data['persen'];
    $transaksi['diskon_rupiah'] = $data['rupiah'];
    $transaksi['total_nominal'] = $data['total_pesanan'];
    $transaksi['grand_total'] = $data['grand_total'];
    $transaksi['proses_pembayaran'] = $data['jenis_transaksi'];
    $transaksi['bayar'] = $data['bayar'];
    if($data['jenis_transaksi']=="kredit"){
      $transaksi['hutang'] = $data['grand_total'] - $data['bayar'];
    }else{
      $transaksi['kembalian'] = $data['bayar'] - $data['grand_total'];
    }
    //$transaksi['kembalian'] = $data['kembalian'];
    $transaksi['id_petugas'] = $id_petugas;
    $transaksi['petugas'] = $nama_petugas;
    $transaksi['kode_kasir'] = $hasil_pesanan_transaksi->kode_kasir;
    //$transaksi['kode_member'] = $data['kode_member'];
    //$transaksi['nama_member'] = $data['nama_member'];
    $this->db->insert('transaksi_penjualan',$transaksi);

  //}
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
      $piutang['kode_customer'] = @$data['kode_member'];
      $piutang['nama_customer'] = @$data['nama_member'];
      $piutang['nominal_piutang'] = $data['grand_total'] - $data['bayar'];
      $piutang['sisa'] = $data['grand_total'] - $data['bayar'];
      $piutang['tanggal_transaksi'] = date("Y-m-d");
      $piutang['petugas'] = $nama_petugas;
      $this->db->insert('transaksi_piutang',$piutang);
    }
  }
  $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
} else {

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
        $pesanan['status_menu'] = $daftar->status_menu;
                    #$pesanan['kode_kasir'] = $daftar->kode_kasir;
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
  $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_menu'=>$hasil_cek->kode_menu, 'kode_penjualan'=>$hasil_cek->kode_penjualan));
  $hasil_cek_gabung = $cek_gabung->result();

  foreach($hasil_cek_gabung as $hapus){
    $cek_menu = $this->db->get_where('master_menu',array('kode_menu'=>$hapus->kode_menu));
    $hasil_cek_menu = $cek_menu->row();
    if($hasil_cek_menu->status_menu=="reguler"){

    }
    else if($hasil_cek_menu->status_menu=="tambahan"){

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
                  //$no_meja = $this->input->post('no_meja');
                  $kode_penjualan = $this->input->post('kode_penjualan');
                  $this->db->select_sum('subtotal','total');
                  $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
                  $hasil = $get_total->row();
                  $hasil_total = array("total"=>format_rupiah($hasil->total),"total2"=>$hasil->total);
                  echo json_encode($hasil_total);
                }
                public function diskon_persen(){
                  //$no_meja = $this->input->post('no_meja');
                  $kode_penjualan = $this->input->post('kode_penjualan');
                  $diskon = $this->input->post('diskon_persen');
                  $this->db->select_sum('subtotal','total');
                  $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
                  $hasil = $get_total->row();
                  echo $hasil->total;     
                }
                public function diskon_persen_personal(){
                  $no_meja = $this->input->post('no_meja');
                  $diskon = $this->input->post('diskon_persen');
                  $this->db->select_sum('subtotal','total');
                  $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$no_meja,'status'=>'personal'));
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
                  //$no_meja = $this->input->post('no_meja');
                  $kode_penjualan = $this->input->post('kode_penjualan');
                  $this->db->select_sum('subtotal','total');
                  $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
                  $hasil = $get_total->row();
                  $total_grand = $hasil->total-$rupiah;
                  $totalnya = array('total_grand'=>format_rupiah($total_grand),'total_no'=>$total_grand);
                  echo json_encode($totalnya);
                }
                public function kembalian(){
                  $dibayar = $this->input->post('dibayar');
                  $total = $this->input->post('total');
                  $hasil = $dibayar-$total;
                  $hasil_hutang = abs($dibayar-$total);
                  $hasil_kembalian = array("kembalian1"=>format_rupiah($hasil),"kembalian2"=>$hasil,"hutang1"=>format_rupiah($hasil_hutang),"hutang2"=>$hasil_hutang);
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
                        $pesanan['keterangan'] = $daftar->keterangan;
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
                        $pesanan['keterangan'] = $pesanku->keterangan;
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
                        $update['keterangan'] = $diupdate->keterangan;
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
                  $menu = $this->db->get_where('master_menu',array('kode_menu'=>$reservasi['kode_menu']));
                  $hasil_menu = $menu->row();
                  $reservasi['kategori_menu'] = $hasil_menu->kategori_menu;
                  $reservasi['nama_menu'] = $hasil_menu->nama_menu;
                  $reservasi['kode_satuan'] = $hasil_menu->kode_satuan_stok;
                  $reservasi['nama_satuan'] = $hasil_menu->satuan_stok;
                  $harga_diskon = ($reservasi['harga_satuan'] * $reservasi['diskon_item'])/100;
                  $reservasi['harga_satuan'] = $reservasi['harga_satuan'] - $harga_diskon;
                  $subtotal = $reservasi['jumlah']*$reservasi['harga_satuan'];
                  $reservasi['subtotal'] = $subtotal;
                  $reservasi['diskon_item'] = $reservasi['diskon_item'];
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
                    $penjualan['keterangan'] = $dipesan->keterangan;
                    $this->db->insert('opsi_transaksi_penjualan_temp',$penjualan);
                    $this->db->group_by('no_meja');
                    $meja = $this->db->get_where('master_meja',array('no_meja'=>$dipesan->kode_meja));
                    $hasil_meja = $meja->row();
                    $update['status'] = '1';
                    $no_meja = $hasil_meja->no_meja;
                    $this->db->update('master_meja',$update,array('no_meja'=>$no_meja));
                    $cek_status_menu = $this->db->get_where('master_menu',array('kode_menu'=>$dipesan->kode_menu));
                    $hasil_status = $cek_status_menu->row();

                    $mejaku = $dipesan->kode_meja;
                  }

                  $this->db->delete('opsi_transaksi_reservasi',array('kode_reservasi'=>$kode_reservasi));
                  echo $mejaku;
                }

   /* public function cetak_bill()
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
		$Data .= align_center($cnt,"TAGIHAN")."\n";
		$Data .= "\n";

		/*if (isset($idmember) && $idmember!='') {
			$Data .= "Kode MEMBER : ".$idmember."\n";
			$Data .= "Nama MEMBER : ".$member->name."\n";
			$Data .= "Alamat : ".$member->address."\n\n\n";
		}

		$Data .= "TANGGAL  : ".tanggalIndo(date("Y-m-d"))."\n";
		$Data .= "MEJA     : ".$hasil_pesanan->kode_meja."\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
        $hasil_menu = $menu->result();
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_left(11,"Menu")."".align_left(2,"Jumlah")."  ".align_left(6,"Harga")." ".align_right(10,"Subtotal")."\n";
		$Data .= cetak_garis($cnt)."\n";
		  foreach ($hasil_menu as $daftar) {
			$Data .= align_left(11,$daftar->nama_menu)." ".align_left(2,$daftar->jumlah)."  ".align_left(6,$daftar->harga_satuan).align_right(10,$daftar->subtotal)."\n";
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
	}*/

   /* public function cetak_pesanan()
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
		}

		$Data .= "TANGGAL  : ".tanggalIndo(date("Y-m-d"))."\n";
		$Data .= "MEJA     : ".$hasil_pesanan->kode_meja."\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
        $hasil_menu = $menu->result();
		$Data .= cetak_garis($cnt)."\n";
		$Data .= align_left(20,"Menu")."".align_left(20,"Jumlah");
		$Data .= cetak_garis($cnt)."\n";
		  foreach ($hasil_menu as $daftar) {
			$Data .= align_left(20,$daftar->nama_menu)."  ".align_left(20,$daftar->jumlah);
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
	} */

  public function cetak_bill()
  {
    $kode_meja = $this->input->post('kode_meja');
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
    $hasil_pesanan = $pesanan->row();

		#$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

    /* text */  
    $printTestText =  "                $hasil_setting->nama_resto        \n";
    $printTestText .= "              $hasil_setting->alamat_resto      \n";
		// $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
    $printTestText .= "               $hasil_setting->telp_resto      \n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "               GUEST BILL                    \n";                                     

    $printTestText .= "\n";
    $printTestText .= "Inv. ID : ".$hasil_pesanan->kode_penjualan."\n";
    $printTestText .= "Tanggal    : ".TanggalIndo(date('Y-m-d'))."\n";
		#$printTestText .= "Payment : ".$hasil[0]->status."\n";
    $printTestText .= "Meja    : ".$hasil_pesanan->kode_meja."\n";
    $get_id_petugas = $this->session->userdata('astrosession');
    $id_petugas = $get_id_petugas->id;
    $nama_petugas = $get_id_petugas->uname;
    $printTestText .= "Kasir : ".$nama_petugas."\n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "Menu          Harga   Jml   Diskon   Subtotal\n";
    $printTestText .= "---------------------------------------------\n";

    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
    $hasil_menu = $menu->result();

    foreach ($hasil_menu as $daftar) {

     $lenset = 12;
     $lennama_produk = strlen($daftar->nama_menu);
     $len = $lenset<=$lennama_produk?$lenset:$lennama_produk;
     $lenspace = 12-$len;
     $nama_produk=substr($daftar->nama_menu, 0, $lenset);
     $space="";
     for ($i=0; $i < $lenspace; $i++) { 
      $space.=' ';
    }
			//System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
			//$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);			

    $printTestText .= $nama_produk." ".$daftar->keterangan.$space." ".$daftar->harga_satuan." ".$space." ".$daftar->jumlah." ".$space." ".$daftar->diskon_item."%"." ".$space." ".$daftar->subtotal."\n";
  }

  $printTestText .= "---------------------------------------------\n";
		#$printTestText .= "Detail Pembayaran\n";
  $total = 0;
  foreach($hasil_menu as $totalan){
    $total += $totalan->subtotal;
  }
  $printTestText .= "Total	: ".format_rupiah($total)."\n";
		/*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
		$printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
	 	 // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
	$printTestText .= "----------------------------------------\n";
		$printTestText .= "               Terima Kasih             \n";
		$printTestText .= "        Barang yang sudah dibeli        \n";
		$printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
		 // $printTestText .= " ".$footer."    \n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";*/


		// /* tulis dan buka koneksi ke printer */    
		// $printer = printer_open("SP-POS76II");  
		// /* write the text to the print job */ 
		// printer_set_option($handle, PRINTER_MODE, "RAW"); 
		// printer_write($printer, $printTestText);   
		// /* close the connection */ 
		// printer_close($printer); 
		 //$handle = printer_open("canon_ip2700_series");

		$handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		#$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
		#printer_select_font($handle, $font);
		printer_write($handle, $printTestText); 
		printer_close($handle);
			 // print_r($printTestText);exit;
	}

  public function cetak_pesanan() {
    $kode_meja = $this->input->post('kode_meja');
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$kode_meja));
    $hasil_pesanan = $pesanan->row();

		#$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

    /* text */  
    $printTestText =  "                $hasil_setting->nama_resto        \n";
    $printTestText .= "              $hasil_setting->alamat_resto      \n";
		// $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
    $printTestText .= "               $hasil_setting->telp_resto      \n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "                  LIST ORDER                 \n";                                     

    $printTestText .= "\n";
    $printTestText .= "Inv. ID    : ".$hasil_pesanan->kode_pembelian."\n";
    $printTestText .= "Tanggal    : ".TanggalIndo(date('Y-m-d'))."\n";
    $printTestText .= "Meja    : ".$hasil_pesanan->kode_meja."\n";
		#$printTestText .= "Payment : ".$hasil[0]->status."\n";
		#$printTestText .= "Kasir : ".$nama->nama."\n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "Nama Menu                Jumlah              \n";
    $printTestText .= "---------------------------------------------\n";

    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$hasil_pesanan->kode_meja));
    $hasil_menu = $menu->result();

    foreach ($hasil_menu as $daftar) {

     $lenset = 25;
     $lennama_produk = strlen($daftar->nama_menu);
     $len = $lenset<=$lennama_produk?$lenset:$lennama_produk;
     $lenspace = 23-$len;
     $nama_produk=substr($daftar->nama_menu, 0, $lenset);;
     $space="";
     for ($i=0; $i < $lenspace; $i++) { 
      $space.=' ';
    }
			//System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
			//$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);			

    $printTestText .= $nama_produk." ".$daftar->keterangan." ".$space." ".$daftar->jumlah."\n";
  }

  $printTestText .= "---------------------------------------------\n";
	/*	$printTestText .= "Detail Pembayaran\n";
		$printTestText .= "Total	: Rp. ".$hasil[0]->total.",-\n";
		$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
		$printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
	 	 // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
		$printTestText .= "----------------------------------------\n";
		$printTestText .= "               Terima Kasih             \n";
		$printTestText .= "        Barang yang sudah dibeli        \n";
		$printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
		 // $printTestText .= " ".$footer."    \n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";*/


		// /* tulis dan buka koneksi ke printer */    
		// $printer = printer_open("SP-POS76II");  
		// /* write the text to the print job */ 
		// printer_set_option($handle, PRINTER_MODE, "RAW"); 
		// printer_write($printer, $printTestText);   
		// /* close the connection */ 
		// printer_close($printer); 
		 //$handle = printer_open("canon_ip2700_series");

		$handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
		printer_select_font($handle, $font);
		printer_write($handle, $printTestText); 
		printer_close($handle);
			 // print_r($printTestText);exit;
	}

  public function cetak_pembayaran(){
    //$kode_meja = $this->input->post('kode_meja');
    $kode_penjualan = $this->input->post('kode_penjualan');
    $jenis_bayar = $this->input->post('jenis_transaksi');
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    //$pesanan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_meja'=>$kode_meja,'kode_penjualan'=>$kode_penjualan));
    $pesanan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan));
    $hasil_pesanan = $pesanan->row();

		#$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

    /* text */  
    $printTestText =  "                $hasil_setting->nama_resto        \n";
    $printTestText .= "              $hasil_setting->alamat_resto      \n";
		// $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
    $printTestText .= "               $hasil_setting->telp_resto      \n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "                NOTA PEMBAYARAN                    \n";                                     

    $printTestText .= "\n";
    $printTestText .= "Inv. ID    : ".$hasil_pesanan->kode_penjualan."\n";
    $printTestText .= "Tanggal    : ".TanggalIndo(date('Y-m-d'))."\n";
    $printTestText .= "Payment    : ".$jenis_bayar."\n";
    $get_id_petugas = $this->session->userdata('astrosession');
    $id_petugas = $get_id_petugas->id;
    $nama_petugas = $get_id_petugas->uname;
    $printTestText .= "Kasir      : ".$nama_petugas."\n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "Nama          Harga   Jml  Diskon    Subtotal\n";
    $printTestText .= "---------------------------------------------\n";

    //$menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_meja'=>$kode_meja,'kode_penjualan'=>$kode_penjualan));
    $menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan));
    $hasil_menu = $menu->result();

    foreach ($hasil_menu as $daftar) {

     $lenset = 12;
     $lennama_produk = strlen($daftar->nama_menu);
     $len = $lenset<=$lennama_produk?$lenset:$lennama_produk;
     $lenspace = 12-$len;
     $nama_produk=substr($daftar->nama_menu, 0, $lenset);
     $space="";
     for ($i=0; $i < $lenspace; $i++) { 
      $space.=' ';
    }
			//System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
			//$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);			

    $printTestText .= bill_php_Left($daftar->nama_menu, 12).bill_php_right($daftar->harga_satuan,7).bill_php_right($daftar->jumlah, 6).bill_php_right($daftar->diskon_item, 7)."%".bill_php_right($daftar->subtotal, 12)."\n";
  }

  $printTestText .= "---------------------------------------------\n";
  $printTestText .= "Detail Pembayaran\n";
  $penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan));
  $hasil_penjualan = $penjualan->row();
  $printTestText .= "Total           : ".format_rupiah($hasil_penjualan->total_nominal)."\n";
  $printTestText .= "Diskon          : ".format_rupiah($hasil_penjualan->diskon_rupiah)."\n";
  $printTestText .= "Grand Total	: ".format_rupiah($hasil_penjualan->grand_total)."\n";
  $printTestText .= "Bayar    	: ".format_rupiah($hasil_penjualan->bayar)."\n";
  $printTestText .= "Kembali  	: ".format_rupiah($hasil_penjualan->kembalian)."\n";
  $printTestText .= "---------------------------------------------\n";
  $printTestText .= "                   Terima Kasih             \n";
  $printTestText .= "        Barang yang sudah dibeli        \n";
  $printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
  $printTestText .= "\n";
		/*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
		$printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
	 	 // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
	
		$printTestText .= "               Terima Kasih             \n";
		$printTestText .= "        Barang yang sudah dibeli        \n";
		$printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
		 // $printTestText .= " ".$footer."    \n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";*/


		// /* tulis dan buka koneksi ke printer */    
		// $printer = printer_open("SP-POS76II");  
		// /* write the text to the print job */ 
		// printer_set_option($handle, PRINTER_MODE, "RAW"); 
		// printer_write($printer, $printTestText);   
		// /* close the connection */ 
		// printer_close($printer); 
		 //$handle = printer_open("canon_ip2700_series");

		$handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		#$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
		#printer_select_font($handle, $font);
		printer_write($handle, $printTestText); 
		printer_close($handle);
			 // print_r($printTestText);exit;
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
    if($masukan['jumlah'] > $masukan['qty']){
      echo "tidak";
    }else{
      unset($masukan['qty']);
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
       $harga_diskon = ($masukan['harga_satuan'] * $masukan['diskon_item'])/100;
       $masukan['harga_satuan'] = $masukan['harga_satuan'] - $harga_diskon;
       $subtotal = $masukan['jumlah']*$masukan['harga_satuan'];
       $masukan['subtotal'] = $subtotal;
       $masukan['status'] = 'personal';
       $masukan['status_menu'] = $hasil_getmenu->status_menu;
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
        $harga_diskon = ($masukan['harga_satuan'] * $masukan['diskon_item'])/100;
        $digabung['harga_satuan'] = $masukan['harga_satuan'] - $harga_diskon;
                        #$digabung['harga_satuan'] = $masukan['harga_satuan'];
        $digabung['diskon_item'] = $masukan['diskon_item'];
        $digabung['kategori_menu'] = $hasil_getmenu->kategori_menu;
        $digabung['nama_menu'] = $hasil_getmenu->nama_menu;
        $digabung['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
        $digabung['nama_satuan'] = $hasil_getmenu->satuan_stok;
        $subtotal = $masukan['jumlah']*$masukan['harga_satuan'];
        $digabung['subtotal'] = $subtotal;
        $digabung['status'] = 'personal';
        $digabung['status_menu'] = $hasil_getmenu->status_menu;

        $this->db->insert('opsi_transaksi_penjualan_temp',$digabung);
                        #echo $this->db->last_query();
        

      }
      $kode_menu = $masukan['kode_menu'];
      $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$masukan['kode_penjualan'],
        'status !='=>'personal','kode_menu'=>$kode_menu));
      $hasil_menu = $menu->result();
      foreach($hasil_menu as $dft){
        $update['jumlah'] = $dft->jumlah - $masukan['jumlah'];
        $update['subtotal'] = $dft->subtotal - ($dft->harga_satuan * $masukan['jumlah']);
        $this->db->update('opsi_transaksi_penjualan_temp',$update,array('kode_penjualan'=>$masukan['kode_penjualan'],
          'status !='=>'personal','kode_menu'=>$kode_menu));
      }
                    #$menu = $this->db->get_where('');

                        #echo $this->db->last_query();

    }

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

  }
  $this->db->group_by('kode_menu');
  $menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('status !='=>'personal','kode_menu'=>$hasil_cek->kode_menu,'kode_penjualan'=>$hasil_cek->kode_penjualan));
  $hasil_menu = $menu->row();
  $update['jumlah'] = $hasil_cek->jumlah+$hasil_menu->jumlah;
  $update['subtotal'] = ($hasil_cek->jumlah+$hasil_menu->jumlah)*$hasil_menu->harga_satuan;

  $this->db->update('opsi_transaksi_penjualan_temp',$update,array('status !='=>'personal','kode_penjualan'=>$hasil_menu->kode_penjualan,'kode_menu'=>$hasil_menu->kode_menu));


}

public function simpan_pembayaran_personal(){
  $data = $this->input->post();
  $kode_penjualan = $data['kode_penjualan'];
  $cek_personal = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan,'status'=>'personal'));
  $hasil_personal = $cek_personal->result_array();
       #$this->db->group_by('kode_meja');
  foreach($hasil_personal as $daftar){
    $masukkan['kode_penjualan'] = $daftar['kode_penjualan'];
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
    $masukkan['kode_kasir'] = $data['kode_kasir'];
    $masukkan['status'] = 'personal';
    $masukkan['waiter'] = $data['waiter'];
    $masukkan['status_menu'] = 'reguler';
    $masukkan['tanggal_transaksi'] = date("Y-m-d");
    $masukkan['keterangan'] = $daftar['keterangan'];
    $this->db->insert('opsi_transaksi_penjualan',$masukkan);
    $cek_menu = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_meja'=>$daftar['kode_meja'],
      'kode_menu'=>$daftar['kode_menu'],'kode_penjualan'=>$daftar['kode_penjualan'],
      'jumlah'=>'0','status !='=>'personal'));
    $hasil_menu = $cek_menu->result();
    foreach($hasil_menu as $dihapus){

      $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$dihapus->kode_penjualan,
        'jumlah'=>0,'status !='=>'personal'));

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
  $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan,'status'=>'personal'));
       #echo $this->db->last_query();

}

public function cetak_pembayaran_personal(){
  $kode_meja = $this->input->post('kode_meja');
  $kode_penjualan = $this->input->post('kode_penjualan');
  $jenis_bayar = $this->input->post('jenis_transaksi');
  $setting = $this->db->get('master_setting');
  $hasil_setting = $setting->row();
  $pesanan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_meja'=>$kode_meja,'kode_penjualan'=>$kode_penjualan,
    'status'=>'personal'));
  $hasil_pesanan = $pesanan->row();

		#$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

  /* text */  
  $printTestText =  "                $hasil_setting->nama_resto        \n";
  $printTestText .= "              $hasil_setting->alamat_resto      \n";
		// $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
  $printTestText .= "               $hasil_setting->telp_resto      \n";
  $printTestText .= "---------------------------------------------\n";
  $printTestText .= "               BILL PERSONAL                 \n";                                     

  $printTestText .= "\n";
  $printTestText .= "Inv. ID    : ".$hasil_pesanan->kode_penjualan."\n";
  $printTestText .= "Tanggal    : ".TanggalIndo(date('Y-m-d'))."\n";
  $printTestText .= "Payment    : ".$jenis_bayar."\n";
  $get_id_petugas = $this->session->userdata('astrosession');
  $id_petugas = $get_id_petugas->id;
  $nama_petugas = $get_id_petugas->uname;
  $printTestText .= "Kasir      : ".$nama_petugas."\n";
  $printTestText .= "Waiter     : ".$hasil_pesanan->waiter."\n";
  $printTestText .= "Meja     : ".$hasil_pesanan->kode_meja."\n";
  $printTestText .= "---------------------------------------------\n";
  $printTestText .= "Menu          Harga   Jml   Diskon   Subtotal\n";
  $printTestText .= "---------------------------------------------\n";

  $menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_meja'=>$kode_meja,'kode_penjualan'=>$kode_penjualan,
    'status'=>'personal'));
  $hasil_menu = $menu->result();

  foreach ($hasil_menu as $daftar) {

   $lenset = 12;
   $lennama_produk = strlen($daftar->nama_menu);
   $len = $lenset<=$lennama_produk?$lenset:$lennama_produk;
   $lenspace = 12-$len;
   $nama_produk=substr($daftar->nama_menu, 0, $lenset);
   $space="";
   for ($i=0; $i < $lenspace; $i++) { 
    $space.=' ';
  }
			//System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
			//$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);			

  $printTestText .= $nama_produk." ".$daftar->keterangan.$space." ".$daftar->harga_satuan." ".$space." ".$daftar->jumlah." ".$space." ".$daftar->diskon_item."%"." ".$space." ".$daftar->subtotal."\n";
}

$printTestText .= "---------------------------------------------\n";
$printTestText .= "Detail Pembayaran\n";
$penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode_penjualan));
$hasil_penjualan = $penjualan->row();
$printTestText .= "Total        : ".format_rupiah($hasil_penjualan->total_nominal)."\n";
$printTestText .= "Diskon       : ".format_rupiah($hasil_penjualan->diskon_rupiah)."\n";
$printTestText .= "Grand Total	: ".format_rupiah($hasil_penjualan->grand_total)."\n";
$printTestText .= "Bayar    	: ".format_rupiah($hasil_penjualan->bayar)."\n";
$printTestText .= "Kembali  	: ".format_rupiah($hasil_penjualan->kembalian)."\n";
$printTestText .= "---------------------------------------------\n";
$printTestText .= "                   Terima Kasih             \n";
		/*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
		$printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
	 	 // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
	
		$printTestText .= "               Terima Kasih             \n";
		$printTestText .= "        Barang yang sudah dibeli        \n";
		$printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
		 // $printTestText .= " ".$footer."    \n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";
		$printTestText .= "\n";*/


		// /* tulis dan buka koneksi ke printer */    
		// $printer = printer_open("SP-POS76II");  
		// /* write the text to the print job */ 
		// printer_set_option($handle, PRINTER_MODE, "RAW"); 
		// printer_write($printer, $printTestText);   
		// /* close the connection */ 
		// printer_close($printer); 
		 //$handle = printer_open("canon_ip2700_series");

		$handle = printer_open($hasil_setting->printer); 
		printer_set_option($handle, PRINTER_MODE, "RAW");
		#$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
		#printer_select_font($handle, $font);
		printer_write($handle, $printTestText); 
		printer_close($handle);
			 // print_r($printTestText);exit;
	}

  public function simpan_item_penjualan_temp()
  {

    $masukan = $this->input->post();

    $jumlah_stok = $this->db->get_where('master_menu',array('kode_menu'=>$masukan['kode_menu']));
    $hasil_jumlah_stok = $jumlah_stok->row();
    $real_stock = $hasil_jumlah_stok->real_stok;

    if ($real_stock < $masukan['jumlah']) {
      echo "tidak cukup";   
    }else{
      $get_produk = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$masukan['kode_penjualan'],'kode_menu'=>$masukan['kode_menu']));
      $hasil_get_produk = $get_produk->result();
      $total_get_produk = count($hasil_get_produk);
      if ($total_get_produk <= 0) {
        if ($masukan['jumlah'] >= 1 && $masukan['jumlah'] <= 3) {
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_1;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_1 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        } else if ($masukan['jumlah'] >= 4 && $masukan['jumlah'] <= 12){
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_2;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_2 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        } else if ($masukan['jumlah'] >= 12){
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_3;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_3 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $masukan['jumlah'] * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        }
        $this->db->insert('opsi_transaksi_penjualan_temp',$masukan);
      } else{
        $produk = $this->db->get_where('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$masukan['kode_penjualan'],'kode_menu'=>$masukan['kode_menu']));
        $hasil_produk = $produk->row();
        $jumlah_produk = $hasil_produk->jumlah + $masukan['jumlah'];

        if ($jumlah_produk >= 1 && $jumlah_produk <= 3) {
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_1;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_1 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        } else if ($jumlah_produk >= 4 && $jumlah_produk <= 12){
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_2;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_2 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        } else if ($jumlah_produk >= 12){
          if ($hasil_jumlah_stok->type_harga == 'nominal') {
            $harga_satuan = $hasil_jumlah_stok->hpp + $hasil_jumlah_stok->harga_3;
          } else {
            $harga_satuan = $hasil_jumlah_stok->hpp + (($hasil_jumlah_stok->harga_3 * $hasil_jumlah_stok->hpp)/100);
          }

          if ($masukan['diskon_item'] == '') {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $masukan['diskon_item'] = '0';
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          } else {
            $masukan['jumlah'] = $jumlah_produk;
            $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
            $masukan['harga_satuan'] = $harga_satuan;
            $total = $jumlah_produk * $harga_satuan;
            $diskon = $total * $masukan['diskon_item']/100;
            $masukan['subtotal'] = $total - $diskon;
            $masukan['hpp'] = $hasil_jumlah_stok->hpp;
          }

        }
        $this->db->update('opsi_transaksi_penjualan_temp',$masukan,array('kode_penjualan'=>$masukan['kode_penjualan'],'kode_menu'=>$masukan['kode_menu']));
      }


      echo "sukses";
    }
  }

  public function hapus_bahan_temp(){
    $kode_penjualan = $this->input->post('kode_penjualan');
    $this->db->delete('opsi_transaksi_penjualan_temp',array('kode_penjualan'=>$kode_penjualan));
  }

}