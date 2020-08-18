<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class daftar_order extends MY_Controller {

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
    
	public function daftar()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}

	public function pendaftaran()
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/form', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);		
	}
    
    public function detail($kode)
	{
		$data['aktif'] = 'setting';
		$data['konten'] = $this->load->view('setting/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('setting/menu', $data, TRUE);
		$this->load->view('main', $data);	
	}

	public function print_po()
	{
		$this->load->view('daftar_order/setting/print_po');
		//$this->load->view ('main_no_bar', $data);		
	}

	public function tabel_temp_data_transaksi($kode)
	{
		$data['diskon'] = $this->diskon_tabel();
		$data['kode'] = $kode ;
		$this->load->view ('pre_order/setting/tabel_transaksi_temp',$data);		
	}
    
    public function get_po($kode){
    	$data['kode'] = $kode ;
        $this->load->view('pre_order/setting/tabel_transaksi_temp',$data);
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
        echo $jenis;

        if($jenis == 'bahan baku'){
            $opt = '';
            $query = $this->db->get_where('master_bahan_baku',array('kode_unit'=> 'U001'));
                $opt = '<option value="">--Pilih Bahan Baku--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_bahan_baku.'">'.$value->nama_bahan_baku.'</option>';  
                }
            echo $opt;
            
        }else if ($jenis == 'barang') {
            $opt = '';
            $query = $this->db->get_where('master_barang',array('position'=> 'U001'));
                $opt = '<option value="">--Pilih Barang--</option>';
                foreach ($query->result() as $key => $value) {
                    $opt .= '<option value="'.$value->kode_barang.'">'.$value->nama_barang.'</option>';  
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
		$kode_ro = $input['kode_po'];
		$kode_unit=$input['kode_unit'];
		 $tgl = date("Y-m-d");
                                        $no_belakang = 0;
                                        $this->db->select_max('kode_po');
                                        $kode = $this->db->get_where('transaksi_po',array('tanggal_input'=>$tgl));
                                        $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                                        $this->db->select('kode_po');
                                        $get_kode_ro = $this->db->get('master_setting');
                                        $hasil_kode_ro = $get_kode_ro->row();
                                        
                                        if(count($hasil_kode)==0){
                                            $no_belakang = 1;
                                        }
                                        else{
                                            $pecah_kode = explode("_",$hasil_kode->kode_po);
                                            $no_belakang = @$pecah_kode[3]+1;
                                        }
                                        $kode_default = $this->db->get('setting_gudang');
                                        $hasil_unit =$kode_default->row();
                                        $param=$hasil_unit->kode_unit;
		$kode_po = $input['kode_po'];
		$kode_unit = $input['kode_unit'];
		  $ko_ro_baru = @$hasil_kode_ro->kode_po."_".date("dmyHis")."_".$param."_".$no_belakang;
		$get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
	    
					 				$this->db->select('*') ;
			$query_pembelian_temp = $this->db->get_where('opsi_transaksi_po_temp',array('kode_po'=>$kode_po));

			$total = 0;
			foreach ($query_pembelian_temp->result() as $item){
		     	$data_opsi['kode_po'] = $ko_ro_baru;
		     	$data_opsi['kategori_bahan'] = $item->kategori_bahan;
		     	$data_opsi['kode_bahan'] = $item->kode_bahan;
		     	$data_opsi['nama_bahan'] = $item->nama_bahan;
		     	$data_opsi['jumlah'] = $item->jumlah;
		     	$data_opsi['keterangan'] = $item->keterangan;
		     	$data_opsi['position'] = $kode_unit;
	            
	            $tabel_opsi_transaksi_pembelian = $this->db->insert("opsi_transaksi_po", $data_opsi);
		    }

		    if($tabel_opsi_transaksi_pembelian){

		    	$data_po['kode_po'] = $ko_ro_baru;
		    	$data_po['tanggal_input'] = date('Y-m-d');
		    	$data_po['petugas'] = $nama_petugas;
		    	
		    	$data_po['position'] = $kode_unit;

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
        }elseif($jenis_bahan=='barang'){
            $nama_bahan = $this->db->get_where('master_barang',array('kode_barang' => $kode_bahan));
            $hasil_bahan = $nama_bahan->row();
            #$bahan = $hasil_bahan->satuan_stok;
        }
        echo json_encode($hasil_bahan);

    }
    
	
}
