

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
<style type="text/css">
 .ombo{
  width: 400px;
 } 

</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
            <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Laporan Penjualan
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
          <a href="javascript:;" class="reload">
          </a>

        </div>
      </div>
      <div class="portlet-body">
        <!------------------------------------------------------------------------------------------------------>
 

        <div class="box-body">            
          <div class="sukses" ></div>
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <label><h3><b>Detail Penjualan</b></h3></label>
                              <?php
                                  //$param = $this->uri->segment(3);
                                  $kode_penjualan = $this->uri->segment(4);
                                  $penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan' => $kode_penjualan));
                                  $list_penjualan_row = $penjualan->row();
                                  $list_penjualan = $penjualan->result();
                              ?>
                              <br>
                              
                              <div class="row">
                              <br><br>
                                <div class="col-md-6 ">
                                   <div class="btn blue btn-lg ">
                                        <span style="font-weight:bold; font-size:13px;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Penjualan &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                                        <span style="text-align:right; font-weight:bold; font-size:13px;"><?php echo @$list_penjualan_row->kode_penjualan; ?></span>
                                        <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_spoil; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_spoil" id="kode_spoil" />
                                      </div>
                                </div>

                                <div class="col-md-6">
                                   
                                      <div class="btn blue btn-lg">
                                        <span style="font-weight:bold; font-size:13px;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Penjualan &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                                        <span style="text-align:right; font-size:13px; font-weight:bold;" id="tanggal_spoil"><?php echo tanggalIndo(@$list_penjualan_row->tanggal_penjualan); ?></span>
                                      </div>
                                   
                                </div><br><br>
                                <br><br>
                              
                             <!--    <div class="col-md-3">
                                    <label><b>Meja</label>
                                   
                                    <input class="form-control" value="<?php echo @$list_penjualan_row->kode_meja ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                
                                </div> -->
                                <div class="col-md-3">
                                    <label><b>Kode Member</label>
                                    <input class="form-control" value="<?php echo @$list_penjualan_row->kode_member ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>
                                <div class="col-md-3">
                                    <label><b>Nama Member</label>
                                    <input class="form-control" value="<?php echo @$list_penjualan_row->nama_member ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>
                                <div class="col-md-3">
                                    <label><b>Pembayaran</label>
                                    <input class="form-control" value="<?php echo @$list_penjualan_row->jenis_transaksi ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>

                                <div class="col-md-3">
                                    <label><b>Nominal Pembayaran</label>
                                    <input class="form-control" value="<?php echo format_rupiah(@$list_penjualan_row->bayar) ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>
                                <div class="col-md-3">
                                    <label><b>Kembalian</label>
                                    <input class="form-control" value="<?php echo format_rupiah(@$list_penjualan_row->kembalian) ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>

                              </div>
                            </div> 
                              <br><br>
                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <div class="row">
                                  
                                </div>

                                <table id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th style="display: none;">Kategori</th>
                                      <th>Produk</th>
                                      <th>QTY</th>
                                      <th>Harga</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                       //$param = $this->uri->segment(3);
                                        $kode_penjualan = $this->uri->segment(4);
                                                 $this->db->select('*'); 
                                                 $this->db->distinct();
                                                 $this->db->select('nama_menu') ;
                                                 $this->db->group_by('nama_menu');
                                        $spoil = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan' => $kode_penjualan));
                                        $list_spoil = $spoil->result();
                                        $nomor = 1;  $total = 0;

                                        foreach($list_spoil as $daftar){ 
                                      ?> 
                                          <tr style="font-size:15px">
                                            <td><?php echo $nomor; ?></td>
                                            <td style="display: none;"><?php echo $daftar->kategori_menu; ?></td>
                                            <td><?php echo $daftar->nama_menu; ?></td>
                                            <td><?php echo $daftar->jumlah; ?></td>
                                            <td align="right"><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                                            <td align="right"><?php echo format_rupiah($daftar->subtotal); ?></td>
                                          </tr>
                                      <?php 
                                          $total = $total + $daftar->subtotal;
                                          $nomor++; 
                                        } 
                                      ?>
                                      <tr style="font-size:15px"x>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Total</td>
                                        <td></td>
                                        <td align="right"><?php echo format_rupiah($total); ?></td>
                                      </tr>

                                      <tr style="font-size:15px"x>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Diskon (%)</td>
                                        <td id="tb_diskon"></td></td>
                                        <td align="right"><?php echo @$list_penjualan_row->diskon_persen ; ?> %</td>
                                      </tr>
                                      
                                      <tr style="font-size:15px"x>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Diskon (Rp)</td>
                                        <td id="tb_diskon_rupiah"></td>
                                        <td align="right"><?php echo format_rupiah(@$list_penjualan_row->diskon_rupiah) ; ?></td>
                                      </tr>
                                      
                                      <tr style="font-size:15px"x>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Ongkos Kirim</td>
                                        <td id="tb_grand_total"></td>
                                        <td align="right"><?php echo format_rupiah(@$list_penjualan_row->ongkos_kirim) ; ?></td>
                                      </tr>
                                      
                                      <tr style="font-size:15px"x>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Grand Total</td>
                                        <td id="tb_grand_total"></td>
                                        <td align="right"><?php echo format_rupiah(@$list_penjualan_row->grand_total-@$list_penjualan_row->nominal_retur) ; ?></td>
                                      </tr>

                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
                              </div>
                            </div>
                            <br>
                              <div class="box-footer">
                                <!-- <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'laporan/'; ?>"><i class="fa fa-backward"></i>Kembali</a> -->
                              </div>
                        </form>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
            
                <!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
 <style type="text/css" media="screen">
        .btn-back
          {
            position: fixed;
            bottom: 10px;
             left: 10px;
            z-index: 999999999999999;
                vertical-align: middle;
                cursor:pointer
          }
        </style>
                <img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">

        <script>
          $('.btn-back').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'laporan/laporan_penjualan'; ?>";
          });
        </script>
