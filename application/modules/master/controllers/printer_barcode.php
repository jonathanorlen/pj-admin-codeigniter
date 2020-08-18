<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printer_barcode extends MY_Controller {

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
		redirect(base_url('master/printer_barcode/daftar'));
		
	}

	public function daftar()
	{
		$data['aktif'] = 'printer_barcode';
		$data['konten'] = $this->load->view('master/printer_barcode/daftar', $data, TRUE);
		$data['halaman'] = $this->load->view('master/printer_barcode/menu', $data, TRUE);
		$this->load->view('printer_barcode/main', $data);		
	}
	public function cari_produk(){
		$this->load->view('master/printer_barcode/cari_produk');

	}
	public function print_barcode(){
		$this->load->view('master/printer_barcode/print_barcode');

	}
	public function barcode(){
		require_once( APPPATH . 'libraries/barcode/BCGFont.php');
		require_once( APPPATH . 'libraries/barcode/BCGColor.php');
		require_once( APPPATH . 'libraries/barcode/BCGDrawing.php');

		require_once( APPPATH . 'libraries/barcode/BCGcode128.barcode.php');
		$font = new BCGFont(APPPATH . 'libraries/barcode/font/Arial.ttf',10);
		$param = $this->uri->segment(4);
		$get_barcode = $this->db->get_where('printer_barcode',array('kode_transaksi'=>$param));
		$hasil = $get_barcode->result();
		$total=count($hasil);
		foreach ($hasil as $value) {
			$text =$value->kode_bahan_baku;
			$color_black = new BCGColor(0, 0, 0);
			$color_white = new BCGColor(255, 255, 255);
			$drawException = null;
			try {
        $code = new BCGcode128(); // kalo pake yg code39, klo yg lain mesti disesuaikan
        // $code->setScale($scale); // Resolution
        // $code->setThickness($thickness); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
    } catch(Exception $exception) {
    	$drawException = $exception;
    }
    $drawing = new BCGDrawing('', $color_white);
    if($drawException) {
    	$drawing->drawException($drawException);
    } else {
        //$drawing->setDPI($dpi);
    	$drawing->setBarcode($code);
    	$drawing->draw();
    }
    // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
    $filename_img_barcode = $text .''.'.png';
    // folder untuk menyimpan barcode
    $drawing->setFilename( FCPATH .'barcode_produk/'. $filename_img_barcode);
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
   
    //return $filename_img_barcode;
    //echo $total--;
    
}


}
public function simpan_barcode_temp(){


	$get_opsi= $this->input->post('opsi_produk');
	foreach ($get_opsi as $value) {
		$bahan=$this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$value));
		$hasil_bahan=$bahan->row();
		$masukan['kode_transaksi'] = $this->input->post('kode_trans');
		$masukan['kode_bahan_baku'] = $hasil_bahan->kode_bahan_baku;

		$this->db->insert('printer_barcode',$masukan);	

		require_once( APPPATH . 'libraries/barcode/BCGFont.php');
		require_once( APPPATH . 'libraries/barcode/BCGColor.php');
		require_once( APPPATH . 'libraries/barcode/BCGDrawing.php');

		require_once( APPPATH . 'libraries/barcode/BCGcode128.barcode.php');
		$font = new BCGFont(APPPATH . 'libraries/barcode/font/Arial.ttf',10);
		
			$text =$hasil_bahan->kode_bahan_baku;
			$color_black = new BCGColor(0, 0, 0);
			$color_white = new BCGColor(255, 255, 255);
			$drawException = null;
			try {
        $code = new BCGcode128(); // kalo pake yg code39, klo yg lain mesti disesuaikan
        // $code->setScale($scale); // Resolution
        // $code->setThickness($thickness); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
    } catch(Exception $exception) {
    	$drawException = $exception;
    }
    $drawing = new BCGDrawing('', $color_white);
    if($drawException) {
    	$drawing->drawException($drawException);
    } else {
        //$drawing->setDPI($dpi);
    	$drawing->setBarcode($code);
    	$drawing->draw();
    }
    // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
    $filename_img_barcode = $text .''.'.png';
    // folder untuk menyimpan barcode
    $drawing->setFilename( FCPATH .'barcode_produk/'. $filename_img_barcode);
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}
}
public function kosongkan_barcode(){

	//$this->db->truncate('printer_barcode');	
}
public function get_table()
{
	$kode_default = $this->db->get('setting_gudang');
	$hasil_unit =$kode_default->row();
	$param =$hasil_unit->kode_unit;
	$start = (100*$this->input->post('page'));
	$this->db->limit(100, $start);
	$spoil = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
	$list_spoil = $spoil->result();
	$nomor = $start+1;  

	foreach($list_spoil as $daftar){ 
		?> 
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $daftar->nama_bahan_baku; ?></td>
			<td><?php echo $daftar->real_stock.' '.$daftar->satuan_stok; ?></td>
			<td><?php echo $daftar->nama_rak; ?></td>
			<td align="center"><input name="opsi_spoil[]" type="checkbox"  id="opsi_pilihan" value="<?php echo $daftar->kode_bahan_baku; ?>"></td>
		</tr>
		<?php 
		$nomor++; 
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




}
