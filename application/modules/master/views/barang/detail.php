<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Barang

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

        $get_master_barang = $this->db->get_where('master_barang', array('id' => $parameter));
        $hasil_master_barang = $get_master_barang->row();
        $item = $hasil_master_barang;

        $get_posisi = $this->db->get_where('master_unit', array('kode_unit' => $item->position));
        $hasil_posisi = $get_posisi->row();

        $get_master_supplier = $this->db->get('master_supplier');
        $hasil_master_supplier = $get_master_supplier->result();
        ?>

        <div class="box-body">                   
          <div class="sukses" ></div>
          <form method="post" id="data_form" name="data_form">
            <div class="col-md-12">
              <div class="col-md-6">
                <label >Kode Barang</label>
                <input readonly="" type="text" name="kode_barang" class="form-control" placeholder="Kode Barang" value="<?php if(!empty($parameter)){ echo $item->kode_barang; } ?>" required />
              </div>

              <div class="col-md-6">
                <label >Nama Barang</label>
                <input readonly="" type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->nama_barang; } ?>" required />
              </div>
            </div>

            <div class="col-md-12">
             <div class="col-md-6">
              <label>Supplier</label>
              <select disabled="" class="form-control" name="supplier" id="supplier">
                <?php
                foreach($hasil_master_supplier as $item_supplier){
                  ?>
                  <option <?php if($item_supplier->kode_supplier == @$item->kode_supplier){ echo "selected"; } ?> value="<?php echo $item_supplier->kode_supplier; ?>"><?php echo $item_supplier->nama_supplier; ?></option>
                  <?php
                }
                ?>
              </select>

               <label>Rak</label>
            
                <input readonly="" type="text" name="rak" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->nama_rak; } ?>" required />
                  <label>Satuan Stok</label>
            
                <input readonly="" type="text" name="rak" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->satuan_stok; } ?>" required />

                <label>Stok Minimal</label>
                <input readonly="" type="text" name="rak" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->stok_minimal; } ?>" required />
            </div>

            <div class="col-md-6">
              <label>Position</label>
              <input readonly="" type="text" name="position" class="form-control" value="<?php echo $hasil_posisi->nama_unit;?>" required />

               <label>Satuan Pembelian</label>
            
                <input readonly="" type="text" name="rak" class="form-control" placeholder="Nama Barang" value="<?php if(!empty($parameter)){ echo $item->satuan_pembelian; } ?>" required />

                <label>Isi Dalam 1 (Satuan Pembelian)</label>
                  <input readonly="" type="text" name="rak" class="form-control" value="<?php if(!empty($parameter)){ echo $item->jumlah_dalam_satuan_pembelian; } ?>" required />
            </div>
          </div>

          <div class="col-md-12">
            <div class="col-md-6" style="width: 100%;">
              <a href="<?php echo base_url(). 'master/barang/daftar' ?>" style="margin-top:30px" type="submit" class="pull-right btn btn-warning" id="data_form">OK <i class="fa fa-arrow-circle-right"></i></a>
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
  
</script>

