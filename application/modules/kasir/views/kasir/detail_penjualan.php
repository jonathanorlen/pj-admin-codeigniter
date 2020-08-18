
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="#">Penjualan</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Penjualan Jasa</a>
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
              Detail Penjualan Jasa
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
            <?php
            $kode_penjualan=$this->uri->segment(3);
            $this->db->where('kode_penjualan',$kode_penjualan);
            $penjualan = $this->db->get('transaksi_penjualan_jasa');
            $hasil_penjualan = $penjualan->row();
            ?>

            <div class="box-body">            
              <div class="sukses" ></div>
              <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
              </div>
              <form id="pencarian_form" method="post" style="margin-left: 18px;" class="form-horizontal" target="_blank">

                <div class="row">
                  <div class="col-md-4" id="trx_penjualan">

                    <label>Kode Penjualan</label>
                    <input type="text" class="form-control tgl" id="kode_penjualan" readonly value="<?php echo @$hasil_penjualan->kode_penjualan?>" />
                    
                  </div>
                  <div class="col-md-4" id="trx_penjualan">
                   <label>Tanggal Penjualan</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->tanggal_penjualan?>" />

                 </div>

                 <div class=" col-md-4">
                   <label>Kode Member</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->kode_member?>" />

                 </div>
                 <div class=" col-md-4">
                   <label>Nama Member</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->nama_member?>"  />

                 </div>
                 <div class=" col-md-4">
                   <label>Kode Proyek</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->kode_proyek?>" />

                 </div>
                 <div class=" col-md-4">
                   <label>Nama Proyek</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->nama_proyek?>"  />

                 </div>
                 <div class=" col-md-4">
                   <label>Keterangan</label>
                   <input type="text" class="form-control tgl" readonly value="<?php echo @$hasil_penjualan->keterangan?>"  />

                 </div>
               </div>

               <br>


             </form>
             <div class="row">
              <div class="col-md-12">
               <hr>
               <table class="table table-bordered table-striped" style="font-size:1.5em;">
                <thead>
                  <tr>
                    <th class="text-center" width="50px">No.</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center" width="125px">Ukuran</th>
                    <th class="text-center" width="125px">Satuan</th>
                    <th class="text-center" width="125px">Harga Satuan</th>
                  </tr>
                </thead>
                <tbody id="">
                  <?php

                  $dft_order = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi',array('kode_penjualan'=>@$kode_penjualan));
                  $hasil_order = $dft_order->result();

                  $nomor = 1;  
                  $total_des=0;
                  foreach($hasil_order as $daftar){ 
                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo @$daftar->deskripsi; ?></td>
                      <td><?php echo @$daftar->ukuran; ?></td>
                      <td><?php echo @$daftar->nama_satuan; ?></td>
                      <td><?php echo @format_rupiah($daftar->harga_satuan); ?></td>
                    </tr>

                    <?php 
                    $nomor++; 
                    $total_des+=@$daftar->subtotal;
                  } 

                  ?>
                  <tr>
                    <td colspan="4" align="center"><b>Total</td>
                    <th><?php echo @format_rupiah($total_des); ?></th>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
              <hr>
            </div>
            <hr>
              <div class="col-md-12">
                <?php
                $this->db->where('kode_penjualan',$kode_penjualan);
                $kasir = $this->db->get('opsi_transaksi_penjualan_jasa');
                $hasil_kasir = $kasir->result();
                ?>
                <div id="cari_kasir">
                  <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        
                       
                        <th>QTY</th>
                        <th>Harga</th>
                        <th>Sub Total</th>


                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $nomor=1;
                      $total=0;
                      foreach($hasil_kasir as $daftar){
                        ?>
                        <tr>
                          <td><?php echo $nomor; ?></td>
                          <td><?php echo $daftar->nama_menu; ?></td>
                          
                          
                          <td><?php echo $daftar->jumlah; ?></td>
                          <td><?php echo @format_rupiah($daftar->harga_satuan); ?></td>
                          <td align="right"><?php echo @format_rupiah($daftar->subtotal) ?></td>
                        </tr>
                        <?php $nomor++; 
                        $total +=$daftar->subtotal;
                      } ?>

                      <tr>
                        <td colspan="4" align="center"><b>  Total </b></td>
                        
                        <td align="right"><b><?php echo @format_rupiah($total) ?></b></td>
                      </tr>
                    </tbody>

                  </table>
                </div>

              </div>
            </div>
            <div class="row">

            <div class="col-md-6">
             <div class="bg-blue" style="height:40px; padding: 0px 10px 0px 10px; margin-bottom:5px">
              <!--<span style="font-size:22px; " class="pull-right" id="grand_total_rupiah"><?php echo @format_rupiah($total+$total_des); ?></span>-->
              <span style="font-size:22px; " class="pull-right" id="grand_total_rupiah"><?php echo @format_rupiah($total); ?></span>
              <i style="font-size:56px; margin-top:5px"></i>
              <p style="font-size: 18px;">Grand Total</p>
              <input type="hidden" id="grand_total" name="grand_total">
            </div>

          </div>
        </div>
            <!------------------------------------------------------------------------------------------------------>

          </div>
        </div>
        
        <!-- /.row (main row) -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color:grey">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembatalan Reservasi</h4>
          </div>
          <div class="modal-body">
            <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan membatalkan reservasi tersebut ?</span>
            <input id="id-delete" type="hidden">
          </div>
          <div class="modal-footer" style="background-color:#eee">
            <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
            <button onclick="delData()" class="btn red">Ya</button>
          </div>
        </div>
      </div>
    </div>
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
      window.location = "<?php echo base_url().'kasir/penjualan_jasa'; ?>";
    });
    </script>
    <script>

    function actDelete(Object) {
      $('#id-delete').val(Object);
      $('#modal-confirm').modal('show');
    }

    function delData() {
      var id = $('#id-delete').val();
      var url = '<?php echo base_url().'kasir/batal'; ?>';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          kode_reservasi: id
        },
        success: function(msg) {
          $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
      return false;
    }

    function status_reservasi(kode_reservasi) {
      var kode_reservasi = kode_reservasi
      var url = "<?php echo base_url().'kasir/buka_reservasi'; ?>";
      $.ajax({
        type:"post",
        url:url,
        data:{kode_reservasi:kode_reservasi},
        success:function(data){
         setTimeout(function(){ window.location="<?php echo base_url().'kasir/menu_kasir/'; ?>"+data; },1500);
       }
     })
      return false;
    }

    function buka_reservasi(){
    //alert("AA");
    var url = "<?php echo base_url().'kasir/buka_reservasi'; ?>";
    var kode_reservasi = $('.buka').attr('kode');
    $.ajax({
      type:"post",
      url:url,
      data:{kode_reservasi:kode_reservasi},
      success:function(data){
       setTimeout(function(){ window.location="<?php echo base_url().'kasir/menu_kasir/'; ?>"+data; },1500);
     }
   })
  }

  function cari_transaksi(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'kasir/search_kasir'; ?>",  
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
    //$("#tabel_daftar").dataTable();

  //$(".tgl").datepicker();
})
  
  </script>