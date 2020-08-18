<div class="row">      
  <div class="col-xs-12">
   <!-- /.box -->
   <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
      Detail Stock Out
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
      <form id="data_form" action="" method="post">
        <div class="box-body">

          <div class="row">
            <?php
             // $param = $this->uri->segment(3);
            $kode_stok_out = $this->uri->segment(3);
            $get = $this->db->get_where('opsi_transaksi_stok_out',array('kode_stok_out' => $kode_stok_out));
            $list_get = $get->row();

           
              ?>
              <div class="col-md-6">
                <div class="" style="background-color: #dfba49 ;width:auto;">
                  <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn">Kode Stock Out :<span style="font-size:20px;"><?php echo @$list_get->kode_stok_out; ?></span></a>
                  <input readonly="true" type="hidden" value="<?php echo @$list_get->kode_stok_out; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_aktifitas" id="kode_aktifitas" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="" style="background-color: #dfba49 ;width:auto;">
                  <a style="padding:13px; margin-bottom:10px;color:white;margin-left:0px;" class="btn">Tanggal :<span style="font-size:20px;"><?php echo tanggalIndo(@$list_get->tanggal_update); ?></span></a>
                </div>
              </div>
              <?php 
            
            ?>

          </div>
        </div> 
        <br><br>
        <div id="list_transaksi_pembelian">
          <div class="box-body">
            <table id="tabel_daftar" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>      
                  <th>Nama Bahan</th>
                  <th>Stok Awal</th>
                  <th>Stok Keluar</th>
                  <th>Stok Akhir</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $get_opsi_stok_out=$this->db->get_where('opsi_transaksi_stok_out',array('kode_stok_out'=>$kode_stok_out));
                $hasil=$get_opsi_stok_out->result();
                $no=1;
                foreach ($hasil as $list) { ?>

                <tr>
                  <td><?php echo $no++; ?></td>      
                  <td><?php echo $list->nama_bahan ?></td>
                  <td><?php echo $list->stok_awal ?></td>
                  <td><?php echo $list->jumlah ?></td>
                  <?php 
                    $stok_akhir=$list->stok_awal - $list->jumlah;
                  ?>
                  <td><?php echo $stok_akhir ?></td>
                  <td><?php echo $list->keterangan ?></td>
                </tr>
                <?php  } ?>
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>
        </div>
      </form>

    </div>



    <!------------------------------------------------------------------------------------------------------>

  </div><!-- /.col -->
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data spoil tersebut ?</span>
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
    window.location = "<?php echo base_url().'stok/daftar_stok_out'; ?>";
  });
  </script>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
})


</script>