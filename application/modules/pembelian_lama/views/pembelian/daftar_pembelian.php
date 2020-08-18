

<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Pembelian
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
      <div class="double bg-blue pull-right" style="cursor:default">
        <div class="tile-object">
          <div  style="padding-right:10px; padding-left:10px;  padding-top:10px; font-size:17px; font-family:arial; font-weight:bold">
            Total Transaksi Pembelian
          </div>
        </div>

        
        <div  style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">
          <?php
          $this->db->select('*');
          $this->db->where('position','gudang');
          $total = $this->db->get('transaksi_pembelian');
          $hasil_total = $total->num_rows();

          ?>
          <i class="total_transaksi"><?php echo $hasil_total; ?></i>
        </div>
      </div>
<br><br><br><br><br>
<br><br><br>
      <div class="box-body">            

        <div class="sukses" ></div>
        <br>
        <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
         <?php
         $this->db->where('position','gudang');
         $pembelian = $this->db->get('transaksi_pembelian');
         $hasil_pembelian = $pembelian->result();
         ?>
         <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $nomor = 1;

          foreach($hasil_pembelian as $daftar){ ?> 
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo TanggalIndo(@$daftar->tanggal_pembelian);?></td>
            <td><?php echo @$daftar->kode_pembelian; ?></td>
            <td><?php echo @$daftar->nomor_nota; ?></td>
            <td><?php echo @$daftar->nama_supplier; ?></td>
            <td><?php echo format_rupiah(@$daftar->grand_total); ?></td>
            <td><?php echo get_detail($daftar->kode_pembelian); ?></td>
          </tr>
          <?php $nomor++; } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Kode Pembelian</th>
            <th>Nota Ref</th>
            <th>Supplier</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
      <?php 
      $user = $this->session->userdata('astrosession');
      $modul = $user->modul;
      $modul_pecah = explode("|",$modul);
      if(in_array('Setting',$modul_pecah)){ 
        ?>
        <div onclick="setting()" class="btn green " style="position: fixed; bottom: 29px; right: 0px; " ><i class="fa fa-gears ngeling"></i></div>
        <?php } ?>


      </div>

      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
</div><!-- /.col -->
</div>
</div>    
</div>  


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
    $("#tabel_daftar").dataTable({
        "paging":   false,
        "ordering": false,
        "info":     false
    });

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