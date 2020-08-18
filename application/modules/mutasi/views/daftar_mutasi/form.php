<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Edit Stok Barang

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
        $parameter = $this->uri->segment(4);

        $get_master_barang = $this->db->get_where('master_barang', array('kode_barang' => $parameter));
        $hasil_master_barang = $get_master_barang->row();
        $item = $hasil_master_barang;

        $get_master_supplier = $this->db->get('master_supplier');
        $hasil_master_supplier = $get_master_supplier->result();
        ?>

        <div class="box-body">                   
          <div class="sukses" ></div>
          <form method="post" id="data_form" name="data_form">
            <div class="col-md-12">
              <div class="col-md-6">
                <label >Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control" placeholder="Kode Barang" value="<?php if(!empty($parameter)){ echo $item->kode_barang; } ?>" required />
              </div>

              <div class="col-md-6">
                <label >Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->nama_barang; } ?>" required />
              </div>
            </div>

            <div class="col-md-12">
             <div class="col-md-6">
              <label>Supplier</label>
              <select class="form-control" name="supplier" id="supplier">
                <?php
                foreach($hasil_master_supplier as $item_supplier){
                  ?>
                  <option <?php if($item_supplier->kode_supplier == @$item->kode_supplier){ echo "selected"; } ?> value="<?php echo $item_supplier->kode_supplier; ?>"><?php echo $item_supplier->nama_supplier; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <label>Stok</label>
              <input type="text" name="stok" class="form-control" value="<?php if(!empty($parameter)){ echo $item->stok; } ?>" required />
            </div>
            <div class="col-md-3">
              <label>Position</label>
              <input readonly="" type="text" name="position" class="form-control" value="Server" required />
            </div>
          </div>

          <div class="col-md-12">
            <div class="col-md-6" style="width: 100%;">
              <button style="margin-top:30px" type="submit" class="pull-right btn btn-warning" id="data_form"><?php if(empty($parameter)){echo 'Save';}else{echo 'Update';} ?><i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
          <div class="box-footer clearfix"></div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">
  $(document).ready(function(){  

    $("#data_form").submit( function() {    
      $.ajax( {  
        type :"post",  
        <?php
        if(empty($parameter)){
          ?>
          url : "<?php echo base_url() . 'stok_barang/simpan_tambah' ?>",  
          <?php
        }else{
          ?>
          url : "<?php echo base_url() . 'stok_barang/simpan_ubah' ?>",  
          <?php
        }
        ?>
        cache :false,  
        data :$(this).serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $(".sukses").html(data);   
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'stok_barang/daftar' ?>";},1500);              
        }  

      });
      return false;                          
    });

  });
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>

