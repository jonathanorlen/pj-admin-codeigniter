<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Grafik Penjualan
       </div>
       <div class="tools">
        <a href="javascript:;" class="collapse">
        </a>
        <a href="javascript:;" class="reload">
        </a>

      </div>
    </div>
    <div class="portlet-body">
      <div class="sukses"></div>
      <script src="<?php echo base_url().'component/admin/highcharts.js'?>"></script>
      <script src="<?php echo base_url().'component/admin/exporting.js'?>"></script>
      <div class="row">
      
         <form id="pencarian_form"  >
           <div class="col-md-5">
          <div class="form-group ombo" id="trx_penjualan">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Awal</span>
              <input type="date" class="form-control tgl" name="tgl_awal" id="tgl_awal" />
            </div>
          </div>
          </div>
           <div class="col-md-5">
          <div class="form-group ombo" id="trx_penjualan">
            <div class="input-group">
              <span class="input-group-addon">Tanggal Akhir</span>
              <input type="date" class="form-control tgl" name="tgl_akhir" id="tgl_akhir" />
            </div>
          </div>
          </div>
          <div class="col-md-2">
          <div class="">
            <div class="">
              <button type="button" id="cari" class="btn btn-success pull-right btn-block" ><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
          </div>
        </form>
     
      <div class="row">
        <div class="col-md-12">
           <div class="cari_pembelian">

      </div>
        </div>
      </div>
     
    </div>


    <div class="box-footer clearfix"></div>
  </div>
</div>
</div>
</div>


<!------------------------------------------------------------------------------------------------------>
<script type="text/javascript">
  $("#cari").click(function(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    var petugas = $("#nama_petugas").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'analisa/cari_grafik_penjualan'; ?>",  
      cache :false,
      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,petugas:petugas},
      beforeSend:function(){
        //$(".tunggu").show();  
      },
      success : function(data) {
       //alert(data);
       $(".cari_pembelian").html(data);
       //$(".tunggu").hide();  
     },  
     error : function(data) {  
     // alert("das");  
    }  
  });
  });
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
            window.location = "<?php echo base_url().'analisa/laporan_grafik'; ?>";
          });
        </script>