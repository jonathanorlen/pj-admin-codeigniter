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
    <?php 
$position = $this->uri->segment(2);
if($position == 'detail' || $position == 'edit'){
	$position = $this->uri->segment(3);
}
?>


    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Spoil <?php echo $position; ?>
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
              <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app green" href="<?php echo base_url().'stok/'.@$position; ?>"><i class="fa fa-edit"></i> Stok </a>
    <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app blue" href="<?php echo base_url().'spoil/'.@$position; ?>"><i class="fa fa-edit"></i> Spoil </a>
    <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app red" href="<?php echo base_url().'retur_pembelian/'.$position; ?>"><i class="fa fa-edit"></i> Retur </a>  -->
    <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-app red" href="<?php echo base_url().'mutasi/'.@$position;; ?>"><i class="fa fa-edit"></i> Mutasi</a> 
     <a style="padding:13px; margin-bottom:10px;width: 100px" class="btn btn-warning" href="<?php echo base_url().'opname/'.@$position;; ?>"><i class="fa fa-edit"></i> Opname </a>
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
        <div id="cari_transaksi">
          <form method="post" id="data_form"> 
            <table class="table table-striped table-hover table-bordered" id="tabel_daftar" style="font-size:1.5em;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Spoil</th>
                  <th>Tanggal Spoil</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $get_kode_unit = $this->db->get_where('master_unit',array('nama_unit'=>"$position"));
                $hasil_unit = $get_kode_unit->row();
                //echo $hasil_unit->kode_unit;
                $param = $this->uri->segment(2);
                $spoil = $this->db->get_where('transaksi_spoil',array('kode_unit' => $hasil_unit->kode_unit));
                $list_spoil = $spoil->result();
                $nomor = 1;  

                foreach($list_spoil as $daftar){ 
                  ?> 
                  <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $daftar->kode_spoil; ?></td>
                    <td><?php echo $daftar->tanggal_spoil; ?></td>
                    <td><?php echo $daftar->petugas; ?></td>
                    <td align="center"><?php echo get_detail_spoil($param,$daftar->kode_spoil); ?></td>
                  </tr>
                  <?php 
                  $nomor++; 
                } 
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Spoil</th>
                  <th>Tanggal Spoil</th>
                  <th>Petugas</th>
                  <th>Action</th>
                </tr>
              </tfoot>            
            </table>
            </form>
            </div>
            </div>
          </div>
        </div>
         <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $hasil_unit->kode_unit;?>">
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
        url : "<?php echo base_url().'spoil/cari_spoil_kitchen'; ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },  
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
                              window.location = "<?php echo base_url() . 'stok/serve' ?>";
                            });
 $("#tabel_daftar").dataTable({
        "paging":   false,
        "ordering": false,
        "info":     false
    });
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
    success: function(msg) {
      $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
  return false;
}

</script>