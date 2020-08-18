<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barang extends MY_Controller {

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
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('barang/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('barang/menu', $data, TRUE);
		$this->load->view('barang/main', $data);		
	}


	public function daftar()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('barang/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('barang/menu', $data, TRUE);
		$this->load->view('barang/main', $data);		
	}

	public function tambah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('barang/form', $data, TRUE);
		$data['halaman'] = $this->load->view('barang/menu', $data, TRUE);
		$this->load->view('barang/main', $data);			
	}

	public function ubah()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('barang/form', $data, TRUE);
		$data['halaman'] = $this->load->view('barang/menu', $data, TRUE);
		$this->load->view('barang/main', $data);			
	}

	public function detail()
	{
		$data['aktif'] = 'barang';
		$data['konten'] = $this->load->view('barang/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('barang/menu', $data, TRUE);
		$this->load->view('barang/main', $data);				
	}


	public function hapus(){
		$kode = $this->input->post("key");
		$this->db->delete( 'master_barang', array('id' => $kode) );
		echo '<div class="alert alert-success">Sudah dihapus.</div>';            

	}

	public function get_temp_pembelian(){
        $id = $this->input->post('id');
        $pembelian = $this->db->get_where('opsi_transaksi_pembelian_temp',array('id'=>$id));
        $hasil_pembelian = $pembelian->row();
        echo json_encode($hasil_pembelian);
    }
    public function get_satuan_stok(){
        $param = $this->input->post();
        $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>$param['id_pembelian']));
        $hasil_satuan_stok = $satuan_stok->row();
        $dft_satuan = $this->db->get_where('master_satuan');
        $hasil_dft_satuan = $dft_satuan->result();
        #$desa = $desa->result();
        $list = '';
        foreach($hasil_dft_satuan as $daftar){
          $list .= 
          "
          <option value='$daftar->kode'>$daftar->nama</option>
          ";
        }
        $opt = "<option selected='true' value=''>Pilih Satuan Stok</option>";
        echo $opt.$list;
    }

	public function simpan_tambah()

		{
			$data = $this->input->post(NULL, TRUE);
            $unit = $this->db->get_where('master_unit',array('kode_unit'=>$data['position']));
            $hasil_unit = $unit->row();
            $rak = $this->db->get_where('master_rak',array('kode_rak'=>$data['kode_rak']));
            $hasil_rak = $rak->row();
            $satuan_pembelian = $this->db->get_where('master_satuan',array('kode'=>$data['id_satuan_pembelian']));
            $hasil_satuan_pembelian = $satuan_pembelian->row();
            $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>$data['id_satuan_stok']));
           
            $hasil_satuan_stok = $satuan_stok->row();
            $data['kode_barang'] = $data['kode_barang'];
            $data['satuan_stok'] = $hasil_satuan_stok->nama;
            $data['satuan_pembelian'] = $hasil_satuan_pembelian->nama;
            
            $get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $data['kode_supplier']));
  			$hasil_master_supplier = $get_master_supplier->row();
  			$item = $hasil_master_supplier;

            $data['nama_supplier'] = $item->nama_supplier;
            $data['nama_rak'] = $hasil_rak->nama_rak;
            $data['real_stok'] = 0;
            $this->db->insert("master_barang", $data);
            echo 'sukses';            
		// $data['kode_barang'] = $this->input->post("kode_barang");
		// $data['nama_barang'] = $this->input->post("nama_barang");
		// $data['kode_supplier'] = $this->input->post("supplier");
		// $parameter = $this->input->post("supplier");
  //       $get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
  //       $hasil_master_supplier = $get_master_supplier->row();
  //       $item = $hasil_master_supplier;
  //       $data['nama_supplier'] = $item->nama_supplier;

		// $data['stok'] = $this->input->post("stok");
		// $position = $this->input->post("position");

		// $get_unit = $this->db->get_where('master_unit', array('nama_unit' => $position));
  //       $hasil_unit = $get_unit->row();

		// $data['position'] = $hasil_unit->kode_unit;

		// $insert = $this->db->insert("master_barang", $data); 
		// echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		// $this->session->set_flashdata('message', $data['kode_barang']);
	}

	public function simpan_ubah()

	{

		$data = $this->input->post(NULL, TRUE);
            $unit = $this->db->get_where('master_unit',array('kode_unit'=>$data['position']));
            $hasil_unit = $unit->row();
            $rak = $this->db->get_where('master_rak',array('kode_rak'=>$data['kode_rak']));
            $hasil_rak = $rak->row();
            $satuan_pembelian = $this->db->get_where('master_satuan',array('kode'=>$data['id_satuan_pembelian']));
            $hasil_satuan_pembelian = $satuan_pembelian->row();
            $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>$data['id_satuan_stok']));
           
            $hasil_satuan_stok = $satuan_stok->row();
            $data['kode_barang'] = $data['kode_barang'];
            $data['satuan_stok'] = $hasil_satuan_stok->nama;
            $data['satuan_pembelian'] = $hasil_satuan_pembelian->nama;
            
            $get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $data['kode_supplier']));
  			$hasil_master_supplier = $get_master_supplier->row();
  			$item = $hasil_master_supplier;

            $data['nama_supplier'] = $item->nama_supplier;
            $data['nama_rak'] = $hasil_rak->nama_rak;
           $update = $this->db->update("master_barang", $data, array('kode_barang' => $data['kode_barang']));
            echo 'sukses';            

		// $data['kode_barang'] = $this->input->post("kode_barang");
		// $data['nama_barang'] = $this->input->post("nama_barang");
		// $data['kode_supplier'] = $this->input->post("supplier");
		// $parameter = $this->input->post("supplier");
  //       $get_master_supplier = $this->db->get_where('master_supplier', array('kode_supplier' => $parameter));
  //       $hasil_master_supplier = $get_master_supplier->row();
  //       $item = $hasil_master_supplier;
  //       $data['nama_supplier'] = $item->nama_supplier;

		// $data['stok'] = $this->input->post("stok");
		// $position = $this->input->post("position");

		// $get_unit = $this->db->get_where('master_unit', array('nama_unit' => $position));
  //       $hasil_unit = $get_unit->row();

		// $data['position'] = $hasil_unit->kode_unit;

		// $update = $this->db->update("master_barang", $data, array('kode_barang' => $data['kode_barang'])); 
		// echo '<div class="alert alert-success">Sudah tersimpan.</div>';
		// $this->session->set_flashdata('message', $data['kode_barang']);
	}

}
