<?php
defined('BASEPATH') or exit('No direct script access allowed');

class bahan_baku extends MY_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at h  ttp://example.com/
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

    public function index()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('bahan_baku/daftar_bahan_baku', null, true);
        $data['halaman'] = $this->load->view('bahan_baku/menu', $data, true);
        $this->load->view('bahan_baku/main', $data);

    }

    public function menu()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('master/menu', null, true);
        $data['halaman'] = $this->load->view('bahan_baku/menu', $data, true);
        $this->load->view('bahan_baku/main', $data);
    }

    public function tambah()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('bahan_baku/tambah_bahan_baku', null, true);
        $data['halaman'] = $this->load->view('bahan_baku/menu', $data, true);
        $this->load->view('bahan_baku/main', $data);
    }

    public function detail()
    {
        $data['aktif'] = 'master';
        $data['konten'] = $this->load->view('bahan_baku/detail_bahan_baku', null, true);
        $data['halaman'] = $this->load->view('bahan_baku/menu', $data, true);
        $this->load->view('bahan_baku/main', $data);
    }
    
    public function get_produk(){
        $this->load->view('bahan_baku/cari_produk');
    }
    public function export(){
        $this->load->view('bahan_baku/export_excel');
    }
    public function print_produk(){
        $this->load->view('bahan_baku/print_bahan_baku');
    }

    public function simpan_temp()
    {
        $data = $this->input->post();

        $satuan = $this->db->get_where('master_satuan', array('kode' => $data['kode_satuan']));
        $hasil_satuan = $satuan->row();
        
        $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>$data['kode_satuan_stok']));
        $hasil_stok = $satuan_stok->row();
        
        $data['nama_satuan_stok'] = $hasil_stok->nama;
        $data['nama_satuan'] = $hasil_satuan->nama;

        $this->db->insert('opsi_bahan_baku_temp', $data);
    }

    public function get_table()
    {
        $kode_default = $this->db->get('setting_gudang');
        $hasil_unit =$kode_default->row();
        $param =$hasil_unit->kode_unit;
        $start = (100*$this->input->post('page'));
        
        $data = $this->input->post();
        $this->db->limit(100, $start);
        if(@$data['kategori']){
            $kategori = $data['kategori'];
            $this->db->where('kode_kategori_produk',$kategori);
        }
        if(@$data['nama_produk']){
            $produk = $data['nama_produk'];
            $this->db->like('nama_bahan_baku',$produk,'both');
        }
        $get_bb = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param));
        $hasil_bb = $get_bb->result();
        $nomor = $start+1;
        // Echo $this->db->last_query();
        foreach ($hasil_bb as $daftar) {
            ?>   
            <tr class="table_bahan" id="table_bahan_<?php echo $nomor; ?>" key="<?php echo $nomor; ?>">
                <td><?php echo $nomor; ?></td>
                <td><?php echo $daftar->kode_bahan_baku; ?></td>
                <td width="500px"><?php echo $daftar->nama_bahan_baku; ?></td>
                <td style="display:none;"><?php echo $daftar->nama_kategori_produk; ?></td>
                <td><?php echo $daftar->nama_unit; ?></td>
                <td><?php echo $daftar->nama_rak; ?></td>
                <td align="right"><?php echo format_rupiah($daftar->hpp); ?></td>
                <td align="right">
                    <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                        <input type="hidden" class="form-control" value="<?php echo $daftar->id; ?>" id="id_<?php echo $nomor; ?>">
                        <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_1; ?>" id="hj1_<?php echo $nomor; ?>">
                    </div>
                    <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj1_<?php echo $nomor; ?>">
                        <?php echo format_rupiah($daftar->harga_jual_1); ?>
                    </div>
                </td>
                <td align="right">
                    <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                        <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_2; ?>" id="hj2_<?php echo $nomor; ?>">
                    </div>
                    <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj2_<?php echo $nomor; ?>">
                        <?php echo format_rupiah($daftar->harga_jual_2); ?>
                    </div>
                </td>
                <td align="right">
                    <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                        <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_3; ?>" id="hj3_<?php echo $nomor; ?>">
                    </div>
                    <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj3_<?php echo $nomor; ?>">
                        <?php echo format_rupiah($daftar->harga_jual_3); ?>
                    </div>
                </td>
                <td align="right"><?php echo format_rupiah($daftar->harga_beli_akhir); ?></td>
                <td><?php echo $daftar->satuan_pembelian; ?></td>
                <td><?php echo $daftar->satuan_stok; ?></td>
                <td style="display:none;"><?php echo $daftar->jumlah_dalam_satuan_pembelian; ?></td>
                <td><?php echo $daftar->stok_minimal; ?></td>
                <td><?php echo $daftar->real_stock; ?></td>
                <td><?php echo $daftar->nama_supplier; ?></td>
                <td>
                    <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                        <button key="<?php echo $nomor; ?>" data-toggle="tooltip" title="Simpan" class="btn btn-circle blue simpan_hj"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>">
                        <?php echo get_detail_edit_delete_string($daftar->id); ?>
                    </div>
              </td>
          </tr>

          <?php 
          $nomor++;
      }
  }

  public function daftar_temp($kode)
  {
    $data['kode'] = $kode;
    $this->load->view('bahan_baku/daftar_temp', $data);
}

public function scroll()
{

    $this->load->view('bahan_baku/bahan_baku_scroll');
}

public function get_bb_temp()
{
    $data = $this->input->post();
    $bb_temp = $this->db->get_where('opsi_bahan_baku_temp', array('id' => $data['id']));
    $hasil_bb = $bb_temp->row();
    echo json_encode($hasil_bb);

}

public function update_temp()
{
    $data = $this->input->post();
    $satuan = $this->db->get_where('master_satuan', array('kode' => $data['kode_satuan']));
    $hasil_satuan = $satuan->row();

    $satuan_stok = $this->db->get_where('master_satuan',array('kode'=>$data['kode_satuan_stok']));
    $hasil_stok = $satuan_stok->row();

    $data['nama_satuan_stok'] = $hasil_stok->nama;
    $data['nama_satuan'] = $hasil_satuan->nama;

    $this->db->update('opsi_bahan_baku_temp', $data, array('id' => $data['id']));

}

public function hapus_temp()
{
    $data = $this->input->post();
    $this->db->delete('opsi_bahan_baku_temp', array('id' => $data['id']));
}

public function bahan_temp(){
    $data = $this->input->post();
    $get_bahan = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku'=>$data['kode_bahan_baku']));
    $hasil_bahan = $get_bahan->result();
    $kode = date("dmYHis");
    foreach($hasil_bahan as $daftar){
        $temp['kode_input'] = $kode;
        $temp['kode_bahan_baku'] = $daftar->kode_bahan_baku;
        $temp['nama_bahan_baku'] = $daftar->nama_bahan_baku;
        $temp['kode_satuan'] = $daftar->kode_satuan;
        $temp['nama_satuan'] = $daftar->nama_satuan;
        $temp['harga'] = $daftar->harga;
        $temp['jumlah'] = $daftar->jumlah;
        $temp['kode_satuan_stok'] = $daftar->kode_satuan_stok;
        $temp['nama_satuan_stok'] = $daftar->nama_satuan_stok;

        $this->db->insert('opsi_bahan_baku_temp',$temp);
    }
    echo $kode;
}

public function simpan()
{
    $this->load->library('form_validation');
        // $this->form_validation->set_rules('kode_bahan_baku', 'Kode bahan baku', 'required');
    $this->form_validation->set_rules('nama_bahan_baku', 'Nama bahan baku',
        'required');
    $this->form_validation->set_rules('kode_rak', 'Kode Rak', 'required');
    $this->form_validation->set_rules('id_satuan_pembelian', 'Satuan pembelian',
        'required');
    $this->form_validation->set_rules('id_satuan_stok', 'Satuan', 'required');
    $this->form_validation->set_rules('jumlah_dalam_satuan_pembelian',
        'Isi dalam 1 pembelian', 'required');
    $this->form_validation->set_rules('stok_minimal', 'Stok Minimal', 'required');
        //jika form validasi berjalan salah maka tampilkan GAGAL
    if ($this->form_validation->run() == false) {
        echo warn_msg(validation_errors());

    }
        //jika form validasi berjalan benar maka inputkan data
    else {

        $data = $this->input->post(null, true);
        @$header_produk = @$data['header_produk'];
        if (!empty($header_produk)) {
            $unit = $this->db->get_where('master_unit', array('kode_unit' => $data['kode_unit']));
            $hasil_unit = $unit->row();
            $rak = $this->db->get_where('master_rak', array('kode_rak' => $data['kode_rak']));
            $hasil_rak = $rak->row();
            $satuan_pembelian = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_pembelian']));
            $hasil_satuan_pembelian = $satuan_pembelian->row();
            $satuan_stok = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_stok']));
            $kategori_produk = $this->db->get_where('master_kategori_menu', array('kode_kategori_menu' =>
                $data['kode_kategori_produk']));
            $hasil_kategori_produk = $kategori_produk->row();
            $this->db->select('kode_bahan_baku');
            $bb = $this->db->get('master_setting');
            $hasil_bb = $bb->row();
            $hasil_satuan_stok = $satuan_stok->row();
            $data['kode_bahan_baku'] = $header_produk . "." . $data['kode_bahan_baku'];
            $data['kode_header_produk'] = $data['header_produk'];
            $data['satuan_stok'] = $hasil_satuan_stok->nama;
            $data['satuan_pembelian'] = $hasil_satuan_pembelian->nama;
            $data['nama_kategori_produk'] = $hasil_kategori_produk->nama_kategori_menu;
            $data['nama_unit'] = $hasil_unit->nama_unit;
            $data['nama_rak'] = $hasil_rak->nama_rak;
            $data['real_stock'] = 0;
            $data['status_produk'] = 'subproduk';

            $supplier = $this->db->get_where('master_supplier',array('kode_supplier' =>$data['kode_supplier']));
            $hasil_supplier = $supplier->row();
            $data['nama_supplier']=$hasil_supplier->nama_supplier;

            unset($data['header_produk']);
            unset($data['kode_sub']);
            unset($data['foto_name_upload']);
            $data['harga_jual_1'] = $data['harga_jual_1'];
            $data['harga_jual_2'] = $data['harga_jual_2'];
            $data['harga_jual_3'] = $data['harga_jual_3'];
            $data['qty_grosir'] = $data['qty_grosir'];
            $data['status_opname'] = $data['status_opname'];
            $data['keterangan'] = $data['keterangan'];
            $foto=$this->input->post('foto_name_upload');
            echo $foto;
            $data['foto'] = $foto;
            $this->db->insert("master_bahan_baku", $data);
            //echo $this->db->last_query();


                // ---------------------singkron----------------------------------------------------------------------------------------
            $singkron_query = $this->db->last_query();
            $singkron['jenis_singkron'] = 'tambah';
            $singkron['query'] = $singkron_query;
            $singkron['status'] = 'pending';
            $this->db->insert("singkronasi", $singkron);


            echo '1';
        } else {
            $unit = $this->db->get_where('master_unit', array('kode_unit' => $data['kode_unit']));
            $hasil_unit = $unit->row();
            $rak = $this->db->get_where('master_rak', array('kode_rak' => $data['kode_rak']));
            $hasil_rak = $rak->row();
            $satuan_pembelian = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_pembelian']));
            $hasil_satuan_pembelian = $satuan_pembelian->row();
            $satuan_stok = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_stok']));
            $this->db->select('kode_bahan_baku');
            $bb = $this->db->get('master_setting');
            $hasil_bb = $bb->row();
            $hasil_satuan_stok = $satuan_stok->row();
            $kategori_produk = $this->db->get_where('master_kategori_menu', array('kode_kategori_menu' =>
                $data['kode_kategori_produk']));
            $hasil_kategori_produk = $kategori_produk->row();
            $data['kode_bahan_baku'] = $hasil_bb->kode_bahan_baku . '_' . $data['kode_bahan_baku'];
            $data['satuan_stok'] = $hasil_satuan_stok->nama;
            $data['satuan_pembelian'] = $hasil_satuan_pembelian->nama;
            $data['nama_unit'] = $hasil_unit->nama_unit;
            $data['nama_rak'] = $hasil_rak->nama_rak;
            $data['real_stock'] = 0;
            $data['status_produk'] = 'produk';
            $data['nama_kategori_produk'] = $hasil_kategori_produk->nama_kategori_menu;
            $supplier = $this->db->get_where('master_supplier',array('kode_supplier' =>@$data['kode_supplier']));
            $hasil_supplier = $supplier->row();
            $data['nama_supplier']=@$hasil_supplier->nama_supplier;
            unset($data['header_produk']);
            unset($data['kode_sub']);
            unset($data['foto_name_upload']);
            $data['status_produk'] = 'subproduk';
            $data['harga_jual_1'] = $data['harga_jual_1'];
            $data['harga_jual_2'] = $data['harga_jual_2'];
            $data['harga_jual_3'] = $data['harga_jual_3'];
            $data['qty_grosir'] = $data['qty_grosir'];
            $data['status_opname'] = $data['status_opname'];
            $data['keterangan'] = $data['keterangan'];
            $foto=$this->input->post('foto_name_upload');
            $data['foto'] = $foto;
            $this->db->insert("master_bahan_baku", $data);
            //echo $this->db->last_query();

                // ---------------------singkron----------------------------------------------------------------------------------------
            $singkron_query = $this->db->last_query();
            $singkron['jenis_singkron'] = 'tambah';
            $singkron['query'] = $singkron_query;
            $singkron['status'] = 'pending';
            $this->db->insert("singkronasi", $singkron);

            $bb = $this->input->post('kode_bahan_baku');
            $temp_bb = $this->db->get_where('opsi_bahan_baku_temp', array('kode_bahan_baku' =>
                $bb));
            $hasil_baku = $temp_bb->result();
                 #echo $this->db->last_query();
            foreach ($hasil_baku as $daftar) {
                $simpan['kode_bahan_baku'] = $hasil_bb->kode_bahan_baku. '_' .$daftar->kode_bahan_baku;
                $simpan['nama_bahan_baku'] = $daftar->nama_bahan_baku;
                $simpan['kode_satuan'] = $daftar->kode_satuan;
                $simpan['nama_satuan'] = $daftar->nama_satuan;
                $simpan['harga'] = $daftar->harga;
                $simpan['jumlah'] = $daftar->jumlah;
                $simpan['kode_satuan_stok'] = $daftar->kode_satuan_stok;
                $simpan['nama_satuan_stok'] = $daftar->nama_satuan_stok;
                $this->db->insert('opsi_bahan_baku',$simpan);                    

                    // ---------------------singkron----------------------------------------------------------------------------------------
                $singkron_query = $this->db->last_query();
                $singkron['jenis_singkron'] = 'tambah';
                $singkron['query'] = $singkron_query;
                $singkron['status'] = 'pending';
                $this->db->insert("singkronasi", $singkron);

                $this->db->delete('opsi_bahan_baku_temp', array('kode_bahan_baku' => $daftar->kode_bahan_baku));
            }
            echo '1';
        }


    }
}

public function simpan_edit()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kode_bahan_baku', 'Kode bahan baku',
        'required');
        //jika form validasi berjalan salah maka tampilkan GAGAL
    if ($this->form_validation->run() == false) {
        echo warn_msg(validation_errors());
    }
        //jika form validasi berjalan benar maka inputkan data
    else {
        $data = $this->input->post(null, true);

        $unit = $this->db->get_where('master_unit', array('kode_unit' => $data['kode_unit']));
        $hasil_unit = $unit->row();
        $rak = $this->db->get_where('master_rak', array('kode_rak' => $data['kode_rak']));
        $hasil_rak = $rak->row();
        $kategori_produk = $this->db->get_where('master_kategori_menu', array('kode_kategori_menu' =>
            $data['kode_kategori_produk']));
        $hasil_kategori_produk = $kategori_produk->row();
        $satuan_pembelian = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_pembelian']));
        $hasil_satuan_pembelian = $satuan_pembelian->row();
        $satuan_stok = $this->db->get_where('master_satuan', array('kode' => $data['id_satuan_stok']));
        $hasil_satuan_stok = $satuan_stok->row();
        $data['satuan_stok'] = $hasil_satuan_stok->nama;
        $data['satuan_pembelian'] = $hasil_satuan_pembelian->nama;
        $data['nama_unit'] = $hasil_unit->nama_unit;
        $data['nama_rak'] = $hasil_rak->nama_rak;
        $data['nama_kategori_produk'] = $hasil_kategori_produk->nama_kategori_menu;
        unset($data['header_produk']);
        unset($data['kode_sub']);
        unset($data['foto_name_upload']);
        $supplier = $this->db->get_where('master_supplier',array('kode_supplier' =>$data['kode_supplier']));
        $hasil_supplier = $supplier->row();
        $data['nama_supplier']=@$hasil_supplier->nama_supplier;
        $foto=$this->input->post('foto_name_upload');
        if($foto != ''){
            $data['foto'] = $foto;
        }
        $this->db->update("master_bahan_baku", $data, array('kode_bahan_baku' => $data['kode_bahan_baku']));


            // ---------------------singkron----------------------------------------------------------------------------------------
        $singkron_query = $this->db->last_query();
        $singkron['jenis_singkron'] = 'ubah';
        $singkron['query'] = $singkron_query;
        $singkron['status'] = 'pending';
        $this->db->insert("singkronasi", $singkron);

        echo '1';

        $opsi_bb = $this->db->get_where('opsi_bahan_baku_temp',array('kode_bahan_baku'=>$data['kode_bahan_baku']));
        $hasil_bb = $opsi_bb->result();
        $this->db->delete('opsi_bahan_baku',array('kode_bahan_baku'=>$data['kode_bahan_baku']));

            // ---------------------singkron----------------------------------------------------------------------------------------
        $singkron_query = $this->db->last_query();
        $singkron['jenis_singkron'] = 'hapus';
        $singkron['query'] = $singkron_query;
        $singkron['status'] = 'pending';
        $this->db->insert("singkronasi", $singkron);

        foreach($hasil_bb as $daftar){
            $opsi['kode_bahan_baku'] = $daftar->kode_bahan_baku;
            $opsi['nama_bahan_baku'] = $daftar->nama_bahan_baku;
            $opsi['kode_satuan'] = $daftar->kode_satuan;
            $opsi['nama_satuan'] = $daftar->nama_satuan;
            $opsi['harga'] = $daftar->harga;
            $opsi['jumlah'] = $daftar->jumlah;
            $opsi['kode_satuan_stok'] = $daftar->kode_satuan_stok;
            $opsi['nama_satuan_stok'] = $daftar->nama_satuan_stok;

            $this->db->insert('opsi_bahan_baku',$opsi);
            $singkron_query = $this->db->last_query();

                // ---------------------singkron----------------------------------------------------------------------------------------
            $singkron_query = $this->db->last_query();
            $singkron['jenis_singkron'] = 'tambah';
            $singkron['query'] = $singkron_query;
            $singkron['status'] = 'pending';
            $this->db->insert("singkronasi", $singkron);
        }
        $this->db->delete('opsi_bahan_baku_temp',array('kode_bahan_baku'=>$data['kode_bahan_baku']));

            // ---------------------singkron----------------------------------------------------------------------------------------
        $singkron_query = $this->db->last_query();
        $singkron['jenis_singkron'] = 'hapus';
        $singkron['query'] = $singkron_query;
        $singkron['status'] = 'pending';
        $this->db->insert("singkronasi", $singkron);

    }
}


public function hapus()
{
    $kode = $this->input->post('id');
    $get_hapus = $this->db->get_where('master_bahan_baku', array('id' => $kode));
    $hasil_get = $get_hapus->row();
    $this->db->delete('master_bahan_baku', array(
        'kode_bahan_baku' => $hasil_get->kode_bahan_baku,
        'kode_unit' => $hasil_get->kode_unit,
        'kode_rak' => $hasil_get->kode_rak));

        // ---------------------singkron----------------------------------------------------------------------------------------
    $singkron_query = $this->db->last_query();
    $singkron['jenis_singkron'] = 'hapus';
    $singkron['query'] = $singkron_query;
    $singkron['status'] = 'pending';
    $this->db->insert("singkronasi", $singkron);
}

public function get_satuan_stok()
{
    $param = $this->input->post();
    $satuan_stok = $this->db->get_where('master_satuan', array('kode' => $param['id_pembelian']));
    $hasil_satuan_stok = $satuan_stok->row();
    $dft_satuan = $this->db->get_where('master_satuan');
    $hasil_dft_satuan = $dft_satuan->result();
        #$desa = $desa->result();
    $list = '';
    foreach ($hasil_dft_satuan as $daftar) {
        $list .= "
        <option value='$daftar->kode'>$daftar->nama</option>
        ";
    }
    $opt = "<option selected='true' value=''>Pilih Satuan Stok</option>";
    echo $opt . $list;
}

public function get_rak()
{
    $kode_unit = $this->input->post('kode_unit');
    $opt = "<option selected='true' value=''>--Pilih Rak--</option>";
    $data = $this->db->get_where('master_rak', array('kode_unit' => $kode_unit));
    foreach ($data->result() as $key => $value) {
        $opt .= "<option value=" . $value->kode_rak . ">" . $value->nama_rak .
        "</option>";
    }
    echo $opt;
}

public function get_kode()
{
    $kode_bahan_baku = $this->input->post('kode_bahan_baku');
    $query = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $kode_bahan_baku))->
    num_rows();

    if ($query > 0) {
        echo "1";
    } else {
        echo "0";
    }
}
public function get_kode_sub()
{
    $kode_header = $this->input->post('kode_header');
    $query = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $kode_bahan_baku))->
    num_rows();

    if ($query > 0) {
        echo "1";
    } else {
        echo "0";
    }
}

public function get_satuan_stok_sub()
{
    $data = $this->input->post();

    $satuan = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $data['kode_header']));
    $hasil_satuan = $satuan->row();
    echo json_encode($hasil_satuan);
}

public function edit_harga_jual()
{
    $data = $this->input->post();
    $id = $data['id'];
    unset($data['id']);
    $this->db->update('master_bahan_baku', $data, array('id' => $id));
    $data = $this->input->post();
    $satuan = $this->db->get_where('master_bahan_baku', array('id' => $data['id']));
    $hasil_satuan = $satuan->row();
    echo json_encode($hasil_satuan);
}

}
