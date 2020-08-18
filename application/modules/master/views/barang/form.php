<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Data Barang
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
        $param = $this->uri->segment(4);
        //echo $param;
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_barang',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
          //echo $hasil_bahan_baku->kode_barang;

        }    

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">


                <div class="form-group  col-xs-6">
                  <label><b>Kode Barang</label>
                  <div class="">
                    <input name="kode_barang" value="<?php echo @$hasil_bahan_baku->kode_barang ?>"  <?php if(!empty($param)){ echo "readonly='true'"; } ?> type="text" class="form-control" id="kode_barang" />
                  </div>
                </div>
                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Nama Barang</label>
                  <input value="<?php echo @$hasil_bahan_baku->nama_barang; ?>" type="text" class="form-control" name="nama_barang" />
                </div>
                <div class="form-group  col-xs-6">
                  <?php 
                  $get_master_supplier = $this->db->get('master_supplier');
                  $hasil_master_supplier = $get_master_supplier->result();

                  ?>
                  <label>Supplier</label>
                  <select class="form-control" name="kode_supplier" id="supplier">
                    <?php
                    foreach($hasil_master_supplier as $item_supplier){

                      ?>
                      <option <?php if($item_supplier->kode_supplier == $item_supplier->kode_supplier){ echo "selected"; } ?> value="<?php echo $item_supplier->kode_supplier; ?>"><?php echo $item_supplier->nama_supplier; ?></option>
                        
                      <?php
                      
                    }echo $item_supplier->kode_supplier;
                    ?>
              </select>
                        </div>
                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Unit</label>
                  <?php
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $kode_unit=$hasil_unit->kode_unit;

                  $unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
                  $hasil_unit = $unit->row();
                  ?>
                  <!-- <select class="form-control select2" style="width: 100%;" name="kode_unit" id="kode_unit">
                    <option selected="true" value="">--Pilih Unit--</option>
                    <?php foreach($hasil_unit as $item){ ?>
                    <option <?php if(@$hasil_bahan_baku->kode_unit==$item->kode_unit){ echo "selected"; } ?> value="<?php echo $item->kode_unit ?>"><?php echo $item->nama_unit ?></option>
                    <?php } ?> 
                  </select> -->
                   <input value="<?php echo @$hasil_unit->nama_unit; ?>" type="text" class="form-control" readonly />
                  <input value="<?php echo @$hasil_unit->kode_unit; ?>" type="hidden" class="form-control" name="position" />
                </div>
                <div class="form-group  col-xs-6">
                  <label class="gedhi"><b>Rak</label>
                  <?php
                  
                    $kode_unit = @$hasil_unit->kode_unit;
                    $get_rak = $this->db->get_where('master_rak',array('kode_unit'=>$kode_unit));
                    $hasil_get_rak = $get_rak->result();
                  //echo $hasil_bahan_baku->kode_rak;
                  
                  ?>
                  <select name="kode_rak" id="kode_rak" class="form-control">
                    <option selected="true" value="">--Pilih Rak--</option>
                    <?php 
                      foreach($hasil_get_rak as $daftar){    
                        ?>
                        <option <?php if(@$hasil_bahan_baku->kode_rak==$daftar->kode_rak){ echo "selected"; } ?> value="<?php echo $daftar->kode_rak; ?>"><?php echo $daftar->nama_rak; ?></option>
                        <?php  } ?>
                      </select>
                    </div>
                    <div class="form-group  col-xs-6">
                      <label class="gedhi"><b>Satuan Pembelian</label>
                      <?php
                      $pembelian = $this->db->get('master_satuan');
                      $hasil_pembelian = $pembelian->result();
                      ?>
                      <select class="form-control select2 pembelian" name="id_satuan_pembelian">
                        <option selected="true" value="">--Pilih satuan pembelian--</option>
                        <?php foreach($hasil_pembelian as $daftar){ ?>
                        <option <?php if(@$hasil_bahan_baku->id_satuan_pembelian==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>" ><?php echo $daftar->nama; ?></option>
                        <?php } ?>
                      </select> 
                    </div>
                    <div class="form-group  col-xs-6">
                      <?php
                     
                        
                        $dft_satuan = $this->db->get_where('master_satuan');
                        $hasil_dft_satuan = $dft_satuan->result();
                    
                     
                      ?>
                      <label class="gedhi"><b>Satuan Stok</label>
                     
                      <select class="form-control stok select2" name="id_satuan_stok">
                        <option selected="true" value="">--Pilih satuan stok--</option>
                        <?php 
                          foreach($hasil_dft_satuan as $daftar){ 
                          
                            ?>
                            <option <?php if(@$hasil_bahan_baku->id_satuan_stok==$daftar->kode){ echo "selected"; } ?> value="<?php echo $daftar->kode; ?>"><?php echo $daftar->nama; ?></option>
                            <?php  }  ?>

                          </select> 
                        </div>
                        <div class="form-group  col-xs-6">
                          <label class="gedhi"><b>Isi Dalam 1 (Satuan Pembelian)</label>
                          <input value="<?php echo @$hasil_bahan_baku->jumlah_dalam_satuan_pembelian; ?>" type="text" class="form-control" name="jumlah_dalam_satuan_pembelian" />
                        </div>
                        <div class="form-group  col-xs-6">
                          <label class="gedhi"><b>Stok Minimal</label>
                          <input type="text" class="form-control" name="stok_minimal" value="<?php echo @$hasil_bahan_baku->stok_minimal ?>" />
                        </div>
                        

                      </div>
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
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
            window.location = "<?php echo base_url().'master/barang/'; ?>";
          });
        </script>
        <script type="text/javascript">
        $(document).ready(function(){
  //$(".select2").select2();
 //   $.ajax( {  
 //              type :"post",  
 //              url : "<?php echo base_url('master/barang/get_satuan_stok'); ?>",  
 //              cache :false,  
 //              data :({ id_pembelian:$(this).val()}),
            
 // success : function(data) {
 //                $(".stok").empty();
 //                $(".stok").html(data);   
 //              },  
 //              error : function(data) {  
 //                alert("das");  
 //              }  
 //            });
 //            return false;
});
        $(function(){

          $('#kode_bahan_baku').on('change',function(){
            var kode_input = $('#kode_bahan_baku').val();
            var kode_setting = $('#kode_setting').val();
            var kode_bahan_baku = kode_setting + "_" + kode_input ;
            var url = "<?php echo base_url() . 'master/bahan_baku/get_kode' ?>";
            $.ajax({
              type: 'POST',
              url: url,
              data: {kode_bahan_baku:kode_bahan_baku},
              success: function(msg){
                if(msg == 1){
                  $(".sukses").html('<div class="alert alert-warning">Kode_Telah_dipakai</div>');
                  setTimeout(function(){
                    $('.sukses').html('');
                  },1700);              
                  $('#kode_bahan_baku').val('');

                }
                else{

                }
              }
            });
          });

          $(".pembelian").change(function(){

           
          });

         // $('#kode_unit').on('change',function(){
         //    var kode_unit = $('#kode_unit').val();
         //    var url = "<?php echo base_url() . 'master/bahan_baku/get_rak'; ?>";
         //    $.ajax({
         //      type: 'POST',
         //      url: url,
         //      data: {kode_unit:kode_unit},
         //      success: function(msg){
         //        //$('#kode_rak').html(msg);
         //        //$('#kode_rak').select2().trigger('change');
         //      }
         //    });
         // // });

          $("#data_form").submit( function() {
       /* var vv = $(this).serialize();
       alert(vv);*/
       <?php if(!empty($param)){ ?>
        var url = "<?php echo base_url(). 'master/barang/simpan_ubah'; ?>";  
        <?php }else{ ?>
          var url = "<?php echo base_url(). 'master/barang/simpan_tambah'; ?>";
          <?php } ?>
          $.ajax( {
           type:"POST", 
           url : url,  
           cache :false,  
           data :$(this).serialize(),
           beforeSend: function(){
             $(".loading").show(); 
           },
           beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
        //if(data=="sukses"){
         $(".sukses").html('<div class="alert alert-success">Data Berhasil Disimpan</div>');
         setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'master/barang/daftar' ?>";},1000);  
        // }
        // else{
        //     $(".sukses").html(data);
        // }
        $(".loading").hide();   

      },  
      error : function(data) {  
        alert(data);  
      }  
    });
          return false;                    
        }); 
})
</script>