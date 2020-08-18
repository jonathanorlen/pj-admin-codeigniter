<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Setting Harga Kategori
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
          <form id="data_form">
                        <div class="box-body">            
                          <div class="row">
                       
                            <div class="form-group  col-xs-5">
                              <label> Kategori Produk</label>
                              <select class="form-control" name="kode_kategori_produk">
                                <option value="" selected="true">-Pilih Kategori-</option>
                                <?php
                                    $kategori = $this->db->get('master_kategori_menu');
                                    $hasil_kategori = $kategori->result();
                                    foreach($hasil_kategori as $daftar){
                                ?>
                                <option value="<?php echo $daftar->kode_kategori_menu; ?>"><?php echo $daftar->nama_kategori_menu; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Harga 1</label>
                              <input type="text" class="form-control" name="harga_jual_1" id="nama_kategori_menu" value="<?php echo @$hasil->nama_kategori_menu;?>" />
                            </div>

                            <div class="form-group  col-xs-5">
                              <label class="gedhi">Harga 2</label>
                              <input type="text" class="form-control" name="harga_jual_2" id="keterangan" value="<?php echo @$hasil->keterangan;?>" />
                            </div>

                          </div>
                          <div class="box-footer">
                              <a id="simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</a>
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
            window.location = "<?php echo base_url().'master/produk/'; ?>";
          });
        </script>



<script type="text/javascript">
$(document).ready(function(){
 $("#simpan").click(function() { 

      $.ajax( {  
        type :"post", 
        url : "<?php echo base_url() . 'master/setting_harga/simpan_harga'; ?>",
        cache :false,  
        data :$("#data_form").serialize(),
         beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {   
          $(".tunggu").hide();  
         window.location = "<?php echo base_url().'master/setting_harga/'; ?>";             
        },  
        error : function(data) {  
          alert("Data gagal dimasukkan.");  
        }  
      });
      return false;                          
    });   

  });

</script>

<script type="text/javascript">
 
    
</script>
