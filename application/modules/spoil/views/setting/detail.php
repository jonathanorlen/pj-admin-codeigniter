<div class="row">      
  <div class="col-xs-12">
   <!-- /.box -->
   <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
       Detail Spoil
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
            <label><h3><b>Detail Spoil</b></h3></label>
            <div class="row">
              <?php
              $param = $this->uri->segment(3);
              $kode_spoil = $this->uri->segment(3);
              $spoil = $this->db->get_where('transaksi_spoil',array('kode_spoil' => $kode_spoil));
              $list_spoil = $spoil->result();

              foreach($list_spoil as $daftar){ 
                ?>

                <div class="col-md-6">
                  <div class="box-body">
                    <div class="btn btn-app blue">
                      <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;"><?php echo @$daftar->kode_spoil; ?></span>
                      <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_spoil; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_spoil" id="kode_spoil" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="box-body">
                    <div class="btn btn-app blue">
                      <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;" id="tanggal_spoil"><?php echo tanggalIndo(@$daftar->tanggal_spoil); ?></span>
                    </div>
                  </div>
                </div>

                <?php 
              } 
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
                    <th>Jenis Bahan</th>
                    <th>Kode Bahan</th>
                    <th>Nama Bahan</th>
                    <th>QTY</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $param = $this->uri->segment(3);
                  $kode_spoil = $this->uri->segment(3);
                  $spoil = $this->db->get_where('opsi_transaksi_spoil',array('kode_spoil' => $kode_spoil));
                  $list_spoil = $spoil->result();
                  $nomor = 1;  

                  foreach($list_spoil as $daftar){ 
                    ?> 
                    <tr style="font-size: 15px;">
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $daftar->jenis_bahan; ?></td>
                      <td><?php echo $daftar->kode_bahan; ?></td>
                      <td><?php echo $daftar->nama_bahan; ?></td>
                     <?php
                                      $kode_bahan=$daftar->kode_bahan;
                       //echo $kode_bahan;

                                      $query=$this->db->query("SELECT satuan_stok from master_bahan_baku where kode_bahan_baku = '$kode_bahan'");
                                      $hasil_satuan=$query->row();


                                      ?>
                                      <td><?php echo $daftar->jumlah." ".@$hasil_satuan->satuan_stok; ?></td>
                      <td><?php echo $daftar->keterangan; ?></td>
                    </tr>
                    <?php 
                    $nomor++; 
                  } 
                  ?>
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
            window.location = "<?php echo base_url().'spoil/'.$this->uri->segment(4); ?>";
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
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
})


</script>