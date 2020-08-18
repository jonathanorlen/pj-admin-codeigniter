<?php
$data = $this->input->post();
?>

<table style="font-size:1.5em" id="tabel_daftar" class="table table-bordered table-hover">
  <tr>
    <td width="10px">1</td>
    <td width="10px" colspan="3"><strong>Pemasukan</strong></td>
    <td width="10px"></td>
  </tr>

  <?php
  if(@$data['tgl_awal'] && @$data['tgl_akhir'] ){
    $tgl_awal = $data['tgl_awal'];
    $tgl_akhir = $data['tgl_akhir'];

    $this->db->where('tanggal_penjualan >=',$tgl_awal);
    $this->db->where('tanggal_penjualan <=',$tgl_akhir);
  }


  $this->db->select('*'); 
  $this->db->distinct();
  $this->db->select('kode_penjualan') ;
  $this->db->order_by('kode_penjualan','desc');
  $this->db->group_by('kode_penjualan');
  $this->db->where('jenis_transaksi !=','kredit') ;
                                # $this->db->where('tanggal_penjualan',date("Y-m-d"));
  $penjualan = $this->db->get('transaksi_penjualan');
  $hasil_penjualan = $penjualan->result();
  $keuangan = 0;
  foreach($hasil_penjualan as $total){
    $keuangan += $total->grand_total;
  }

  ?>

  <tr>
    <td width="10px"></td>
    <td width="10px"></td>
    <td colspan="2">Penjualan</td>
    <td align="right" width="10px"><?php echo format_rupiah($keuangan); ?></td>
  </tr>
  <?php 
  $tgl_awal=$data['tgl_awal'];
  $tgl_akhir=$data['tgl_akhir'];
  $sub_masuk=$this->db->query("SELECT * from keuangan_masuk where tanggal_transaksi >='$tgl_awal' and tanggal_transaksi <='$tgl_akhir' and kode_sub_kategori_keuangan !='1.1.1' group by kode_sub_kategori_keuangan");
  $hasil_sub_masuk=$sub_masuk->result();
  $hasil_masuk=0;
  foreach ($hasil_sub_masuk as $value) {
    ?>
    <tr>
      <td width="10px"></td>
      <td width="10px"></td>
      <?php


      $keungan_masuk=$this->db->query("SELECT SUM(nominal) as total from keuangan_masuk where tanggal_transaksi >='$tgl_awal' and tanggal_transaksi <='$tgl_akhir' and kode_sub_kategori_keuangan ='$value->kode_sub_kategori_keuangan'");
      $hasil_keuangan_masuk=$keungan_masuk->row();
      ?>
      <td colspan="2"><?php echo $value->nama_sub_kategori_keuangan;?></td>
      <td align="right" width="10px"><?php echo format_rupiah($hasil_keuangan_masuk->total); ?></td>
    </tr>
    <?php
    $hasil_masuk +=$hasil_keuangan_masuk->total;
  }
  ?>






  <tr>
    <td colspan="4" class="text-center"><strong> TOTAL PEMASUKAN</strong></td>
    <td align="right"><strong><?php echo format_rupiah($keuangan+$hasil_masuk); ?></strong></td>
  </tr>
                                                          <!--<tr>
                                  <td colspan="4" class="text-center"><strong>TOTAL </strong></td>
                                  <td align="right"></td>
                                </tr>-->






                                <tr>
                                  <td width="10px">2</td>
                                  <td width="10px" colspan="3"><strong>Pengeluaran</strong></td>
                                  <td width="10px"></td>
                                </tr>




                                <tr>
                                  <td width="20px"></td>
                                  <td width="20px"></td>

                                  <td colspan="2">HPP</td>
                                  <td width="250px" align="right">
                                    <?php

                                    if(@$data['tgl_awal'] && @$data['tgl_akhir'] ){
                                      $tgl_awal = $data['tgl_awal'];
                                      $tgl_akhir = $data['tgl_akhir'];

                                      $this->db->where('tanggal_transaksi >=',$tgl_awal);
                                      $this->db->where('tanggal_transaksi <=',$tgl_akhir);
                                    }
                                                #$this->db->where('tanggal_aktifitas',date("Y-m-d"));
                                  
                                    //$this->db->where('tanggal_transaksi',date("Y-m-d"));
                                    $hpp = $this->db->get('opsi_transaksi_penjualan');
                                    $hasil_hpp = $hpp->result();
                                    $total_hpp = 0;
                                   // echo $this->db->last_query();
                                    foreach ($hasil_hpp as $daftar) {
                                      $total_hpp += $daftar->jumlah * $daftar->hpp;
                                    }

                                    if(@$data['tgl_awal'] && @$data['tgl_akhir'] ){
                                      $tgl_awal = $data['tgl_awal'];
                                      $tgl_akhir = $data['tgl_akhir'];

                                      $this->db->where('tanggal_transaksi >=',$tgl_awal);
                                      $this->db->where('tanggal_transaksi <=',$tgl_akhir);
                                    }
                                    $hpp_jasa = $this->db->get('opsi_transaksi_penjualan_jasa');
                                    $hasil_hpp_jasa = $hpp_jasa->result();
                                    
                                   // echo $this->db->last_query();
                                    foreach ($hasil_hpp_jasa as $value) {
                                      $total_hpp += $value->jumlah * $value->harga_satuan;
                                    }

                                    ?>

                                    <?php

                                    echo format_rupiah($total_hpp); 
                                    ?>          
                                  </td>
                                </tr>
                                <?php 
                                $tgl_awal=$data['tgl_awal'];
                                $tgl_akhir=$data['tgl_akhir'];
                                $sub_keluar=$this->db->query("SELECT * from keuangan_keluar where tanggal_transaksi >='$tgl_awal' and tanggal_transaksi <='$tgl_akhir' and kode_sub_kategori_keuangan !='1.1.1' group by kode_sub_kategori_keuangan");
                                $hasil_sub_keluar=$sub_keluar->result();
                                $hasil_keluar=0;
                                foreach ($hasil_sub_keluar as $value) {
                                  ?>
                                <tr>
                                  <td width="10px"></td>
                                  <td width="10px"></td>
                                  <?php
                                  
                                  $tanggal=date('Y-m-d');
                                  $keungan_keluar=$this->db->query("SELECT SUM(nominal) as total from keuangan_keluar where tanggal_transaksi >='$tgl_awal' and tanggal_transaksi <='$tgl_akhir' and kode_sub_kategori_keuangan ='$value->kode_sub_kategori_keuangan'");
                                  $hasil_keuangan_keluar=$keungan_keluar->row();
                                  ?>
                                  <td colspan="2"><?php echo $value->nama_sub_kategori_keuangan;?></td>
                                  <td align="right" width="10px"><?php echo format_rupiah($hasil_keuangan_keluar->total); ?></td>
                                </tr>
                                  <?php
                                  $hasil_keluar +=$hasil_keuangan_keluar->total;
                                }
                                ?>
                                <tr>
                                  <td colspan="4" class="text-center"><strong> TOTAL PENGELUARAN</strong></td>
                                  <td align="right"><strong><?php echo format_rupiah($total_hpp+$hasil_keluar); ?></strong></td>
                                </tr>

                                                          <!--<tr>
                                  <td colspan="4" class="text-center"><strong>TOTAL </strong></td>
                                  <td align="right"></td>
                                </tr>-->
                                <br>
                                <tr>
                                  <?php
                                   $laba = ($keuangan + $hasil_masuk) - ($total_hpp +$hasil_keluar);
                                  $absolut = abs($laba) ;
                                  $status = ($laba < 0) ? 'RUGI' : 'LABA'   ;
                                  ?>
                                  <td colspan="4" class="text-center"><strong>TOTAL <?php echo $status; ?></strong></td>
                                  <td align="right"><strong><?php echo format_rupiah($absolut); ?></strong></td>
                                </tr>
                              </table>