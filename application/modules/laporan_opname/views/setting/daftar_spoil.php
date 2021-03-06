<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a href="<?php echo base_url().'laporan_opname/daftar_spoil' ?> " class="dashboard-stat dashboard-stat-light blue-soft" id="stok_opname">
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" ></i>
      </div>
      <div class="details" >
        <div class="number">

        </div>
        <div class="desc">
        Laporan Spoil
        </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a href="<?php echo base_url().'laporan_opname/total_spoil' ?> " class="dashboard-stat dashboard-stat-light red-soft"  id="spoil" >
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" ></i>
      </div>
      <div class="details">
        <div class="number">

        </div>
        <div class="desc">
          Total Produk Spoil
        </div>
      </div>
    </a>
  </div>

</div>

<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Laporan Spoil 
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
          <form id="data_form" method="post" hidden>
            <div class="box-body">            
              <div class="row">
              <div class="col-md-10 " id="">
              <div class="col-md-5 " id="">
                <div class="input-group">
                  <span class="input-group-addon">Filter</span>
                  <select class="form-control" id="kategori_filter">
                    <option value="">- PILIH Filter -</option>
                    <option value="kategori">Kategori Produk</option>
                    <option value="blok">Blok</option>
                  </select>
                </div>
                <br>
              </div>
            </div>

            <div class="col-md-10 " id="opsi_filter">
              <div class="col-md-5 " id="">
                <div class="input-group">
                  <span class="input-group-addon">Filter By</span>
                  <select class="form-control" id="jenis_filter">
                    <option value="">- PILIH Filter -</option>
                    
                  </select>
                </div>
                <br>
              </div>                        
            </div>
            <div class="col-md-10 " id="opsi_filter">
              <div class="col-md-5 " id="">
                <button style="width: 100px" type="button" class="btn btn-warning " id="cari"><i class="fa fa-search"></i> Cari</button>
              </div>
            </div>
          </div> 

            </div>
          </div>
        </form>
        <form id="data_opname">
              <div id="cari_transaksi">

                <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
                 <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Spoil</th>
                    <th>Tanggal Spoil</th>
                    <th>Nama Petugas</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="daftar_list_stock">

                  <?php
                  
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $param=$hasil_unit->kode_unit;
                  $date = date('Y-m');
           

                  $get_stok = $this->db->query("SELECT * from transaksi_spoil where kode_unit='$param' and tanggal_spoil like '%$date%' order by tanggal_spoil DESC");
                  $hasil_stok = $get_stok->result_array();
                  $no=1;
                  foreach ($hasil_stok as $item) {

                    ?>   
                    <tr>
                      <td><?php echo $no++;?></td>
                      <td><?php echo $item['kode_spoil'];?></td>
                      <td><?php echo TanggalIndo($item['tanggal_spoil']);?></td>
                      <td><?php echo $item['petugas'];?></td>
                      <?php 
                        $get_total =$this->db->get_where("opsi_transaksi_spoil",array('kode_spoil'=>$item['kode_spoil']));
                        $hasil_total=$get_total->result();
                        $total =count($hasil_total);
                       ?>
                      <td><?php echo $total;?></td>
                      

                       <td align="center">
                       <a href="<?php echo base_url().'laporan_opname/detail_spoil/'.$item['kode_spoil'] ?>" class="btn btn-circle btn-primary btn-icon-only"><i class="fa fa-search"></i></a>
                        
                       </td>
                    </tr>

                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <tr>
                    <th>No</th>
                    <th>Kode Spoil</th>
                    <th>Tanggal Spoil</th>
                    <th>Nama Petugas</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </form>
            <div class="row">
            <!-- <a style="padding:13px; margin-bottom:10px; margin-right:15px;" id="opname" class="btn btn-app green pull-right" ><i class="fa fa-edit"></i> Opname </a> -->
            </div>  
      </div>

      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
</div><!-- /.col -->
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

$('.tgl').Zebra_DatePicker({});


// $('#cari').click(function(){

//   var tgl_awal =$("#tgl_awal").val();
//   var tgl_akhir =$("#tgl_akhir").val();
//   var kode_unit =$("#kode_unit").val();

//     $.ajax( {  
//       type :"post",  
//       url : "<?php echo base_url().'opname/cari_opname'; ?>",  
//       cache :false,

//       data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
//       beforeSend:function(){
//         $(".tunggu").show();  
//       },
//       success : function(data) {
//        $(".tunggu").hide();  
//        $("#cari_transaksi").html(data);
//      },  
//      error : function(data) {  
//          // alert("das");  
//        }  
//      });
//   }

//   $('#tgl_awal').val('');
//   $('#tgl_akhir').val('');

// });
</script>
<script>
$(document).ready(function(){
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
    "info":     false
  });
  $('#opsi_filter').hide();
})

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
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg) {
      $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
  return false;
}

$('#kategori_filter').on('change',function(){
  var kategori_filter = $('#kategori_filter').val();

  var url = "<?php echo base_url() . 'opname/get_jenis_filter' ?>";
  $.ajax({
    type: 'POST',
    url: url,
    data: {kategori_filter:kategori_filter},
    success: function(msg){
      $('#opsi_filter').show();
      $('#jenis_filter').html(msg);
    }
  });
});

$('#cari').click(function(){

  var jenis_filter =$("#jenis_filter").val();
  var kategori_filter =$("#kategori_filter").val();
  $.ajax( {  
    type :"post",  
    url : "<?php echo base_url().'opname/cari_opname'; ?>",  
    cache :false,

    data : {jenis_filter:jenis_filter,kategori_filter:kategori_filter},
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success : function(data) {
     $(".tunggu").hide();  
     $("#cari_transaksi").html(data);
     // $('#jenis_filter').val('');
     // $('#kategori_filter').val('');
   },  
   error : function(data) {  
         // alert("das");  
       }  
     });
});
$('#opname').click(function(){


  $.ajax( {  
    type :"post",  
    url : "<?php echo base_url().'opname/simpan_opname_temp_baru'; ?>",  
    cache :false,

    data :$('#data_opname').serialize(),
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success : function(data) {
     $(".tunggu").hide();  
     window.location = "<?php echo base_url() . 'opname/tambah_opname_baru/' ; ?>";
     // $("#cari_transaksi").html(data);
     // // $('#jenis_filter').val('');
     // // $('#kategori_filter').val('');
   },  
   error : function(data) {  
         // alert("das");  
       }  
     });
});
function print(Object) {
  var kode_opname = Object;
  window.open("<?php echo base_url() . 'opname/print_opname/' ; ?>"+kode_opname);
  $('#modal-confirm-print').modal('hide');
}
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
<img class="btn-back" src="<?php echo base_url().'component/img/back_icon.png'?>" style="width: 70px;height: 70px;">


<script>
$('.btn-back').click(function(){
  $(".tunggu").show();
  window.location = "<?php echo base_url().'laporan_opname/menu_laporan'; ?>";
});
</script>