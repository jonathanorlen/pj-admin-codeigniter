<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Kategori Produk
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
//mengambil dari address bar segmen ke 4 dari base_url
$param = $this->uri->segment(4);
//jika terdapat segmen maka tampilkan view_user berdasar id sesuai value segmen
if (!empty($param)) {
 $get = $this->db->get_where('master_kategori_menu' , array('kode_kategori_menu' => $param));
 $hasil = $get->row();
}
?>

        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
                        <div class="box-body">            
                          <div class="row">
                       
                            <div class="form-group  col-xs-5">
                              <label>Kode Kategori Produk</label>
                              <input type="hidden" id="id" name="id" value="<?php echo @$hasil->id;?>">
                              <input <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" name="kode_kategori_menu" id="kode_kategori_menu" value="<?php echo @$hasil->kode_kategori_menu;?>" />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Nama Kategori Produk</label>
                              <input type="text" class="form-control" name="nama_kategori_menu" id="nama_kategori_menu" value="<?php echo @$hasil->nama_kategori_menu;?>" />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Keterangan</label>
                              <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo @$hasil->keterangan;?>" />
                            </div>

                          </div>
                          <div class="box-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                          
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!------------------------------------------------------------------------------------------------------>
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
            window.location = "<?php echo base_url().'master/bahan_baku/'; ?>";
          });
        </script>



<script type="text/javascript">
$(document).ready(function(){
  $(".tgl").datepicker();
  $(".select2").select2();
});
</script>

<script type="text/javascript">
  $(function () {
    //jika tombol Send diklik maka kirimkan data_form ke url berikut
    $("#data_form").submit( function() { 

      $.ajax( {  
        type :"post", 
        <?php 
          if (empty($param)) {
        ?>
        //jika tidak terdapat segmen maka simpan di url berikut
          url : "<?php echo base_url() . 'master/kategori_produk/simpan_tambah_kategori_menu'; ?>",
        <?php }
          else { ?>
        //jika terdapat segmen maka simpan di url berikut
          url : "<?php echo base_url() . 'master/kategori_produk/simpan_edit_kategori_menu'; ?>",
        <?php }
        ?>  
        cache :false,  
        data :$(this).serialize(),
         beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $(".sukses").html(data);   
          setTimeout(function(){$('.sukses').html('');
            window.location = "<?php echo base_url() . 'master/kategori_produk/daftar_kategori_produk' ?>";},2000);              
        },  
        error : function() {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;                          
    });   

  });
</script>
