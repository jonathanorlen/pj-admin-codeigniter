<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends MY_Controller {

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
    
	public function daftar_po()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/po/daftar_po', NULL, TRUE);
		$this->load->view ('main', $data);		
	}

	public function tambah()
	{
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/po/tambah_po', NULL, TRUE);
		$this->load->view ('main', $data);		
	}
    
    public function detail($kode)
	{
		$data['kode'] = $kode;
		$data['aktif']='pembelian';
		$data['konten'] = $this->load->view('pembelian/po/detail_po', $data, TRUE);
		$this->load->view ('main', $data);		
	}

	public function print_po($kode)
	{
		$session = $this->session->userdata('astrosession');
		$setting = $this->db->get('master_setting')->row();
		$po = $this->db->get_where('transaksi_po',array('kode_po' => $kode))->row();

		$data['kode'] = $kode;
		$data['session'] = $session;
		$data['setting'] = $setting ;
		$data['po'] = $po ;

		$data['konten'] = $this->load->view('pembelian/po/print_po', $data, TRUE);
		$this->load->view ('main_no_bar', $data);		
	}

	public function tabel_temp_data_transaksi($kode)
	{
		$data['diskon'] = $this->diskon_tabel();
		$data['kode'] = $kode ;
		$this->load->view ('pembelian/pembelian/tabel_transaksi_temp',$data);		
	}
    
    public function get_po($kode){
    	$data['kode'] = $kode ;
        $this->load->view('pembelian/po/tabel_transaksi_temp',$data);
    }

	//------------------------------------------ Proses ----------------- --------------------//

	public function get_kode_nota()
	{
		$nomor_nota = $this->input->post('nomor_nota');
        $query = $this->db->get_where('transaksi_po',array('nomor_nota' => $nomor_nota, 'tanggal_input'=> date('Y-m-d') ))->num_rows();

        if($query > 0){
            echo "1";
        }
        else{
            echo "0";
        }
	}

	public function simpan_item_temp()
	{
	   $masukan = $this->input->post();       
       $this->db->insert('opsi_transaksi_po_temp',$masukan);
       echo "sukses";				 				
	}

	public function get_temp_po(){
        $id = $this->input->post('id');
        $po = $this->db->get_where('opsi_transaksi_po_temp',array('id'=>$id));
        $hasil_po = $po->row();
        echo json_encode($hasil_po);
    }

    public function hapus_bahan_temp(){
        $id = $this->input->post('id');
        $this->db->delete('opsi_transaksi_po_temp',array('id'=>$id));
    }

    public function get_bahan()
    {
        $param = $this->input->post();
        $jenis = $param['jenis_bahan'];

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> '01'));
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'bahan jadi') {
            $opt = '';
            $query = $this->db->get_where('master_bahan_jadi',array('kode_unit'=> '01'));
                $opt = '<option value="">--Pilih Bahan Jadi--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_jadi.'">'.$value->nama_bahan_jadi.'</option>';  
                }
            echo $opt;
        }
    }

    public function update_item_temp(){
        $update = $this->input->post();
        $this->db->update('opsi_transaksi_po_temp',$update,array('id'=>$update['id']));
        echo "sukses";
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
		$kode_po = $this->input->post('kode_po');
		$query = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_po));
        $data = $query->row();
        echo $input ;
	}
	
    
    

	public function simpan_transaksi()
	{
		$input = $this->input->post();
		$kode_po = $input['kode_po'];

		$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
	    
					 				$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_po));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
		     	$data_opsi['kode_po'] = $item->kode_po;
		     	$data_opsi['kategori_bahan'] = $item->kategori_bahan;
		     	$data_opsi['kode_bahan'] = $item->kode_bahan;
		     	$data_opsi['nama_bahan'] = $item->nama_bahan;
		     	$data_opsi['jumlah'] = $item->jumlah;
		     	$data_opsi['keterangan'] = $item->keterangan;
	            
	            $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_po", $data_opsi);
		    }

		    if($tabel_opsi_transaksi_pembelian){

		    	$data_po['kode_po'] = $kode_po;
		    	$data_po['tanggal_input'] = date('Y-m-d');
		    	$data_po['petugas'] = $nama_petugas;
		    	$data_po['id_petugas'] = $id_petugas;

				$insert_transaksi_po = $this->db->insert("transaksi_po", $data_po);
				$this->db->truncate('opsi_transaksi_po_temp');
				echo '0|<div class="alert alert-success">Berhasil melakukan PO.</div>';  
			}
			else{
				echo '1|<div class="alert alert-danger">Gagal Melakukan PO (rincian barang).</div>';  
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
    
	
}
