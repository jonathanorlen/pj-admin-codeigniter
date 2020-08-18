<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Tambah Opname

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
        $kode_unit = $this->uri->segment(3);
        $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
        $hasil_unit = $get_unit->result_array();

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              
              <div class="row">
                <?php
                $param = $this->uri->segment(3);
                $kode_opname = $this->uri->segment(4);
                $opname = $this->db->get_where('transaksi_opname',array('kode_opname' => $kode_opname));
                $list_opname = $opname->result();

                foreach($list_opname as $daftar){ 
                  ?>

                  <div class="col-md-6">
                    <div class="box-body">
                      <div class="btn btn-app blue">
                        <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;"><?php echo @$daftar->kode_opname; ?></span>
                        <input readonly="true" type="hidden" value="<?php echo @$daftar->kode_opname; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_opname" id="kode_opname" />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 pull-right" >
                    <div class="box-body" >
                      <div class="btn btn-app blue " style="width: 100%">
                        <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Opname &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                        <span style="text-align:right;" id="tanggal_opname"><?php echo tanggalIndo(@$daftar->tanggal_opname); ?></span>
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
                      <th>Nama Bahan</th>
                      <th>Qty Stok</th>
                      <th>Qty Fisik</th>
                      <th>Selisih</th>
                      <th>Status</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $param = $this->uri->segment(3);
                    $kode_opname = $this->uri->segment(4);
                    $opname = $this->db->get_where('opsi_transaksi_opname',array('kode_opname' => $kode_opname));
                    $list_opname = $opname->result();
                    $nomor = 1;  

                    foreach($list_opname as $daftar){ 
                      ?> 
                      <tr style="font-size: 15px">
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $daftar->jenis_bahan; ?></td>
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <?php
                        $kode_bahan=$daftar->kode_bahan;
                       // echo $kode_bahan;
                      
                        $query=$this->db->query("SELECT satuan_stok from master_bahan_baku where kode_bahan_baku = '$kode_bahan'");
                        $hasil_satuan=$query->row();
                       
                       
                     ?>
                        <td><?php echo $daftar->stok_awal." ".$hasil_satuan->satuan_stok; ?></td>
                        <td><?php echo $daftar->stok_akhir." ".$hasil_satuan->satuan_stok; ?></td>
                        <td><?php echo $daftar->selisih." ".$hasil_satuan->satuan_stok; ?></td>
                        <td><?php echo $daftar->status; ?></td>
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
            <button type="submit" class="btn btn-danger pull-right" id="jangan_sesuaikan"><i class="fa fa-remove"></i>  Jangan Sesuaikan</button>
            <button type="submit" class="btn btn-success pull-right" id="sesuaikan"><i class="fa fa-check"></i>  Sesuaikan</button>
            <div class="box-footer clearfix">

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data opname tersebut ?</span>
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
            window.location = "<?php echo base_url().'opname/kitchen'; ?>";
          });
        </script>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $('#jangan_sesuaikan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'opname/jangan_sesuaikan_kitchen'?>";
    var form_data = {
      kode_opname: kode_opname
    };
    $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'opname/kitchen/'.$kode_unit; ?>";
        },1500); 
      }
    });
    return false;
  });

  $('#sesuaikan').on('click',function(){
    var kode_opname = $('#kode_opname').val();
    var url = "<?php echo base_url().'opname/sesuaikan_kitchen'?>";
    var form_data = {
      kode_opname: kode_opname
    };
    $.ajax({
      type: "POST",
      url: url,
      data: form_data,
      success: function(msg)
      {
        $(".sukses").html(msg);   
        setTimeout(function(){$('.sukses').html('');
          window.location = "<?php echo base_url() . 'opname/kitchen/'.$kode_unit; ?>";
        },1500);
      }
    });
    return false;
  });
}) 
</script>