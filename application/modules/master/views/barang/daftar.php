
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Barang
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
          <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th width="50px;">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Nama Supplier</th>

                <th width="220px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $param=$hasil_unit->kode_unit;


              $get_master_barang = $this->db->get_where('master_barang', array('position' => $param));
              $hasil_master_barang = $get_master_barang->result();

              $no = 1;
              foreach($hasil_master_barang as $item){
                if($this->session->flashdata('message')==$item->kode_barang){

                  echo '<tr id="warna" style="background: #88cc99; display: none;">';
                }
                else{
                  echo '<tr>';
                }
                ?>
                <td><?php echo $no;?></td>
                <td><?php echo $item->kode_barang; ?></td>                  
                <td><?php echo $item->nama_barang; ?></td>                  
                <td><?php echo $item->nama_supplier; ?></td>
                <td align="center"><?php echo get_detail_edit_delete_string($item->id); ?></td>
              </tr>
              <?php
              $no++;
            } ?>
          </tbody>                
        </table>


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
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data bahan baku tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
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
  window.location = "<?php echo base_url().'master/daftar'; ?>";
});
</script>


<script>
$(document).ready(function() {

  setTimeout(function(){
    $("#warna").fadeIn('slow');
  }, 1000);
  $("a#hapus").click( function() {    
    var r =confirm("Anda yakin ingin menghapus data ini ?");
    if (r==true)  
    {
      $.ajax( {  
        type :"post",  
        url :"<?php echo base_url() . 'master/barang/hapus' ?>",  
        cache :false,  
        data :({key:$(this).attr('key')}),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
          $(".sukses").html(data);   
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/barang/daftar' ?>";},1500);              
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;
    }
    else {}        
  });

  
  $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": true,
    "info":     false
  });
} );
setTimeout(function(){
  $("#warna").css("background-color", "white");
  $("#warna").css("transition", "all 3000ms linear");
}, 3000);
function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}
function delData() {
  var key = $('#id-delete').val();
  var url = '<?php echo base_url().'master/barang/hapus'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      key: key
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

</script>

