

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
             Laporan Laba Rugi
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

            <div id="cari_laba_rugi">
              <table style="font-size:1.5em" id="tabel_daftar" class="table table-bordered table-hover">
                <tr>
                  <td width="10px">1</td>
                  <td width="10px" colspan="3"><strong>Pemasukan</strong></td>
                  <td width="10px"></td>
                </tr>

                <?php
                $this->db->select('*'); 
                $this->db->distinct();
                $this->db->select('kode_penjualan') ;
                $this->db->where('jenis_transaksi !=','kredit') ;
                $this->db->order_by('kode_penjualan','desc');
                $this->db->group_by('kode_penjualan');
                $this->db->where('tanggal_penjualan',date("Y-m-d"));
                $penjualan = $this->db->get('transaksi_penjualan');
                $hasil_penjualan = $penjualan->result();
                $keuangan = 0;
                foreach($hasil_penjualan as $total){
                  $keuangan += $total->grand_total;
                }

                ?>

                <tr>
                  <td width="10px"></td>
                  <td width="10px"></td>
                  <td colspan="2">Penjualan</td>
                  <td align="right" width="10px"><?php echo format_rupiah($keuangan); ?></td>
                </tr>
                <?php 
                $tanggal=date('Y-m-d');
                
                $sub_masuk=$this->db->query("SELECT * from keuangan_masuk where tanggal_transaksi ='$tanggal' and kode_sub_kategori_keuangan !='1.1.1' group by kode_sub_kategori_keuangan");
                $hasil_sub_masuk=$sub_masuk->result();
                $hasil_masuk=0;
                foreach ($hasil_sub_masuk as $value) {
                  ?>
                  <tr>
                    <td width="10px"></td>
                    <td width="10px"></td>
                    <?php

                    $keungan_masuk=$this->db->query("SELECT SUM(nominal) as total from keuangan_masuk where tanggal_transaksi ='$tanggal' and kode_sub_kategori_keuangan ='$value->kode_sub_kategori_keuangan'");
                    $hasil_keuangan_masuk=$keungan_masuk->row();
                   
                    ?>

                    <td colspan="2"><?php echo $value->nama_sub_kategori_keuangan;?></td>
                    <td align="right" width="10px"><?php echo format_rupiah($hasil_keuangan_masuk->total); ?></td>
                  </tr>
                  <?php
                  $hasil_masuk +=$hasil_keuangan_masuk->total;
                }
                ?>





                <tr>
                  <td colspan="4" class="text-center"><strong> TOTAL PEMASUKAN</strong></td>
                  <td align="right"><strong><?php echo format_rupiah($keuangan + $hasil_masuk); ?></strong></td>
                </tr>
                                                          <!--<tr>
                                  <td colspan="4" class="text-center"><strong>TOTAL </strong></td>
                                  <td align="right"></td>
                                </tr>-->
                                





                                <tr>
                                  <td width="10px">2</td>
                                  <td width="10px" colspan="3"><strong>Pengeluaran</strong></td>
                                  <td width="10px"></td>
                                </tr>

                                

                                
                                <tr>
                                  <td width="20px"></td>
                                  <td width="20px"></td>
                                  
                                  <td colspan="2">HPP</td>
                                  <td width="250px" align="right">
                                    <?php
                                    $this->db->where('tanggal_transaksi',date("Y-m-d"));
                                    $hpp = $this->db->get('opsi_transaksi_penjualan');
                                    $hasil_hpp = $hpp->result();
                                   // echo $this->db->last_query();
                                    $total_hpp = 0;
                                    $hasil = 0;
                                    foreach ($hasil_hpp as $daftar) {
                                      $total_hpp += $daftar->jumlah * $daftar->hpp;
                                      $hasil+=$total_hpp;
                                      //echo $daftar->jumlah. "X" .format_rupiah($daftar->hpp)."<br>";
                                    }

                                    $this->db->where('tanggal_transaksi',date("Y-m-d"));
                                    $hpp_jasa = $this->db->get('opsi_transaksi_penjualan_jasa');
                                    $hasil_hpp_jasa = $hpp_jasa->result();
                                   // echo $this->db->last_query();
                                    // $total_hpp = 0;
                                    // $hasil = 0;
                                    foreach ($hasil_hpp_jasa as $value) {
                                      $total_hpp += $value->jumlah * $value->harga_satuan;
                                      $hasil+=$total_hpp;
                                      //echo $daftar->jumlah. "X" .format_rupiah($daftar->hpp)."<br>";
                                    }

                                    ?>


                                    <?php
                                    echo format_rupiah($total_hpp); 
                                    ?>                                           
                                  </td>
                                </tr>
                                <?php 
                                $sub_keluar=$this->db->query("SELECT * from keuangan_keluar where tanggal_transaksi ='$tanggal' and kode_sub_kategori_keuangan !='1.1.1' group by kode_sub_kategori_keuangan");
                                $hasil_sub_keluar=$sub_keluar->result();
                                $hasil_keluar=0;
                                foreach ($hasil_sub_keluar as $value) {
                                  ?>
                                  <tr>
                                    <td width="10px"></td>
                                    <td width="10px"></td>
                                    <?php
                                    $tanggal=date('Y-m-d');
                                    $keungan_keluar=$this->db->query("SELECT SUM(nominal) as total from keuangan_keluar where tanggal_transaksi ='$tanggal' and kode_sub_kategori_keuangan ='$value->kode_sub_kategori_keuangan'");
                                    $hasil_keuangan_keluar=$keungan_keluar->row();
                                    ?>
                                    <td colspan="2"><?php echo $value->nama_sub_kategori_keuangan;?></td>
                                    <td align="right" width="10px"><?php echo format_rupiah($hasil_keuangan_keluar->total); ?></td>
                                  </tr>
                                  <?php
                                  $hasil_keluar +=$hasil_keuangan_keluar->total;
                                }
                                ?>
                                <tr>
                                  <td colspan="4" class="text-center"><strong> TOTAL PENGELUARAN</strong></td>
                                  <td align="right"><strong><?php echo format_rupiah($total_hpp+$hasil_keluar); ?></strong></td>
                                </tr>
                                                          <!--<tr>
                                  <td colspan="4" class="text-center"><strong>TOTAL </strong></td>
                                  <td align="right"></td>
                                </tr>-->
                                <br>
                                <tr>
                                  <?php
                                  $laba = ($keuangan + $hasil_masuk) - ($total_hpp +$hasil_keluar);
                                  $absolut = abs($laba) ;
                                  $status = ($laba < 0) ? 'RUGI' : 'LABA'   ;
                                  ?>
                                  <td colspan="4" class="text-center"><strong>TOTAL <?php echo $status; ?></strong></td>
                                  <td align="right"><strong><?php echo format_rupiah($absolut); ?></strong></td>
                                </tr>
                              </table>
                              

                              
                              
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
                          window.location = "<?php echo base_url().'analisa'; ?>";
                        });
                        </script>
                        
                        <!-- /.row (main row) -->
                      </section><!-- /.content -->
                    </div><!-- /.content-wrapper -->
                    <script>
                    function cari_transaksi(){
                      var tgl_awal =$("#tgl_awal").val();
                      var tgl_akhir =$("#tgl_akhir").val();
                      var petugas = $("#nama_petugas").val();
                      $.ajax( {  
                        type :"post",  
                        url : "<?php echo base_url().'laba_rugi/search_laba_rugi'; ?>",  
                        cache :false,
                        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir,petugas:petugas},
                        beforeSend:function(){
                          $(".tunggu").show();  
                        },
                        success : function(data) {
                         $("#cari_laba_rugi").html(data);
                         $(".tunggu").hide();  
                       },  
                       error : function(data) {  
                        alert("das");  
                      }  
                    });
                    }
                    </script>
