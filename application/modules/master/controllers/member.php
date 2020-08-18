<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class member extends MY_Controller {

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
		$data['konten'] = $this->load->view('member/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('member/menu', $data, TRUE);
		$this->load->view('member/main', $data);		
	}


	public function daftar()
	{
		$data['aktif'] = 'member';
		$data['konten'] = $this->load->view('member/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('member/menu', $data, TRUE);
		$this->load->view('member/main', $data);		
	}

	public function tambah()
	{
		$data['aktif'] = 'member';
		$data['konten'] = $this->load->view('member/form', $data, TRUE);
		$data['halaman'] = $this->load->view('member/menu', $data, TRUE);
		$this->load->view('member/main', $data);			
	}

	public function edit()
	{
		$data['aktif'] = 'member';
		$data['konten'] = $this->load->view('member/ubah', $data, TRUE);
		$data['halaman'] = $this->load->view('member/menu', $data, TRUE);
		$this->load->view('member/main', $data);			
	}

	public function detail()
	{
		$data['aktif'] = 'member';
		$data['konten'] = $this->load->view('member/detail', $data, TRUE);
		$data['halaman'] = $this->load->view('member/menu', $data, TRUE);
		$this->load->view('member/main', $data);				
	}


	public function hapus(){
		$kode = $this->input->post("key");
		$this->db->delete( 'master_member', array('id' => $kode) );
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
            $this->db->insert("master_member", $data);
            echo '<div class="alert alert-success">Sudah Tersimpan.</div>';
            //echo $this->db->last_query();          
		}

	public function simpan_ubah()

	{

		$data = $this->input->post(NULL, TRUE);
        $update = $this->db->update("master_member", $data, array('kode_member' => $data['kode_member']));
        echo '<div class="alert alert-success">Sudah Dirubah.</div>';      
        //echo $this->db->last_query();     
	}

}
