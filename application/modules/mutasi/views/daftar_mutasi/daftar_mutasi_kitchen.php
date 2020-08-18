<?php 
$get_position = $this->uri->segment(2);
$position = ucwords($get_position);
?>
<div class="row">      
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="gudang">
      <div class="visual">
        <i class="glyphicon glyphicon-tasks" ></i>
      </div>
      <div class="details" >
        <div class="number">

        </div>
        <div class="desc">
          Gudang
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light red-soft"  id="kitchen">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Kitchen
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light green-soft"  id="bar">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Bar
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light purple-soft"  id="serve">
      <div class="visual">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Server
        </div>
      </div>
    </a>
  </div>
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Data Mutasi
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
          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app green" href="<?php echo base_url().'stok/'.$position; ?>"><i class="fa fa-edit"></i> Stok </a>

          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app blue" href="<?php echo base_url().'spoil/'.$position; ?>"><i class="fa fa-edit"></i> Spoil </a>

          <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" href="<?php echo base_url().'retur_pembelian/'.$position; ?>"><i class="fa fa-edit"></i> Retur </a> -->
          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app red" href="<?php echo base_url().'mutasi/kitchen'; ?>"><i class="fa fa-edit"></i> Mutasi </a>

          <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-warning" href="<?php echo base_url().'opname/kitchen'; ?>"><i class="fa fa-edit"></i> Opname </a>
          <div class="row">
            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Awal</span>
                <input type="text" class="form-control tgl" id="tgl_awal">
              </div>
            </div>

            <div class="col-md-5" id="">
              <div class="input-group">
                <span class="input-group-addon">Tanggal Akhir</span>
                <input type="text" class="form-control tgl" id="tgl_akhir">
              </div>
            </div>                        
            <div class="col-md-2 pull-left">
              <button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <div class="row">
              <div class="col-md-12">
               
              </div>
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                  <div class="box box-info">                 
                    <div class="box-body"> 

                    <div id="cari_transaksi">
                      <table id="tabel_daftar" class="table table-bordered table-striped">
                        <?php
                        $this->db->group_by('kode_mutasi','desc');
                        $mutasi = $this->db->get('opsi_transaksi_mutasi');
                        $hasil_mutasi = $mutasi->result();
                        $kode_default = $this->db->get('setting_kitchen');
                        $hasil_unit =$kode_default->row();

                        $kode_unit = $hasil_unit->kode_unit; 
                        ?>
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Tanggal Mutasi</th>
                            <th>Petugas</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $nomor = 1;
                          foreach($hasil_mutasi as $daftar){ 
                           $query = $this->db->query(" SELECT * FROM transaksi_stok where kode_transaksi= '$daftar->kode_mutasi' and kode_unit_asal='$kode_unit' ");
                           $cek=$query->num_rows();
                           $petugas=$query->row();
                           if($cek>0){
                            //echo "$kode_unit";

                             ?> 
                             <tr style="font-size: 15px;">
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo @$daftar->kode_mutasi; ?></td>
                              <td><?php echo @$daftar->tanggal_update; ?></td>
                              <td><?php echo @$petugas->nama_petugas; ?></td>
                              <td align="center"><?php echo get_detail_mutasi_kitchen($daftar->kode_mutasi); ?></td>
                            </tr>
                            <?php $nomor++; }} ?>

                          </tbody>
                        </table>
                        </div>
                      </div>
                    </div>
                  </section><!-- /.Left col -->   
                   <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $kode_unit;?>">   
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
              </div>
            </div>
          </div>

          <!------------------------------------------------------------------------------------------------------>

        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>    
</div>  
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

$('.tgl').Zebra_DatePicker({});
$('#cari').click(function(){
  var tgl_awal =$("#tgl_awal").val();
  var tgl_akhir =$("#tgl_akhir").val();
  var kode_unit =$("#kode_unit").val();
  if (tgl_awal=='' || tgl_akhir==''){ 
    alert('Masukan Tanggal Awal & Tanggal Akhir..!')
  }
  else{
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'mutasi/cari_mutasi_kitchen'; ?>",  
      cache :false,
        
      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
       $(".tunggu").hide();  
       $("#cari_transaksi").html(data);
     },  
     error : function(data) {  
         // alert("das");  
       }  
     });
  }

  $('#tgl_awal').val('');
  $('#tgl_akhir').val('');

});
</script>

<script>
$(document).ready(function(){
   $("#gudang").click(function(){
                              window.location = "<?php echo base_url() . 'stok/gudang' ?>";

                            });

                            $("#bar").click(function(){
                              window.location = "<?php echo base_url() . 'stok/bar' ?>";
                            });

                            $("#kitchen").click(function(){
                              window.location = "<?php echo base_url() . 'stok/kitchen' ?>";
                            });

                            $("#serve").click(function(){
                              window.location = "<?php echo base_url() . 'stok/server' ?>";
                            });
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });
  $("#stock").click(function(){
        window.location = "<?php echo base_url() . 'stock/daftar' ?>";
    });
  $("#spoil").click(function(){
        window.location = "<?php echo base_url() . 'spoil/daftar' ?>";
    });

    $("#opname").click(function(){
        window.location = "<?php echo base_url() . 'opname/daftar_opname/01' ?>";
    });

    $("#mutasi").click(function(){
        window.location = "<?php echo base_url() . 'mutasi/daftar_mutasi' ?>";
    });
  //$("#tabel_daftar").dataTable();
  $("#update").hide();


  $("#unit_awal").change(function(){
    var unit_awal = $("#unit_awal").val();
    var url = "<?php echo base_url().'stok/mutasi/get_rak_unit_awal'; ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {unit_awal:unit_awal},
      success: function(pilihan) {   
        var data = pilihan.split("|");
        var rak = data[0];
        var unit = data[1];  
        $("#rak_awal").html(rak);
              //alert(unit);
              $("#nama_unit_awal").val(unit);
            }
          });
  });

  $("#unit_akhir").change(function(){
    var unit_akhir = $("#unit_akhir").val();
    var url = "<?php echo base_url().'stok/mutasi/get_rak_unit_akhir'; ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {unit_akhir:unit_akhir},
      success: function(pilihan) {   
        var data = pilihan.split("|");
        var rak = data[0];
        var unit = data[1];  
        $("#rak_akhir").html(rak);
              //alert(unit);
              $("#nama_unit_akhir").val(unit);          
            }
          });
  });

  $("#rak_awal").change(function(){
    var rak_awal = $("#rak_awal").val();
    var url = "<?php echo base_url().'stok/mutasi/get_nama_rak_awal'; ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {rak_awal:rak_awal},
      success: function(rak) {   
              //alert(rak);
              $("#nama_rak_awal").val(rak);
            }
          });
  });

  $("#rak_akhir").change(function(){
    var rak_akhir = $("#rak_akhir").val();
    var url = "<?php echo base_url().'stok/mutasi/get_nama_rak_akhir'; ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {rak_akhir:rak_akhir},
      success: function(rak) {   
              //alert(rak);
              $("#nama_rak_akhir").val(rak);
            }
          });
  });

  $("#kategori_bahan").change(function(){
    var jenis_bahan = $(this).val();
    var unit_awal = $("#unit_awal").val();
    var rak_awal = $("#rak_awal").val();     
    var url = "<?php echo base_url().'stok/mutasi/get_bahan'; ?>";

      //alert(unit_awal); alert(rak_awal);
      if(unit_awal=='' && rak_awal==''){
        alert('Posisi Gudang dan rak asal harus diisi');
      }
      else{
        $.ajax({
          type: "POST",
          url: url,
          data: {jenis_bahan:jenis_bahan,kode_unit_asal:unit_awal,kode_rak_asal:rak_awal},
          success: function(pilihan) {              
           $("#kode_bahan").html(pilihan);
         }
       });
      }
    });

  $('#kode_bahan').on('change',function(){
    var jenis_bahan = $('#kategori_bahan').val();
    var kode_bahan = $('#kode_bahan').val();
    var url = "<?php echo base_url() . 'stok/mutasi/get_satuan' ?>";
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
    var simpan_mutasi = "<?php echo base_url().'stok/mutasi/simpan_mutasi/'?>";
    $.ajax({
      type: "POST",
      url: simpan_mutasi,
      data: $('#data_form').serialize(),
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'stok/menu_stok/' ?>";
        },1800);        
      }
    });
    return false;

  });

})

function add_item(){
  var kategori_bahan = $('#kategori_bahan').val();
  var unit_awal = $("#unit_awal").val();
  var rak_awal = $("#rak_awal").val();    
  var kode_bahan = $('#kode_bahan').val();
  var nama_bahan = $('#nama_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_mutasi = $('#kode_mutasi').val();

  var url = "<?php echo base_url().'stok/mutasi/simpan_item_mutasi_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { 
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      jumlah:jumlah,
      nama_bahan:nama_bahan,
      kode_mutasi:kode_mutasi,
      kode_unit_asal:unit_awal,
      kode_rak_asal:rak_awal
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
        $('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
      }
      else {
        $(".gagal").html(pesan);   
        setTimeout(function(){
          $('.gagal').html('');
        },1500);
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
  var url = '<?php echo base_url().'master/menu_resto/hapus_bahan_jadi'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id: id
    },
    success: function(msg) {
      $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
  return false;
}

function actEdit(id) {
  var id = id;
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/get_temp_mutasi'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(mutasi){
      $('#kategori_bahan').val(mutasi.kategori_bahan);
      $("#kode_bahan").empty();
      $('#kode_bahan').html("<option value="+mutasi.kode_bahan+" selected='true'>"+mutasi.nama_bahan+"</option>");
      $("#nama_bahan").val(mutasi.nama_bahan);
      $('#jumlah').val(mutasi.jumlah);
      $("#id_item_temp").val(mutasi.id);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
    }
  });
}

function update_item(){
  var kode_mutasi = $('#kode_mutasi').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var nama_bahan = $("#nama_bahan").val();
  var id_item_temp = $("#id_item_temp").val();
  var url = "<?php echo base_url().'stok/mutasi/ubah_item_mutasi_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_mutasi:kode_mutasi,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      id:id_item_temp
    },
    success: function(data)
    {
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#nama_bahan").val('');
      $("#id_item_temp").val('');
      $("#add").show();
      $("#update").hide();

    }
  });
}

function delData() {
  var id = $('#id-delete').val();
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/hapus_temp'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    data: {id:id},
    success: function(pembelian){
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
    }
  });
}

</script>