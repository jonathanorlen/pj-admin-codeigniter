<?php
defined('BASEPATH') or exit('No direct script access allowed');
class kasir extends MY_Controller
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
    public function index()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else
            if (getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else
                if (getenv('HTTP_X_FORWARDED'))
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                else
                    if (getenv('HTTP_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    else
                        if (getenv('HTTP_FORWARDED'))
                            $ipaddress = getenv('HTTP_FORWARDED');
                        else
                            if (getenv('REMOTE_ADDR'))
                                $ipaddress = getenv('REMOTE_ADDR');
                            else
                                $ipaddress = 'UNKNOWN';
                            $kasir = $this->db->get_where('master_kasir', array('ip' => $ipaddress));
                            $hasil_kasir = $kasir->row();
                            @$nomor_kasir = $hasil_kasir->kode_kasir;


                            $cek_kasir = $this->db->get_where('transaksi_kasir', array(
                                'kode_kasir' => $nomor_kasir,
                                'tanggal' => date("Y-m-d"),
                                'status' => 'open'));
                            $hasil_cek_kasir = $cek_kasir->row();

                            if (count($hasil_cek_kasir) < 1) {

                                // $data['aktif'] = 'kasir';
                                // $data['konten'] = $this->load->view('kasir/kasir/buka_kasir', null, true);
                                // $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                // $this->load->view('kasir/kasir/main', $data);
                             $data['aktif'] = 'kasir';
                             $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', null, true);
                             $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                             $this->load->view('kasir/kasir/main', $data);

                         } else {
                            $data['aktif'] = 'kasir';
                            $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', null, true);
                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                            $this->load->view('kasir/kasir/main', $data);

                        }


                    }
                    public function daftar_laporan()
                    {
                        $data['halaman'] = $this->load->view('kasir/kasir/home_laporan', null, true);
                        $this->load->view('kasir/kasir/main', $data);
                    }

                    public function buka_kasir()
                    {
                        $this->form_validation->set_rules('saldo_awal', 'Saldo', 'required');
                        if ($this->form_validation->run() == false) {
                            echo "<div style='font-size: 1.5em;' class='alert alert-warning'>Saldo Awal Belum Diisi</div>";
                        } else {
                            $kasir = $this->input->post();
            #$this->db->select_max('kode_transaksi');
                            $ipaddress = '';
                            if (getenv('HTTP_CLIENT_IP'))
                                $ipaddress = getenv('HTTP_CLIENT_IP');
                            else
                                if (getenv('HTTP_X_FORWARDED_FOR'))
                                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                                else
                                    if (getenv('HTTP_X_FORWARDED'))
                                        $ipaddress = getenv('HTTP_X_FORWARDED');
                                    else
                                        if (getenv('HTTP_FORWARDED_FOR'))
                                            $ipaddress = getenv('HTTP_FORWARDED_FOR');
                                        else
                                            if (getenv('HTTP_FORWARDED'))
                                                $ipaddress = getenv('HTTP_FORWARDED');
                                            else
                                                if (getenv('REMOTE_ADDR'))
                                                    $ipaddress = getenv('REMOTE_ADDR');
                                                else
                                                    $ipaddress = 'UNKNOWN';
                                                $get_kasir = $this->db->get_where('master_kasir', array('ip' => $ipaddress));
                                                $hasil_kasir = $get_kasir->row();
                                                $nomor_kasir = $hasil_kasir->kode_kasir;
                                                $get_id_petugas = $this->session->userdata('astrosession');
                                                $cek_kasir = $this->db->get_where('transaksi_kasir', array(
                                                    'validasi' => '',
                                                    'kode_kasir' => $nomor_kasir,
                                                    'petugas' => $hasil_kasir->nama_kasir));
                                                $hasil_cek = $cek_kasir->row();
                                                if (empty($hasil_cek->kode_transaksi)) {
                                                    $id_petugas = $get_id_petugas->id;
                                                    $nama_petugas = $get_id_petugas->uname;
                #echo $nama_petugas;
                                                    $kasir['petugas'] = $nama_petugas;
                                                    $kasir['kode_kasir'] = $nomor_kasir;
                                                    $kasir['nama_kasir'] = $hasil_kasir->nama_kasir;
                                                    $this->db->insert('transaksi_kasir', $kasir);

                                                } else {
                                                    echo "<div style='font-size: 1.5em;' class='alert alert-warning'>Kasir Belum Divalidasi Atau Bermasalah</div>";
                                                }
                                            }


                                        }

                                        public function menu_penjualan()
                                        {

                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/menu_penjualan', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }
                                        public function tutup_kasir()
                                        {

                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/tutup_kasir', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }

                                        public function dft_transaksi_kasir()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/dft_transaksi_kasir', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }
                                        public function penjualan_jasa()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/daftar_penjualan_jasa', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }

                                        public function simpan_tutup_kasir()
                                        {
                                            $update = $this->input->post();
                                            $update['selisih'] = $update['saldo_sebenarnya'] - $update['saldo_akhir'];
                                            $this->db->update('transaksi_kasir', $update, array('kode_transaksi' => $update['kode_transaksi']));
                                        }

                                        public function menu_kasir()
                                        {

                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/menu_kasir', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }

                                        public function laporan()
                                        {
                                            $data['aktif'] = 'laporan';
                                            $data['konten'] = $this->load->view('kasir/kasir/laporan_penjualan', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);
                                        }
                                        public function laporan_menu()
                                        {
                                            $data['aktif'] = 'laporan';
                                            $data['konten'] = $this->load->view('kasir/kasir/laporan_menu', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);
                                        }

                                        public function laporan_penjualan_menu()
                                        {
                                            $data['aktif'] = 'laporan_penjualan';
                                            $data['konten'] = $this->load->view('kasir/kasir/laporan_penjualan_menu', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);
                                        }


                                        public function detail_laporan()
                                        {
                                            $data['aktif'] = 'detail_laporan';
                                            $data['konten'] = $this->load->view('kasir/kasir/detail_laporan_penjualan', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);
                                        }
                                        public function detail_laporan_menu()
                                        {
                                            $data['aktif'] = 'detail_laporan_menu';
                                            $data['konten'] = $this->load->view('kasir/kasir/detail_laporan_menu', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);
                                        }

                                        public function search_laporan()
                                        {
                                            $this->load->view('kasir/kasir/search_penjualan');
                                        }
                                        public function search_laporan_menu()
                                        {
                                            $this->load->view('kasir/kasir/search_menu');
                                        }

                                        public function search_kasir()
                                        {
                                            $data['konten'] = $this->load->view('kasir/kasir/search_kasir');
                                        }
                                        public function search_penjualan_jasa()
                                        {
                                            $data['konten'] = $this->load->view('kasir/kasir/search_penjualan_jasa');
                                        }

                                        public function sold_out()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/sold_out', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);


                                        }

                                        public function daftar_sold_out()
                                        {
                                            $this->load->view('kasir/kasir/daftar_sold_out');
                                        }

                                        public function simpan_sold_out()
                                        {
                                            $kode_menu = $this->input->post('kode_menu');
                                            $update['status'] = '0';
                                            $this->db->update('master_menu', $update, array('kode_menu' => $kode_menu));
                                        }

                                        public function simpan_tersedia()
                                        {
                                            $kode_menu = $this->input->post('kode_menu');
                                            $update['status'] = '1';
                                            $this->db->update('master_menu', $update, array('kode_menu' => $kode_menu));
                                        }

                                        public function simpan_validasi_kasir()
                                        {
                                            $kode = $this->input->post('kode_transaksi');
                                            $update['validasi'] = 'valid';
                                            $this->db->update('transaksi_kasir', $update, array('kode_transaksi' => $kode));
                                        }

                                        public function detail()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/detail_penjualan', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);


                                        }
                                        public function validasi()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/validasi_penjualan', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);


                                        }

                                        public function record_member()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/daftar_member', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }
                                        public function menu_record_member()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/menu_record', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        public function record_konsinasi()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/daftar_konsinasi', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        public function detail_member()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/detail_member', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);
                                        }

                                        public function detail_transaksi_member()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/detail_transaksi_member', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        public function detail_transaksi_konsinasi()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/record/detail_transaksi_konsinasi', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        public function list_transaksi()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/list_penjualan/list_transaksi', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        

                                        public function detail_list_transaksi()
                                        {
                                            $data['aktif'] = 'record member';
                                            $data['konten'] = $this->load->view('kasir/list_penjualan/detail_list_transaksi', null, true);
                                            $data['halaman'] = $this->load->view('kasir/record/menu', $data, true);
                                            $this->load->view('kasir/record/main', $data);


                                        }

                                        public function bayar_personal()
                                        {
                                            $data['aktif'] = 'kasir';
                                            $data['konten'] = $this->load->view('kasir/kasir/bayar_personal', null, true);
                                            $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
                                            $this->load->view('kasir/kasir/main', $data);

                                        }

                                        public function get_meja()
                                        {
                                            $this->load->view('kasir/kasir/get_meja');
                                        }

                                        public function get_member()
                                        {
                                            $kode = $this->input->post('kode_member');
                                            //$this->db->where('kode_unit_jabung','LI_001');
                                            $member = $this->db->get_where('master_member', array('kode_member' => $kode));
                                            $hasil_member = $member->row();
                                            echo json_encode($hasil_member);
                                        }


                                        public function get_non_anggota()
                                        {
                                            $kode = $this->input->post('kode_non_anggota');
                                            //$this->db->where('kode_unit_jabung','LI_001');
                                            $non_anggota = $this->db->get_where('jenis_anggota', array('kode_jenis_anggota' => $kode));
                                            $hasil_non_anggota = $non_anggota->row();
                                            echo json_encode($hasil_non_anggota);
                                        }

                                        

                                        public function get_retail()
                                        {
                                            $kode = $this->input->post('kode_retail');
                                            //$this->db->where('kode_unit_jabung','LI_001');
                                            $retail = $this->db->get_where('master_retail', array('kode_retail' => $kode));
                                            $hasil_retail = $retail->row();
                                            echo json_encode($hasil_retail);
                                        }

    //------------------------------------------ Proses ----------------- --------------------//
                                        public function get_grand_total()
                                        {
                                            $kode_penjualan = $this->input->post('kode_penjualan');

                                            $this->db->select_sum('subtotal');
                                            $dft_order_temp = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi',array('kode_penjualan'=>@$kode_penjualan));
                                            $hasil_order_temp = $dft_order_temp->row();
                                           // echo $this->db->last_query();
                                            $this->db->select_sum('subtotal');
                                            $opsi = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp',array('kode_penjualan'=>@$kode_penjualan));
                                            $hasil_opsi = $opsi->row();
                                            //echo $this->db->last_query();
                                            //$jumlah=$hasil_opsi->subtotal + $hasil_order_temp->subtotal;
                                            $jumlah=$hasil_opsi->subtotal;
                                            $total = array('total' =>$jumlah,'total_rupiah' =>format_rupiah($jumlah));
                                            echo json_encode($total);
                                        }
                                        public function get_opsi_penjualan()
                                        {
                                            $kode = $this->input->post('id');
                                            //$this->db->where('kode_unit_jabung','LI_001');
                                            $opsi = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('id' => $kode));
                                            $hasil_opsi = $opsi->row();
                                            echo json_encode($hasil_opsi);
                                        }

                                        public function update_opsi_penjualan_validasi()
                                        {
                                            $input=$this->input->post();
                                            $kode_menu=$input['kode_produk'];
                                            $update['jumlah']=$input['jumlah'];
                                            $update['harga_satuan']=$input['harga'];
                                            $update['subtotal']=$input['harga'] * $input['jumlah'];

                                            $get_menu = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                                                $input['kode_produk']));
                                            $hasil_getmenu = $get_menu->row();


    // echo $jumlah;
    // echo $hasil_getmenu->real_stock;
                                            if($hasil_getmenu->real_stock >= $input['jumlah']){
                                                echo "0|";
                                                $this->db->update('opsi_transaksi_penjualan_jasa_temp', $update, array('kode_menu' => $kode_menu));
                                           // echo $this->db->last_query();
                                            }else{
                                                echo "1|";
                                            }


                                        }
                                        public function hapus_penjualan_validasi()
                                        {
                                            $kode = $this->input->post('id');

                                            $this->db->delete('opsi_transaksi_penjualan_jasa', array('id' => $kode));

                                        }

                                            //-------------------------------------member--------------------------//

                                        public function get_detail_temp()
                                        {
                                            $this->load->view('kasir/record/table_transaksi');

                                        }
                                        public function item_validasi()
                                        {
                                            $this->load->view('kasir/kasir/item_validasi');

                                        }

                                        public function update_opsi_penjualan()
                                        {
                                            $input=$this->input->post();
                                            $id=$input['id'];
                                            $update['jumlah_retur']='0';
                                            $update['status']='Habis';

                                            $this->db->where('kode_unit_jabung','LI_001');
                                            $this->db->update('opsi_transaksi_penjualan', $update, array('id' => $id));
                                           // echo $this->db->last_query();


                                        }
                                        public function update_opsi_penjualan_tidak_habis()
                                        {
                                            $input=$this->input->post();
                                            $id=$input['id'];
                                            $kode_retur=$input['kode_retur'];
                                            $jumlah_retur=$input['jumlah_retur'];
                                            $update['jumlah_retur']=$jumlah_retur;
                                            $update['status']='Tidak Habis';
                                            $this->db->where('kode_unit_jabung','LI_001');
                                            $this->db->update('opsi_transaksi_penjualan', $update, array('id' => $id));
                                            //echo $this->db->last_query();

                                            //Insert Retur

                                            $get_opsi_penjualan=$this->db->get_where('opsi_transaksi_penjualan',array('id'=>$id));
                                            $hasil_opsi=$get_opsi_penjualan->row();

                                            $insert['kode_retur']=$kode_retur; 
                                            $insert['kode_kasir']=$hasil_opsi->kode_kasir; 
                                            $insert['kode_penjualan']= $hasil_opsi->kode_penjualan;
                                            $insert['kode_produk']=$hasil_opsi->kode_menu;
                                            $insert['nama_produk']=$hasil_opsi->nama_menu;
                                            $insert['jumlah']=$hasil_opsi->jumlah_retur;
                                            $insert['exp_date']=$hasil_opsi->expired;
                                            $insert['kode_satuan']=$hasil_opsi->kode_satuan;
                                            $insert['nama_satuan']=$hasil_opsi->nama_satuan;
                                            $insert['harga_satuan']=$hasil_opsi->harga_satuan;
                                            $insert['kode_unit_jabung']='LI_001';
                                            // $insert['kode_member']=$input['kode_member'];
                                            // $insert['nama_member']=$input['nama_member'];
                                            $this->db->insert('opsi_transaksi_retur_penjualan_temp', $insert);



                                        }
                                        public function simpan_retur()
                                        {
                                           $input=$this->input->post();
                                           $kode_transaksi=$input['kode_transaksi'];
                                           $this->db->where('kode_unit_jabung','LI_001');
                                           $get_opsi_retur_temp=$this->db->get_where('opsi_transaksi_retur_penjualan_temp',array('kode_penjualan'=>$kode_transaksi));
                                           $hasil_retur=$get_opsi_retur_temp->result();
                                           $nominal_retur=0;
                                           foreach ($hasil_retur as $list) {
                                            $nominal_retur+=$list->jumlah * $list->harga_satuan;
                                            $insert['kode_retur']=$list->kode_retur;
                                            $insert['kode_kasir']=$list->kode_kasir; 
                                            $insert['kode_penjualan']= $list->kode_penjualan;
                                            $insert['kode_produk']=$list->kode_produk;
                                            $insert['nama_produk']=$list->nama_produk;
                                            $insert['jumlah']=$list->jumlah;

                                            $insert['subtotal']=$list->jumlah * $list->harga_satuan;
                                            $insert['exp_date']=$list->exp_date;
                                            $insert['kode_satuan']=$list->kode_satuan;
                                            $insert['nama_satuan']=$list->nama_satuan;
                                            $insert['harga_satuan']=$list->harga_satuan;
                                            $insert['kode_unit_jabung']='LI_001';
                                            $this->db->insert('opsi_transaksi_retur_penjualan', $insert);


                                            $insert_stok['jenis_transaksi']='retur';
                                            $insert_stok['kode_transaksi']=$list->kode_retur; 
                                            $insert_stok['kode_bahan']=$list->kode_produk;
                                            $insert_stok['nama_bahan']=$list->nama_produk;
                                            $insert_stok['stok_masuk']=$list->jumlah;
                                            $insert_stok['tanggal_transaksi']=date('Y-m-d');
                                            $user=$this->session->userdata('astrosession');

                                            $insert_stok['id_petugas']=$user->id;
                                            $insert_stok['nama_petugas']=$user->uname;
                                            $insert_stok['status']='masuk';
                                            $insert_stok['kode_unit_jabung']='LI_001';
                                            $this->db->insert('transaksi_stok', $insert_stok);
                                            echo $this->db->last_query();

                                        }  
                                        $this->db->where('kode_unit_jabung','LI_001');
                                        $get_opsi_retur=$this->db->get_where('opsi_transaksi_retur_penjualan_temp',array('kode_penjualan'=>$kode_transaksi));
                                        $hasil_=$get_opsi_retur->row();
                                        $insert_retur['kode_kasir']=$hasil_->kode_kasir; 
                                        $insert_retur['kode_retur']=$hasil_->kode_retur;
                                        $insert_retur['kode_penjualan']= $hasil_->kode_penjualan;
                                        $insert_retur['tanggal_retur']=date('Y-m-d');
                                        $insert_retur['nominal_retur']=$nominal_retur;
                                        $insert_retur['kode_unit_jabung']='LI_001';
                                        $this->db->insert('transaksi_retur_penjualan', $insert_retur);

                                        $this->db->delete('opsi_transaksi_retur_penjualan_temp', array('kode_penjualan' => $kode_transaksi,'kode_unit_jabung' =>'LI_001'));


                                        $this->db->where('kode_unit_jabung','LI_001');
                                        $get_piutang=$this->db->get_where('transaksi_piutang',array('kode_transaksi'=>$kode_transaksi));
                                        $hasil_piutang=$get_piutang->row();

                                        $nominal_piutang        = $hasil_piutang->nominal;
                                        $angsuran               = $hasil_piutang->angsuran;
                                        $total_piutang          = $nominal_piutang - $nominal_retur;
                                        $total_sisa             = $total_piutang-$angsuran;

                                        $update_piutang['nominal']  = $total_piutang;
                                        $update_piutang['sisa']             =  $total_sisa;

                                        $this->db->update('transaksi_piutang', $update_piutang, array('kode_transaksi' => $kode_transaksi,'kode_unit_jabung' =>'LI_001'));
                                        echo $this->db->last_query();

                                    }

                                    public function keterangan()
                                    {
                                        $data = $this->input->post();
                                        $this->db->insert('setting_kasir', $data);
                                    }

                                    public function tutup_meja()
                                    {
                                        $id_meja = $this->input->post('id_meja');
                                        $cek_meja = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
                                            $id_meja));
                                        $hasil_cek = $cek_meja->result();
                                        if (count($hasil_cek) > 0) {
                                            echo "<div style='font-size:1.5em' class='alert alert-warning'>Pesanan Belum Dibayar</div>";
                                        } else {
                                            $update['status'] = '0';
                                            $this->db->update('master_meja', $update, array('no_meja' => $id_meja));
                                            echo "<script>
                                            setTimeout(function(){ $('.sukses').html('');window.location = '" .
                                            base_url('kasir') . "';},1000);

                                        </script>";
                                    }

                                }
                                public function pesanan_temp()
                                {
                                    @$kode = $this->uri->segment(4);
                                    @$data['kode'] = @$kode;
                                    $this->load->view('kasir/kasir/daftar_pesanan_temp', $data);
                                }
                                public function buka_meja()
                                {
                                    $id_meja = $this->input->post('id_meja');
                                    $update['status'] = '1';
                                    $this->db->update('master_meja', $update, array('no_meja' => $id_meja));
                                }
                                public function diskon_tabel()
                                {
                                    $input = $this->input->post('diskon');
                                    echo $input;
                                }
                                public function get_harga()
                                {
                                    $kode = $this->input->post('id_menu');
                                    $qty = $this->input->post('qty');
                                    $menu = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $kode));
                                    $hasil_menu = $menu->row();
                                    if ($hasil_menu->qty_grosir == '') {
                                        echo @$hasil_menu->harga_jual_1;
                                    } else
                                    if ($qty >= $hasil_menu->qty_grosir) {
                                        echo @$hasil_menu->harga_jual_2;
                                    } else {
                                        echo @$hasil_menu->harga_jual_1;
                                    }

                                }
                                public function get_produk()
                                {
                                    $kode = $this->input->post('id_menu');
                                    $menu = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $kode));
                                    $hasil_menu = $menu->row();
                                    if (count($hasil_menu) < 1) {
                                        echo "tidak";
                                    } else {
                                        echo $hasil_menu->harga_jual_1;
                                    }


                                }
                                public function get_produk_manual()
                                {
                                    $kode_produk = $this->input->post('kode_produk');
                                    $menu = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $kode_produk));
                                    $hasil_menu = $menu->row();

                                    echo json_encode($hasil_menu);


                                }

                                public function get_satuan_stok()
                                {
                                    $data = $this->input->post();
                                    $kategori=$data['pilihan'];
                                    $retail=$data['retail'];
        //echo $retail;
                                    $this->db->where('kode_unit_jabung','LI_001');
                                    $opsi_satuan = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                                        $data['id_menu']));
                                    $hasil_opsi = $opsi_satuan->row();
                                    if ($kategori=='Anggota') {
                                        $harga=$hasil_opsi->harga_jual_1;
                                    }elseif($kategori=='Non Anggota'){
                                     $harga=$hasil_opsi->harga_jual_2;

                                 }elseif($kategori=='Retail'){
                                  $get_retail = $this->db->get_where('master_retail', array('kode_retail' => $retail));
                                  $hasil_retail = $get_retail->row();
                                  $cek_harga=$hasil_retail->harga;
                                  if ($cek_harga=='1') {
                                     $harga=$hasil_opsi->harga_jual_1;
                                 }else if ($cek_harga=='2') {
                                     $harga=$hasil_opsi->harga_jual_2;
                                 }else if ($cek_harga=='3') {
                                     $harga=$hasil_opsi->harga_jual_3;
                                 }
                             }
                             $hasil_harga = array('harga' => $harga);
                             echo json_encode($hasil_harga);

                         }
                         public function get_harga_all()
                         {
                            $data = $this->input->post();
                            $this->db->where('kode_unit_jabung','LI_001');
                            $opsi_satuan = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                                $data['id_menu']));
                            $hasil_opsi = $opsi_satuan->row();
                            echo '<select id="harga" name="harga" class="form-control">';
                            echo '<option value="'.@$hasil_opsi->harga_jual_1.'" selected>'.@$hasil_opsi->harga_jual_1.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_2.'">'.@$hasil_opsi->harga_jual_2.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_3.'">'.@$hasil_opsi->harga_jual_3.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_4.'">'.@$hasil_opsi->harga_jual_4.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_5.'">'.@$hasil_opsi->harga_jual_5.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_6.'">'.@$hasil_opsi->harga_jual_6.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_7.'">'.@$hasil_opsi->harga_jual_7.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_8.'">'.@$hasil_opsi->harga_jual_8.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_9.'">'.@$hasil_opsi->harga_jual_9.'</option>';
                            echo '<option value="'.@$hasil_opsi->harga_jual_10.'">'.@$hasil_opsi->harga_jual_10.'</option>';
                            echo "</select>";
                        }
                        public function get_kode_pesanan()
                        {
                            $kode_pesanan = $this->input->post('kode_pesanan');
                            $kode_penjualan = $this->input->post('kode_penjualan');

                            $this->db->where('kode_unit_jabung','LI_001');
                            $get_menu = $this->db->get_where('transaksi_pesanan', array('kode_pesanan' =>$kode_pesanan,'status' =>'Belum Diterima','kode_unit_jabung' =>'LI_001'));
                            $hasil_getmenu = $get_menu->row();
                            if(count($hasil_getmenu) > 0){
                                $user = $this->session->userdata('astrosession');
                                $id_petugas = $user->id;
                                $get_opsi = $this->db->get_where('opsi_transaksi_pesanan', array('kode_pesanan' =>$kode_pesanan,'kode_unit_jabung' =>'LI_001'));
                                $hasil_ge_opsi = $get_opsi->result();
                                foreach ($hasil_ge_opsi as  $opsi) {
                                    $masukan['kode_kasir'] = $id_petugas;
                                    $masukan['kode_penjualan'] = $kode_penjualan; 
                                    $masukan['kode_menu'] = $opsi->kode_menu;
                                    $masukan['nama_menu'] = $opsi->nama_menu;
                                    $masukan['jumlah'] = $opsi->jumlah;
                                    $masukan['kode_satuan'] = $opsi->kode_satuan;
                                    $masukan['nama_satuan'] = $opsi->nama_satuan;
                                    $masukan['harga_satuan'] = $opsi->harga_satuan;
                                    $masukan['diskon_item'] = $opsi->diskon_item;
                                    $masukan['subtotal'] = $opsi->subtotal;
                                    $masukan['status_menu'] = $opsi->status_menu;
                                    $masukan['expired'] = $opsi->expired;
                                    $masukan['jenis_diskon'] = $opsi->jenis_diskon;

                                    $masukan['kode_unit_jabung'] = 'LI_001';

                                    $this->db->insert('opsi_transaksi_penjualan_temp', $masukan);
                                }
            //echo "0|".$hasil_getmenu->kateg."|".;
                                $kode=$hasil_getmenu->kode_member;
                                $get_ketegori_harga = $this->db->get_where('master_member', array('kode_member' =>$kode,'kode_unit_jabung' =>'LI_001'));
                                $hasil_kategori = $get_ketegori_harga->row();

                                $pesan = array('hasil_cari' => '0','kategori_penjualan'=>$hasil_getmenu->kategori_penjualan,
                                    'kode_member'=>$hasil_getmenu->kode_member,'nama_member'=>$hasil_getmenu->nama_member,
                                    'total_nominal'=>$hasil_getmenu->total_nominal,'diskon_persen'=>$hasil_getmenu->diskon_persen,
                                    'diskon_rupiah'=>$hasil_getmenu->diskon_rupiah,'grand_total'=>$hasil_getmenu->grand_total,
                                    'ongkos_kirim'=>$hasil_kategori->ongkir,'jenis_transaksi'=>$hasil_getmenu->jenis_transaksi,
                                    'kode_pesanan'=>$hasil_getmenu->kode_pesanan,
                                    'kateori_harga'=>$hasil_kategori->kategori_harga
                                    );
                            }else{
                                $pesan = array('hasil_cari' => '0');
                            }
                            echo json_encode($pesan);
                        }


                        public function simpan_pesanan_temp()
                        {
                            $masukan = $this->input->post();


                            $kode_produk = $masukan['kode_produk'];
                            $get_menu = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' =>
                                $kode_produk));
                            $hasil_getmenu = $get_menu->row();
                            $cek_menu = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('kode_penjualan' =>
                                $masukan['kode_penjualan'], 'kode_menu' => $kode_produk));
                            $hasil_cek_menu = $cek_menu->row();
                            $jumlah=$masukan['jumlah'] + @$hasil_cek_menu->jumlah;
    // echo $jumlah;
    // echo $hasil_getmenu->real_stock;
                            if($hasil_getmenu->real_stock >= $jumlah){
                                echo "0|";

                                if(empty($hasil_cek_menu)){

                                    $simpan_masukan['kode_penjualan'] =  $masukan['kode_penjualan'];
                                    $simpan_masukan['kode_menu'] = $hasil_getmenu->kode_bahan_baku;
                                    $simpan_masukan['nama_menu'] = $hasil_getmenu->nama_bahan_baku;
                                    $simpan_masukan['jumlah'] =  @$masukan['jumlah'];
                                    $simpan_masukan['kode_satuan'] = $hasil_getmenu->id_satuan_stok;
                                    $simpan_masukan['nama_satuan'] = $hasil_getmenu->satuan_stok;
                                    $simpan_masukan['harga_satuan'] = $masukan['harga'];
                                    $simpan_masukan['subtotal'] = $masukan['jumlah'] * $masukan['harga'];
                                    $simpan_masukan['tanggal_transaksi'] = date('Y-m-d');
                                    $user = $this->session->userdata('astrosession');
                                    $id_petugas = $user->id;
                                    $simpan_masukan['kode_kasir'] = $id_petugas;
                                    $this->db->insert('opsi_transaksi_penjualan_jasa_temp', $simpan_masukan);            
                                }else{
                                    $update_masukan['jumlah'] = @$hasil_cek_menu->jumlah + @$masukan['jumlah'];
                                    $update_masukan['harga_satuan'] = $masukan['harga'];
                                    $update_masukan['subtotal'] = (@$hasil_cek_menu->jumlah + @$masukan['jumlah']) * $masukan['harga'];
                                    $this->db->update('opsi_transaksi_penjualan_jasa_temp',$update_masukan,array('kode_penjualan' =>
                                        $masukan['kode_penjualan'], 'kode_menu' => $kode_produk));
                                }


                            }else{
                                echo "1|";
                            }




                        }
                        public function simpan_deskripsi_temp()
                        {
                            $masukan = $this->input->post();
                            $kode_satuan = $masukan['kode_satuan'];
        // $cek_menu = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp_deskripsi', array('kode_penjualan' =>
        //     $masukan['kode_penjualan'], 'kode_menu' => $kode_produk));
        // $hasil_cek_menu = $cek_menu->row();

                            $get_satuan = $this->db->get_where('master_satuan', array('kode' =>
                                $kode_satuan));
                            $hasil_getsatuan = $get_satuan->row();

                            $simpan_masukan['kode_penjualan'] =  $masukan['kode_penjualan'];

                            $simpan_masukan['ukuran'] =  @$masukan['ukuran'];
                            $simpan_masukan['deskripsi'] =  @$masukan['deskripsi'];
                            $simpan_masukan['kode_satuan'] = $kode_satuan;
                            $simpan_masukan['nama_satuan'] = $hasil_getsatuan->nama;
                            $simpan_masukan['harga_satuan'] = $masukan['harga'];
                            $simpan_masukan['subtotal'] = $masukan['ukuran'] * $masukan['harga'];
                            $simpan_masukan['tanggal_transaksi'] = date('Y-m-d');
                            $user = $this->session->userdata('astrosession');
                            $id_petugas = $user->id;
                            $simpan_masukan['kode_kasir'] = $id_petugas;
                            $this->db->insert('opsi_transaksi_penjualan_jasa_deskripsi_temp', $simpan_masukan);
                            echo "0|";

                        }
                        public function update_deskripsi_temp()
                        {
                            $masukan = $this->input->post();
                            $kode_satuan = $masukan['kode_satuan'];

                            $get_satuan = $this->db->get_where('master_satuan', array('kode' =>
                                $kode_satuan));
                            $hasil_getsatuan = $get_satuan->row();

                            $simpan_masukan['kode_penjualan'] =  $masukan['kode_penjualan'];

                            $simpan_masukan['ukuran'] =  @$masukan['ukuran'];
                            $simpan_masukan['deskripsi'] =  @$masukan['deskripsi'];
                            $simpan_masukan['kode_satuan'] = $kode_satuan;
                            $simpan_masukan['nama_satuan'] = $hasil_getsatuan->nama;
                            $simpan_masukan['harga_satuan'] = $masukan['harga'];
                            $simpan_masukan['subtotal'] = $masukan['ukuran'] * $masukan['harga'];
                            $simpan_masukan['tanggal_transaksi'] = date('Y-m-d');
                            $user = $this->session->userdata('astrosession');
                            $id_petugas = $user->id;
                            $simpan_masukan['kode_kasir'] = $id_petugas;

                            $this->db->update('opsi_transaksi_penjualan_jasa_deskripsi_temp',$simpan_masukan,array('id' => $masukan['id_temp']));
                            echo "0|";

                        }
                        public function simpan_ubah_pesanan_temp()
                        {
                            $update = $this->input->post();

                            $harga_diskon = ($update['harga_satuan'] * $update['diskon_item']) / 100;
                            $update['harga_satuan'] = $update['harga_satuan'] - $harga_diskon;
                            $update['diskon_item'] = $update['diskon_item'];
                            $subtotal = $update['jumlah'] * $update['harga_satuan'];
                            $update['subtotal'] = $subtotal;

                            $this->db->group_by('kode_menu');
                            $cek_trx = $this->db->get_where('opsi_transaksi_penjualan_temp', array(
                                'kode_penjualan' => $update['kode_penjualan'],
                                'kode_menu' => $update['kode_menu'],
                                'status !=' => 'personal'));
        # echo $this->db->last_query();
                            $cek_trx_hasil = $cek_trx->row();

                            $get_menu = $this->db->get_where('master_menu', array('kode_menu' => $update['kode_menu']));
                            $hasil_getmenu = $get_menu->row();

                            $jumlah = $this->input->post('jumlah');
                            $jumlah_awal = $update['jumlah_awal'];
                            echo $jumlah . "||" . $jumlah_awal;


                            unset($update['jumlah_awal']);
                            unset($update['kode_meja']);
                            $cek_tipe = $this->db->get_where('tipe_menu', array('nama_tipe' => $hasil_getmenu->
                                status_menu, 'status' => '1'));
                            $hasil_tipe = $cek_tipe->row();
                            if ($hasil_tipe->non_stok == '0') {
                                $this->db->update('opsi_transaksi_penjualan_temp', $update, array(
                                    'kode_penjualan' => $update['kode_penjualan'],
                                    'kode_menu' => $update['kode_menu'],
                                    'status !=' => 'personal'));
                            }

        #echo $this->db->last_query();
                        }
                        public function simpan_pembayaran()
                        {
                            $data = $this->input->post();
                            $this->db->where('kode_unit_jabung','LI_001');
                            $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_penjualan' =>
                                $data['kode_penjualan']));
                            $hasil_pesanan = $get_pesanan->result();
                            $hasil_baris = $get_pesanan->row();

                            $user = $this->session->userdata('astrosession');
                            $id_petugas = $user->id;
                            $nama_petugas = $user->uname;
                            $jml_total=0;
                            foreach ($hasil_pesanan as $daftar) {
                                $jml_total += @$daftar->jumlah;
                                $masukkan['kode_kasir'] = $id_petugas;
                                $masukkan['kode_penjualan'] = $data['kode_penjualan_baru'];
                                $masukkan['kategori_menu'] = $daftar->kategori_menu;
                                $masukkan['kode_menu'] = $daftar->kode_menu;
                                $masukkan['nama_menu'] = $daftar->nama_menu;
                                $masukkan['jumlah'] = $daftar->jumlah;
                                $masukkan['kode_satuan'] = $daftar->kode_satuan;
                                $masukkan['nama_satuan'] = $daftar->nama_satuan;
                                $masukkan['harga_satuan'] = $daftar->harga_satuan;
                                $masukkan['jenis_diskon'] = @$daftar->jenis_diskon;
                                $masukkan['diskon_item'] = @$daftar->diskon_item;
                                $masukkan['diskon_rupiah'] = @$daftar->diskon_rupiah;
                                $masukkan['subtotal'] = $daftar->subtotal;
                                $masukkan['tanggal_transaksi'] = date('Y-m-d');
                                $masukkan['expired'] = $daftar->expired;
                                $masukkan['kode_unit_jabung'] = 'LI_001';
                                $this->db->insert('opsi_transaksi_penjualan', $masukkan);

                                $this->db->where('kode_unit_jabung','LI_001');
                                $min_transaksi=$this->db->get_where('transaksi_stok',array('sisa_stok !='=>0, 'jenis_transaksi '=>'pembelian','kode_bahan'=>$daftar->kode_menu));
                                $hasil_min_transaksi=$min_transaksi->result();
                        //echo $this->db->last_query()."<br>";
                                $reload=0;
                                $selisih_fifo=0;
                                $hpp_produksi_prtrans=0;
                                foreach ($hasil_min_transaksi as  $value) {
                            // echo"reload :".$reload;
                            // echo"selisih_fifo :".$selisih_fifo;
                            // echo"sisa_stok :".$value->sisa_stok;
                            // echo"<br>";
                                    $jumlah_produksi=$daftar->jumlah;
                                    if($reload==0 and $selisih_fifo==0){
                                        if($jumlah_produksi<= $value->sisa_stok){
                                            $fifo_transaksi['stok_keluar']=$jumlah_produksi;
                                            $fifo_transaksi['sisa_stok']=$value->sisa_stok - $jumlah_produksi;
                                            $update_fifo=$this->db->update('transaksi_stok',$fifo_transaksi,array('id'=>$value->id,'kode_unit_jabung'=>'LI_001'));

                                            $transaksi_stok['jenis_transaksi']='penjualan';
                                            $transaksi_stok['kode_transaksi']=$data['kode_penjualan_baru'];
                                            $transaksi_stok['kategori_bahan']=$daftar->kategori_menu;
                                            $transaksi_stok['kode_bahan']=$daftar->kode_menu;
                                            $transaksi_stok['nama_bahan']=$daftar->nama_menu;
                                            $transaksi_stok['stok_keluar']=$jumlah_produksi;

                                            $transaksi_stok['hpp']=$value->hpp;
                                            $transaksi_stok['id_petugas']=$id_petugas;
                                            $transaksi_stok['nama_petugas']=$nama_petugas;
                                            $transaksi_stok['tanggal_transaksi']=date('Y-m-d');
                                            $transaksi_stok['status']='keluar';
                                            $transaksi_stok['kode_unit_jabung'] = 'LI_001';
                                            $insert_transaksi_stok=$this->db->insert('transaksi_stok',$transaksi_stok);
                                            $hpp_produksi_prtrans +=$jumlah_produksi * $value->hpp;
                                        }else{

                                            $fifo_transaksi['stok_keluar']=@$value->stok_keluar + $value->sisa_stok;
                                            $fifo_transaksi['sisa_stok']=0;
                                            $update_fifo=$this->db->update('transaksi_stok',$fifo_transaksi,array('id'=>$value->id,'kode_unit_jabung'=>'LI_001'));
                                            $selisih_fifo=$jumlah_produksi - $value->sisa_stok;
                                    //echo "tidak cukup";


                                            $transaksi_stok['jenis_transaksi']='penjualan';
                                            $transaksi_stok['kode_transaksi']=$data['kode_penjualan_baru'];
                                            $transaksi_stok['kategori_bahan']=$daftar->kategori_menu;
                                            $transaksi_stok['kode_bahan']=$daftar->kode_menu;
                                            $transaksi_stok['nama_bahan']=$daftar->nama_menu;
                                            $transaksi_stok['stok_keluar']=@$value->stok_keluar + $value->sisa_stok;
                                            $transaksi_stok['hpp']=$value->hpp;
                                            $transaksi_stok['id_petugas']=$id_petugas;
                                            $transaksi_stok['nama_petugas']=$nama_petugas;
                                            $transaksi_stok['tanggal_transaksi']=date('Y-m-d');
                                            $transaksi_stok['status']='keluar';
                                            $transaksi_stok['kode_unit_jabung'] = 'LI_001';
                                            $insert_transaksi_stok=$this->db->insert('transaksi_stok',$transaksi_stok);
                                            $hpp_produksi_prtrans +=$jumlah_produksi * $value->hpp;
                                        }

                                    }

                                    if($selisih_fifo > 0 and $reload > 0){
                                        if($selisih_fifo <= $value->sisa_stok){

                                            $fifo_transaksi2['stok_keluar']=$selisih_fifo;
                                            $fifo_transaksi2['sisa_stok']=$value->sisa_stok - $selisih_fifo;
                                            $update_fifo=$this->db->update('transaksi_stok',$fifo_transaksi2,array('id'=>$value->id,'kode_unit_jabung'=>'LI_001'));
                                    //echo $this->db->last_query();

                                    //echo"|cukup".$reload;

                                            $transaksi_stok2['jenis_transaksi']='penjualan';
                                            $transaksi_stok2['kode_transaksi']=$data['kode_penjualan_baru'];
                                            $transaksi_stok2['kategori_bahan']=$daftar->kategori_menu;
                                            $transaksi_stok2['kode_bahan']=$daftar->kode_menu;
                                            $transaksi_stok2['nama_bahan']=$daftar->nama_menu;
                                            $transaksi_stok2['stok_keluar']=@$selisih_fifo;
                                            $transaksi_stok2['hpp']=$value->hpp;
                                            $transaksi_stok2['id_petugas']=$id_petugas;
                                            $transaksi_stok2['tanggal_transaksi']=date('Y-m-d');
                                            $transaksi_stok2['status']='keluar';
                                            $transaksi_stok2['nama_petugas']=$nama_petugas;
                                            $transaksi_stok2['kode_unit_jabung'] = 'LI_001';
                                            $insert_transaksi_stok=$this->db->insert('transaksi_stok',$transaksi_stok2);
                                            echo $this->db->last_query();

                                            $hpp_produksi_prtrans +=$selisih_fifo * $value->hpp;
                                            $selisih_fifo=0;

                                        }else{

                                            $fifo_transaksi2['stok_keluar']=@$value->stok_keluar + $value->sisa_stok;
                                            $fifo_transaksi2['sisa_stok']=0;
                                            $update_fifo=$this->db->update('transaksi_stok',$fifo_transaksi2,array('id'=>$value->id,'kode_unit_jabung'=>'LI_001'));
                                            $selisih_fifo=$selisih_fifo - $value->sisa_stok;
                                    //echo "tidak cukup".$reload;
                                            $transaksi_stok2['jenis_transaksi']='penjualan';
                                            $transaksi_stok2['kode_transaksi']=$data['kode_penjualan_baru'];
                                            $transaksi_stok2['kategori_bahan']=$daftar->kategori_menu;
                                            $transaksi_stok2['kode_bahan']=$daftar->kode_menu;
                                            $transaksi_stok2['nama_bahan']=$daftar->nama_menu;
                                            $transaksi_stok2['sisa_stok']=0;
                                            $transaksi_stok2['hpp']=$value->hpp;
                                            $transaksi_stok2['id_petugas']=$id_petugas;
                                            $transaksi_stok2['tanggal_transaksi']=date('Y-m-d');
                                            $transaksi_stok2['status']='keluar';
                                            $transaksi_stok2['nama_petugas']=$nama_petugas;
                                            $transaksi_stok2['kode_unit_jabung'] = 'LI_001';
                                            $insert_transaksi_stok=$this->db->insert('transaksi_stok',$transaksi_stok2);
                                            $hpp_produksi_prtrans +=$selisih_fifo * $value->hpp;
                                        }
                                    }

                                    $reload++;



                // if ($data['kode_member'] != "") {
                //     $this->db->where('kode_produk', $daftar->kode_menu);
                //     $cek_bahan = $this->db->get('master_produk');
                //     $hasil_bahan = $cek_bahan->row();

                //     echo $jumlah_bahan = count($hasil_bahan);

                //     if ($jumlah_bahan < 1) {
                //         $this->db->where('kode_produk', $daftar->kode_menu);
                //         $this->db->where('status', 'sendiri');
                //         $get_bahan_jadi = $this->db->get('master_produk');
                //         $hasil_menu = $get_bahan_jadi->row_array();

                //         unset($hasil_menu['id']);
                //         $hasil_menu['real_stock'] = $daftar->jumlah;
                //         $hasil_menu['status'] = 'member';
                //         $hasil_menu['kode_member'] = $data['kode_member'];
                //         $hasil_menu['nama_member'] = $data['nama_member'];

                //         $this->db->insert('master_produk', $hasil_menu);
                //     } else{

                //         $hasil_menu['real_stock'] = $hasil_bahan->real_stock + $daftar->jumlah;
                //         $this->db->update('master_produk', $hasil_menu, array(
                //             'kode_produk' => $daftar->kode_menu,'kode_produk' => $daftar->kode_menu));
                //     }
                // }
                                }
                                $this->db->where('kode_unit_jabung','LI_001');
                                $stok = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $daftar->kode_menu));
                                $hasil_stok = $stok->row();

                                $updatestok['real_stock'] = $hasil_stok->real_stock - $daftar->jumlah;
                                $this->db->update('master_bahan_baku', $updatestok, array('kode_bahan_baku' => $daftar->kode_menu,'kode_unit_jabung'=>'LI_001'));

                            }
                            $get_id_petugas = $this->session->userdata('astrosession');
                            $id_petugas = $get_id_petugas->id;
                            $nama_petugas = $get_id_petugas->uname;



                //-------------------------

                            $transaksi['kode_kasir'] = $hasil_baris->kode_kasir;
                            $transaksi['kode_penjualan'] = $data['kode_penjualan_baru'];
                            $transaksi['tanggal_penjualan'] = date("Y-m-d");
                            $transaksi['jam_penjualan'] = date("H:i:s");
                            $transaksi['diskon_persen'] = $data['persen'];
                            $transaksi['diskon_rupiah'] = $data['rupiah'];
                            $transaksi['total_nominal'] = $data['total_pesanan'];
                            $transaksi['grand_total'] = $data['grand_total'];
                            $transaksi['jenis_transaksi'] = $data['jenis_transaksi'];
                            $transaksi['bayar'] = $data['bayar'];
                            $transaksi['kembalian'] = $data['kembalian'];
                            $transaksi['id_petugas'] = $id_petugas;
                            $transaksi['petugas'] = $nama_petugas;
                            $transaksi['kode_member'] = $data['kode_member'];
                            $transaksi['nama_member'] = $data['nama_member'];
                            if ($data['kode_member'] == "") {
                                $transaksi['kategori_penjualan'] = "Umum";
                            } else {
                                $transaksi['kategori_penjualan'] = "Member";

            //--- withdraw--------------
                                $get_member = $this->db->get_where('master_member',array('kode_unit_jabung' =>'LI_001', 'kode_member'=> @$data['kode_member']));
                                $hasil_member=$get_member->row();
           // echo $this->db->last_query();
                                if($hasil_member->status_fee=='FEE'){
                                    $data_widraw['kode_kelompok']=@$data['kode_member'];
                                    $data_widraw['nama_kelompok']=@$hasil_member->nama_member;
                                    $data_widraw['nominal_withdraw']=@$hasil_member->nominal_fee;
                                    $data_widraw['total_withdraw']=@$hasil_member->nominal_fee * $jml_total;
                                    $data_widraw['sisa']=@$hasil_member->nominal_fee * $jml_total;
                                    $data_widraw['kode_unit_jabung']='LI_001';
                                    $cek_widraw=$this->db->get_where('transaksi_withdraw',array('kode_unit_jabung' =>'LI_001', 'kode_kelompok'=> @$data['kode_member']));
                                    $hasil_cek_widraw=$cek_widraw->row();
                    //echo $this->db->last_query();
                                    if(count($hasil_cek_widraw) > 0){
                      //  echo $hasil_cek_widraw->total_withdraw;
                                        $update_widraw['total_withdraw']=$hasil_cek_widraw->total_withdraw + (@$hasil_member->nominal_fee * $jml_total);
                                        $update_widraw['sisa']=$hasil_cek_widraw->sisa + (@$hasil_member->nominal_fee * $jml_total);
                                        $this->db->update('transaksi_withdraw',$update_widraw, array('kode_unit_jabung' =>'LI_001', 'kode_kelompok'=> @$data['kode_member']));
                                    }else{
                                        $this->db->insert('transaksi_withdraw', $data_widraw);    
                                    }

                   // echo $this->db->last_query();
                                }
                            }
        # $transaksi['status_penerimaan'] = $data['jenis_penerimaan'];
        /*  if ($data['jenis_penerimaan'] == "dikirim") {
        $transaksi['status'] = "belum terkirim";
        $transaksi['nama_penerima'] = $data['penerima'];
        $transaksi['no_telp'] = $data['no_telp'];
        $transaksi['alamat_penerima'] = $data['alamat'];
        $transaksi['tanggal_pengiriman'] = $data['tgl_kirim'];
        $transaksi['jam_pengiriman'] = $data['jam_kirim'];
    }*/

    $tgl = date("Y-m-d");
    $no_belakang = 0;
    $this->db->select_max('kode_penjualan');
    $this->db->where('kode_unit_jabung','LI_001');
    $kode = $this->db->get_where('transaksi_penjualan', array('tanggal_penjualan' =>
        $tgl));
    $hasil_kode = $kode->row();
        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
        #echo $pecah_kode[0];
        #echo $pecah_kode[2];
    // $this->db->select('kode_penjualan');
    // $kode_penjualan = $this->db->get('master_setting');
    // $hasil_kode_penjualan = $kode_penjualan->row();
    if (count($hasil_kode) == 0) {
        $no_belakang = 1;
    } else {
        $pecah_kode = explode("_", @$hasil_kode->kode_transaksi);
        $no_belakang = @$pecah_kode[2] + 1;
    }
    $this->db->select_max('kode_transaksi');
    $this->db->where('kode_unit_jabung','LI_001');
    $kasir = $this->db->get_where('transaksi_kasir', array('tanggal' => $tgl,
        'status' => "open"));
    $hasil_cek_kasir = $kasir->row();
    $transaksi['kode_transaksi'] = "PEN_".
    date("dmyHis") . "_" . $no_belakang;
    $transaksi['urut'] = $no_belakang;
    $transaksi['ongkos_kirim'] = $this->input->post("ongkos");
    $transaksi['kode_unit_jabung'] = 'LI_001';
    $transaksi['kategori_penjualan'] = $this->input->post("pilihan");
    $transaksi['kategori_penjualan'] = $this->input->post("pilihan");

    $this->db->insert('transaksi_penjualan', $transaksi);

    $this->db->delete('opsi_transaksi_penjualan_temp', array('kode_penjualan' => $data['kode_penjualan'],'kode_unit_jabung' =>'LI_001'));
    $update_pesanan['status']='Diterima';
    $this->db->update('transaksi_pesanan', $update_pesanan,array('kode_pesanan' => @$data['pesanan_penjualan'],'kode_unit_jabung' =>'LI_001'));
        #echo $this->db->last_query();

    $keuangan['kode_jenis_keuangan'] = '1';
    $keuangan['nama_jenis_keuangan'] = 'Pemasukan';
    $keuangan['kode_kategori_keuangan'] = '1.1';
    $keuangan['nama_kategori_keuangan'] = 'Penjualan';
    $kode_sub = '';
    if ($data['jenis_transaksi'] == 'tunai') {
        $kode_sub = '1.1.1';
    } elseif ($data['jenis_transaksi'] == 'debet') {
        $kode_sub = '1.1.2';
    } elseif ($data['jenis_transaksi'] == 'kredit') {
        $kode_sub = '1.1.3';
    } else {
        $kode_sub = '2.6.2';
    }

    $keuangan['kode_unit_jabung'] = 'LI_001';
    $keuangan['kode_sub_kategori_keuangan'] = $kode_sub;
    $this->db->select('nama_sub_kategori_akun');
    //$this->db->where('kode_unit_jabung','LI_001');
    $kategori = $this->db->get_where('keuangan_sub_kategori_akun', array('kode_sub_kategori_akun' =>
        $kode_sub));
    $hasil_kategori = $kategori->row();
    $keuangan['nama_sub_kategori_keuangan'] = $hasil_kategori->
    nama_sub_kategori_akun;
    if ($data['jenis_transaksi'] == 'tunai') {
        $keuangan['nominal'] = $data['grand_total'];
        $keuangan['tanggal_transaksi'] = date('Y-m-d');
        $keuangan['id_petugas'] = $id_petugas;
        $keuangan['petugas'] = $nama_petugas;
        $keuangan['kode_referensi'] = $data['kode_penjualan_baru'];
        $this->db->insert('keuangan_masuk', $keuangan);
    }elseif ($data['jenis_transaksi'] == 'kredit') {
        $keuangan['nominal'] = $data['bayar'];
        $keuangan['tanggal_transaksi'] = date('Y-m-d');
        $keuangan['id_petugas'] = $id_petugas;
        $keuangan['petugas'] = $nama_petugas;
        $keuangan['kode_referensi'] = $data['kode_penjualan_baru'];
        $this->db->insert('keuangan_masuk', $keuangan);
    }elseif ($data['jenis_transaksi']=='debet') {
       $keuangan['nominal'] = $data['grand_total'];
       $keuangan['tanggal_transaksi'] = date('Y-m-d');
       $keuangan['id_petugas'] = $id_petugas;
       $keuangan['petugas'] = $nama_petugas;
       $keuangan['kode_referensi'] = $data['kode_penjualan_baru'];
       $this->db->insert('keuangan_masuk', $keuangan);
   }else{
     $keuangan['nominal'] = $data['grand_total'];
     $keuangan['tanggal_transaksi'] = date('Y-m-d');
     $keuangan['id_petugas'] = $id_petugas;
     $keuangan['petugas'] = $nama_petugas;
     $keuangan['keterangan'] = 'Penjualan Konsinyasi';
     $keuangan['kode_referensi'] = $data['kode_penjualan_baru'];
     $this->db->insert('keuangan_keluar', $keuangan);
 }


 if ($data['jenis_transaksi'] == 'kredit') {
    $piutang['kode_unit_jabung'] = 'LI_001';
    $piutang['kode_transaksi'] = $data['kode_penjualan_baru'];
    $piutang['kode_anggota'] = $data['kode_member'];
    $piutang['nama_anggota'] = $data['nama_member'];
    $piutang['nominal'] = $data['grand_total'] - $data['bayar'];
    $piutang['sisa'] = $data['grand_total'] - $data['bayar'];
    $piutang['tanggal_transaksi'] = date("Y-m-d");
    $piutang['petugas'] = $nama_petugas;
    $piutang['status'] = 'member';
    $this->db->insert('transaksi_piutang', $piutang);
}


}


public function hapus_pesanan_temp()
{
    $id = $this->input->post('id');
    $cek = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('id' => $id));
    $hasil_cek = $cek->row();

    $this->db->delete('opsi_transaksi_penjualan_jasa_temp', array('id' => $id));
   // echo $this->db->last_query();

}
public function hapus_deskripsi_temp()
{
    $id = $this->input->post('id');
    $cek = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi_temp', array('id' => $id));
    $hasil_cek = $cek->row();

    $this->db->delete('opsi_transaksi_penjualan_jasa_deskripsi_temp', array('id' => $id));


}
public function get_pesanan_temp()
{
    $id = $this->input->post('id');
    $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp', array('id' =>
        $id));
    $hasil_pesanan = $get_pesanan->row();
    $hasil = json_encode($hasil_pesanan);

    echo $hasil;
}
public function get_deskripsi_temp()
{
    $id = $this->input->post('id');
    $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi_temp', array('id' =>
        $id));
    $hasil_pesanan = $get_pesanan->row();
    echo json_encode($hasil_pesanan);

    
}
public function get_total_temp()
{

    $kode_member = $this->input->post('kode_member');
    $kode_kasir = $this->input->post('kode_kasir');
    $this->db->select_sum('subtotal', 'total');
    
    $get_total = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('kode_kasir' =>
        $kode_kasir));
    $hasil = $get_total->row();

    $get_member = $this->db->get_where('master_member', array('kode_member' =>
        $kode_member));
    $hasil_member = $get_member->row();
   // echo $this->db->last_query();
    @$ongkir=$hasil_member->ongkir;
    $total=$hasil->total;
    $grand_total=$total;
    $hasil_total = array("total" => format_rupiah($grand_total), 
        "total2" => $grand_total
        );
    echo json_encode($hasil_total);
}
public function diskon_persen()
{
        #$no_meja = $this->input->post('no_meja');
    $kode_penjualan = $this->input->post('kode_penjualan');
    $kode_kasir = $this->input->post('kode_kasir');
    $diskon = $this->input->post('diskon_persen');
    $this->db->select_sum('subtotal', 'total');
    $this->db->where('kode_unit_jabung','LI_001');
    $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_kasir' =>
        $kode_kasir));
    $hasil = $get_total->row();
    echo $hasil->total;
}

public function diskon_all()
{
    $diskon = $this->input->post('rupiah');
    echo format_rupiah($diskon);
}

public function diskon_per_item()
{
    $diskon = $this->input->post();
    $harga_diskon = $diskon['harga'] - $diskon['diskon'];
    echo $harga_diskon;
}

public function grand_total()
{
    $kode_penjualan = $this->input->post('kode_penjualan');
    $kode_kasir = $this->input->post('kode_kasir');

    $this->db->select_sum('subtotal', 'total');

    $get_total = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('kode_kasir' =>
        $kode_kasir));
    $hasil = $get_total->row();


    $total_grand = ($hasil->total);
    $total_no=$total_grand;
    $totalnya = array('total_grand' => format_rupiah($total_grand), 'total_no' => $total_no);
    echo json_encode($totalnya);
}
public function kembalian()
{
    $dibayar = $this->input->post('dibayar');
    $total = $this->input->post('total');
    $hasil = $dibayar - $total;
    $hasil_hutang = abs($dibayar - $total);
    $hasil_kembalian = array(
        "kembalian1" => format_rupiah($hasil),
        "kembalian2" => $hasil,
        "hutang1" => format_rupiah($hasil_hutang),
        "hutang2" => $hasil_hutang,
        "dibayar" => format_rupiah($dibayar));
    echo json_encode($hasil_kembalian);
}
public function cek_status()
{
    // $kode_meja = $this->input->post('kode_meja');
    // $status_meja = $this->db->get_where('master_meja', array('no_meja' => $kode_meja));
    // $hasil_status = $status_meja->row();
    // if ($hasil_status->status == 0) {
    //     echo "aktif";
    // } else {
    //     echo "terpakai";
    // }
}

public function pindah_meja()
{
    $asal = $this->input->post('meja_asal');
    $tujuan = $this->input->post('meja_akhir');
    $update['kode_meja'] = $tujuan;
    $this->db->update('opsi_transaksi_penjualan_temp', $update, array('kode_meja' =>
        $asal));
    $update_asal['status'] = 0;
    $this->db->update('master_meja', $update_asal, array('no_meja' => $asal));
    $update_tujuan['status'] = 1;
    $this->db->update('master_meja', $update_tujuan, array('no_meja' => $tujuan));
        #echo ;
}

public function gabung_meja()
{
    $kode_meja = $this->input->post('kode_meja');
    $gabungan = $this->input->post('gabungan');
    $cek_meja = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
        $kode_meja));

    $update_status['status_meja'] = 'digabung';
    $this->db->update('opsi_transaksi_penjualan_temp', $update_status, array('kode_meja' =>
        $kode_meja));
    $hasil_cek = $cek_meja->result();
    if (count($hasil_cek) < 1) {
        echo '<div style="font-size:1.5em" class="alert alert-warning">Menu Belum Dipesan Silakan Pesan Menu</div>';
    } else {
        for ($i = 0; $i < count($gabungan); $i++) {
            $gabung_meja = $gabungan[$i];
            $update['status'] = '1';
            $this->db->update('master_meja', $update, array('no_meja' => $gabung_meja));
            foreach ($hasil_cek as $daftar) {
                $pesanan['kode_kasir'] = $daftar->kode_kasir;
                $pesanan['kode_penjualan'] = $daftar->kode_penjualan;
                $pesanan['kode_meja'] = $gabung_meja;
                $pesanan['kategori_menu'] = $daftar->kategori_menu;
                $pesanan['kode_menu'] = $daftar->kode_menu;
                $pesanan['nama_menu'] = $daftar->nama_menu;
                $pesanan['jumlah'] = $daftar->jumlah;
                $pesanan['kode_satuan'] = $daftar->kode_satuan;
                $pesanan['nama_satuan'] = $daftar->nama_satuan;
                $pesanan['harga_satuan'] = $daftar->harga_satuan;
                $pesanan['diskon_item'] = $daftar->diskon_item;
                $pesanan['subtotal'] = $daftar->subtotal;
                $pesanan['status_menu'] = $daftar->status_menu;
                $pesanan['status_meja'] = 'digabung';
                    #$pesanan['kode_kasir'] = $daftar->kode_kasir;
                $this->db->insert('opsi_transaksi_penjualan_temp', $pesanan);
            }

        }
        echo '<div style="font-size:1.5em" class="alert alert-success">Berhasil Gabung Meja</div>';
    }
}

public function get_taking_order()
{
    $data = $this->input->post();
    $kode_kasir = $this->uri->segment(4);
    $opsi_to = $this->db->get_where('opsi_taking_order', array('kode_transaksi' => $data['kode_transaksi']));
    $hasil_to = $opsi_to->result();
    foreach ($hasil_to as $daftar) {
        $penjualan_temp['kode_kasir'] = $kode_kasir;
        $penjualan_temp['kode_penjualan'] = $data['kode_penjualan'];
        $penjualan_temp['kode_menu'] = $daftar->kode_menu;
        $penjualan_temp['nama_menu'] = $daftar->nama_menu;
        $penjualan_temp['jumlah'] = $daftar->jumlah;
        $penjualan_temp['kode_satuan'] = $daftar->kode_satuan;
        $penjualan_temp['nama_satuan'] = $daftar->nama_satuan;
        $penjualan_temp['harga_satuan'] = $daftar->harga_satuan;
        $penjualan_temp['diskon_item'] = $daftar->diskon_item;
        $penjualan_temp['subtotal'] = $daftar->subtotal;
        $penjualan_temp['status_menu'] = $daftar->status_menu;

        $this->db->insert('opsi_transaksi_penjualan_temp', $penjualan_temp);
            //echo $this->db->last_query();
    }

    $status['status'] = 'selesai';
    $this->db->update('taking_order', $status, array('kode_transaksi' => $data['kode_transaksi']));

    $get_to = $this->db->get_where('taking_order', array('kode_transaksi' => $data['kode_transaksi']));
    $hasil_to = $get_to->row();
    echo json_encode($hasil_to);
}


public function cetak_bill()
{
    $kode_meja = $this->input->post('kode_meja');
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
        $kode_meja));
    $hasil_pesanan = $pesanan->row();

        #$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

    /* text */
    $printTestText = "                $hasil_setting->nama_resto        \n";
    $printTestText .= "              $hasil_setting->alamat_resto      \n";
        // $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
    $printTestText .= "               $hasil_setting->telp_resto      \n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "               GUEST BILL                    \n";

    $printTestText .= "\n";
    $printTestText .= "Inv. ID    : " . $hasil_pesanan->kode_penjualan . "\n";
    $printTestText .= "Tanggal    : " . TanggalIndo(date('Y-m-d')) . "\n";
        #$printTestText .= "Payment : ".$hasil[0]->status."\n";
    $printTestText .= "Meja       : " . $hasil_pesanan->kode_meja . "\n";
    $get_id_petugas = $this->session->userdata('astrosession');
    $id_petugas = $get_id_petugas->id;
    $nama_petugas = $get_id_petugas->uname;
    $printTestText .= "Kasir      : " . $nama_petugas . "\n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "Menu          Harga   Jml   Diskon   Subtotal\n";
    $printTestText .= "---------------------------------------------\n";

    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
        $hasil_pesanan->kode_meja));
    $hasil_menu = $menu->result();

    foreach ($hasil_menu as $daftar) {

        $lenset = 12;
        $lennama_produk = strlen($daftar->nama_menu);
        $len = $lenset <= $lennama_produk ? $lenset : $lennama_produk;
        $lenspace = 12 - $len;
        $nama_produk = substr($daftar->nama_menu, 0, $lenset);
        $space = "";
        for ($i = 0; $i < $lenspace; $i++) {
            $space .= ' ';
        }
            //System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
            //$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);

        $printTestText .= bill_php_Left($daftar->nama_menu, 12) . bill_php_right($daftar->
            harga_satuan, 7) . bill_php_right($daftar->jumlah, 6) . bill_php_right($daftar->
            diskon_item, 7) . "%" . bill_php_right($daftar->subtotal, 12) . "\n";

            /*$printTestText .= $nama_produk . " " . $daftar->keterangan . $space . " " . $daftar->
            harga_satuan . " " . $space . " " . $daftar->jumlah . " " . $space . " " . $daftar->
            diskon_item . "%" . " " . $space . " " . $daftar->subtotal . "\n";*/
        }

        $printTestText .= "---------------------------------------------\n";
        #$printTestText .= "Detail Pembayaran\n";
        $total = 0;
        foreach ($hasil_menu as $totalan) {
            $total += $totalan->subtotal;
        }
        $printTestText .= "Total	: " . format_rupiah($total) . "\n";
        /*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
        $printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
        // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
        $printTestText .= "----------------------------------------\n";
        $printTestText .= "               Terima Kasih             \n";
        $printTestText .= "        Barang yang sudah dibeli        \n";
        $printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
        // $printTestText .= " ".$footer."    \n";*/
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";


        // /* tulis dan buka koneksi ke printer */
        // $printer = printer_open("SP-POS76II");
        // /* write the text to the print job */
        // printer_set_option($handle, PRINTER_MODE, "RAW");
        // printer_write($printer, $printTestText);
        // /* close the connection */
        // printer_close($printer);
        //$handle = printer_open("canon_ip2700_series");

        $handle = printer_open($hasil_setting->printer);
        printer_set_option($handle, PRINTER_MODE, "RAW");
        #$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
        #printer_select_font($handle, $font);
        printer_write($handle, $printTestText);
        printer_close($handle);
        // print_r($printTestText);exit;
    }

    public function cetak_pesanan()
    {
        $kode_meja = $this->input->post('kode_meja');
        $setting = $this->db->get('master_setting');
        $hasil_setting = $setting->row();
        $pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
            $kode_meja));
        $hasil_pesanan = $pesanan->row();

        #$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

        /* text */
        $printTestText = "                $hasil_setting->nama_resto        \n";
        $printTestText .= "              $hasil_setting->alamat_resto      \n";
        // $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
        $printTestText .= "               $hasil_setting->telp_resto      \n";
        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "                  LIST ORDER                 \n";

        $printTestText .= "\n";
        $printTestText .= "Inv. ID    : " . $hasil_pesanan->kode_penjualan . "\n";
        $printTestText .= "Tanggal    : " . TanggalIndo(date('Y-m-d')) . "\n";
        $printTestText .= "Meja       : " . $hasil_pesanan->kode_meja . "\n";
        #$printTestText .= "Payment : ".$hasil[0]->status."\n";
        #$printTestText .= "Kasir : ".$nama->nama."\n";
        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "Nama Menu                Jumlah              \n";
        $printTestText .= "---------------------------------------------\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
            $hasil_pesanan->kode_meja));
        $hasil_menu = $menu->result();

        foreach ($hasil_menu as $daftar) {

            $lenset = 25;
            $lennama_produk = strlen($daftar->nama_menu);
            $len = $lenset <= $lennama_produk ? $lenset : $lennama_produk;
            $lenspace = 23 - $len;
            $nama_produk = substr($daftar->nama_menu, 0, $lenset);
            ;
            $space = "";
            for ($i = 0; $i < $lenspace; $i++) {
                $space .= ' ';
            }
            //System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
            //$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);

            $printTestText .= bill_php_Left($daftar->nama_menu, 25) . bill_php_Left($daftar->
                jumlah, 20) . "\n";
            /*$printTestText .= $nama_produk . " " . $daftar->keterangan . " " . $space . " " .
            $daftar->jumlah . "\n";*/
        }

        $printTestText .= "---------------------------------------------\n";
        /*	$printTestText .= "Detail Pembayaran\n";
        $printTestText .= "Total	: Rp. ".$hasil[0]->total.",-\n";
        $printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
        $printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
        // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
        $printTestText .= "----------------------------------------\n";
        $printTestText .= "               Terima Kasih             \n";
        $printTestText .= "        Barang yang sudah dibeli        \n";
        $printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
        // $printTestText .= " ".$footer."    \n";*/
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";


        // /* tulis dan buka koneksi ke printer */
        // $printer = printer_open("SP-POS76II");
        // /* write the text to the print job */
        // printer_set_option($handle, PRINTER_MODE, "RAW");
        // printer_write($printer, $printTestText);
        // /* close the connection */
        // printer_close($printer);
        //$handle = printer_open("canon_ip2700_series");

        $handle = printer_open($hasil_setting->printer);
        printer_set_option($handle, PRINTER_MODE, "RAW");
        $font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
        printer_select_font($handle, $font);
        printer_write($handle, $printTestText);
        printer_close($handle);
        // print_r($printTestText);exit;
    }

    public function cetak_pembayaran()
    {
        $kode_meja = $this->input->post('kode_meja');
        $kode_penjualan = $this->input->post('kode_penjualan_baru');
        $jenis_bayar = $this->input->post('jenis_transaksi');
        $setting = $this->db->get('master_setting');
        $hasil_setting = $setting->row();
        $pesanan = $this->db->get_where('opsi_transaksi_penjualan', array('kode_meja' =>
            $kode_meja, 'kode_penjualan' => $kode_penjualan));
        //$pesanan = $this->db->get_where('opsi_transaksi_penjualan', array('kode_penjualan' =>
        //                $kode_penjualan));
        $hasil_pesanan = $pesanan->row();

        #$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

        /* text */
        $printTestText = bill_php_middle($hasil_setting->nama_resto, 45) . "\n";
        $printTestText .= bill_php_middle_alamat($hasil_setting->alamat_resto, 45) . "\n";
        // $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
        $printTestText .= bill_php_middle($hasil_setting->telp_resto, 45) . "\n";
        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "Inv. ID    : " . $kode_penjualan . "\n";
        $printTestText .= "Tanggal    : " . TanggalIndo(date('Y-m-d')) . "\n";
        $printTestText .= "Payment    : " . $jenis_bayar . "\n";
        $get_id_petugas = $this->session->userdata('astrosession');
        $id_petugas = $get_id_petugas->id;
        $nama_petugas = $get_id_petugas->uname;
        $printTestText .= "Kasir      : " . $nama_petugas . "\n";
        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "Harga           Jml      Diskon      Subtotal\n";
        $printTestText .= "---------------------------------------------\n";

        $menu = $this->db->get_where('opsi_transaksi_penjualan', array('kode_penjualan' =>
            $kode_penjualan));
        //$menu = $this->db->get_where('opsi_transaksi_penjualan', array('kode_penjualan' =>
        //                $kode_penjualan));
        $hasil_menu = $menu->result();

        foreach ($hasil_menu as $daftar) {

            $lenset = 12;
            $lennama_produk = strlen($daftar->nama_menu);
            $len = $lenset <= $lennama_produk ? $lenset : $lennama_produk;
            $lenspace = 12 - $len;
            $nama_produk = substr($daftar->nama_menu, 0, $lenset);
            $space = "";
            for ($i = 0; $i < $lenspace; $i++) {
                $space .= ' ';
            }
            //System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
            //$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);

            if ($daftar->jenis_diskon == 'persen') {
                $diskon = @$daftar->diskon_item . ' %';
            } else {
                $diskon = @$daftar->diskon_rupiah;
            }

            $printTestText .= bill_php_Left($daftar->nama_menu, 45) . "\n" . bill_php_Left($daftar->
                harga_satuan, 13) . bill_php_right($daftar->jumlah, 6) . bill_php_right($diskon,
                12) . bill_php_right($daftar->subtotal, 14) . "\n";
            }

            $printTestText .= "---------------------------------------------\n";
            $printTestText .= "Detail Pembayaran\n";
            $penjualan = $this->db->get_where('transaksi_penjualan', array('kode_penjualan' =>
                $kode_penjualan));
            $hasil_penjualan = $penjualan->row();
            $printTestText .= "Total           : Rp" . bill_php_right(format_rupiah_norp($hasil_penjualan->
                total_nominal), 25) . "\n";
            $printTestText .= "Diskon          : Rp" . bill_php_right(format_rupiah_norp($hasil_penjualan->
                diskon_rupiah), 25) . "\n";
            $printTestText .= "Ongkos Kirim    : Rp" . bill_php_right(format_rupiah_norp($hasil_penjualan->
                ongkos_kirim), 25) . "\n";
            $printTestText .= "Grand Total	: Rp" . bill_php_right(format_rupiah_norp($hasil_penjualan->
                grand_total), 25) . "\n";

            $printTestText .= "Bayar    	: Rp" . bill_php_right(format_rupiah_norp($hasil_penjualan->
                bayar), 25) . "\n";
            if ($jenis_bayar == 'kredit') {
                $hasil = "Sisa   ";
            } else {
                $hasil = "Kembali";
            }
            $printTestText .= "$hasil  	: Rp" . bill_php_right(format_rupiah_norp(abs($hasil_penjualan->
                kembalian)), 25) . "\n";
            $printTestText .= "---------------------------------------------\n";
            $printTestText .= "                   Terima Kasih             \n";
            $printTestText .= "              Barang yang sudah dibeli      \n";
            $printTestText .= "         Tidak dapat ditukar/dikembalikan   \n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
            $printTestText .= "\n";
        /*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
        $printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
        // $printTestText .= "    Harga sudah termasuk PPN 10%\n";
        
        $printTestText .= "               Terima Kasih             \n";
        $printTestText .= "        Barang yang sudah dibeli        \n";
        $printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
        // $printTestText .= " ".$footer."    \n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";
        $printTestText .= "\n";*/


        // /* tulis dan buka koneksi ke printer */
        // $printer = printer_open("SP-POS76II");
        // /* write the text to the print job */
        // printer_set_option($handle, PRINTER_MODE, "RAW");
        // printer_write($printer, $printTestText);
        // /* close the connection */
        // printer_close($printer);
        //$handle = printer_open("canon_ip2700_series");

        $handle = printer_open($hasil_setting->printer);
        printer_set_option($handle, PRINTER_MODE, "RAW");
        #$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
        #printer_select_font($handle, $font);
        printer_write($handle, $printTestText);
        printer_close($handle);
        // print_r($printTestText);exit;
    }

    //------------------------------------------ PERSONAL ----------------- --------------------//
    //----------------------------------------------------------------- --------------------//


    public function simpan_item_penjualan_temp()
    {

        $masukan = $this->input->post();

        $jumlah_stok = $this->db->get_where('master_menu', array('kode_menu' => $masukan['kode_menu']));
        $hasil_jumlah_stok = $jumlah_stok->row();
        $real_stock = $hasil_jumlah_stok->real_stok;

        if ($real_stock < $masukan['jumlah']) {
            echo "tidak cukup";
        } else {
            $get_produk = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_penjualan' =>
                $masukan['kode_penjualan'], 'kode_menu' => $masukan['kode_menu']));
            $hasil_get_produk = $get_produk->result();
            $total_get_produk = count($hasil_get_produk);
            if ($total_get_produk <= 0) {
                $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
                $masukan['harga_satuan'] = $hasil_jumlah_stok->harga_jual;
                $total = $masukan['jumlah'] * $hasil_jumlah_stok->harga_jual;
                $diskon = $total * $masukan['diskon_item'] / 100;
                $masukan['subtotal'] = $total - $diskon;
                $masukan['hpp'] = $hasil_jumlah_stok->hpp;
                $this->db->insert('opsi_transaksi_penjualan_temp', $masukan);
            } else {
                $produk = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_penjualan' =>
                    $masukan['kode_penjualan'], 'kode_menu' => $masukan['kode_menu']));
                $hasil_produk = $produk->row();
                $jumlah_produk = $hasil_produk->jumlah + $masukan['jumlah'];
                $jumlah_diskon = $hasil_produk->diskon_item + $masukan['diskon_item'];

                $masukan['jumlah'] = $jumlah_produk;
                $masukan['nama_menu'] = $hasil_jumlah_stok->nama_menu;
                $masukan['harga_satuan'] = $hasil_jumlah_stok->harga_jual;
                $masukan['diskon_item'] = $jumlah_diskon;
                $total = $jumlah_produk * $hasil_jumlah_stok->harga_jual;
                $diskon = $total * $jumlah_diskon / 100;
                $masukan['subtotal'] = $total - $diskon;
                $masukan['hpp'] = $hasil_jumlah_stok->hpp;

                $this->db->update('opsi_transaksi_penjualan_temp', $masukan, array('kode_penjualan' =>
                    $masukan['kode_penjualan'], 'kode_menu' => $masukan['kode_menu']));
            }
            echo "sukses";
        }
    }

    public function hapus_bahan_temp()
    {
        $kode_penjualan = $this->input->post('kode_penjualan');
        $this->db->delete('opsi_transaksi_penjualan_temp', array('kode_penjualan' => $kode_penjualan));
    }
    //--------------------------------------------RESERVASI--------------------------------------------------------//
    public function reservasi()
    {
        $param = $this->uri->segment(3);
        if (!empty($param)) {
            $cek_pesan = $this->db->get_where('opsi_transaksi_reservasi', array('kode_reservasi' =>
                $param));
            $hasil_pesan = $cek_pesan->result();
            foreach ($hasil_pesan as $pindah_temp) {
                $masuk['kode_reservasi'] = $pindah_temp->kode_reservasi;
                $masuk['kode_meja'] = $pindah_temp->kode_meja;
                $masuk['kategori_menu'] = $pindah_temp->kategori_menu;
                $masuk['kode_menu'] = $pindah_temp->kode_menu;
                $masuk['nama_menu'] = $pindah_temp->nama_menu;
                $masuk['jumlah'] = $pindah_temp->jumlah;
                $masuk['kode_satuan'] = $pindah_temp->kode_satuan;
                $masuk['nama_satuan'] = $pindah_temp->nama_satuan;
                $masuk['harga_satuan'] = $pindah_temp->harga_satuan;
                $masuk['diskon_item'] = $pindah_temp->diskon_item;
                $masuk['subtotal'] = $pindah_temp->subtotal;
                $this->db->insert('opsi_transaksi_reservasi_temp', $masuk);
            }
        }

        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/reservasi', null, true);
        $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
        $this->load->view('kasir/kasir/main', $data);
    }
    public function dft_reservasi()
    {
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/dft_reservasi', null, true);
        $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
        $this->load->view('kasir/kasir/main', $data);
    }
    public function detail_reservasi()
    {
        $data['aktif'] = 'kasir';
        $data['konten'] = $this->load->view('kasir/kasir/detail_reservasi', null, true);
        $data['halaman'] = $this->load->view('kasir/kasir/menu', $data, true);
        $this->load->view('kasir/kasir/main', $data);


    }

    public function batal()
    {
        $kode_reservasi = $this->input->post('kode_reservasi');
        $pelanggan = $this->db->get_where('transaksi_reservasi', array('kode_reservasi' =>
            $kode_reservasi));
        $hasil_pelanggan = $pelanggan->row();
        $this->db->delete('master_pelanggan', array('kode_pelanggan' => $hasil_pelanggan->
            kode_pelanggan));
        $this->db->delete('transaksi_reservasi', array('kode_reservasi' => $kode_reservasi));
        $this->db->delete('opsi_transaksi_reservasi', array('kode_reservasi' => $kode_reservasi));

    }


    public function pilih_meja()
    {
        $param = $this->input->post('reserv');
        $ruang = $this->input->post('ruang');
        if ($ruang == "") {
            $meja = $this->db->get('master_meja');
        } else {
            $meja = $this->db->get_where('master_meja', array('kode_ruang' => $ruang));
        }

        $hasil_meja = $meja->result();
        foreach ($hasil_meja as $daftar) {
            if (!empty($param)) {
                $cek_meja = $this->db->get_where('transaksi_reservasi', array('kode_reservasi' =>
                    $param, 'kode_meja' => $daftar->no_meja));
                $hasil_cek = $cek_meja->row();
                if (@$hasil_cek->kode_meja == $daftar->no_meja) {
                    echo "<input type='checkbox' checked='true' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
                } else {
                    echo "<input type='checkbox' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
                }
            } else {
                echo "<input type='checkbox' name='dipilih' value='$daftar->no_meja'>$daftar->no_meja<br />";
            }

        }
    }

    public function simpan_reservasi()
    {
        $reservasi = $this->input->post();
        @$kode_meja = @$reservasi['kode_meja'];
        unset($reservasi['hapus_meja']);
        $pesane = $this->db->get_where('opsi_transaksi_reservasi_temp', array('kode_reservasi' =>
            $reservasi['kode_reservasi']));
        $hasil_pesanan = $pesane->result();
        if (empty($kode_meja)) {
            echo "belum";
        }
        if (count($hasil_pesanan) < 1) {
            echo 'gagal';
        } else {
            for ($i = 0; $i < count($kode_meja); $i++) {
                $meja = $kode_meja[$i];
                $reservasi['kode_meja'] = $meja;

                #$reservasi['tanggal_transaksi']
                foreach ($hasil_pesanan as $daftar) {
                    $pesanan['kode_reservasi'] = $daftar->kode_reservasi;
                    $pesanan['kode_meja'] = $meja;
                    $pesanan['kategori_menu'] = $daftar->kategori_menu;
                    $pesanan['kode_menu'] = $daftar->kode_menu;
                    $pesanan['nama_menu'] = $daftar->nama_menu;
                    $pesanan['jumlah'] = $daftar->jumlah;
                    $pesanan['kode_satuan'] = $daftar->kode_satuan;
                    $pesanan['nama_satuan'] = $daftar->nama_satuan;
                    $pesanan['harga_satuan'] = $daftar->harga_satuan;
                    $pesanan['subtotal'] = $daftar->subtotal;

                    $this->db->insert('opsi_transaksi_reservasi', $pesanan);
                }
                $this->db->delete('opsi_transaksi_reservasi_temp', array('kode_reservasi' => $reservasi['kode_reservasi']));
                $this->db->insert('transaksi_reservasi', $reservasi);

            }


            #$this->db->insert('transaksi_reservasi',$reservasi);
            $pelanggan['kode_pelanggan'] = $reservasi['kode_pelanggan'];
            $pelanggan['nama_pelanggan'] = $reservasi['nama_pelanggan'];
            $pelanggan['alamat_pelanggan'] = $reservasi['alamat_pelanggan'];
            $pelanggan['telepon_pelanggan'] = $reservasi['telepon_pelanggan'];
            $this->db->insert('master_pelanggan', $pelanggan);
        }
        #echo $this->db->last_query();

    }

    public function simpan_edit_reservasi()
    {
        $reservasi = $this->input->post();
        $kode_meja = $reservasi['kode_meja'];
        $meja = '';
        unset($reservasi['hapus_meja']);
        for ($i = 0; $i < count($kode_meja); $i++) {
            $meja = $kode_meja[$i];
            $reservasi['kode_meja'] = $meja;
            #$reservasi['tanggal_transaksi']
            $cek_meja = $this->db->get_where('transaksi_reservasi', array('kode_meja' => $meja,
                'kode_reservasi' => $reservasi['kode_reservasi']));
            $hasil_cek = $cek_meja->row();
            if ($hasil_cek->kode_meja != $meja) {
                $this->db->insert('transaksi_reservasi', $reservasi);
                $this->db->group_by('kode_menu');
                $cek_pesanan = $this->db->get_where('opsi_transaksi_reservasi_temp', array('kode_reservasi' =>
                    $reservasi['kode_reservasi']));
                $hasil_cek_pesanan = $cek_pesanan->result();
                foreach ($hasil_cek_pesanan as $pesanku) {
                    $pesanan['kode_reservasi'] = $reservasi['kode_reservasi'];
                    $pesanan['kode_meja'] = $reservasi['kode_meja'];
                    $pesanan['kategori_menu'] = $pesanku->kategori_menu;
                    $pesanan['kode_menu'] = $pesanku->kode_menu;
                    $pesanan['nama_menu'] = $pesanku->nama_menu;
                    $pesanan['jumlah'] = $pesanku->jumlah;
                    $pesanan['kode_satuan'] = $pesanku->kode_satuan;
                    $pesanan['nama_satuan'] = $pesanku->nama_satuan;
                    $pesanan['harga_satuan'] = $pesanku->harga_satuan;
                    $pesanan['subtotal'] = $pesanku->subtotal;
                    $pesanan['keterangan'] = $pesanku->keterangan;
                    $this->db->insert('opsi_transaksi_reservasi', $pesanan);
                }
            } else {
                $this->db->update('transaksi_reservasi', $reservasi, array('kode_reservasi' => $reservasi['kode_reservasi'],
                    'kode_meja' => $meja));
                $cek_pesan = $this->db->get_where('opsi_transaksi_reservasi_temp', array('kode_reservasi' =>
                    $reservasi['kode_reservasi']));
                $hasil_cek_pesan = $cek_pesan->result();
                foreach ($hasil_cek_pesan as $diupdate) {
                    $update['kode_reservasi'] = $diupdate->kode_reservasi;
                    $update['kode_meja'] = $diupdate->kode_meja;
                    $update['kategori_menu'] = $diupdate->kategori_menu;
                    $update['kode_menu'] = $diupdate->kode_menu;
                    $update['nama_menu'] = $diupdate->nama_menu;
                    $update['jumlah'] = $diupdate->jumlah;
                    $update['kode_satuan'] = $diupdate->kode_satuan;
                    $update['nama_satuan'] = $diupdate->nama_satuan;
                    $update['harga_satuan'] = $diupdate->harga_satuan;
                    $update['subtotal'] = $diupdate->subtotal;
                    #$update['keterangan'] = $diupdate->keterangan;
                    $this->db->update('opsi_transaksi_reservasi', $update, array('kode_reservasi' =>
                        $diupdate->kode_reservasi));
                }
                $this->db->delete('opsi_transaksi_reservasi_temp', array('kode_reservasi' => $diupdate->
                    kode_reservasi));

            }
            $hapus_meja = $this->input->post('hapus_meja');
            for ($k = 0; $k < count($hapus_meja); $k++) {
                $hapus = $hapus_meja[$k];
                $cek_meja = $this->db->get_where('transaksi_reservasi', array('kode_reservasi' =>
                    $reservasi['kode_reservasi'], 'kode_meja' => $hapus));
                $hasil_cek_meja = $cek_meja->row();
                if (count($hasil_cek_meja) > 0) {
                    $this->db->delete('transaksi_reservasi', array('kode_reservasi' => $reservasi['kode_reservasi'],
                        'kode_meja' => $hasil_cek_meja->kode_meja));
                }
                $cek_hapus_pesan = $this->db->get_where('opsi_transaksi_reservasi', array('kode_reservasi' =>
                    $reservasi['kode_reservasi'], 'kode_meja' => $hapus));
                $hasil_cek_hapus = $cek_hapus_pesan->result();
                if (count($hasil_cek_hapus) > 0) {
                    foreach ($hasil_cek_hapus as $dihapus) {
                        $this->db->delete('opsi_transaksi_reservasi', array('kode_reservasi' => $reservasi['kode_reservasi'],
                            'kode_meja' => $dihapus->kode_meja));
                    }
                }
            }
            echo $meja;
        }
        #$this->db->insert('transaksi_reservasi',$reservasi);
        $pelanggan['nama_pelanggan'] = $reservasi['nama_pelanggan'];
        $pelanggan['alamat_pelanggan'] = $reservasi['alamat_pelanggan'];
        $pelanggan['telepon_pelanggan'] = $reservasi['telepon_pelanggan'];
        $this->db->update('master_pelanggan', $pelanggan, array('kode_pelanggan' => $reservasi['kode_pelanggan']));
    }

    public function batal_edit_reservasi()
    {
        $kode = $this->input->post('kode_reservasi');
        $this->db->delete('opsi_transaksi_reservasi_temp', array('kode_reservasi' => $kode));
    }

    public function status_selesai_reservasi()
    {
        $kode = $this->input->post('kode_reservasi');
        $status['status'] = 'selesai';
        $this->db->update('transaksi_reservasi', $status, array('kode_reservasi' => $kode));
    }

    public function pesanan_reservasi_temp()
    {
        $this->load->view('kasir/kasir/daftar_pesanan_reservasi_temp');
    }

    public function simpan_pesanan_reservasi_temp()
    {
        $reservasi = $this->input->post();
        $menu = $this->db->get_where('master_menu', array('kode_menu' => $reservasi['kode_menu']));
        $hasil_menu = $menu->row();
        $reservasi['kategori_menu'] = $hasil_menu->kategori_menu;
        $reservasi['nama_menu'] = $hasil_menu->nama_menu;
        $reservasi['kode_satuan'] = $hasil_menu->kode_satuan_stok;
        $reservasi['nama_satuan'] = $hasil_menu->satuan_stok;
        $harga_diskon = ($reservasi['harga_satuan'] * $reservasi['diskon_item']) / 100;
        $reservasi['harga_satuan'] = $reservasi['harga_satuan'] - $harga_diskon;
        $subtotal = $reservasi['jumlah'] * $reservasi['harga_satuan'];
        $reservasi['subtotal'] = $subtotal;
        $reservasi['diskon_item'] = $reservasi['diskon_item'];
        $this->db->insert('opsi_transaksi_reservasi_temp', $reservasi);
    }

    public function get_pesanan_reservasi_temp()
    {
        $id = $this->input->post('id');
        $get_pesanan = $this->db->get_where('opsi_transaksi_reservasi_temp', array('id' =>
            $id));
        $hasil_pesanan = $get_pesanan->row();
        $hasil = json_encode($hasil_pesanan);
        /*$get_komposisi = $this->db->get_where('opsi_menu',array('kode_menu'=>$hasil_pesanan->kode_menu));
        $hasil_komposisi = $get_komposisi->result();
        foreach($hasil_komposisi as $daftar){
        if($daftar->jenis_bahan=="Bahan Baku"){
        $get_baku = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$daftar->kode_bahan));
        $hasil_baku = $get_baku->row();
        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
        $pengurangan_bahan = $hasil_baku->real_stock + $bahan_keluar;
        $stok['real_stock'] = $pengurangan_bahan;
        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
        }elseif($daftar->jenis_bahan=="Bahan Jadi"){
        $get_jadi = $this->db->get_where('master_bahan_jadi',array('kode_bahan_jadi'=>$daftar->kode_bahan));
        $hasil_jadi = $get_jadi->row();
        $bahan_keluar = $daftar->jumlah_bahan*$hasil_pesanan->jumlah;
        $pengurangan_bahan = $hasil_jadi->real_stock + $bahan_keluar;
        $stok['real_stock'] = $pengurangan_bahan;
        $this->db->update('master_bahan_baku',$stok,array('kode_bahan_baku'=>$daftar->kode_bahan,'kode_rak'=>$daftar->kode_rak));
        }
    } */
    $this->db->delete('opsi_transaksi_reservasi_temp', array('kode_menu' => $hasil_pesanan->
        kode_menu, 'kode_reservasi' => $hasil_pesanan->kode_reservasi));
    echo $hasil;
}

public function hapus_pesanan_reservasi_temp()
{
    $id = $this->input->post('id');
    $this->db->delete('opsi_transaksi_reservasi_temp', array('id' => $id));
}

public function buka_reservasi()
{
    $kode_reservasi = $this->input->post('kode_reservasi');
    $trx['status'] = 'selesai';
    $this->db->update('transaksi_reservasi', $trx, array('kode_reservasi' => $kode_reservasi));
    $tgl = date("Y-m-d");
    $this->db->select_max('kode_transaksi');
    $kasir = $this->db->get_where('transaksi_kasir', array('tanggal' => $tgl,
        'status' => "open"));
    $hasil_cek_kasir = $kasir->row();
    $this->db->group_by('kode_menu');
    $pesanan = $this->db->get_where('opsi_transaksi_reservasi', array('kode_reservasi' =>
        $kode_reservasi));
    $hasil_pesanan = $pesanan->result();

    $no_belakang = 0;
    $this->db->select_max('kode_penjualan');
    $kode = $this->db->get_where('transaksi_penjualan', array('tanggal_penjualan' =>
        $tgl));
    $hasil_kode = $kode->row();
    ;
    $this->db->select('kode_penjualan');
    $kode_penjualan = $this->db->get('master_setting');
    $hasil_kode_penjualan = $kode_penjualan->row();
    if (count($hasil_kode) == 0) {
        $no_belakang = 1;
    } else {
        $pecah_kode = explode("_", $hasil_kode->kode_penjualan);
        $no_belakang = @$pecah_kode[2] + 1;
    }
    $kode_penjualan = @$hasil_kode_penjualan->kode_penjualan . "_" . date("dmyHis") .
    "_" . $no_belakang;
    $mejaku = "";
    foreach ($hasil_pesanan as $dipesan) {

        $penjualan['kode_kasir'] = $hasil_cek_kasir->kode_transaksi;
        $penjualan['kode_penjualan'] = $kode_penjualan;
        $penjualan['kode_meja'] = $dipesan->kode_meja;
        $penjualan['kategori_menu'] = $dipesan->kategori_menu;
        $penjualan['kode_menu'] = $dipesan->kode_menu;
        $penjualan['nama_menu'] = $dipesan->nama_menu;
        $penjualan['jumlah'] = $dipesan->jumlah;
        $penjualan['kode_satuan'] = $dipesan->kode_satuan;
        $penjualan['nama_satuan'] = $dipesan->nama_satuan;
        $penjualan['harga_satuan'] = $dipesan->harga_satuan;
        $penjualan['subtotal'] = $dipesan->subtotal;
        $this->db->insert('opsi_transaksi_penjualan_temp', $penjualan);
        $this->db->group_by('no_meja');
        $meja = $this->db->get_where('master_meja', array('no_meja' => $dipesan->
            kode_meja));
        $hasil_meja = $meja->row();
        $update['status'] = '1';
        $no_meja = $hasil_meja->no_meja;
        $this->db->update('master_meja', $update, array('no_meja' => $no_meja));
        $cek_status_menu = $this->db->get_where('master_menu', array('kode_menu' => $dipesan->
            kode_menu));
        $hasil_status = $cek_status_menu->row();

        $mejaku = $dipesan->kode_meja;
    }

    $this->db->delete('opsi_transaksi_reservasi', array('kode_reservasi' => $kode_reservasi));
    echo $mejaku;
}
    //------------------------------------------ PERSONAL ----------------- --------------------//
    //----------------------------------------------------------------- --------------------//
public function get_harga_personal()
{
    $kode_menu = $this->input->post('id_menu');
    $kode_meja = $this->input->post('kode_meja');
    $this->db->where('kode_unit_jabung','LI_001');
    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_menu' =>
        $kode_menu, 'kode_meja' => $kode_meja));
    $hasil_menu = $menu->row();
    echo json_encode($hasil_menu);
}

public function get_total_personal_temp()
{
    $no_meja = $this->input->post('no_meja');
    $this->db->select_sum('subtotal', 'total');
    $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
        $no_meja, 'status' => 'personal'));
    $hasil = $get_total->row();
    $hasil_total = array("total" => format_rupiah($hasil->total), "total2" => $hasil->
        total);
    echo json_encode($hasil_total);
}

public function grand_total_personal()
{
    $rupiah = $this->input->post('rupiah');
    $no_meja = $this->input->post('no_meja');
    $this->db->select_sum('subtotal', 'total');
    $get_total = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
        $no_meja, 'status' => 'personal'));
    $hasil = $get_total->row();
    $total_grand = $hasil->total - $rupiah;
    $totalnya = array('total_grand' => format_rupiah($total_grand), 'total_no' => $total_grand);
    echo json_encode($totalnya);
}

public function pesanan_personal_temp()
{
    $this->load->view('kasir/kasir/daftar_pesanan_personal_temp');
}

public function simpan_pesanan_personal_temp()
{
    $masukan = $this->input->post();
    if ($masukan['jumlah'] > $masukan['qty']) {
        echo "<div style='font-size:1em;' class='alert alert-warning'>Jumlah Melebihi Pesanan</div>";
    } else {
        unset($masukan['qty']);
        $kode_meja = $masukan['kode_meja'];
        $kode_pembelian = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
            $kode_meja));
        $hasil = $kode_pembelian->row();

        $this->db->group_by('kode_meja');
        $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_penjualan' =>
            $hasil->kode_penjualan));
        $hasil_cek_gabung = $cek_gabung->result();

        if (count($hasil_cek_gabung) <= 1) {
            $kode_menu = $masukan['kode_menu'];
            $get_menu = $this->db->get_where('master_menu', array('kode_menu' => $kode_menu));
            $hasil_getmenu = $get_menu->row();
            $masukan['kategori_menu'] = $hasil_getmenu->kategori_menu;
            $masukan['nama_menu'] = $hasil_getmenu->nama_menu;
            $masukan['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
            $masukan['nama_satuan'] = $hasil_getmenu->satuan_stok;
            $harga_diskon = ($masukan['harga_satuan'] * $masukan['diskon_item']) / 100;
            $masukan['harga_satuan'] = $masukan['harga_satuan'] - $harga_diskon;
            $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
            $masukan['subtotal'] = $subtotal;
            $masukan['status'] = 'personal';
            $masukan['status_menu'] = $hasil_getmenu->status_menu;
            $this->db->insert('opsi_transaksi_penjualan_temp', $masukan);
            $personal = $this->db->get_where('opsi_transaksi_penjualan_temp', array('kode_meja' =>
                $kode_meja, 'kode_menu' => $kode_menu));
            $hasil_personal = $personal->row();
                #if($hasil_personal->jumlah > $masukan['jumlah']){
            $qty['jumlah'] = $hasil_personal->jumlah - $masukan['jumlah'];
            $qty['subtotal'] = $hasil_personal->subtotal - ($hasil_personal->harga_satuan *
                $masukan['jumlah']);
            $this->db->update('opsi_transaksi_penjualan_temp', $qty, array('id' => $hasil_personal->
                id));
                # }elseif($hasil_personal->jumlah==$masukan['jumlah']){
                #$this->db->delete('opsi_transaksi_penjualan_temp',array('id'=>$hasil_personal->id));
                # }
                #echo "berhasil";
        } elseif (count($hasil_cek_gabung > 1)) {
            foreach ($hasil_cek_gabung as $daftar) {
                $kode_menu = $masukan['kode_menu'];
                $get_menu = $this->db->get_where('master_menu', array('kode_menu' => $kode_menu));
                $hasil_getmenu = $get_menu->row();
                $digabung['kode_penjualan'] = $daftar->kode_penjualan;
                $digabung['kode_meja'] = $daftar->kode_meja;
                $digabung['kode_menu'] = $hasil_getmenu->kode_menu;
                $digabung['jumlah'] = $masukan['jumlah'];
                $harga_diskon = ($masukan['harga_satuan'] * $masukan['diskon_item']) / 100;
                $digabung['harga_satuan'] = $masukan['harga_satuan'] - $harga_diskon;
                    #$digabung['harga_satuan'] = $masukan['harga_satuan'];
                $digabung['diskon_item'] = $masukan['diskon_item'];
                $digabung['kategori_menu'] = $hasil_getmenu->kategori_menu;
                $digabung['nama_menu'] = $hasil_getmenu->nama_menu;
                $digabung['kode_satuan'] = $hasil_getmenu->kode_satuan_stok;
                $digabung['nama_satuan'] = $hasil_getmenu->satuan_stok;
                $subtotal = $masukan['jumlah'] * $masukan['harga_satuan'];
                $digabung['subtotal'] = $subtotal;
                $digabung['status'] = 'personal';
                $digabung['status_menu'] = $hasil_getmenu->status_menu;

                $this->db->insert('opsi_transaksi_penjualan_temp', $digabung);
                    #echo $this->db->last_query();


            }
            $kode_menu = $masukan['kode_menu'];
            $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array(
                'kode_penjualan' => $masukan['kode_penjualan'],
                'status !=' => 'personal',
                'kode_menu' => $kode_menu));
            $hasil_menu = $menu->result();
            foreach ($hasil_menu as $dft) {
                $update['jumlah'] = $dft->jumlah - $masukan['jumlah'];
                $update['subtotal'] = $dft->subtotal - ($dft->harga_satuan * $masukan['jumlah']);
                $this->db->update('opsi_transaksi_penjualan_temp', $update, array(
                    'kode_penjualan' => $masukan['kode_penjualan'],
                    'status !=' => 'personal',
                    'kode_menu' => $kode_menu));
            }
                #$menu = $this->db->get_where('');

                #echo $this->db->last_query();

        }

    }

}

public function get_pesanan_personal_temp()
{
    $id = $this->input->post('id');
    $get_pesanan = $this->db->get_where('opsi_transaksi_penjualan_temp', array('id' =>
        $id));
    $hasil_pesanan = $get_pesanan->row();
    $hasil = json_encode($hasil_pesanan);

    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array(
        'kode_penjualan' => $hasil_pesanan->kode_penjualan,
        'kode_meja' => $hasil_pesanan->kode_meja,
        'kode_menu' => $hasil_pesanan->kode_menu,
        'status !=' => 'personal'));
    $hasil_menu = $menu->row();
    $jumlah['jumlah'] = $hasil_pesanan->jumlah + $hasil_menu->jumlah;
    $jumlah['subtotal'] = $hasil_pesanan->subtotal + $hasil_menu->subtotal;
    $this->db->update('opsi_transaksi_penjualan_temp', $jumlah, array(
        'kode_penjualan' => $hasil_pesanan->kode_penjualan,
        'kode_meja' => $hasil_pesanan->kode_meja,
        'kode_menu' => $hasil_pesanan->kode_menu,
        'status !=' => 'personal'));
    $this->db->delete('opsi_transaksi_penjualan_temp', array('id' => $id));
    echo $hasil;
}

public function hapus_pesanan_personal_temp()
{
    $id = $this->input->post('id');
    $cek = $this->db->get_where('opsi_transaksi_penjualan_temp', array('id' => $id));
    $hasil_cek = $cek->row();

    $cek_gabung = $this->db->get_where('opsi_transaksi_penjualan_temp', array(
        'kode_menu' => $hasil_cek->kode_menu,
        'kode_penjualan' => $hasil_cek->kode_penjualan,
        'status' => 'personal'));
    $hasil_cek_gabung = $cek_gabung->result();
    foreach ($hasil_cek_gabung as $hapus) {
        $this->db->delete('opsi_transaksi_penjualan_temp', array(
            'kode_menu' => $hapus->kode_menu,
            'kode_penjualan' => $hapus->kode_penjualan,
            'status' => 'personal'));

    }
    $this->db->group_by('kode_menu');
    $menu = $this->db->get_where('opsi_transaksi_penjualan_temp', array(
        'status !=' => 'personal',
        'kode_menu' => $hasil_cek->kode_menu,
        'kode_penjualan' => $hasil_cek->kode_penjualan));
    $hasil_menu = $menu->row();
    $update['jumlah'] = $hasil_cek->jumlah + $hasil_menu->jumlah;
    $update['subtotal'] = ($hasil_cek->jumlah + $hasil_menu->jumlah) * $hasil_menu->
    harga_satuan;

    $this->db->update('opsi_transaksi_penjualan_temp', $update, array(
        'status !=' => 'personal',
        'kode_penjualan' => $hasil_menu->kode_penjualan,
        'kode_menu' => $hasil_menu->kode_menu));


}

public function simpan_pembayaran_jasa()
{
    $data = $this->input->post();
    $kode_penjualan = $data['kode_penjualan'];

    $cek_personal = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi_temp', array('kode_penjualan' => $kode_penjualan));
    $hasil_personal = $cek_personal->result_array();
        #$this->db->group_by('kode_meja');
    $grand_total=0;
    foreach ($hasil_personal as $daftar) {
        $masukkan['kode_penjualan'] = $data['kode_penjualan'];
        $masukkan['ukuran'] = $daftar['ukuran'];
        $masukkan['kode_satuan'] = $daftar['kode_satuan'];
        $masukkan['nama_satuan'] = $daftar['nama_satuan'];
        $masukkan['harga_satuan'] = $daftar['harga_satuan'];
        $masukkan['subtotal'] = $daftar['subtotal'];
        $masukkan['kode_kasir'] = $data['kode_kasir'];
        $masukkan['tanggal_transaksi'] = date("Y-m-d");
        $masukkan['deskripsi'] = $daftar['deskripsi'];
        $this->db->insert('opsi_transaksi_penjualan_jasa_deskripsi', $masukkan);
        
        $grand_total+=$daftar['subtotal'];
    }

    $this->db->delete('opsi_transaksi_penjualan_jasa_deskripsi_temp', array('kode_penjualan' => $kode_penjualan));
    $transaksi['kode_kasir'] = $data['kode_kasir'];
    $transaksi['kode_penjualan'] = $data['kode_penjualan'];
    $transaksi['tanggal_penjualan'] = $data['tanggal_transaksi'];
    $transaksi['jam_penjualan'] = date("H:i:s");
    $transaksi['grand_total'] = $grand_total;
    $transaksi['bayar'] = $data['bayar'];
    $transaksi['kembalian'] = $data['kembalian'];
    $transaksi['id_petugas'] = $data['id_petugas'];
    $transaksi['petugas'] = $data['nama_petugas'];
    $transaksi['kode_member'] = $data['kode_member'];
    $get_member = $this->db->get_where('master_member', array('kode_member' => $data['kode_member']));
    $hasil_member = $get_member->row();

    $transaksi['nama_member'] = $hasil_member->nama_member;
    $transaksi['kode_proyek'] = $data['kode_proyek'];
    $get_proyek = $this->db->get_where('master_proyek', array('kode_proyek' => $data['kode_proyek']));
    $hasil_proyek = $get_proyek->row();
    
    $transaksi['nama_proyek'] = $hasil_proyek->nama_proyek;
    $transaksi['keterangan'] = $data['keterangan'];
    $this->db->insert('transaksi_penjualan_jasa', $transaksi);


    


}
public function simpan_validasi_penjualan()
{
    $data = $this->input->post();
    $kode_penjualan = $data['kode_penjualan'];

    $get_id_petugas = $this->session->userdata('astrosession');
    $id_petugas = $get_id_petugas->id;
    $nama_petugas = $get_id_petugas->uname;


    $cek_personal = $this->db->get_where('opsi_transaksi_penjualan_jasa_temp', array('kode_penjualan' => $kode_penjualan));
    $hasil_personal = $cek_personal->result();
        #$this->db->group_by('kode_meja');
    $grand_total=$data['grand_total'];
    foreach ($hasil_personal as $daftar) {
        $simpan_masukan['kode_penjualan'] = $daftar->kode_penjualan;
        $simpan_masukan['kode_menu'] = $daftar->kode_menu;
        $simpan_masukan['nama_menu'] = $daftar->nama_menu;
        $simpan_masukan['jumlah'] = $daftar->jumlah;
        
        $simpan_masukan['kode_satuan'] = $daftar->kode_satuan;
        $simpan_masukan['nama_satuan'] = $daftar->nama_satuan;
        $simpan_masukan['harga_satuan'] = $daftar->harga_satuan;
        $simpan_masukan['subtotal'] = $daftar->subtotal;
        $simpan_masukan['tanggal_transaksi'] = date('Y-m-d');
        $user = $this->session->userdata('astrosession');
        $id_petugas = $user->id;
        $simpan_masukan['kode_kasir'] = $id_petugas;
        $this->db->insert('opsi_transaksi_penjualan_jasa', $simpan_masukan);      


        $bahan_baku = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $daftar->kode_menu));
        $hasil_bahan_baku = $bahan_baku->row();

        $stok['real_stock']=$hasil_bahan_baku->real_stock - $daftar->jumlah;
        $this->db->update('master_bahan_baku', $stok,array('kode_bahan_baku' => $daftar->kode_menu));
        

        $trans_stok['jenis_transaksi'] = 'penjualan jasa';
        $trans_stok['kode_transaksi'] = $kode_penjualan;
        $trans_stok['kategori_bahan'] = 'Stok';
        $trans_stok['kode_bahan'] = $daftar->kode_menu;
        $trans_stok['nama_bahan'] = $daftar->nama_menu;
        $trans_stok['stok_keluar'] = $daftar->jumlah;
        $trans_stok['hpp'] = $hasil_bahan_baku->hpp;
        $trans_stok['id_petugas'] = $get_id_petugas->id;
        $trans_stok['nama_petugas'] = $get_id_petugas->uname;
        $trans_stok['tanggal_transaksi'] = date('Y-m-d');
        $trans_stok['posisi_awal'] = 'gudang';
        $trans_stok['posisi_akhir'] = 'Member';

        $insert_trans_stok = $this->db->insert('transaksi_stok', $trans_stok);
    } 

    $transaksi['grand_total']=$grand_total;
    $transaksi['bayar'] = $data['dibayar'];
    $transaksi['jenis_transaksi'] = $data['jenis_transaksi'];
    $transaksi['validasi']='valid';
    $this->db->update('transaksi_penjualan_jasa',$transaksi, array('kode_penjualan' =>$kode_penjualan));

    $this->db->delete('opsi_transaksi_penjualan_jasa_temp', array('kode_penjualan' => $kode_penjualan));

    if ($data['jenis_transaksi'] == 'Tunai') {
        $kode_sub = '1.1.6';
    } elseif ($data['jenis_transaksi'] == 'Kredit') {
        $kode_sub = '1.1.7';
    }
    $kategori = $this->db->get_where('keuangan_sub_kategori_akun', array('kode_sub_kategori_akun' =>$kode_sub));
    $hasil_kategori = $kategori->row();
    $keuangan['kode_jenis_keuangan'] = $hasil_kategori->kode_jenis_akun;
    $keuangan['nama_jenis_keuangan'] = $hasil_kategori->nama_jenis_akun;
    $keuangan['kode_kategori_keuangan'] = $hasil_kategori->kode_kategori_akun;
    $keuangan['nama_kategori_keuangan'] = $hasil_kategori->nama_kategori_akun;
    $keuangan['kode_sub_kategori_keuangan'] = $hasil_kategori->kode_sub_kategori_akun;
    $keuangan['nama_sub_kategori_keuangan'] = $hasil_kategori->nama_sub_kategori_akun;
    $keuangan['nominal'] = $data['dibayar'];
    $keuangan['tanggal_transaksi'] = date('Y-m-d');
    $keuangan['id_petugas'] = $id_petugas;
    $keuangan['petugas'] = $nama_petugas;
    $keuangan['kode_referensi'] = $kode_penjualan;
    $this->db->insert('keuangan_masuk', $keuangan);
    if($data['jenis_transaksi'] == 'Kredit') {
     $piutang['kode_transaksi'] = $kode_penjualan;
     $piutang['kode_customer'] = $data['kode_member'];
     $piutang['nama_customer'] = $data['nama_member'];
     $piutang['nominal_piutang'] = @$data['grand_total'] - @$data['dibayar'];
     $piutang['sisa'] = @$data['grand_total'] - @$data['dibayar'];
     $piutang['tanggal_transaksi'] = date("Y-m-d");
     $piutang['petugas'] = $nama_petugas;
     $piutang['jatuh_tempo'] = @$data['jatuh_tempo'];
     $this->db->insert('transaksi_piutang', $piutang);
 }


}

public function cetak_pembayaran_personal()
{
    $kode_meja = $this->input->post('kode_meja');
    $kode_penjualan = $this->input->post('kode_penjualan_baru');
    $jenis_bayar = $this->input->post('jenis_transaksi');
    $setting = $this->db->get('master_setting');
    $hasil_setting = $setting->row();
    $pesanan = $this->db->get_where('opsi_transaksi_penjualan', array(
        'kode_meja' => $kode_meja,
        'kode_penjualan' => $kode_penjualan,
        'status' => 'personal'));
    $hasil_pesanan = $pesanan->row();

    #$nama = $this->db->query("select * from atombizz_employee WHERE id='".$hasil[0]->user_id."'")->row();

    /* text */
    $printTestText = "                $hasil_setting->nama_resto        \n";
    $printTestText .= "              $hasil_setting->alamat_resto      \n";
    // $printTestText .= "      TOKO BASMALAH CAB. WONOREJO      \n";
    $printTestText .= "               $hasil_setting->telp_resto      \n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "          NOTA PEMBAYARAN PERSONAL        \n";
    $printTestText .= "Inv. ID    : " . $hasil_pesanan->kode_penjualan . "\n";
    $printTestText .= "Tanggal    : " . TanggalIndo(date('Y-m-d')) . "\n";
    $printTestText .= "Payment    : " . $jenis_bayar . "\n";
    $get_id_petugas = $this->session->userdata('astrosession');
    $id_petugas = $get_id_petugas->id;
    $nama_petugas = $get_id_petugas->uname;
    $printTestText .= "Kasir      : " . $nama_petugas . "\n";
    $printTestText .= "Meja       : " . $hasil_pesanan->kode_meja . "\n";
    $printTestText .= "---------------------------------------------\n";
    $printTestText .= "Menu          Harga   Jml   Diskon   Subtotal\n";
    $printTestText .= "---------------------------------------------\n";

    $menu = $this->db->get_where('opsi_transaksi_penjualan', array(
        'kode_meja' => $kode_meja,
        'kode_penjualan' => $kode_penjualan,
        'status' => 'personal'));
    $hasil_menu = $menu->result();

    foreach ($hasil_menu as $daftar) {

        $lenset = 12;
        $lennama_produk = strlen($daftar->nama_menu);
        $len = $lenset <= $lennama_produk ? $lenset : $lennama_produk;
        $lenspace = 12 - $len;
        $nama_produk = substr($daftar->nama_menu, 0, $lenset);
        $space = "";
        for ($i = 0; $i < $lenspace; $i++) {
            $space .= ' ';
        }
//System.out.printf("%10s (%10s) @%10s  %10s,\n",product_name,qty,price,subtotal).toString();
//$printTestText .= sprintf("%18s %4s %10s  %10s,\n",$nama_produk,$value->qty,$value->price,$value->discount_sub);

        $printTestText .= bill_php_Left($daftar->nama_menu, 12) . bill_php_right($daftar->
            harga_satuan, 7) . bill_php_right($daftar->jumlah, 6) . bill_php_right($daftar->
            diskon_item, 7) . "%" . bill_php_right($daftar->subtotal, 12) . "\n";
#$printTestText .= $nama_produk." ".$daftar->keterangan.$space." ".$daftar->harga_satuan." ".$space." ".$daftar->jumlah." ".$space." ".$daftar->diskon_item."%"." ".$space." ".$daftar->subtotal."\n";
        }

        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "Detail Pembayaran\n";
        $penjualan = $this->db->get_where('transaksi_penjualan', array('kode_penjualan' =>
            $kode_penjualan));
        $hasil_penjualan = $penjualan->row();
        $printTestText .= "Total           : " . format_rupiah($hasil_penjualan->
            total_nominal) . "\n";
        $printTestText .= "Diskon          : " . format_rupiah($hasil_penjualan->
            diskon_rupiah) . "\n";
        $printTestText .= "Grand Total	: " . format_rupiah($hasil_penjualan->
            grand_total) . "\n";
        $printTestText .= "Bayar    	: " . format_rupiah($hasil_penjualan->bayar) . "\n";
        $printTestText .= "Kembali  	: " . format_rupiah($hasil_penjualan->kembalian) .
        "\n";
        $printTestText .= "---------------------------------------------\n";
        $printTestText .= "                   Terima Kasih             \n";
/*	$printTestText .= "Bayar	: Rp. ".$hasil[0]->pay.",-\n";
$printTestText .= "Kembali: Rp. ".$hasil[0]->pay_back.",-\n";
// $printTestText .= "    Harga sudah termasuk PPN 10%\n";

$printTestText .= "               Terima Kasih             \n";
$printTestText .= "        Barang yang sudah dibeli        \n";
$printTestText .= "    Tidak dapat ditukar/dikembalikan    \n";
// $printTestText .= " ".$footer."    \n";*/
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";
$printTestText .= "\n";


// /* tulis dan buka koneksi ke printer */
// $printer = printer_open("SP-POS76II");
// /* write the text to the print job */
// printer_set_option($handle, PRINTER_MODE, "RAW");
// printer_write($printer, $printTestText);
// /* close the connection */
// printer_close($printer);
//$handle = printer_open("canon_ip2700_series");

$handle = printer_open($hasil_setting->printer);
printer_set_option($handle, PRINTER_MODE, "RAW");
#$font = printer_create_font("Arial", 72, 48, 400, false, false, false, 0);
#printer_select_font($handle, $font);
printer_write($handle, $printTestText);
printer_close($handle);
// print_r($printTestText);exit;
}
public function get_jasa()
{

    $start = (20*$this->input->post('page'));

    $this->db->limit(20,$start);
    $this->db->order_by('id','desc');
    $get_bb = $this->db->get('transaksi_penjualan_jasa');
    $hasil_bb = $get_bb->result();
    $nomor = $start+1;
    foreach ($hasil_bb as $daftar) { ?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $daftar->kode_penjualan; ?></td>
      <td><?php echo TanggalIndo($daftar->tanggal_penjualan) ?></td>
      <td><?php echo $daftar->nama_member ?></td>

      <td><?php echo format_rupiah($daftar->grand_total) ?></td>

      <td align="center"><?php #echo get_detail_valid($daftar->kode_penjualan); ?>
        <div class="btn-group">

          <a href="<?php echo base_url().'kasir/detail/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
          <?php if(@$daftar->validasi!='valid'){?>
          <a href="<?php echo base_url().'kasir/validasi/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Validasi" class="btn btn-icon-only btn-circle blue"><i class="fa fa-check-square-o"></i></a>
          <?php } ?>
      </div>
  </td>

</tr>


<?php 
$nomor++;
}
}

}

