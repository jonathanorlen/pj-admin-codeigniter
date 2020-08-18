

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
          Daftar Kategori Produk
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
          <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Kategori Produk</th>
                                <th>Nama Kategori Produk</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                  //ambil data dari db lalu tampilkan dibawah foreach 
                                  $get_kategori_menu = $this->db->get('master_kategori_menu');
                                  $hasil_kategori_menu = $get_kategori_menu->result_array();
                                  $i = 0;
                                  foreach ($hasil_kategori_menu as $item) {
                                  $i++;
                                ?>   
                                <tr>
                                  <td><?php echo $i;?></td>
                                  <td><?php echo $item['kode_kategori_menu'];?></td>
                                  <td><?php echo $item['nama_kategori_menu'];?></td>
                                  <td><?php echo $item['keterangan'];?></td>
                                  <td><?php echo get_detail_edit_delete_string($item['kode_kategori_menu']); ?></td>
                                </tr>

                                <?php } ?>
                               
                            </tbody>
                              <tfoot>
                                <tr>
                                <th>No</th>
                                <th>Kode Kategori Produk</th>
                                <th>Nama Kategori Produk</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                              </tr>
                             </tfoot>
                        </table>

          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                    <!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data kategori menu tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn red"  data-dismiss="modal" aria-hidden="true">Tidak</button>
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
            window.location = "<?php echo base_url().'master/produk/'; ?>";
          });
        </script>

<script>
function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
}

function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/kategori_produk/hapus'; ?>/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            kode_kategori_menu: id
        },
        success: function(msg) {
            $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
        }
    });
    return false;
}
$(document).ready(function(){
  $("#tabel_daftar").dataTable();
})
   
</script>