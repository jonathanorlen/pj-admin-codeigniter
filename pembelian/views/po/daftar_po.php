

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Pembelian </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
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
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/pembelian/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/pembelian/daftar_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/retur/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Retur Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/retur/daftar_retur_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Retur Pembelian
            </a>

            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/po/tambah'; ?>">
              <i class="fa fa-plus"></i> Formulir PO
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/po/daftar_po'; ?>">
              <i class="fa fa-list"></i> Daftar PO
            </a>

            <div class="double bg-blue pull-right" style="cursor:default">
                <div class="tile-object">
                    <div  style="padding-right:10px; padding-left:10px;  padding-top:10px; font-size:17px; font-family:arial; font-weight:bold">
                        Total Transaksi PO
                    </div>
                </div>
                <div class="pull-right" style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">
                  <?php
                      $this->db->select('*');
                      $total = $this->db->get('transaksi_po');
                      $hasil_total = $total->num_rows();
                      
                  ?>
                    <i class="total_transaksi"><?php echo $hasil_total; ?></i>
                </div>
            </div>

              <br><br><br>
                <div class="box box-info">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools"></div><!-- /. tools -->
                    </div>
                    <?php 
                                $user = $this->session->userdata('astrosession');
                                $modul = $user->modul;
                                $modul_pecah = explode("|",$modul);
                                  if(in_array('Setting',$modul_pecah)){ 
                              ?>
                              <div onclick="setting()" class="btn green " style="position: fixed; bottom: 29px; right: 0px; " ><i class="fa fa-gears ngeling"></i></div>
                              <?php } ?>
                              
                    <div class="box-body">            
                        <div class="sukses" ></div>
                        <table id="tabel_daftar" class="table table-bordered table-striped">
                            <?php
                              $po = $this->db->get('transaksi_po');
                              $hasil_po = $po->result();
                            ?>
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Petugas</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_po as $daftar){ ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo @$daftar->kode_po; ?></td>
                                      <td><?php echo TanggalIndo(@$daftar->tanggal_input);?></td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <td align="center"><?php echo  get_detail_print($daftar->kode_po); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                             <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Kode Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Petugas</th>
                                <th>Action</th>
                              </tr>
                             </tfoot>
                        </table>

            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="modal_setting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content" >
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                <label><b><i class="fa fa-gears"></i>Setting</b></label>
            </div>

            <form id="form_setting" >
            <div class="modal-body">
              <?php
              $setting = $this->db->get('setting_pembelian');
              $hasil_setting = $setting->row();
            ?>
            
              <div class="box-body">
                
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Note</label>
                      <input type="text" name="keterangan"  class="form-control" />
                    </div>
                    
                  </div>
                </div>

              </div>

            <div class="modal-footer" style="background-color:#eee">
                <button class="btn red" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function setting() {
    $('#modal_setting').modal('show');
}

$(document).ready(function(){
  $("#tabel_daftar").dataTable();

  $("#form_setting").submit(function(){
        var keterangan = "<?php echo base_url().'pembelian/keterangan'?>";
        $.ajax({
                  type: "POST",
                  url: keterangan,
                  data: $('#form_setting').serialize(),
                  success: function(msg)
                  {
                    $('#modal_setting').modal('hide');  
                  }
        });
        return false;
    });
})
   
</script>