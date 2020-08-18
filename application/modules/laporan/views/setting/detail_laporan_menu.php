

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
             Laporan Menu
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
                <label><h3><b>Detail Menu</b></h3></label>
                <div class="row">
                  <?php
                                  //$param = $this->uri->segment(3);
                  $kode_menu = $this->uri->segment(4);
                  $menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_menu' => $kode_menu));
                  $list_menu_row = $menu->row();
                  $list_menu = $menu->result();

                  $ambil_menu = $this->db->get_where('master_menu',array('kode_menu' => $kode_menu));
                  $hasil_menu = $ambil_menu->row();
                  ?>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="callout callout-info">
                        <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Menu &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;"><?php echo @$hasil_menu->kode_menu; ?></span>
                        <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_spoil; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_spoil" id="kode_spoil" />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="callout callout-info">
                        <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Nama Menu &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;" id="tanggal_spoil"><?php echo @$hasil_menu->nama_menu; ?></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                    <div class="box-body">
                      <div class="callout callout-info">
                        <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Harga Menu &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;" id="tanggal_spoil"><?php echo @$hasil_menu->harga_jual; ?></span>
                      </div>
                    </div>
                  </div>
                  <br><br>



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
                        <th>Kode_penjualan</th>
                        <th>Menu</th>
                        <th>QTY</th>
                       
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                       $total = 0;
                       $nomor=1;
                      foreach($list_menu as $daftar){ 
                        ?> 
                        <tr style="font-size:15px">
                          <td><?php echo $nomor; ?></td>
                          <td><?php echo $daftar->kode_penjualan; ?></td>
                          <td><?php echo $daftar->nama_menu; ?></td>
                          <td><?php echo $daftar->jumlah; ?></td>
                          
                          <td><?php echo format_rupiah($daftar->subtotal); ?></td>
                        </tr>
                        <?php 
                        $total = $total + $daftar->subtotal;
                        $nomor++; 
                      } 
                      ?>
                      <tr style="font-size:15px"x>
                        <td colspan="2"></td>
                        <td></td>
                        <td style="font-weight:bold;">Total</td>
                        <td><?php echo format_rupiah($total); ?></td>
                      </tr>

                     <!--  <tr style="font-size:15px"x>
                        <td colspan="3"></td>
                        <td style="font-weight:bold;">Diskon (%)</td>
                        <td id="tb_diskon"></td></td>
                        <td><?php echo @$list_penjualan_row->diskon_persen ; ?> %</td>
                      </tr>

                      <tr style="font-size:15px"x>
                        <td colspan="3"></td>
                        <td style="font-weight:bold;">Diskon (Rp)</td>
                        <td id="tb_diskon_rupiah"></td>
                        <td><?php echo format_rupiah(@$list_penjualan_row->diskon_rupiah) ; ?></td>
                      </tr>

                      <tr style="font-size:15px"x>
                        <td colspan="3"></td>
                        <td style="font-weight:bold;">Grand Total</td>
                        <td id="tb_grand_total"></td>
                        <td><?php echo format_rupiah(@$list_penjualan_row->grand_total) ; ?></td>
                      </tr>
 -->
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
      window.location = "<?php echo base_url().'laporan/laporan_menu'; ?>";
    });
    </script>
