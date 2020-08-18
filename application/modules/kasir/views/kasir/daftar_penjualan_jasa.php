
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="#">Penjualan</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Penjualan Jasa</a>
          <i class="fa fa-angle-right"></i>
        </li>
        
        
      </ul>
      
    </div>
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
        <div class="portlet box blue">
          <div class="portlet-title">
            <div class="caption">
              Daftar Penjualan Jasa
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
              <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
                <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
              </div>
              <form id="pencarian_form" method="post" style="margin-left: 18px;" class="form-horizontal" target="_blank">

                <div class="row">
                  <div class="col-md-4" id="trx_penjualan">
                    <div class="input-group">
                      <span class="input-group-addon">Tanggal Awal</span>
                      <input type="date" class="form-control tgl" id="tgl_awal" />
                    </div>
                  </div>
                  <div class="col-md-4" id="trx_penjualan">
                    <div class="input-group">
                      <span class="input-group-addon">Tanggal Akhir</span>
                      <input type="date" class="form-control tgl" id="tgl_akhir" />
                    </div>
                  </div>
                  
                  <div class=" col-md-4">
                    <div class="input-group">
                      <button type="button" class="btn btn-success" onclick="cari_transaksi()"><i class="fa fa-search"></i> Cari</button>
                      
                    </div>
                  </div>
                </div>

                <br>

                
              </form>
              <div id="cari_kasir">
                <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
                  <?php
              // $waktu=date("m");
              // $this->db->like("tanggal_penjualan",$waktu);
                  $this->db->limit(20);
                  $this->db->order_by('id','desc');
                  $kasir = $this->db->get('transaksi_penjualan_jasa');
                  $hasil_kasir = $kasir->result();
                  ?>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Transaksi</th>
                      <th>Tanggal</th>
                      <th>Member</th>
                      <th>Total</th>
                      
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="scroll_data" >
                    <?php
                    $nomor=1;
                    foreach($hasil_kasir as $daftar){
                      ?>
                      <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $daftar->kode_penjualan; ?></td>
                        <td><?php echo TanggalIndo($daftar->tanggal_penjualan) ?></td>
                        <td><?php echo $daftar->nama_member ?></td>

                        <td><?php echo format_rupiah($daftar->grand_total) ?></td>

                        <td align="center"><?php #echo get_detail_valid($daftar->kode_penjualan); ?>
                          <div class="btn-group">

                            <a href="<?php echo base_url().'kasir/detail/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
                            <?php if(@$daftar->validasi!='valid'){?>
                            <a href="<?php echo base_url().'kasir/validasi/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Validasi" class="btn btn-icon-only btn-circle blue"><i class="fa fa-check-square-o"></i></a>
                            <?php } ?>
                          </div>
                        </td>
                        <input type="hidden" class="form-control  " id="id" value="<?php echo $daftar->id; ?>">
                      </tr>
                      <?php } ?>
                    </tbody>
                  
                </table>
                <?php 
                $get_jumlah = $this->db->get_where('transaksi_penjualan_jasa');
                $jumlah = $get_jumlah->num_rows();
                $jumlah = floor($jumlah/20);
                ?>
                <input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
                <input type="hidden" class="form-control pagenum " value="0">


              </div>
              
              <!------------------------------------------------------------------------------------------------------>

            </div>
          </div>
          
          <!-- /.row (main row) -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembatalan Reservasi</h4>
            </div>
            <div class="modal-body">
              <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan membatalkan reservasi tersebut ?</span>
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
          window.location = "<?php echo base_url().'kasir/menu_penjualan'; ?>";
        });
      </script>
      <script>
        function actDelete(Object) {
          $('#id-delete').val(Object);
          $('#modal-confirm').modal('show');
        }

        function delData() {
          var id = $('#id-delete').val();
          var url = '<?php echo base_url().'kasir/batal'; ?>';
          $.ajax({
            type: "POST",
            url: url,
            data: {
              kode_reservasi: id
            },
            success: function(msg) {
              $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
          }
        });
          return false;
        }

        function status_reservasi(kode_reservasi) {
          var kode_reservasi = kode_reservasi
          var url = "<?php echo base_url().'kasir/buka_reservasi'; ?>";
          $.ajax({
            type:"post",
            url:url,
            data:{kode_reservasi:kode_reservasi},
            success:function(data){
             setTimeout(function(){ window.location="<?php echo base_url().'kasir/menu_kasir/'; ?>"+data; },1500);
           }
         })
          return false;
        }

        function buka_reservasi(){
    //alert("AA");
    var url = "<?php echo base_url().'kasir/buka_reservasi'; ?>";
    var kode_reservasi = $('.buka').attr('kode');
    $.ajax({
      type:"post",
      url:url,
      data:{kode_reservasi:kode_reservasi},
      success:function(data){
       setTimeout(function(){ window.location="<?php echo base_url().'kasir/menu_kasir/'; ?>"+data; },1500);
     }
   })
  }

  function cari_transaksi(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'kasir/search_penjualan_jasa'; ?>",  
      cache :false,
      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
        $(".tunggu").hide(); 
        $("#cari_kasir").html(data);
      },  
      error : function(data) {  
        alert("lol :v");  
      }  
    });
  }

  
  $(window).scroll(function(){
    if (Math.floor($(window).scrollTop()) == ($(document).height() - $(window).height())){
      if(parseInt($(".pagenum").val()) <= parseInt($(".rowcount").val())) {
        var pagenum = parseInt($(".pagenum").val()) + 1;
        $(".pagenum").val(pagenum);
      //$(window).scrollTop(200);
      load_table(pagenum);
    }
  }
});

  
</script>
<script type="text/javascript">

  function load_table(page){
    // var id = $("#id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'kasir/get_jasa' ?>",
      data: ({  page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#scroll_data").append(msg);

      }
    });
  }
</script>