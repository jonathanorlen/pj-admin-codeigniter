
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="#">Retur Pembelian</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Detail Retur Pembelian</a>
          <i class="fa fa-angle-right"></i>
        </li>


      </ul>

    </div>
  </section>
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
              Detail Retur Pembelian
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
            <label><h3><b>Detail Transaksi Retur Pembelian</b></h3></label>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode Retur</label>
                  <?php
                  $kode = $this->uri->segment(3);
                  $transaksi_retur_pembelian = $this->db->get_where('transaksi_retur',array('kode_retur'=>$kode));
                  $hasil_transaksi_retur_pembelian = $transaksi_retur_pembelian->row();
                  ?>
                  <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_retur_pembelian->kode_retur; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_retur" id="kode_retur" />
                </div>
                
                <div class="form-group">
                  <label class="gedhi">Tanggal Retur</label>
                  <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_retur_pembelian->tanggal_retur_keluar); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_retur" id="tanggal_retur"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Total Retur pembelian</label>
                  <input type="text" value="<?php echo format_rupiah($hasil_transaksi_retur_pembelian->grand_total); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_retur" id="tanggal_retur"/>
                </div>
              </div>
              
              <div class="col-md-6" style="display: none">
                <div class="form-group">
                  <label>Nominal Retur</label>
                  <input type="text" value="<?php echo format_rupiah($hasil_transaksi_retur_pembelian->total_nominal) ?>" readonly="true" class="form-control" placeholder="Nominal Retur" name="tanggal_retur" id="tanggal_retur"/>
                </div>
              </div>
              <div class="col-md-6" style="display: none;">
                <div class="form-group">
                  <label>Customer</label>
                  <input type="text" value="<?php echo $hasil_transaksi_retur_pembelian->nama_member; ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_retur" id="tanggal_retur"/>
                </div>
              </div>
            </div>
          </div> 
          <div id="list_transaksi_retur_pembelian">
            <div class="box-body">
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size: 1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>QTY</th>
                    <th>Harga Satuan</th>
                    <th>Diskon (%)</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody id="tabel_temp_data_transaksi">
                  <?php
                  $kode = $this->uri->segment(3);
                  $pembelian = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode));
                  $list_pembelian = $pembelian->result();
                  #echo $this->db->last_query();
                  $nomor = 1;  $total = 0;
                  foreach($list_pembelian as $daftar){ 
                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $daftar->nama_bahan; ?></td>
                      <td><?php echo $daftar->jumlah; ?></td>
                      <td align="right"><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                      <td align="center"><?php echo $daftar->diskon_item; ?></td>
                      <td align="right"><?php echo format_rupiah($daftar->subtotal); ?></td>
                    </tr>
                    <?php 
                    $total = $total + $daftar->subtotal;
                    $nomor++; 
                  } 
                  ?>
                  <tr>
                    <td colspan="4"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td align="right" style="font-weight:bold;"><?php echo format_rupiah($total); ?></td>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
          </div>
        </form>


              </div>

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
    window.location = "<?php echo base_url().'laporan/laporan_retur_pembelian'; ?>";
  });
  </script>
