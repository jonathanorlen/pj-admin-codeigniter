<div class="row">      
  <div class="col-xs-12">
   <!-- /.box -->
   <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
        Tambah Spoil
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
      $kode_unit = $this->uri->segment(3);
      $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
      $hasil_unite = $unit->row();
      ?>

      <div class="box-body">    

        <div class="sukses" ></div>
        <form id="data_form" action="" method="post">
          <div class="box-body">
            <label><h3><b>Tambah Spoil</b></h3></label>
            <div class="row">
              <?php
              $tgl = date("Y-m-d");
              $no_belakang = 0;
              $this->db->select_max('kode_spoil');
              $kode = $this->db->get_where('transaksi_spoil',array('tanggal_spoil'=>$tgl));
              $hasil_kode = $kode->row();
                                    #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                    #echo $pecah_kode[0];
                                    #echo $pecah_kode[2];
              $this->db->select('kode_spoil');
              $kode_spoil = $this->db->get('master_setting');
              $hasil_kode_spoil = $kode_spoil->row();

              if(count($hasil_kode)==0){
                $no_belakang = 1;
              }
              else{
                $pecah_kode = explode("_",$hasil_kode->kode_spoil);
                $no_belakang = @$pecah_kode[2]+1;
              }

                                    #echo $this->db->last_query();

              ?>

              <div class="col-md-6">
                <div class="box-body">
                  <div class="btn btn-app blue">
                    <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                    <span style="text-align:right;"><?php echo @$hasil_kode_spoil->kode_spoil."_".date("dmyHis")."_".$no_belakang ?></span>
                    <input readonly="true" type="hidden" value="<?php echo @$hasil_kode_spoil->kode_spoil."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_spoil" id="kode_spoil" />
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="box-body">
                  <div class="btn btn-app blue">
                    <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                    <span style="text-align:right;" id="tanggal_spoil"><?php echo TanggalIndo(date("Y-m-d")); ?></span>
                  </div>
                </div>
              </div>

            </div>
          </div> 
          <br><br>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <!-- <div class="col-md-2">
                  <label>Jenis Bahan</label>
                  <select name="jenis_bahan" id="jenis_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                    <option value="" selected="true">--Pilih Jenis Bahan--</option>
                    <option value="bahan baku">Bahan Baku</option>                     
                    <option value="bahan jadi">Bahan Jadi</option> 
                  </select>
                </div> -->
                <input type="hidden" id="jenis_bahan" name="jenis_bahan"  value="bahan baku"/>
                <div class="col-md-2">
                  <label>Nama Bahan</label>
                  <select id="kode_bahan" name="kode_bahan" class="form-control select2">
                    <option value="">Pilih Bahan</option>
                    <?php 
                    $ambil_data = $this->db->get('master_bahan_baku');
                    $hasil_ambil_data = $ambil_data->result();
                    foreach ($hasil_ambil_data as $key => $value) {
                     ?>
                     <option value="<?php echo $value->kode_bahan_baku ;?>"><?php echo $value->nama_bahan_baku ;?></option>
                     <?php
                   }
                   ?>
                 </select>
               </div>
               <input type="hidden" id="nama_bahan" name="nama_bahan" />
               <input type="hidden" id="kode_rak" name="kode_rak" />
               <input type="hidden" id="nama_rak" name="nama_rak" />
               <input type="hidden" id="kode_unit" name="kode_unit" />
               <input type="hidden" id="nama_unit" name="nama_unit" />
               <input type="hidden" name="id_item" id="id_item" />
               <div class="col-md-2">
                <label>QTY</label>
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
              <div class="col-md-2" style="padding:25px;">
                <div onclick="add_item()" id="add"  class="btn btn-primary">Add</div>
                <div onclick="update_item()" id="update"  class="btn btn-primary">Update</div>
              </div>
            </div>
          </div>
        </div>

        <div id="list_transaksi_pembelian">
          <div class="box-body">
            <table id="tabel_daftar" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Bahan</th>
                  <th>Nama Unit</th>
                  <th>Nama Rak</th>
                  <th>Nama Bahan</th>
                  <th>QTY</th>
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
        
        <button type="submit" class="btn btn-success pull-right" >Simpan</button>
        
        <div class="box-footer clearfix"></div>

      </form>

      <!------------------------------------------------------------------------------------------------------>
    </div>
  </div><!-- /.col -->
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data spoil tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $("#update").hide();
  $("#tabel_temp_data_transaksi").load("<?php echo base_url().'spoil/spoil/get_spoil'; ?>");

  // $("#jenis_bahan").change(function(){
  //   var jenis_bahan = $(this).val();
  //   var url = "<?php echo base_url().'spoil/spoil/get_bahan/'.$kode_unit; ?>";
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: {jenis_bahan:jenis_bahan},
  //     success: function(pilihan) {              
  //      $("#kode_bahan").html(pilihan);
  //    }
  //  });
  // });


$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var url = "<?php echo base_url() . 'spoil/spoil/get_nama_bahan/'.$kode_unit; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType:'json',
    data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
    success: function(msg){
      if(msg.nama_bahan_baku){
        $("#nama_bahan").val(msg.nama_bahan_baku);
       // alert(msg.satuan_stok);
       $("#satuan_stok").val(msg.satuan_stok);
     }else if(msg.nama_bahan_jadi){
      $("#nama_bahan").val(msg.nama_bahan_jadi);
    }

    if(msg.kode_rak){
      $('#kode_rak').val(msg.kode_rak);
    }else if(msg.kode_rak){
      $('#kode_rak').val(msg.kode_rak);
    }

    if(msg.nama_rak){
      $("#nama_rak").val(msg.nama_rak);
    }else if(msg.nama_rak){
      $("#nama_rak").val(msg.nama_rak);
    }

    if(msg.kode_unit){
      $('#kode_unit').val(msg.kode_unit);
    }else if(msg.kode_unit){
      $('#kode_unit').val(msg.kode_unit);
    }

    if(msg.nama_unit){
      $("#nama_unit").val(msg.nama_unit);
    }else if(msg.nama_unit){
      $("#nama_unit").val(msg.nama_unit);
    }

  }
});
});

$("#data_form").submit(function(){
  var simpan_spoil = "<?php echo base_url().'spoil/spoil/simpan_spoil'?>";
  $.ajax({
    type: "POST",
    url: simpan_spoil,
    data: $('#data_form').serialize(),
    success: function(msg)
    {
      $(".sukses").html(msg);   
      setTimeout(function(){$('.sukses').html('');
       window.location = "<?php echo base_url() . 'spoil/daftar_spoil/'.$kode_unit ; ?>";
      },1500);        
    }
  });
  return false;

});

})


function add_item(){
  var kode_spoil = $('#kode_spoil').val();
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var nama_bahan = $("#nama_bahan").val();
  var kode_unit = $("#kode_unit").val();
  var nama_unit = $("#nama_unit").val();
  var kode_rak = $("#kode_rak").val();
  var nama_rak = $("#nama_rak").val();
  var keterangan = $("#keterangan").val();
  var url = "<?php echo base_url().'spoil/spoil/simpan_item_temp'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_spoil:kode_spoil,
      jenis_bahan:jenis_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_unit:kode_unit,
      nama_unit:nama_unit,
      kode_rak:kode_rak,
      nama_rak:nama_rak,
      keterangan:keterangan
    },
    success: function(data)
    {
      $(".sukses").html(data);
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'spoil/spoil/get_spoil'; ?>");
      $('#jenis_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#kode_unit").val('');
      $('#nama_unit').val('');
      $("#kode_rak").val('');
      $('#nama_rak').val('');
      $("#nama_bahan").val('');
      $("#keterangan").val('');

    }
  });
}

function actEdit(id) {
  var id = id;
  var url = "<?php echo base_url().'spoil/spoil/get_temp_spoil'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(spoil){
      $('#jenis_bahan').val(spoil.jenis_bahan);
      //$("#kode_bahan").empty();
      //$('#kode_bahan').html("<option value="+spoil.kode_bahan+" selected='true'>"+spoil.nama_bahan+"</option>");
      $("#kode_bahan").val(spoil.kode_bahan);
      $("#nama_bahan").val(spoil.nama_bahan);
      $('#jumlah').val(spoil.jumlah);
      $('#kode_unit').val(spoil.kode_unit);
      $('#nama_unit').val(spoil.nama_unit);
      $('#kode_rak').val(spoil.kode_rak);
      $('#nama_rak').val(spoil.nama_rak);
      $('#keterangan').val(spoil.keterangan);
      $("#id_item").val(spoil.id);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'spoil/spoil/get_spoil'; ?>");
    }
  });
}

function update_item(){
  var kode_spoil = $('#kode_spoil').val();
  var jenis_bahan = $('#jenis_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_unit = $('#kode_unit').val();
  var nama_unit = $("#nama_unit").val();
  var kode_rak = $('#kode_rak').val();
  var nama_rak = $("#nama_rak").val();
  var nama_bahan = $("#nama_bahan").val();
  var keterangan = $("#keterangan").val();
  var id_item = $("#id_item").val();
  var url = "<?php echo base_url().'spoil/spoil/update_item_temp/'.$kode_unit; ?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_spoil:kode_spoil,
      jenis_bahan:jenis_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_unit:kode_unit,
      nama_unit:nama_unit,
      kode_rak:kode_rak,
      nama_rak:nama_rak,
      keterangan:keterangan,
      id:id_item
    },
    success: function(data)
    {
      $(".sukses").html(data);
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'spoil/spoil/get_spoil'; ?>");
      $('#jenis_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#kode_unit").val('');
      $('#nama_unit').val('');
      $("#kode_rak").val('');
      $('#nama_rak').val('');
      $("#nama_bahan").val('');
      $("#keterangan").val('');
      $("#id_item").val('');
      $("#add").show();
      $("#update").hide();
    }
  });
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function delData() {
  var id = $('#id-delete').val();
  var url = '<?php echo base_url().'spoil/spoil/hapus_bahan_temp'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id
    },
    success: function(msg) {
      $('#kode_bahan').val('');
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'spoil/spoil/get_spoil'; ?>");

    }
  });
  return false;
}

</script>