
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
      <!--<a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'pembelian/tambah' ?>"><i class="fa fa-edit"></i> Tambah </a>-->
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'pembelian/daftar_pembelian' ?>"><i class="fa fa-list"></i> Daftar </a> 


      <?php
      $this->db->select('*');
          //$this->db->where('position','gudang');
      $this->db->order_by('id', 'desc');
      $total = $this->db->get('transaksi_pembelian');
      $hasil_total = $total->num_rows();

      ?>
      <a style="padding:13px; margin-bottom:10px;width: 190px" class="btn btn-warning pull-right"><i class="fa fa-list"></i>Total Pembelian <?php echo $hasil_total; ?></a> 
      
      <div class="double bg-green pull-right" style="cursor:default">


        <div  style="padding-right:10px; padding-top:0px; font-size:48px; font-family:arial; font-weight:bold">


        </div>
      </div>
      <br><br
      <div class="box-body">            

        <div class="sukses" ></div>
        <br>
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
            <br>
          </div>   
          <div class="col-md-10" id="">
            <div class="input-group">
              <span class="input-group-addon">Supplier</span>
              <select required class="form-control select2" name="supplier" id="supplier">
                <option value="">Pilih Suplier</option>
                <?php
                $this->db->where('status_supplier', '1');
                $get_suplier=$this->db->get('master_supplier');
                $hasil_supplier=$get_suplier->result();
                foreach ($hasil_supplier as $list) {
                  ?>
                  <option value="<?php echo $list->kode_supplier; ?>"><?php echo $list->nama_supplier; ?></option>
                  <?php 
                } ?>
              </select>
            </div>
          </div>   
          <div class="col-md-2 pull-left">
            <button style="width: 190px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
          </div>

        </div>
        <div id="cari_transaksi">
          <table class="table table-striped table-hover table-bordered" id="daftar_pembelian"  style="font-size:1.5em;">
           <?php
           $this->db->order_by('id', 'desc');
           $this->db->where('position','gudang');
            $this->db->like('tanggal_pembelian', date('Y-m'), 'both');
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
              <th>Status</th>
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
              <td><?php echo cek_status_barang(@$daftar->status); ?></td>
              <td align="center"><?php echo get_detail($daftar->kode_pembelian); ?>
                <?php 
                if(@$daftar->status == 'sesuai' and $daftar->dibayar == ''){
                  ?>
                  <a href="<?php echo base_url().'pembelian/pembayaran/'.$daftar->kode_pembelian ?>" class="btn btn-warning btn-sm">Pembayaran</a>
                  <?php
                }
                ?>


              </td>
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
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!--  -->

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
  <script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
  <script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
  <link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
  <script type="text/javascript">

   $('.tgl').Zebra_DatePicker({});


   $('#cari').click(function(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    var kode_unit =$("#kode_unit").val();
    var supplier =$("#supplier").val();
    //if (tgl_awal=='' || tgl_akhir==''){ 
    //  alert('Masukan Tanggal Awal & Tanggal Akhir..!')
    //}
    //else{
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'pembelian/cari_pembelian'; ?>",  
        cache :false,
        beforeSend:function(){
          $(".tunggu").show();  
        },  
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit,supplier:supplier},
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
    //}

    $('#tgl_awal').val('');
    $('#tgl_akhir').val('');
    $('#supplier').val('');

  });
</script>
<script>
  function setting() {
    $('#modal_setting').modal('show');
  }

  $(document).ready(function(){
    $(".select2").select2();

    $("#daftar_pembelian").dataTable({
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

  });

</script>
