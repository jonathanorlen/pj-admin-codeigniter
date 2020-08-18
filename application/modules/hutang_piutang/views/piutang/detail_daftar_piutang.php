

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

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
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption">
            Daftar Piutang
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
            <div class="row">
          <!--     <?php 
              $kode_customer2 = $this->uri->segment(4);
              @$this->db->where('kode_customer', $kode_customer2);
              @$this->db->select_min('tanggal_transaksi');
              $tanggal_transaksi = $this->db->get_where('transaksi_piutang',array('sisa !=' => 0));
              $hasil_tanggal_awal = $tanggal_transaksi->row();
             // $tanggal_transaksi = $this->db->query(" SELECT * FROM  where nama_fild= '$parameter' ");
             // $hasil_ambil_data =$tanggal_transaksi->result();
              ?> -->
              <div class="col-md-5" id="">
                <div class="input-group">
                  <span class="input-group-addon">Tanggal Awal</span>
                  <input type="text"  class="form-control tgl" id="tgl_awal">
                </div>
              </div>
           <!--    <?php 
              $kode_customer3 = $this->uri->segment(4);
              @$this->db->where('kode_customer', $kode_customer3);
              @$this->db->select_max('tanggal_transaksi');
              $tanggal_transaksi_2 = $this->db->get_where('transaksi_piutang',array('sisa !=' => 0));
              $hasil_tanggal_akhir = $tanggal_transaksi_2->row();
              ?> -->
              <div class="col-md-5" id="">
                <div class="input-group">
                  <span class="input-group-addon">Tanggal Akhir</span>
                  <input type="text" class="form-control tgl" id="tgl_akhir">
                </div>
              </div>                        
              <div class="col-md-2 pull-left">
                <button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
              </div>
            </div><br>
            <div id="cari_transaksi">
              <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                <?php
                $kode_customer = $this->uri->segment(4);
                $this->db->where('kode_customer', $kode_customer);
                $this->db->order_by('sisa','desc');
                $this->db->order_by('tanggal_transaksi','desc');
                $hutang = $this->db->get_where('transaksi_piutang',array('sisa !=' => 0));
                $hasil_hutang = $hutang->result();
                ?>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Customer</th>
                    <th>Nominal Piutang</th>
                    <th>Sisa</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $nomor = 1;
                  foreach($hasil_hutang as $daftar){ 
                    $tgl = ($daftar->tanggal_transaksi=='0000-00-00' || empty($daftar->tanggal_transaksi)) ? '-' : TanggalIndo(@$daftar->tanggal_transaksi) ;
                    ?> 
                    <tr class=" <?php if($daftar->sisa!=0){ echo "danger"; } ?>">
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo @$daftar->kode_transaksi; ?></td>
                      <td><?php echo @$daftar->nama_customer; ?></td>
                      <td><?php echo format_rupiah(@$daftar->nominal_piutang); ?></td>
                      <td><?php echo format_rupiah(@$daftar->sisa); ?></td>
                      <td><?php echo $tgl; ?></td>
                      <td><?php echo cek_status_piutang($daftar->sisa); ?></td>
                      <td><?php if($daftar->sisa!=0) { echo get_detail_proses($daftar->kode_transaksi);  }
                        else { echo get_detail($daftar->kode_transaksi); }
                        ?></td>
                      </tr>
                      <?php $nomor++; } ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Customer</th>
                        <th>Nominal Piutang</th>
                        <th>Sisa</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section> 
      </div>
    </section> 
  </div>
  <script type="text/javascript">
    $(document).ready(function() {

     $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": false,
      "info":     false
    });   
   } );
 </script>
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
    window.location = "<?php echo base_url().'keuangan'; ?>";
  });
</script>
<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

  $('.tgl').Zebra_DatePicker({});
  $('#cari').click(function(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    var kode_unit =$("#kode_unit").val();
    var kode_transaksi= "<?php echo $this->uri->segment(4); ?>";
    if (tgl_awal=='' || tgl_akhir==''){ 
      alert('Masukan Tanggal Awal & Tanggal Akhir..!')
    }
    else{
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'hutang_piutang/piutang/cari_piutang'; ?>",  
        cache :false,
        
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,kode_unit:kode_unit,kode_transaksi:kode_transaksi},
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
