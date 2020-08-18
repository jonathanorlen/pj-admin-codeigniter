<div class="row">      
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
            window.location = "<?php echo base_url().'pembelian/daftar_pembelian'; ?>";
          });
        </script>
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Pembelian 

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
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'pembelian/retur/tambah' ?>"><i class="fa fa-edit"></i> Tambah </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>"><i class="fa fa-list"></i> Daftar </a> 

        <?php
        $param = $this->uri->segment(4);
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Retur Pembelian</b></h3></label>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kode Transaksi Retur</label>
                    <?php
                    $tgl = date("Y-m-d");
                    $no_belakang = 0;
                    $this->db->select_max('kode_retur');
                    $kode = $this->db->get_where('transaksi_retur',array('tanggal_retur_keluar'=>$tgl));
                    $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                    $this->db->select('kode_retur');
                    $kode_retur = $this->db->get('master_setting');
                    $hasil_kode_retur = $kode_retur->row();

                    if(count($hasil_kode)==0){
                      $no_belakang = 1;
                    }
                    else{
                      $pecah_kode = explode("_",$hasil_kode->kode_retur);
                      $no_belakang = @$pecah_kode[2]+1;
                    }

                                        #echo $this->db->last_query();

                    ?>
                    <input type="text" value="<?php echo @$hasil_kode_retur->kode_retur."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_retur" id="kode_retur" readonly/>
                  </div>
                  <div class="form-group">
                    <label class="gedhi">Tanggal Transaksi</label>
                    <input type="text" readonly value="<?php echo TanggalIndo(date("Y-m-d")); ?>" class="form-control tgl" placeholder="Tanggal Transaksi" name="tanggal_retur_keluar" id="tanggal_retur_keluar"/>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nota Referensi</label>
                    <input type="text" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" readonly/>
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <?php
                    $supplier = $this->db->get('master_supplier');
                    $supplier = $supplier->result();
                    ?>
                    <select class="form-control" name="kode_supplier" id="kode_supplier" readonly>
                     <option selected="true" value="">--Pilih Supplier--</option>
                     <?php foreach($supplier as $daftar){ ?>
                     <option value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                     <?php } ?>
                   </select> 
                 </div>
               </div>
             </div>
           </div> 

           <div class="sukses" ></div>
           <div class="gagal" ></div>
           <div class="box-body">
            <label><h3><b>Item Retur Pembelian</b></h3></label>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2">
                 <label>Jenis Barang</label>
                 <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true" readonly>
                  <option value="" selected="true">--Pilih Jenis Barang--</option>
                  <option value="bahan baku">Bahan Baku</option>                     
                  <option value="barang">Barang</option> 
                </select>

              </div> 

              <div class="col-md-2">
                <label>Nama Bahan</label>
                <select id="kode_bahan" name="kode_bahan" class="form-control" readonly>
                  <option value="">Pilih Bahan</option>
                </select>
                <input type="hidden" id="nama_bahan" name="nama_bahan" />
              </div>

              <div class="col-md-2">
                <label>QTY</label>
                <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
              </div>
              <div class="col-md-2">
                <label>Satuan</label>
                <input type="text" class="form-control" placeholder="Satuan Stok" name="nama_satuan" id="nama_satuan" readonly/>
                <input type="hidden" name="kode_satuan" id="kode_satuan" />
              </div>
              <div class="col-md-2">
                <label>Harga Satuan</label>
                <input type="text" class="form-control" placeholder="Harga Satuan" name="harga_satuan" id="harga_satuan" readonly/>
              </div>
              <div class="col-md-2" style="padding:25px; display:none;" id="add_item">
                <div onclick="add_item()"  class="btn btn-primary">Add</div>
              </div>
              <div class="col-md-2" style="padding:25px;" id="update_item">
                <div onclick="update_item()"  class="btn btn-primary">Update</div>
                <input type="hidden" name="id_item_temp" id="id_item_temp" />
              </div>
            </div>
          </div>
        </div>

        <div id="list_retur_pembelian">
          <div class="box-body">
            <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama bahan</th>
                  <th>QTY</th>
                  <th>Harga Satuan</th>
                  <th>Subtotal</th>
                  <th width="100px">Action</th>
                </tr>
              </thead>
              <tbody id="tabel_temp_data_retur">

              </tbody>
              <tfoot>
              </tfoot>

            </table>
          </div>
        </div>

        <div class="box-body">
          <div class="row">
            <div class="col-md-9">
              <label>Keterangan</label>
              <textarea class="form-control" value="" name="keterangan" id="keterangan" required=""></textarea>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-success pull-right">Simpan</button>
        <div class="box-footer clearfix">
         
       </div>

     </form>
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data tersebut ?</span>
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
      <form id="cari_nota" method="post">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" onclick="" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Transaksi Retur</h4>
        </div>
        <div class="modal-body" >
          <div class="form-body">
            <div id="edit_hide" class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Nama Suplier</label>
                  <?php
                  $supplier = $this->db->get('master_supplier');
                  $supplier = $supplier->result();
                  ?>
                  <select class="form-control" name="kode_supplier_awal" id="kode_supplier_awal" required="">
                   <option selected="true" value="">--Pilih Supplier--</option>
                   <?php foreach($supplier as $daftar){ ?>
                   <option value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                   <?php } ?>
                 </select> 
               </div>
             </div>
           </div>
           <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Nota Referensi</label>
                <input type="text" id="nota" name="nota" class="form-control" placeholder="Nota Referensi" required="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Tanggal</label>
                <input type="date" class="form-control" placeholder="Tanggal" name="tanggal_pembelian_awal" id="tanggal_pembelian_awal" required="" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="gagal" ></div>
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
</div>

<script type="text/javascript">

$(document).ready(function(){
  //  $("#tabel_daftar").dataTable();
  $(".tgl").datepicker();
  //$(".select2").select2();
  begin();
  $('#update_item').show();

  $("#cari_nota").submit(function(){
    var cari_nota = "<?php echo base_url().'pembelian/retur/cari_nota/'?>";
    var kode_supplier_awal = $('#kode_supplier_awal').val();
    var nota = $('#nota').val();
    var tanggal_pembelian_awal = $('#tanggal_pembelian_awal').val();
    var kode_retur = $('#kode_retur').val();

    $.ajax({
      type: "POST",
      url: cari_nota,
      data: {kode_supplier:kode_supplier_awal, nota:nota, tanggal_pembelian:tanggal_pembelian_awal, kode_retur:kode_retur},
      success: function(msg)
      {
        var data = msg.split("|");
        var num = data[0];
        var nota = data[1];
                //var kode = data[2];
                var kode_supplier = data[3];

                if(num > 0){  
                  //var kode = data[2];
                  //$('#tabel_item_pembelian').load("<?php echo base_url().'pembelian/retur/tabel_item_pembelian/'; ?>"+kode);
                  $('#tabel_temp_data_retur').load("<?php echo base_url().'pembelian/retur/tabel_item_retur/'; ?>"+kode_retur);
                  $('#modal-regular').modal('hide');
                  $('#nomor_nota').val(nota);
                  $('#kode_supplier').val(kode_supplier);
                }
                else{
                  $(".gagal").html('<div class="alert alert-danger">Nota Tidak Ditemukan</div>');
                  setTimeout(function(){
                    $('.gagal').html('');
                  },1700);              
                  $('#kode_supplier_awal').val('');
                  $('#nota').val('');
                  $('#tanggal_pembelian_awal').val('');
                }   
              }
            });
return false;
});

$("#kategori_bahan").change(function(){
  var jenis_bahan = $(this).val();
  var url = "<?php echo base_url().'pembelian/retur/get_bahan'; ?>";
  $.ajax({
    type: "POST",
    url: url,
    data: {jenis_bahan:jenis_bahan},
    success: function(pilihan) {              
     $("#kode_bahan").html(pilihan);
   }
 });
});

$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var url = "<?php echo base_url() . 'pembelian/retur/get_satuan' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
    success: function(msg){
      if(msg.satuan_pembelian){
        $('#nama_satuan').val(msg.satuan_pembelian);
      }else if(msg.satuan_stok){
        $('#nama_satuan').val(msg.satuan_stok);
      }
      if(msg.id_satuan_pembelian){
        $("#kode_satuan").val(msg.id_satuan_pembelian);
      }else if(msg.kode_satuan_stok){
        $("#kode_satuan").val(msg.kode_satuan_stok);
      }
      if(msg.nama_bahan_baku){
        $("#nama_bahan").val(msg.nama_bahan_baku);
      }else if(msg.nama_bahan_jadi){
        $("#nama_bahan").val(msg.nama_bahan_jadi);
      }

    }
  });
});

$("#data_form").submit(function(){
  var simpan_retur = "<?php echo base_url().'pembelian/retur/simpan_retur/'?>";
  $.ajax({
    type: "POST",
    url: simpan_retur,
    data: $('#data_form').serialize(),
    success: function(msg)
    {
      $(".sukses").html(msg);   
      setTimeout(function(){$('.sukses').html('');
        window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>";
      },1500);        
    }
  });
  return false;

});


});

function begin(){
  $('#modal-regular').modal('show'); 
}

function cancel(){
  window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";
}

function add_item(){
  var kode_retur = $('#kode_retur').val();
  var nomor_nota = $('#nomor_nota').val();
  var kode_supplier = $('#kode_supplier').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_satuan = $('#kode_satuan').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var nama_bahan = $("#nama_bahan").val();
  var url = "<?php echo base_url().'pembelian/retur/simpan_item_retur_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_retur:kode_retur,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_satuan:kode_satuan,
      nama_satuan:nama_satuan,
      harga_satuan:harga_satuan,
      kode_supplier:kode_supplier
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $("#tabel_temp_data_retur").load("<?php echo base_url().'pembelian/retur/tabel_item_retur/'; ?>"+kode_retur);
        $('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
        $("#nama_satuan").val('');
        $('#harga_satuan').val('');
      }
      else {
        $(".gagal").html(pesan);   
        setTimeout(function(){$('.gagal').html('');
          window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>";
        },1800);
      }               
    }
  });
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function delData() {
  var id = $('#id-delete').val();
  var kode_retur = $('#kode_retur').val();
  var url = "<?php echo base_url().'pembelian/retur/hapus_temp'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    data: {id:id},
    success: function(pembelian){
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_retur").load("<?php echo base_url().'pembelian/retur/tabel_item_retur/'; ?>"+kode_retur);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#nama_satuan").val('');
      $('#harga_satuan').val('');

    }
  });
}

function actEdit(id) {
  var id = id;
  var url = "<?php echo base_url().'pembelian/retur/get_temp_retur'; ?>";
  var kode_retur = $('#kode_retur').val();
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(pembelian){
      $('#kategori_bahan').val(pembelian.kategori_bahan);
            //$("#kode_bahan").empty();
            $('#kode_bahan').html("<option value="+pembelian.kode_bahan+" selected>"+pembelian.nama_bahan+"</option>");
            $('#nama_bahan').val(pembelian.nama_bahan);
            $('#jumlah').val(pembelian.jumlah);
            $('#kode_satuan').val(pembelian.kode_satuan);
            $('#nama_satuan').val(pembelian.nama_satuan);
            $('#harga_satuan').val(pembelian.harga_satuan);
            $('#kode_supplier').val(pembelian.kode_supplier);
            $("#tabel_temp_data_retur").load("<?php echo base_url().'pembelian/retur/tabel_item_retur/'; ?>"+kode_retur);
            $('#id_item_temp').val(id);
            $('#add_item').hide(); 
            $('#update_item').show(); 
          }
        });
}

function update_item(){
  var kode_retur = $('#kode_retur').val();
  var nomor_nota = $('#nomor_nota').val();
  var kode_supplier = $('#kode_supplier').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_satuan = $('#kode_satuan').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var nama_bahan = $("#nama_bahan").val();
  var id = $('#id_item_temp').val();
  var url = "<?php echo base_url().'pembelian/retur/ubah_item_retur_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { 
      nomor_nota:nomor_nota,
      kode_retur:kode_retur,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_satuan:kode_satuan,
      nama_satuan:nama_satuan,
      harga_satuan:harga_satuan,
      kode_supplier:kode_supplier,
      id:id
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $("#tabel_temp_data_retur").load("<?php echo base_url().'pembelian/retur/tabel_item_retur/'; ?>"+kode_retur);
        $('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
        $("#nama_satuan").val('');
        $('#harga_satuan').val('');
        $('#add_item').hide(); 
        $('#update_item').show();
      }
      else {
        alert(pesan);   
      }
    }
  });
}

</script>