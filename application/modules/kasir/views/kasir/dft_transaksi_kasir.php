
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      <div class="page-bar">
                          <ul class="page-breadcrumb">
                            <li>
                              <i class="fa fa-home"></i>
                              <a href="#">Transaksi Kasir</a>
                              <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                              <a href="#">Daftar Transaksi Kasir</a>
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
          Daftar Transaksi Kasir
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
                        <form id="pencarian_form" method="post" style="margin-left: 18px;" class="form-horizontal" target="_blank">

                          <div class="row">
                            <div class="col-md-4" id="trx_penjualan">
                              <div class="input-group">
                                <span class="input-group-addon">Tanggal Awal</span>
                                <input type="date" class="form-control tgl" id="tgl_awal" />
                              </div>
                            </div>
                            <div class="col-md-4" id="trx_penjualan">
                              <div class="input-group">
                                <span class="input-group-addon">Tanggal Akhir</span>
                                <input type="date" class="form-control tgl" id="tgl_akhir" />
                              </div>
                            </div>
                            
                            <div class=" col-md-4">
                              <div class="input-group">
                                <button type="button" class="btn btn-success" onclick="cari_transaksi()"><i class="fa fa-search"></i> Cari</button>
                               
                              </div>
                            </div>
                          </div>

                          <br>

                          
                        </form>
                        <?php
                            $this->db->order_by('tanggal','desc');
                            $kasir = $this->db->get('transaksi_kasir');
                            $hasil_kasir = $kasir->result();
                        ?>
                        <div id="cari_kasir">
                                <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Petugas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Nominal Penjualan</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor=1;
                        foreach($hasil_kasir as $daftar){
                        ?>
                        <tr class="<?php if($daftar->status=="open"){ echo "danger"; }elseif ($daftar->status=="close" && $daftar->validasi=="") {
                          echo "warning";
                        } ?>">
                          <td><?php echo $nomor; ?></td>
                          <td><?php echo $daftar->kode_transaksi; ?></td>
                          <td><?php echo TanggalIndo($daftar->tanggal) ?></td>
                          <td><?php echo $daftar->check_in ?></td>
                          <td><?php echo $daftar->check_out ?></td>
                          <td><?php echo $daftar->petugas ?></td>
                          <td><?php echo format_rupiah($daftar->saldo_awal) ?></td>
                          <td><?php echo format_rupiah($daftar->saldo_akhir) ?></td>
                          <td><?php echo format_rupiah($daftar->nominal_penjualan) ?></td>
                          <td><?php echo $daftar->status ?></td>
                          <td align="center"><?php echo get_detail($daftar->kode_transaksi); ?></td>
                          
                        </tr>
                       <?php $nomor++; } ?>
                    </tbody>
                      <tfoot>
                        <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Petugas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Nominal Penjualan</th>
                        <th>Status</th>
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
  $("#tabel_daftar").dataTable();

  //$(".tgl").datepicker();
})
   
</script>