
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Retur Pembelian
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
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'pembelian/retur/tambah' ?>"><i class="fa fa-edit"></i> Tambah </a>
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>"><i class="fa fa-list"></i> Daftar </a> 

       <?php
          $this->db->select('*');
          $total = $this->db->get('transaksi_retur');
          $hasil_total = $total->num_rows();

        ?>

       <a style="padding:13px; margin-bottom:10px;width: 190px" class="btn btn-warning pull-right" href="<?php echo base_url() . 'pembelian/daftar_pembelian' ?>"><i class="fa fa-list"></i> Total Transaksi Retur <?php echo $hasil_total; ?></a> 
    
      <br><br>
      <div class="box-body">            

        <div class="sukses" ></div>
        <div class="row">
          <div class="col-md-5" id="">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Awal</span>
              <input type="text" class="form-control tgl" id="tgl_awal">
            </div>
          </div>
          
          <div class="col-md-5" id="">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Akhir</span>
              <input type="text" class="form-control tgl" id="tgl_akhir">
            </div>
          </div>                        
          <div class="col-md-2 pull-left">
            <button style="width: 190px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
          </div>
        </div>
        <br>
        <div id="cari_transaksi">
        <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
          <?php
          $retur = $this->db->get('transaksi_retur');
          $hasil_retur = $retur->result();
          ?>
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal Retur</th>
              <th>Kode Retur</th>
              <th>Nota Ref</th>
              <th>Supplier</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $nomor = 1;

            foreach($hasil_retur as $daftar){ 
              ?> 
              <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo @$daftar->tanggal_retur_keluar; ?></td>
                <td><?php echo @$daftar->kode_retur; ?></td>
                <td><?php echo @$daftar->nomor_nota; ?></td>
                <td><?php echo @$daftar->nama_supplier; ?></td>
                <td><?php echo format_rupiah(@$daftar->grand_total); ?></td>
                <td><?php echo cek_status_retur($daftar->status_retur); ?></td>
                <td align="center"><?php echo get_detail($daftar->kode_retur); ?></td>
              </tr>
              <?php $nomor++; } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Tanggal Retur</th>
                <th>Kode Retur</th>
                <th>Nota Ref</th>
                <th>Supplier</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
          </div>
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
  <div id="modal_setting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
      <div class="modal-content" >
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
          <label><b><i class="fa fa-gears"></i>Setting</b></label>
        </div>

        <form id="form_setting" action="<?php echo base_url().'pembelian/keterangan/' ?>">
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
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

       $('.tgl').Zebra_DatePicker({});


  $('#cari').click(function(){
      var tgl_awal =$("#tgl_awal").val();
      var tgl_akhir =$("#tgl_akhir").val();
      var kode_unit =$("#kode_unit").val();
      if (tgl_awal=='' || tgl_akhir==''){ 
        alert('Masukan Tanggal Awal & Tanggal Akhir..!')
      }
      else{
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'pembelian/retur/cari_reture'; ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },  
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
           $(".tunggu").hide();  
             $("#cari_transaksi").html(data);
        },  
        error : function(data) {  
         // alert("das");  
        }  
      });
    }
   
    $('#tgl_awal').val('');
    $('#tgl_akhir').val('');

  });
</script>
  <script>
    function setting() {
      $('#modal_setting').modal('show');
    }

    $(document).ready(function(){
     $("#tabel_daftar").dataTable({
        "paging":   false,
        "ordering": true,
        "searching": false,
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