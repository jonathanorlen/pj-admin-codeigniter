<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reloader extends MY_Controller {


	public function __construct()
	{
		parent::__construct();				
	}



//------------------------------------------------------Reloader------------------------------------------------------------------------->

public function cek_update()
	{

 		$cek_update = $this->db->get('singkronasi');
        $hasil = @$cek_update->result();

        if (!empty($hasil)) {
                echo '+';	
                }        

	}




//------------------------------------------------------penjualan------------------------------------------------------------------------->

	public function input_transaksi_penjualan()
	{

        $transaksi['kode_kasir'] = '-';
        $transaksi['kode_penjualan'] = $this->input->post('kode_penjualan');
        $transaksi['tanggal_penjualan'] = date("Y-m-d");
        $transaksi['jam_penjualan'] = date("H:i:s");
        $transaksi['diskon_persen'] = $this->input->post('persen');
        $transaksi['diskon_rupiah'] = $this->input->post('rupiah');
        $transaksi['total_nominal'] = $this->input->post('total_pesanan');
        $transaksi['grand_total'] = $this->input->post('grand_total');
        $transaksi['jenis_transaksi'] = $this->input->post('jenis_transaksi');
        $transaksi['bayar'] = $this->input->post('bayar');
        $transaksi['kembalian'] = $this->input->post('kembalian');
        $transaksi['id_petugas'] = $this->input->post('id_petugas');
        $transaksi['petugas'] = $this->input->post('nama_petugas');
        $transaksi['kode_member'] = $this->input->post('kode_member');
        $transaksi['nama_member'] = $this->input->post('nama_member');
        $transaksi['status_penerimaan'] = $this->input->post('jenis_penerimaan');
    
        if ($this->input->post('jenis_penerimaan') == "dikirim") {
            $transaksi['status'] = "belum terkirim";
            $transaksi['nama_penerima'] = $this->input->post('penerima');
            $transaksi['no_telp'] = $this->input->post('no_telp');
            $transaksi['alamat_penerima'] = $this->input->post('alamat');
            $transaksi['tanggal_pengiriman'] = $this->input->post('tgl_kirim');
            $transaksi['jam_pengiriman'] = $this->input->post('jam_kirim');
        }

        $this->db->select('kode_penjualan');
        $get_kode_ro = $this->db->get('master_setting');
        $hasil_kode_ro = $get_kode_ro->row();
        $tgl = date("Y-m");
                  $this->db->select_max('urut');    
                  $this->db->like('tanggal_penjualan',$tgl,'after');
                  $result = $this->db->get_where('transaksi_penjualan');
                  $hasil = @$result->result();
                  if($result->num_rows()) $no = ($hasil[0]->urut)+1;
                  else $no = 1;

                  if($no<10)$no = '0000'.$no;
                  else if($no<100)$no = '000'.$no;
                  else if($no<1000)$no = '00'.$no;
                  else if($no<10000)$no = '0'.$no;
                  else if($no<10000)$no = ''.$no;
                  //else if($no<100000)$no = $no;
                  $code = $no;
        $transaksi['kode_transaksi'] = @$hasil_kode_ro->kode_penjualan."_".$code;
        $transaksi['urut'] = $no;

        $this->db->insert('transaksi_penjualan', $transaksi);
	}	







}



