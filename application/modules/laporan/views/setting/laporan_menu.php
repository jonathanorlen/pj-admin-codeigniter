

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
             Laporan Produk
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
                <div class="col-md-5" id="trx_penjualan">
                  <div class="input-group">
                    <span class="input-group-addon">Tanggal Awal</span>
                    <input type="date" class="form-control tgl" id="tgl_awal" />
                  </div>
                </div>
                <div class="col-md-5" id="trx_penjualan">
                  <div class="input-group">
                    <span class="input-group-addon">Tanggal Akhir</span>
                    <input type="date" class="form-control tgl" id="tgl_akhir" />
                  </div>
                </div>

                <div class=" col-md-2">
                  <div class="input-group pull-right">
                    <button style="width:200px" type="button" class="btn btn-success" onclick="cari_transaksi()"><i class="fa fa-search"></i> Cari</button>

                  </div>
                </div>
              </div>
            <div class="loading" style="z-index:9999999999999999; background:rgba(255,255,255,0.8); width:100%; height:100%; position:fixed; top:0; left:0; text-align:center; padding-top:25%; display:none" >
              <img src="<?php echo base_url() . '/public/img/loading.gif' ?>" >
            </div>
            <form id="pencarian_form" method="post" style="margin-left: 18px;" class="form-horizontal" target="_blank">

             

              <br>


            </form>

            <div id="cari_menu">
              <div>
                <?php

                $this->db->select('*'); 
                $this->db->distinct();

                $this->db->like('tanggal_transaksi',date('Y-m'), 'both') ;
                
                $this->db->group_by('kode_menu');
                $penjualan = $this->db->get('opsi_transaksi_penjualan');
                //echo $this->db->last_query();
                $hasil_penjualan = $penjualan->result();
                $keuangan = 0;
                foreach($hasil_penjualan as $total){
                  @$keuangan += $total->grand_total;

                }

                ?>
                <!-- <label><h4><strong>Total Transaksi Menu : <?php echo @count($hasil_penjualan); ?></strong></h4></label><br /> -->
                <!-- <span><label><h4><strong>Total Keuangan Penjualan :<?php echo @format_rupiah($keuangan); ?></strong></h4></label></span> -->
              </div><hr>
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">

                <thead>
                  <tr>
                 <th width="20">No</th>
                   
                    <th>Nama Produk</th>
                    <th>Total</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $nomor = 1;

                  foreach($hasil_penjualan as $daftar){
                    $jumlah_menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_menu' => $daftar->kode_menu, 'tanggal_transaksi'=>date('Y-m-d')));
                    $hasil_jumlah = $jumlah_menu->result();
                    //echo $this->db->last_query();
                    $total_menu=0;
                    foreach ($hasil_jumlah as $value) {
                      //echo $value->jumlah."|";
                      $total_menu +=$value->jumlah;
                    }

                    $ambil_menu = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $daftar->kode_menu));
                    $hasil_menu = $ambil_menu->row();

                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                     
                      <td><?php echo @$hasil_menu->nama_bahan_baku; ?></td>
                      <td><?php echo @$total_menu; ?></td>
                      
                    </tr>
                    <?php $nomor++; } ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                     
                      <th>Nama Produk</th>
                      <th>Total</th>
                     
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!------------------------------------------------------------------------------------------------------>

            </div>
          </div>

          <!-- /.row (main row) -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
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
        window.location = "<?php echo base_url().'laporan'; ?>";
      });
      </script>

      <script>
      function cari_transaksi(){
        var tgl_awal =$("#tgl_awal").val();
        var tgl_akhir =$("#tgl_akhir").val();
        var petugas = $("#nama_petugas").val();
        $.ajax( {  
          type :"post",  
          url : "<?php echo base_url().'laporan/search_laporan_menu'; ?>",  
          cache :false,
          data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success : function(data) {
           $("#cari_menu").html(data);
           $(".tunggu").hide();  
         },  
         error : function(data) {  
          alert("Kosong");  
          $(".tunggu").hide();  
        }  
      });
      }
      </script>
