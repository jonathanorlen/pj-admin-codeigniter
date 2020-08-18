

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
          Daftar Jabatan
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
          <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                              $jabatan = $this->db->get_where('master_jabatan',array('kode_jabatan !='=>003));
                              $hasil_jabatan = $jabatan->result();
                            ?>
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Jabatan</th>
                                <th>Nama Jabatan</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_jabatan as $daftar){ ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->kode_jabatan; ?></td>
                                      <td><?php echo $daftar->nama_jabatan; ?></td>
                                      <td><?php echo $daftar->keterangan; ?></td>
                                      <td align="center"><?php echo get_detail_edit_delete($daftar->kode_jabatan); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                            </tbody>
                              <tfoot>
                                <tr>
                                  <th>No</th>
                                  <th>Kode Jabatan</th>
                                  <th>Nama Jabatan</th>
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
                    
                    
                    <div class="box-body">            
                        
                        

            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
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
            window.location = "<?php echo base_url().'master/daftar/'; ?>";
          });
        </script>
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data jabatan tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn red"  data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()"  class="btn green">Ya</button>
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
    var url = '<?php echo base_url().'master/jabatan/hapus'; ?>';
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
            window.location.reload();
        }
    });
    return false;
}

$(document).ready(function(){
  $("#tabel_daftar").dataTable();
})
   
</script>