<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="#">Transaksi Kasir</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Daftar Transaksi Kasir</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Detail Transaksi Kasir</a>
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
            Detail Transaksi Kasir
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
            <?php
            $kode_kasir = $this->uri->segment(3);
            $kasir = $this->db->get_where('transaksi_kasir',array('kode_transaksi'=>$kode_kasir));
            $hasil_kasir = $kasir->row();
            ?>
            <form id="data_form" method="post">  
              <div class="box-body">            
                <div class="row">
                  <div class="form-group  col-xs-5">
                    <label>Kode Kasir</label>
                    <input readonly="true" value="<?php echo $kode_kasir; ?>" id="kode_transaksi" type="text" class="form-control" name="kode_transaksi" />

                  </div>
                  <div class="form-group  col-xs-5">
                    <label>Tanggal</label>
                    <input readonly="true" value="<?php echo TanggalIndo($hasil_kasir->tanggal); ?>" type="text" class="form-control" />

                  </div>
                  <div class="form-group  col-xs-5">
                    <label>Check In</label>
                    <input readonly="true" value="<?php echo ($hasil_kasir->check_in); ?>" type="text" class="form-control" />

                  </div>
                  <div class="form-group  col-xs-5">
                    <label>Check Out</label>
                    <input readonly="true" value="<?php echo ($hasil_kasir->check_out); ?>" type="text" class="form-control" />

                  </div>
                  <div class="form-group  col-xs-5">
                    <label>Petugas</label>
                    <input readonly="true" value="<?php echo ($hasil_kasir->petugas); ?>" type="text" class="form-control" />

                  </div>
                  <div class="form-group  col-xs-5">
                    <label>Nominal Penjualan</label>
                    <?php
                    $this->db->select_sum('grand_total');
                    $penjualan = $this->db->get_where('transaksi_penjualan',array('kode_kasir'=>$kode_kasir));
                    $hasil_penjualan = $penjualan->row();

                    ?>
                    <input readonly="true" value="<?php echo format_rupiah($hasil_penjualan->grand_total); ?>" type="text" class="form-control" />
                    <input readonly="true" value="<?php echo ($hasil_penjualan->grand_total); ?>" type="hidden" name="nominal_penjualan" class="form-control" />
                  </div>
                  <!--<div class="form-group  col-xs-5">
                    <label>Nominal Retur Penjualan</label>
                    <?php
                   /* $this->db->select_sum('nominal_retur');
                    $retur_penjualan = $this->db->get_where('transaksi_retur_penjualan',array('kode_kasir'=>$kode_kasir));
                    $hasil_retur_penjualan = $retur_penjualan->row();*/
                    
                    ?>
                    <input readonly="true" value="<?php #echo format_rupiah($hasil_retur_penjualan->nominal_retur); ?>" type="text" class="form-control" />
                    <input readonly="true" value="<?php #echo ($hasil_retur_penjualan->nominal_retur); ?>" type="hidden" name="nominal_retur_penjualan" class="form-control" />
                  </div>-->
                  
                  <div class="form-group  col-xs-5">
                    <label>Saldo Awal</label>
                    <input readonly="true" value="<?php echo format_rupiah($hasil_kasir->saldo_awal); ?>" type="text" class="form-control" />

                  </div>

                  <div class="form-group  col-xs-5">
                    <label>Saldo Laporan Kasir</label>
                    <input readonly="true" value="<?php echo format_rupiah($hasil_kasir->saldo_akhir); ?>" type="text" class="form-control" />

                  </div>

                  <div class="form-group  col-xs-5">
                    <label>Saldo Sebenarnya</label>
                    <?php
                              /*$this->db->select_sum('subtotal');
                                $penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_kasir'=>$kode_kasir));
                                $hasil_penjualan = $penjualan->row();*/
                                #echo $hasil_penjualan->subtotal;
                                $this->db->group_by('kode_penjualan');
                                $penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_kasir'=>$kode_kasir));
                                $hasil_penjualan = $penjualan->result();
                                $saldo = 0;
                                foreach($hasil_penjualan as $daftar){
                                  $total = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$daftar->kode_penjualan));
                                  $hasil_total = $total->row();
                                  
                                  $saldo += $hasil_total->grand_total;
                                }
                                ?>
                                <input readonly="true" value="<?php echo format_rupiah($saldo+$hasil_kasir->saldo_awal);  ?>" type="text" class="form-control" />
                                
                              </div>
                              <div class="form-group col-xs-5">
                                <label>Selisih</label>
                                <!--<input readonly="true" type="text" value="<?php #echo format_rupiah($hasil_kasir->saldo_akhir - ($hasil_kasir->saldo_awal + $hasil_penjualan->subtotal) ) ;  ?>" class="form-control" name="selisih" id="dp" />-->
                                <?php
                                $hasil_selisih = "";
                                $selisih = $hasil_kasir->saldo_akhir - ($hasil_kasir->saldo_awal + $saldo);
                                if($selisih<0){
                                  $hasil_selisih =   "Kurang ".format_rupiah(abs($selisih));
                                }else if($selisih>0){
                                 $hasil_selisih =   "Lebih ".format_rupiah(abs($selisih));
                               }else if($selisih==0){
                                $hasil_selisih =   format_rupiah(abs($selisih));
                              }
                              ?>
                              <input readonly="true" type="text" value="<?php echo $hasil_selisih; ?>" class="form-control" name="selisih" id="dp" />
                            </div>
                            <div class="form-group ombo" style="margin-left: 18px;">
                              <input type="hidden" value="" class="form-control" name="petugas" />
                              <input type="hidden" value="<?php echo date("H:i:s"); ?>" class="form-control" name="check_out" />
                              <input type="hidden" value="close" class="form-control" name="status" />
                            </div>
                          </div>
                          <?php if(empty($hasil_kasir->validasi)){ ?>
                          <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Validasi</button>
                          </div>
                          <?php } ?>
                        </div>
                      </form>
                      

                    </div>

                    <!------------------------------------------------------------------------------------------------------>

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
                    window.location = "<?php echo base_url().'kasir/dft_transaksi_kasir'; ?>";
                  });
                </script>

                <!-- /.row (main row) -->
              </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <script type="text/javascript">
              $(document).ready(function(){
                $(".select2").select2();
              });
            </script>
            <script>
              function rupiah(){
                var rupiah = $("#dp").val();
                var url = "<?php echo base_url().'kasir/diskon_all' ?>";
                $.ajax({
                  type:"post",
                  url:url,
                  data:{rupiah:rupiah},
                  success:function(data){
                    $("#rupiah").text(data);
                  }
                })
              }

              $(function(){
                $("#data_form").submit( function() {
       /* var vv = $(this).serialize();
       alert(vv);*/
       var kode_transaksi = $("#kode_transaksi").val();
       var url = "<?php echo base_url(). 'kasir/simpan_validasi_kasir'; ?>";  
       $.ajax( {
         type:"POST", 
         url : url,  
         cache :false,  
         data :{kode_transaksi:kode_transaksi},
         beforeSend: function(){
           $(".loading").show(); 
         },
         beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
          $(".sukses").html("<div style='font-size:1.5em' class='alert alert-info'>Berhasil Melakukan Validasi</div>");
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'kasir/dft_transaksi_kasir' ?>";},1000); 
          $(".loading").hide();             
        },  
        error : function(data) {  
          alert(data);  
        }  
      });
       return false;                    
     });
              })
            </script>