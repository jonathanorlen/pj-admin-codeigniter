<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends MY_Controller
{

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
        if ($this->session->userdata('astrosession') == false) {
            redirect(base_url('authenticate'));
        }
        $this->load->library('form_validation');
    }

    //------------------------------------------ View Data Table----------------- --------------------//

    public function daftar_hutang()
    {
        $data['aktif'] = 'hutang_piutang';
        $data['konten'] = $this->load->view('hutang_piutang/hutang/daftar_hutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
        $this->load->view('main', $data);


    }

    public function daftar_hutang_belum_lunas()
    {
        $data['aktif'] = 'hutang_piutang';
        $data['konten'] = $this->load->view('hutang_piutang/hutang/daftar_hutang', null, true);
        $this->load->view('main', $data);
    }

    public function cari_hutang()
    {
        $this->load->view('hutang_piutang/hutang/cari_hutang');
    }

    public function cari_daftar_hutang()
    {
        $this->load->view('hutang_piutang/hutang/cari_daftar_hutang');
    }


    public function detail($kode)
    {
        $data['aktif'] = 'hutang_piutang';
        $data['kode'] = @$kode;
        $data['konten'] = $this->load->view('hutang_piutang/hutang/detail_hutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
        $this->load->view('main', $data);


    }
    public function detail_cari($kode)
    {
        $data['aktif'] = 'hutang_piutang';
        $data['kode'] = @$kode;
        $data['konten'] = $this->load->view('hutang_piutang/hutang/detail_hutang_cari', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
        $this->load->view('main', $data);


    }

    public function detail_daftar($kode)
    {
        @$uriseg = $this->uri->segment(4);
        if(@$uriseg=='detail'){
            @$data['aktif'] = 'hutang_piutang';
            @$data['kode'] = @$kode;
            @$data['konten'] = $this->load->view('hutang_piutang/hutang/detail_hutang', $data, true);
            @$data[@'halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
            $this->load->view('main', $data);
        } else if(@$uriseg=='proses'){
            @$data['aktif'] = 'hutang_piutang';
            @$data['kode'] = @$kode;
            @$data['konten'] = $this->load->view('hutang_piutang/hutang/proses_hutang', $data, true);
            @$data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
            $this->load->view('main', $data);
        } else{
            @$data['aktif'] = 'hutang_piutang';
            @$data['kode'] = @$kode;
            @$data['konten'] = $this->load->view('hutang_piutang/hutang/detail_daftar_hutang', $data, true);
            @$data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
            $this->load->view('main', $data);

        }
    }

    /*public function proses($kode)
    {
        $data['aktif'] = 'hutang_piutang';
        $data['kode'] = $kode;
        $data['konten'] = $this->load->view('hutang_piutang/hutang/proses_hutang', $data, true);
        $data['halaman'] = $this->load->view('hutang_piutang/hutang/menu', $data, true);
        $this->load->view('main', $data);


    }*/


    //------------------------------------------ Proses ----------------- --------------------//

    public function get_rupiah()
    {
        $angsuran = $this->input->post('angsuran');
        $hasil = format_rupiah($angsuran);

        echo $hasil;

    }
    public function get_potongan()
    {
        $potongan = $this->input->post('potongan_hutang');
        $hasil = format_rupiah($potongan);

        echo $hasil;

    }

    public function cek_sisa()
    {
        $kode_transaksi = $this->input->post('kode_transaksi');
        $transaksi_hutang = $this->db->get_where('transaksi_hutang', array('kode_transaksi' =>
            $kode_transaksi));
        $hasil_transaksi_hutang = $transaksi_hutang->row();
        $sisa = $hasil_transaksi_hutang->sisa;

        echo $sisa;

    }

    public function simpan_hutang()
    {
        $kode_transaksi = $this->input->post('kode_transaksi');
        $angsuran = $this->input->post('angsuran');
        $potongan_hutang = $this->input->post('potongan_hutang');
        $jenis_transaksi = $this->input->post('jenis_transaksi');

        $transaksi_hutang = $this->db->get_where('transaksi_hutang', array('kode_transaksi' =>
            $kode_transaksi));
        $hasil_transaksi_hutang = $transaksi_hutang->row();
        $sisa = $hasil_transaksi_hutang->sisa;
        //echo $this->db->last_query();

        // if ($angsuran > $sisa) {
        //     echo '<div style="font-size:1.5em" class="alert alert-danger">angsuran lebih besar dari sisa.</div>';
        // } else {


        $query = $this->db->get_where('transaksi_hutang', array('kode_transaksi' => $kode_transaksi))->
        row();
        $cek_angsuran = $query->angsuran;
        $cek_potongan_hutang = $query->potongan_hutang;
        $cek_nominal = $query->nominal_hutang;

        if($jenis_transaksi=='Transfer'){
            $this->db->select('*');
            $query_akun = $this->db->get_where('keuangan_sub_kategori_akun', array('kode_sub_kategori_akun' =>
                '2.1.5'))->row();        
        }else if ($jenis_transaksi=='Cash') {
           $this->db->select('*');
           $query_akun = $this->db->get_where('keuangan_sub_kategori_akun', array('kode_sub_kategori_akun' =>
            '2.1.4'))->row();   
       }

       $kode_sub = $query_akun->kode_sub_kategori_akun;
       $nama_sub = $query_akun->nama_sub_kategori_akun;
       $kode_kategori = $query_akun->kode_kategori_akun;
       $nama_kategori = $query_akun->nama_kategori_akun;
       $kode_jenis = $query_akun->kode_jenis_akun;
       $nama_jenis = $query_akun->nama_jenis_akun;

       $get_id_petugas = $this->session->userdata('astrosession');
       $id_petugas = $get_id_petugas->id;
       $nama_petugas = $get_id_petugas->uname;

       if (empty($cek_angsuran)) {

        if($angsuran){

            $opsi['kode_transaksi'] = $kode_transaksi;
            $opsi['angsuran'] = $angsuran;
            $opsi['tanggal_angsuran'] = date("Y-m-d");
            $this->db->insert('opsi_hutang', $opsi);
        }
        $update_hutang['angsuran'] = $angsuran;
        $update_hutang['potongan_hutang'] = $potongan_hutang;
        if ($angsuran > $sisa) {
            $update_hutang['sisa'] = '0';
        }else{
            $potongan = $cek_nominal - $potongan_hutang;
            $update_hutang['sisa'] = $potongan - $angsuran;
        }
        $sukses = $this->db->update('transaksi_hutang', $update_hutang, array('kode_transaksi' =>
            $kode_transaksi));
        if($angsuran){

            $data_keu['petugas'] = $nama_petugas;
            $data_keu['kode_referensi'] = $kode_transaksi;
            $data_keu['tanggal_transaksi'] = date("Y-m-d");
            $data_keu['keterangan'] = 'angsuran pembelian';
            $data_keu['nominal'] = $angsuran;
            $data_keu['kode_jenis_keuangan'] = $kode_jenis;
            $data_keu['nama_jenis_keuangan'] = $nama_jenis;
            $data_keu['kode_kategori_keuangan'] = $kode_kategori;
            $data_keu['nama_kategori_keuangan'] = $nama_kategori;
            $data_keu['kode_sub_kategori_keuangan'] = $kode_sub;
            $data_keu['nama_sub_kategori_keuangan'] = $nama_sub;

            $keuangan = $this->db->insert("keuangan_keluar", $data_keu);
        }
    } else {
        if($angsuran){

        $opsi['kode_transaksi'] = $kode_transaksi;
        $opsi['angsuran'] = $angsuran;
        $opsi['tanggal_angsuran'] = date("Y-m-d");
        $this->db->insert('opsi_hutang', $opsi);
        }



        $update_angsuran['angsuran'] = $cek_angsuran + $angsuran;
        if ($potongan_hutang) {
            $update_angsuran['potongan_hutang'] = $cek_potongan_hutang + $potongan_hutang;
        }
        $this->db->update('transaksi_hutang', $update_angsuran, array('kode_transaksi' =>
            $kode_transaksi));

        // $query_angsuran = $this->db->get_where('transaksi_hutang', array('kode_transaksi' =>
        //     $kode_transaksi))->row()->angsuran;
        $sisa_hutang = $this->db->get_where('transaksi_hutang', array('kode_transaksi' =>
            $kode_transaksi))->row()->sisa;

        if ($angsuran > $sisa) {
            $update_sisa['sisa'] = '0';
        }else{
            if($potongan_hutang){
                
                $sisa_angsuran = $sisa_hutang - $angsuran;
                $update_sisa['sisa'] = $sisa_angsuran - $potongan_hutang;

            }else{

                
                $update_sisa['sisa'] = $sisa_hutang - $angsuran;
            }
        }

        $sukses = $this->db->update('transaksi_hutang', $update_sisa, array('kode_transaksi' =>
            $kode_transaksi));
        if ($angsuran) {

            $data_keu['petugas'] = $nama_petugas;
            $data_keu['kode_referensi'] = $kode_transaksi;
            $data_keu['tanggal_transaksi'] = date("Y-m-d");
            $data_keu['keterangan'] = 'angsuran pembelian';
            $data_keu['nominal'] = $angsuran;
            $data_keu['kode_jenis_keuangan'] = $kode_jenis;
            $data_keu['nama_jenis_keuangan'] = $nama_jenis;
            $data_keu['kode_kategori_keuangan'] = $kode_kategori;
            $data_keu['nama_kategori_keuangan'] = $nama_kategori;
            $data_keu['kode_sub_kategori_keuangan'] = $kode_sub;
            $data_keu['nama_sub_kategori_keuangan'] = $nama_sub;

            $keuangan = $this->db->insert("keuangan_keluar", $data_keu);
        }

    }


    if ($sukses) {
        echo '1';
    }
        // }
}


}
