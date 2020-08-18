<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piutang extends MY_Controller {

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
    
	public function daftar_piutang()
	{
	   $data['aktif'] = 'hutang_piutang';
        $data['konten'] = $this->load->view('hutang_piutang/piutang/daftar_piutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
        $this->load->view('main', $data);
       
	   	
	}
	public function cari_piutang()
	{
        $this->load->view('hutang_piutang/piutang/cari_piutang');   	
	}
	public function cari_daftar_piutang()
	{
        $this->load->view('hutang_piutang/piutang/cari_daftar_piutang');   	
	}
	
	public function daftar_piutang_belum_lunas()
	{
        $data['aktif'] = 'hutang_piutang';
		$data['konten'] = $this->load->view('hutang_piutang/piutang/daftar_piutang', NULL, TRUE);
		$this->load->view ('main', $data);		
	}
    
    public function detail($kode)
	{
	   $data['aktif'] = 'hutang_piutang';
       $data['kode'] = $kode;
        $data['konten'] = $this->load->view('hutang_piutang/piutang/detail_piutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
        $this->load->view('main', $data);
       
	    	
	}

	public function detail_cari($kode)
	{
	   $data['aktif'] = 'hutang_piutang';
       $data['kode'] = $kode;
        $data['konten'] = $this->load->view('hutang_piutang/piutang/detail_piutang_cari', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
        $this->load->view('main', $data);
       
	    	
	}

	public function detail_daftar($kode)
    {
        @$uriseg = $this->uri->segment(4);
        if($uriseg=='detail'){
            $data['aktif'] = 'hutang_piutang';
            $data['kode'] = $kode;
            $data['konten'] = $this->load->view('hutang_piutang/piutang/detail_piutang', $data, true);
            $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
            $this->load->view('main', $data);
        } else if($uriseg=='proses'){
            $data['aktif'] = 'hutang_piutang';
            $data['kode'] = $kode;
            $data['konten'] = $this->load->view('hutang_piutang/piutang/proses_piutang', $data, true);
            $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
            $this->load->view('main', $data);
        } else{
            $data['aktif'] = 'hutang_piutang';
            $data['kode'] = $kode;
            $data['konten'] = $this->load->view('hutang_piutang/piutang/detail_daftar_piutang', $data, true);
            $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
            $this->load->view('main', $data);

        }
    }

	/*public function proses($kode)
    {
        $data['aktif'] = 'hutang_piutang';
       $data['kode'] = $kode;
        $data['konten'] = $this->load->view('hutang_piutang/piutang/proses_piutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/piutang/menu', $data, true);
        $this->load->view('main', $data);
        
           
    }*/


	//------------------------------------------ Proses ----------------- --------------------//

    public function get_rupiah(){
        $angsuran = $this->input->post('angsuran');
        $hasil = format_rupiah($angsuran);
	    
	    echo $hasil;
        
    }

    public function simpan_piutang()
	{
	   $kode_transaksi = $this->input->post('kode_transaksi');
	   $sisa = $this->input->post('sisa');
	   $angsuran = $this->input->post('angsuran');
       if($angsuran > $sisa){
            echo '<div style="font-size:1.5em" class="alert alert-danger">Angsuran Lebih Besar Dari Sisa.</div>';
       }else{
                $query = $this->db->get_where('transaksi_piutang',array('kode_transaksi' => $kode_transaksi) )->row();
    	   $cek_angsuran = $query->angsuran;
    	   $cek_nominal = $query->nominal_piutang;
            
            	$opsi['kode_transaksi'] = $kode_transaksi ;
    	   		$opsi['angsuran'] = $angsuran ;
    	   		$opsi['tanggal_angsuran'] = date("Y-m-d") ;
    	   		$this->db->insert('opsi_piutang',$opsi);

    	   			$this->db->select('*') ;
					$query_akun = $this->db->get_where('keuangan_sub_kategori_akun',array('kode_sub_kategori_akun'=> '1.1.4'))->row();
					$kode_sub = $query_akun->kode_sub_kategori_akun;
		        	$nama_sub = $query_akun->nama_sub_kategori_akun;
		        	$kode_kategori = $query_akun->kode_kategori_akun;
		        	$nama_kategori = $query_akun->nama_kategori_akun;
		        	$kode_jenis = $query_akun->kode_jenis_akun;
		        	$nama_jenis = $query_akun->nama_jenis_akun;

			$get_id_petugas = $this->session->userdata('astrosession');
	        $id_petugas = $get_id_petugas->id;
	        $nama_petugas = $get_id_petugas->uname;
            
    	   if(empty($cek_angsuran)){
    	       $update_hutang['angsuran'] = $angsuran;
    	   		$update_hutang['sisa'] = $cek_nominal - $angsuran ;
    	   		$sukses = $this->db->update('transaksi_piutang', $update_hutang, array('kode_transaksi'=>$kode_transaksi) );

    	   				$data_keu['petugas'] = $nama_petugas ;
						$data_keu['kode_referensi'] = $kode_transaksi ;
						$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
						$data_keu['keterangan'] = 'angsuran penjualan' ;
						$data_keu['nominal'] = $angsuran;
						$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
						$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
						$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
						$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
						$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
						$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
						
						$keuangan = $this->db->insert("keuangan_masuk", $data_keu);

    	   }
    	   else{
    	   		$update_angsuran['angsuran'] = $cek_angsuran + $angsuran;
    	   		$this->db->update('transaksi_piutang', $update_angsuran,  array('kode_transaksi'=>$kode_transaksi) );
    
    	   		$query_angsuran = $this->db->get_where('transaksi_piutang',array('kode_transaksi' => $kode_transaksi) )->row()->angsuran;
    	   		$update_sisa['sisa'] = $cek_nominal - $query_angsuran ;
    	   		$sukses = $this->db->update('transaksi_piutang', $update_sisa,  array('kode_transaksi'=>$kode_transaksi) );
    	   		
    	   				$data_keu['petugas'] = $nama_petugas ;
						$data_keu['kode_referensi'] = $kode_transaksi ;
						$data_keu['tanggal_transaksi'] = date("Y-m-d") ;
						$data_keu['keterangan'] = 'angsuran penjualan' ;
						$data_keu['nominal'] = $angsuran;
						$data_keu['kode_jenis_keuangan'] = $kode_jenis ;
						$data_keu['nama_jenis_keuangan'] = $nama_jenis ;
						$data_keu['kode_kategori_keuangan'] = $kode_kategori ;
						$data_keu['nama_kategori_keuangan'] = $nama_kategori ;
						$data_keu['kode_sub_kategori_keuangan'] = $kode_sub ;
						$data_keu['nama_sub_kategori_keuangan'] = $nama_sub ;
						
						$keuangan = $this->db->insert("keuangan_masuk", $data_keu);
    	   }
    
    	    if($sukses){
    	    	echo 1;
    	   	} 		
       }
	   		
	}

	
	
}
