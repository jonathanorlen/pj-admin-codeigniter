<?php
//mengambil dari address bar segmen ke 4 dari base_url
$param = $this->uri->segment(4);
//jika terdapat segmen maka tampilkan view_user berdasar id sesuai value segmen
if (!empty($param)) {
 $get = $this->db->get_where('master_kategori_menu' , array('kode_kategori_menu' => $param));
 $hasil = $get->row();
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
      
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
          Detail Kategori Menu
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
          
                    <form id="data_form" action="" method="post">
                        <div class="box-body">            
                          <div class="row">
                       
                            <div class="form-group  col-xs-5">
                              <label>Kode Kategori Menu</label>
                              <input type="hidden" id="id" name="id" value="<?php echo @$hasil->id;?>">
                              <input type="text" class="form-control" name="kode_kategori_menu" id="kode_kategori_menu" value="<?php echo @$hasil->kode_kategori_menu;?>" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Kategori Menu</label>
                              <input type="text" class="form-control" name="nama_kategori_menu" id="nama_kategori_menu" value="<?php echo @$hasil->nama_kategori_menu;?>" readonly/>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Keterangan</label>
                              <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo @$hasil->keterangan;?>" readonly/>
                            </div>

                          </div>
                          
                        </div>
                    </form>
                      
          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    
                        <div class="sukses" ></div>
                        <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                          <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
                        </div>

                    
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
    window.location = "<?php echo base_url().'master/kategori_produk/daftar_kategori_produk'; ?>";
  });
  </script>
<script type="text/javascript">
$(document).ready(function(){
  $(".tgl").datepicker();
  $(".select2").select2();
});
</script>