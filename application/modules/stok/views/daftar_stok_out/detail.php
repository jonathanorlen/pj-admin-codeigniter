<?php 
$position = $this->uri->segment(3);
?>
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Stok <?php echo $position ?>

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

        $get_master_barang = $this->db->get_where('master_bahan_baku', array('kode_bahan_baku' => $parameter));
        $hasil_master_barang = $get_master_barang->row();
        $item = $hasil_master_barang;

        $get_master_supplier = $this->db->get('master_supplier');
        $hasil_master_supplier = $get_master_supplier->result();
        ?>

        <div class="box-body">                   
          <div class="sukses" ></div>
          <div class="col-md-12">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="dashboard-stat">
                <div class="visual">
                  <i class="fa fa-barcode"></i>
                </div>
                <div class="details">
                  <div class="number" style="font-size: 1.5em;">
                    Kode
                  </div>
                  <div class="desc" style="font-size: 2em;">
                    <?php if(!empty($parameter)){ echo $item->kode_bahan_baku; } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="dashboard-stat ">
                <div class="visual">
                  <i class="fa fa-cube"></i>
                </div>
                <div class="details">
                  <div class="number" style="font-size: 1.5em;">
                    Nama
                  </div>
                  <div class="desc" style="font-size: 2em;">
                    <?php if(!empty($parameter)){ echo $item->nama_bahan_baku; } ?>
                  </div>
                </div>
              </div>
              <br>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="dashboard-stat">
                <div class="visual">
                  <i class="fa fa-tasks"></i>
                </div>
                <div class="details">
                  <div class="number" style="font-size: 1.5em;">
                    Rak
                  </div>
                  <div class="desc" style="font-size: 2em;">

                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="dashboard-stat ">
                <div class="visual">
                  <i class="fa fa-cubes"></i>
                </div>
                <div class="details">
                  <div class="number" style="font-size: 1.5em;">
                    Real Stock
                  </div>
                  <div class="desc" style="font-size: 2em;">
                  <?php
                                      $kode_bahan=$item->kode_bahan_baku;
                       //echo $kode_bahan;

                                      $query=$this->db->query("SELECT satuan_stok from master_barang where kode_barang = '$kode_bahan'");
                                      $hasil_satuan=$query->row();


                                      ?>
                                     
                    <?php if(!empty($parameter)){ echo $item->real_stock." ".$item->satuan_stok; } ?>
                  </div>
                </div>
              </div>
              <br>
            </div>
          </div>

          <table class="table table-striped table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
            <thead>
              <tr>
                <th>Tanggal Transaksi</th>
                <th>Jenis Transaksi</th>
                <th>kode Transaksi</th>
                <th>Stok Keluar</th>
                <th>Stok Masuk</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $get_master_barang = $this->db->get_where('transaksi_stok', array('kode_bahan' => $item->kode_bahan_baku));
              $hasil_master_barang = $get_master_barang->result();

              $no = 1;
              foreach($hasil_master_barang as $item){
                if($this->session->flashdata('message')==$item->kode_bahan){

                  echo '<tr id="warna" style="background: #88cc99; display: none;">';
                }
                else{
                  echo '<tr>';
                }
                ?>
                <td><?php echo tanggalIndo($item->tanggal_transaksi); ?></td>                  
                <td><?php echo $item->jenis_transaksi; ?></td>                  
                <td><?php echo $item->kode_transaksi; ?></td>
                <?php
                                      $kode_bahan=$item->kode_bahan;
                       //echo $kode_bahan;

                                      $query=$this->db->query("SELECT satuan_stok from master_bahan_baku where kode_bahan_baku = '$kode_bahan'");
                                      $hasil_satuan=$query->row();


                                      ?>
                
                <td><?php if ($item->stok_keluar==''){echo "0". " ".@$hasil_satuan->satuan_stok;}else{
                  echo $item->stok_keluar." ".@$hasil_satuan->satuan_stok;
                  } ?></td>

                <td><?php if ($item->stok_masuk==''){echo "0". " ".@$hasil_satuan->satuan_stok;}else{
                  echo $item->stok_masuk." ".@$hasil_satuan->satuan_stok;
                  } ?></td>
                  
               
              </tr>
              <?php
              $no++;
            } ?>
          </tbody>                
        </table>

        

        <div class="box-footer clearfix"></div>
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
            window.location = "<?php echo base_url().'stok/'.$this->uri->segment(3); ?>";
          });
        </script>
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">

</script>

