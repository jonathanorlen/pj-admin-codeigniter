
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
              Validasi Penjualan Jasa
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
                   <input type="text" class="form-control tgl" id="kode_member" readonly value="<?php echo @$hasil_penjualan->kode_member?>" />

                 </div>
                 <div class=" col-md-4">
                   <label>Nama Member</label>
                   <input type="text" class="form-control tgl" id="nama_member" readonly value="<?php echo @$hasil_penjualan->nama_member?>"  />

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
                  $total=0;
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
                    $total+=@$daftar->subtotal;
                  } 

                  ?>
                  <tr>
                    <td colspan="4" align="center"><b>Total</td>
                    <th><?php echo @format_rupiah($total); ?></th>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
              <hr>
            </div>


            <div class="row">
              <div class="col-md-3" id="trx_penjualan">

                <label>Produk</label>
                <!-- <input type="hidden" class="form-control" id="kode_produk" readonly  /> -->
                <input type="hidden" class="form-control" id="nama_produk" readonly  />
                <select onchange="get_bahan_baku()" class="form-control select2" id="kode_produk" name="kode_produk">
                 <option value="">Pilih Produk</option>
                 <?php 
                 //$this->db->limit(100);
                 $get_bahan_baku=$this->db->get('master_bahan_baku');
                 $hasil=$get_bahan_baku->result();
                 foreach ($hasil as $list) {
                  ?>
                  <option value="<?php echo $list->kode_bahan_baku;  ?>"><?php echo $list->nama_bahan_baku;  ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3" id="trx_penjualan">
               <label>QTY</label>
               <input type="text" class="form-control"  id="jumlah" />

             </div>

             <div class=" col-md-3">
               <label>Harga</label>
               <input type="text" class="form-control"  id="harga" />

             </div>
             <div class=" col-md-3">

              <button type="button" id="add" style="margin-top:25px;" class="btn blue" onclick="add()"><i class="fa fa-plus"></i> Add</button>
              <button type="button" id="update" style="margin-top:25px;" class="btn blue" onclick="update()"><i class="fa fa-save"></i> Update</button>

            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-md-12">
              <?php


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
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody id="item_validasi">

                  </tbody>

                </table>
              </div>

            </div>
          </div>
          <div class="row">

            <div class="col-md-6">
             <div class="bg-blue" style="height:40px; padding: 0px 10px 0px 10px; margin-bottom:5px">
              <span style="font-size:22px; " class="pull-right" id="grand_total_rupiah"><?php echo @format_rupiah($total); ?></span>
              <i style="font-size:56px; margin-top:5px"></i>
              <p style="font-size: 18px;">Grand Total</p>
              <input type="hidden" id="grand_total" name="grand_total">
            </div>

          </div>
        </div>
        <div class="row">

          <div class="col-md-6">
            <div style="height:40px; margin-top: 10px;" >
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon" style="font-weight: bolder;"><strong>Jenis Transaksi&nbsp;</strong></span>
                  <select style="font-size: 20px;" onchange="jenis_transaksi()" class="form-control select2" id="jenis_transaksi" name="jenis_transaksi">
                    <option value='Tunai'>Tunai</option>
                    <option value='Kredit'>Kredit</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 jatuh_tempo">
            <div style="height:40px; margin-top: 10px;" >
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon" style="font-weight: bolder;"><strong>Jatuh Tempo&nbsp;</strong></span>
                  <input style="font-size: 20px;"  type="date" class="form-control" name="jatuh_tempo" id="jatuh_tempo" />
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-md-6">
            <div style="height:40px; margin-top: 10px;" >
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon" style="font-weight: bolder;"><strong>Dibayar&nbsp;</strong></span>
                  <span id="dibayar">

                    <input style="font-size: 20px;" onkeyup="kembalian()" type="text" class="form-control " name="bayar" id="bayar" />
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
           <div id="rupiah_bayar" style="margin-top:20px;font-size:20px" class="pull-left col-md-8">
            Rp 0,00
          </div>
        </div>
      </div>
      <div class="row">


        <div class="col-lg-12">
          <br><br>
          <a style="text-decoration: none; align:center;" onclick="konfirm_bayar()"  class="bg-green btn col-md-12" >
            <center><span style="font-size:20px; font-weight: bold; "><i style="font-size: 20px;" class="fa fa-check"></i> Validasi</span></center>  
          </a>
        </div>

      </div>

      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>

  <!-- /.row (main row) -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal-confirm-bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Penjualan</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin validasi data tersebut?</span>
        <input id="no" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button id="tidak" class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button id="ya" onclick="bayar()" class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-confirm-validasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
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
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn green">Ya</button>
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

function add() {
  var kode_penjualan = $('#kode_penjualan').val();
  var kode_produk = $('#kode_produk').val();
  var nama_produk = $('#nama_produk').val();
  var jumlah = $('#jumlah').val();
  var harga = $('#harga').val();
  var url = '<?php echo base_url().'kasir/simpan_pesanan_temp'; ?>';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      kode_penjualan:kode_penjualan,
      kode_produk:kode_produk,
      nama_produk:nama_produk,
      jumlah:jumlah,
      harga:harga,
    },
    success: function(msg) {
      data=msg.split('|');

      if(data[0]==0){
        $("#item_validasi").load('<?php echo base_url().'kasir/item_validasi/'; ?>'+kode_penjualan);
        $("#kode_produk").select2().select2('val', '');
        $('#nama_produk').val('');
        $('#jumlah').val('');
        $('#harga').val('');
        get_grand_total();
      }else{
        alert('Stok Tidak Mencukupi');
      }
      
    },
  });
  return false;
}

function get_bahan_baku() {
  var kode_produk = $('#kode_produk').val();
  var url = '<?php echo base_url().'kasir/get_produk_manual'; ?>';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      kode_produk: kode_produk
    },
    dataType:'json',
    success: function(msg) {
      $('#nama_produk').val(msg.nama_bahan_baku);
      $('#harga').val(msg.hpp);
    },
  });
  
}
function actEdit(Object) {
  var id = Object;
  var url = '<?php echo base_url().'kasir/get_opsi_penjualan'; ?>';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id: id
    },
    dataType:'json',
    success: function(msg) {
      $("#kode_produk").select2().select2('val',msg.kode_menu);
      //$("#kode_produk").val(msg.kode_menu);
      $("#nama_produk").val(msg.nama_menu);
      $("#jumlah").val(msg.jumlah);
      $("#harga").val(msg.harga_satuan);
      $("#add").hide();
      $("#update").show();
    }
  });

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

  function update(){
    var kode_produk =$("#kode_produk").val();
    var nama_produk =$("#nama_produk").val();
    var jumlah =$("#jumlah").val();
    var harga =$("#harga").val();
    var kode_penjualan =$("#kode_penjualan").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'kasir/update_opsi_penjualan_validasi'; ?>",  
      cache :false,
      data : {kode_produk:kode_produk,nama_produk:nama_produk,
        jumlah:jumlah,
        harga:harga,
        kode_penjualan:kode_penjualan,
      },

      success : function(data) {
       msg=data.split('|');

       if(msg[0]==0){
        $("#kode_produk").val('');
        $("#kode_produk").select2().select2('val','');
        $("#nama_produk").val('');
        $("#jumlah").val('');
        $("#harga").val('');
        $("#item_validasi").load('<?php echo base_url().'kasir/item_validasi/'; ?>'+kode_penjualan);
        $("#update").hide();
        $("#add").show();
        get_grand_total();
      }else{
        alert('Stok Tidak Mencukupi');
      }
    },  
    error : function(data) {  
      alert("das");  
    }  
  });
  }
  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }
  function delData() {
    var kode_penjualan =$("#kode_penjualan").val();
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'kasir/kasir/hapus_pesanan_temp'; ?>/delete';

    $.ajax({
      type: "POST",
      url: url,
      data: {
        id:id
      },
      success: function(msg) {
        var kode_kasir = $("#kode_kasir").val();
        $('#modal-confirm').modal('hide');
        $("#item_validasi").load('<?php echo base_url().'kasir/item_validasi/'; ?>'+kode_penjualan);
        get_grand_total();
      }
    });
    return false;
  }
  function get_grand_total(){
    var url = "<?php echo base_url().'kasir/kasir/get_grand_total'; ?>";
    var kode_penjualan = $("#kode_penjualan").val();

    $.ajax({
      type: 'POST',
      url: url,
      dataType:'json',
      data: {kode_penjualan:kode_penjualan},
      success: function(rupiah){
        $("#grand_total").val(rupiah.total);
        $("#grand_total_rupiah").text(rupiah.total_rupiah);
      }
    });
  }
  function kembalian(){
    var url = "<?php echo base_url().'kasir/kasir/kembalian'; ?>";
    var dibayar = $("#bayar").val();

    $.ajax({
      type: 'POST',
      url: url,
      dataType:'json',
      data: {dibayar:dibayar},
      success: function(rupiah){

        $("#rupiah_bayar").text(rupiah.dibayar);
      }
    });
  }
  function konfirm_bayar(){
    $("#modal-confirm-bayar").modal('show');
  }
  function jenis_transaksi(){
    var jenis_transaksi = $("#jenis_transaksi").val();
    if(jenis_transaksi=='Kredit'){
      $(".jatuh_tempo").show();
    }else{
      $(".jatuh_tempo").hide();
    }
  }
  function bayar() {
    var kode_penjualan =$("#kode_penjualan").val();
    var dibayar = $("#bayar").val();
    var grand_total = $("#grand_total").val();
    var jenis_transaksi = $("#jenis_transaksi").val();
    var kode_member = $("#kode_member").val();
    var nama_member = $("#nama_member").val();
    var jatuh_tempo = $("#jatuh_tempo").val();
    var url = '<?php echo base_url().'kasir/kasir/simpan_validasi_penjualan'; ?>';

    $.ajax({
      type: "POST",
      url: url,
      data: {
        kode_penjualan:kode_penjualan,dibayar:dibayar,grand_total:grand_total,jenis_transaksi:jenis_transaksi,
        kode_member:kode_member,nama_member:nama_member,jatuh_tempo:jatuh_tempo
      },
      success: function(msg) {
        $("#modal-confirm-bayar").modal('hide');

        $(".sukses").html('<div style="font-size:1.5em" class="alert alert-success">Validasi Penjualan Berhasil</div>');
        setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'kasir/penjualan_jasa' ?>";},1000);  
      }
    });
    return false;
  }
  $(document).ready(function(){
    //$("#tabel_daftar").dataTable();
    $(".select2").select2();
    $("#update").hide();
  //$(".tgl").datepicker();
  var kode_penjualan=$('#kode_penjualan').val();
  $("#item_validasi").load('<?php echo base_url().'kasir/item_validasi/'; ?>'+kode_penjualan);
  get_grand_total();
  $(".jatuh_tempo").hide();
})
  
  </script>