<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class opname extends MY_Controller {

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
	 *s
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

	public function daftar()
	{
		$data['halaman'] = $this->load->view('setting/daftar', NULL, TRUE);
		$this->load->view ('main', $data);		
	}	

	public function cari_opname()
	{
		$this->load->view ('daftar_opname/cari_opname');		
	}
	public function cari_opname_kitchen()
	{
		$this->load->view ('daftar_opname/cari_opname_kitchen');		
	}
	public function gudang()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/daftar_opname_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	
	public function detail_mutasi_kitchen()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/detail_opname_kitchen', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function validasi_opname_gudang()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/detail_opname_gudang', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function validasi_opname_kithcen()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/detail_opname_kitchen', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function kitchen()
	{
		$data['aktif'] = 'kitchen';
		$data['konten'] = $this->load->view('daftar_opname/daftar_opname_kitchen', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function bar()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/daftar_opname_bar', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
		$this->load->view ('main', $data);		
	}
	public function server()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('daftar_opname/daftar_opname_server', $data, TRUE);
		$data['halaman'] = $this->load->view('daftar_opname/menu', $data, TRUE);
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
		$data['konten'] = $this->load->view('daftar_stok/detail', $data, TRUE);
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
	public function jangan_sesuaikan_kitchen()
    {
        $param = $this->input->post();
        $kode_opname = $param['kode_opname'];

		$update['validasi'] = 'confirmed';
        $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));
        echo '<div class="alert alert-success">Berhasil, tidak menyesuaikan stok opname.</div>';
    }
	public function sesuaikan_kitchen()
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
    public function jangan_sesuaikan_gudang()
    {
        $param = $this->input->post();
        $kode_opname = $param['kode_opname'];

		$update['validasi'] = 'confirmed';
        $this->db->update('transaksi_opname',$update,array('kode_opname'=>$param['kode_opname']));
        echo '<div class="alert alert-success">Berhasil, tidak menyesuaikan stok opname.</div>';
    }
    public function sesuaikan_gudang()
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
    
}
