
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
              Daftar Retur Pembelian
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
            <!--   <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'retur_penjualan/retur_penjualan/tambah'; ?>">
                <i class="fa fa-plus"></i> Tambah Retur Penjualan
              </a>
              <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'retur_penjualan/retur_penjualan/daftar_retur_penjualan'; ?>">
                <i class="fa fa-list"></i> Daftar Retur Penjualan
              </a> -->
              <!-- <div class="double bg-blue pull-right" style="cursor:default">
                <div class="tile-object">
                  <div  style="padding-right:10px; padding-left:10px;  padding-top:10px; font-size:17px; font-family:arial; font-weight:bold">
                    Total Transaksi Retur Penjualan
                  </div>
                </div>
                <div class="pull-right" style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">
                  <?php
                  $total = $this->db->get('transaksi_retur_penjualan');
                  $hasil_total = $total->num_rows();
                  ?>
                  <i class="total_transaksi"><?php echo $hasil_total; ?></i>
                </div>
              </div> -->
              <br><br>
              <form id="pencarian_form" method="post" style="margin-left: 0px;" class="form-horizontal" target="_blank">

                <div class="row">
                  <div class="col-md-5" id="trx_penjualan">
                    <div class="input-group">
                      <span class="input-group-addon">Tanggal Awal</span>
                      <input type="date" class="form-control tgl" id="tgl_awal" />
                    </div>
                  </div>
                  <div class="col-md-5" id="trx_penjualan">
                    <div class="input-group">
                      <span class="input-group-addon">Tanggal Akhir</span>
                      <input type="date" class="form-control tgl" id="tgl_akhir" />
                    </div>
                  </div>

                  <div class=" col-md-2">
                    <div class="input-group">
                      <button type="button" class="btn btn-success" onclick="cari_transaksi()"><i class="fa fa-search"></i> Cari</button>

                    </div>
                  </div>
                </div>

                <br>


              </form>

              
              
              <div id="cari_kasir">
               <table id="tabel_daftar" class="table table-bordered" style="font-size: 1.5em;">
                <?php
                $get_retur_penjualan = $this->db->get('transaksi_retur');
                $hasil_get_retur_penjualan = $get_retur_penjualan->result();
                ?>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Total Retur Pembelian</th>
                    <!-- <th>Nominal Retur Pembelian</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $nomor = 1;
                  $total= 0;
                  foreach($hasil_get_retur_penjualan as $daftar){ 
                    $kode_retur = $daftar->kode_retur;
                    $get_opsi_retur_penjualan = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode_retur));
                    $hasil_get_opsi_retur_penjualan = $get_opsi_retur_penjualan->row();

                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo @$daftar->kode_retur; ?></td>
                      <td><?php echo TanggalIndo(@$daftar->tanggal_retur_keluar);?></td>
                      <td align="right"><?php echo format_rupiah($daftar->grand_total);?></td>
                      <!-- <td align="right"><?php echo format_rupiah($daftar->total_nominal);?></td> -->
                      <td align="center"><?php echo get_detail_retur_pembelian($daftar->kode_retur); ?></td>
                    </tr>
                    <?php $nomor++; } ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Total Retur Pembelian</th>
                    <!-- <th>Nominal Retur Pembelian</th> -->
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>



            </div>

            <!------------------------------------------------------------------------------------------------------>

          </div>
        </div>

        <!-- /.row (main row) -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->


    <script>
      function setting() {
        $('#modal_setting').modal('show');
      }

      function cari_transaksi(){
        var tgl_awal =$("#tgl_awal").val();
        var tgl_akhir =$("#tgl_akhir").val();
        $.ajax( {  
          type :"post",  
          url : "<?php echo base_url().'laporan/search_retur_pembelian'; ?>",  
          cache :false,
          data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success : function(data) {
            $(".tunggu").hide(); 
            $("#cari_kasir").html(data);
          },  
          error : function(data) {  
            alert("das");  
          }  
        });
      }

      $(document).ready(function(){
        $("#tabel_daftar").dataTable({
          "aLengthMenu": [[50, 100, -1], [50, 100, "All"]],
          "iDisplayLength": 50});
        $("#form_setting").submit(function(){
          var keterangan = "<?php echo base_url().'pembelian/keterangan'?>";
          $.ajax({
            type: "POST",
            url: keterangan,
            data: $('#form_setting').serialize(),
            success: function(msg)
            {
              $('#modal_setting').modal('hide');  
            }
          });
          return false;
        });
      })
    </script>
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
                <!--<img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">-->

        <script>
          $('.btn-back').click(function(){
$(".tunggu").show();
            window.location = "<?php echo base_url().'laporan'; ?>";
          });
        </script>