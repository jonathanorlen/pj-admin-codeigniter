<div class="row">      

  <div class="col-xs-12">
   <!-- /.box -->
   <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
        Tambah Stock Out
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

      ?>
    <!--   <a onclick="penjualan_jasa()" style="padding:13px; margin-bottom:10px" class="btn btn-app red pull-right" href="#">
        <i class="fa fa-plus"></i> Penjualan Jasa
      </a> -->
      <div class="box-body">    

        <div class="sukses" ></div>
        <form id="data_form" action="" method="post">
          <div class="box-body">

            <div class="row">
              <?php
              $tgl = date("Y-m-d");
              $no_belakang = 0;
              $this->db->select_max('kode_stok_out');
              $kode = $this->db->get_where('transaksi_stok_out',array('tanggal_input'=>$tgl));
              $hasil_kode = $kode->row();
              if(count($hasil_kode)==0){
                $no_belakang = 1;
              }
              else{
                $pecah_kode = explode("_",$hasil_kode->kode_stok_out);
                $no_belakang = @$pecah_kode[2]+1;
              }

                                    #echo $this->db->last_query();
              $ak_sekarang=date('Y-m-d');
              ?>
              <div class="col-md-4">
                <div class="" style="background-color: #428bca ;width:auto;">
                  <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Kode Stok Out : <span style="font-size:20px;"><?php echo "SO_".date("dmyHis")."_".$no_belakang;  ?></span></a>
                  <input readonly="true" type="hidden" value="<?php echo "SO_".date("dmyHis")."_".$no_belakang; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_stok_out" id="kode_stok_out" />
                </div>
              </div>
               <input type="hidden" readonly class="form-control" id="kode_penjualan_jasa" />

              <div class="col-md-4">
                <div class="" style="background-color: #428bca ;width:auto;">
                  <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn"> Tanggal Transaksi : <span style="font-size:20px;"><?php echo TanggalIndo(date("Y-m-d")); ?></span></a>

                </div>
              </div>
            </div>
          </div> 
          <br><br>
          <div class="box-body">
            <div class="row">
              <div class="">
                <div class="col-md-3">
                  <label>Nama Bahan</label>
                  <select id="kode_bahan" name="kode_bahan" class="form-control select2">
                   <option value="">Pilih Bahan</option>
                   <?php 
                   $get_bahan=$this->db->get('master_bahan_baku');
                   $hasil_get_bahan=$get_bahan->result();
                   foreach ($hasil_get_bahan as $list) { ?>
                   <option value="<?php echo $list->kode_bahan_baku ?>"><?php echo $list->nama_bahan_baku ?></option>                   
                   <?php } ?>
                 </select>
                 <input type="hidden" readonly class="form-control" placeholder="Satuan Stok"  id="nama_bahan" />
                 <input type="hidden" readonly class="form-control" placeholder="Satuan Stok"  id="stok_awal" />
                 <input type="hidden" readonly class="form-control" placeholder="Satuan Stok"  id="hpp" />
               </div>
               <div class="col-md-3">
                <label>QTY Keluar</label>
                <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
              </div>
              <div class="col-md-2">
                <label>Satuan Stok</label>
                <input type="text" readonly class="form-control" placeholder="Satuan Stok"  id="satuan_stok" />
              </div>
              <div class="col-md-3">
                <label>Keterangan</label>
                <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan" />
              </div>
              <div class="col-md-1 pull-right" ><br>
                <div style="margin-top: 12px" onclick="add_item()" id="add"  class="btn btn-primary btn-block">Add</div>
                <div style="margin-top: 12px" onclick="update_item()" id="update"  class="btn btn-primary btn-block">Update</div>
              </div>
            </div>  
          </div>
        </div>

        <div id="list_transaksi_pembelian">
          <div class="box-body"><br>
            <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
              <thead>
                <tr>
                  <th>No</th>

                  <th>Nama Barang</th>
                  <th>Stok Awal</th>
                  <th>Stok Keluar</th>
                  <th>Stok Akhir</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tabel_temp_data_transaksi">

              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>
        </div>

        <button type="button" class="btn btn-success pull-right" onclick="confirm()" >Simpan</button>

        <div class="box-footer clearfix"></div>

      </form>

      <!------------------------------------------------------------------------------------------------------>
    </div>
  </div><!-- /.col -->
</div>
</div>
<div id="modal-hapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus produk tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()"  class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin ingin menyimpan transaksi Stok Out ? ?</span>
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="simpan()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-confirm-hapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi  Aktifitas</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data Aktiftas Tersebut?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<div id="modal-regular" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="cari_penj" method="post">
        <div class="modal-header" style="background-color:grey">

          <h4 class="modal-title" style="color:#fff;">Transaksi Penjualan</h4>
        </div>
        <div class="modal-body" >
          <div class="form-body">

           <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Kode Penjualan Jasa</label>
                <input type="text" id="kode_penjualan" name="kode_penjualan" class="form-control" placeholder="Kode Penjualan Jasa" required="">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer" style="background-color:#eee">
        <button onclick="cancel()" class="btn blue" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn green">Cari</button>
      </div>
    </form>
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
  window.location = "<?php echo base_url().'stok/daftar_Stok_out'; ?>";
});
</script>
<script>
function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-hapus').modal('show');
}
function penjualan_jasa() {

  $('#modal-regular').modal('show');
}
function delData() {
  var id = $('#id-delete').val();
  var kode_stok_out = $('#kode_stok_out').val();
  var url = '<?php echo base_url().'stok/hapus_bahan_temp'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg) {
      $('#modal-hapus').modal('hide');
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'stok/get_stok_out/'; ?>"+kode_stok_out);
      $(".tunggu").hide();

    }
  });
  return false;
}

function actEdit(id) {
  var id = id;
  var kode_stok_out = $('#kode_stok_out').val();
  var url = "<?php echo base_url().'stok/get_temp_stok_out'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(pembelian){
      $("#kode_bahan").select2().select2('val', pembelian.kode_bahan);
      $('#jumlah').val(pembelian.jumlah);
      $('#satuan_stok').val(pembelian.satuan_stok);
      $("#keterangan").val(pembelian.keterangan);
      $('#stok_awal').val(pembelian.real_stock);
      $('#hpp').val(pembelian.hpp);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'stok/get_stok_out/'; ?>"+kode_stok_out);
      get_satuan();
    }
  });
}

function update_item(){
  var kode_stok_out = $('#kode_stok_out').val();
  var kode_bahan = $('#kode_bahan').val();
  var stok_awal = $('#stok_awal').val();
  var jumlah = $('#jumlah').val();
  var nama_bahan = $("#nama_bahan").val();
  var kategori_bahan ='stok';
  var keterangan = $("#keterangan").val();
  var hpp = $("#hpp").val();
  var sub_total =hpp * jumlah;
  var url = "<?php echo base_url().'stok/update_item_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_stok_out:kode_stok_out,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      keterangan:keterangan,
      stok_awal:stok_awal,
      kategori_bahan,
      jumlah:jumlah,sub_total:sub_total 
    },
    success: function(data)
    {
     $(".tunggu").hide(); 
     $("#kode_bahan").select2().select2('val', '');
     $("#tabel_temp_data_transaksi").load("<?php echo base_url().'stok/get_stok_out/'; ?>"+kode_stok_out);
     $('#jumlah').val('');
     $('#satuan_stok').val('');      
     $("#keterangan").val('');  
     $("#add").show();
     $("#update").hide();
   }
 });
}

function confirm(){
  $("#modal-confirm").modal('show');
}

function simpan(){
  var kode_stok_out = $('#kode_stok_out').val();
  var url = "<?php echo base_url().'stok/simpan_stok_out/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_stok_out:kode_stok_out
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(data)
    {
      window.location = "<?php echo base_url() . 'stok/daftar_Stok_out' ?>";   
      $(".tunggu").hide();
      $("#modal-confirm").modal('hide');
    }
  });
}

function get_satuan(){
  var kode_bahan = $('#kode_bahan').val();
  var url = "<?php echo base_url() . 'stok/get_satuan' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan},
    success: function(msg){
     if(msg.satuan_stok){
      $('#satuan_stok').val(msg.satuan_stok);
    }
    if(msg.hpp){
      $('#hpp').val(msg.hpp);
    }
  }
});
}
$(document).ready(function(){

  $('.select2').select2();
  $("#update").hide();

  $('#kode_bahan').on('change',function(){
    var kode_bahan = $('#kode_bahan').val();
    var url = "<?php echo base_url() . 'stok/get_satuan' ?>";
    $.ajax({
      type: 'POST',
      url: url,
      dataType:'json',
      data: {kode_bahan:kode_bahan},
      success: function(msg){
       if(msg.satuan_stok){
        $('#satuan_stok').val(msg.satuan_stok);
      }

      if(msg.nama_bahan_baku){
        $('#nama_bahan').val(msg.nama_bahan_baku);
      }
      if(msg.real_stock){
        $('#stok_awal').val(msg.real_stock);
      }
      if(msg.hpp){
        $('#hpp').val(msg.hpp);
      }

    }
  });
  });

  $("#cari_penj").submit(function(){
    var kode_penjualan = $('#kode_penjualan').val();  
    var kode_stok_out = $('#kode_stok_out').val();
    var gt_url = "<?php echo base_url().'stok/get_penjualan'?>";
    
    $.ajax({
      type: "POST",
      url: gt_url,
      data: {kode_penjualan:kode_penjualan,kode_stok_out:kode_stok_out},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        var data = msg.split("|");
        if(data[0] == 1){  
          $("#tabel_temp_data_transaksi").load("<?php echo base_url().'stok/get_stok_out/'; ?>"+kode_stok_out);
          $('#modal-regular').modal('hide');
          $(".tunggu").hide();
          $('#kode_penjualan_jasa').val(data[1]);  
        }
        else{
          alert('Kode Tidak Ditemukan');            
          $(".tunggu").hide();
        }  
      }
    });
    return false;
  });

});

function add_item(){
  var kode_stok_out = $('#kode_stok_out').val();
  var kode_bahan = $('#kode_bahan').val();
  var stok_awal = $('#stok_awal').val();
  var jumlah = $('#jumlah').val();
  var nama_bahan = $("#nama_bahan").val();
  var kategori_bahan ='stok';
  var keterangan = $("#keterangan").val();
  var hpp = $("#hpp").val();
  var sub_total =hpp * jumlah;
  var url = "<?php echo base_url().'stok/simpan_item_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_stok_out:kode_stok_out,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      keterangan:keterangan,
      stok_awal:stok_awal,
      kategori_bahan,
      jumlah:jumlah,sub_total:sub_total 
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(data)
    {
     $(".tunggu").hide(); 
     $("#tabel_temp_data_transaksi").load("<?php echo base_url().'stok/get_stok_out/'; ?>"+kode_stok_out);
     $('#kode_bahan').val('');
     $('#jumlah').val('');
     $('#satuan_stok').val('');      
     $("#keterangan").val('');             
   }
 });

}
</script>