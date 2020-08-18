<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Daftar Aktifitas
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
        <?php

        $get_pemasukan = $this->db->get('keuangan_masuk');
        $hasil_pemasukan = $get_pemasukan->result();
        ?>

        <div class="box-body">            
          <div class="sukses" ></div>
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
                                <a class="btn btn-success" onclick="cari_transaksi()"><i class="fa fa-search"></i> Cari</a>
                               
                              </div>
                            </div>
                          </div>

                          <br>

                          
                        </form>
        <div id="aktifitas">
          <table class="table table-hover table-bordered" id="sample_editable_1"  style="font-size:1.5em;">
            <thead>
            <th>No</th>
            <th>Nama Aktifitias</th>
            <th>Jumlah Transaksi</th>
            <th>Action</th>
            </thead>
                
                    <tbody>
            <tr>
            <?php
                $get_pembelian = $this->db->get('transaksi_pembelian');
                $hasil_pembelian = $get_pembelian->result();
                $jml_pembelian = count($hasil_pembelian);
            ?>
                <td>1</td>
                <td>Pembelian</td>
                <td><?php echo $jml_pembelian; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_pembelian/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_po = $this->db->get('transaksi_po');
                $hasil_po = $get_po->result();
                $jml_po = count($hasil_po);
            ?>
                <td>1</td>
                <td>Pre Order</td>
                <td><?php echo $jml_po; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_po/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_retur = $this->db->get('transaksi_retur');
                $hasil_retur = $get_retur->result();
                $jml_retur = count($hasil_retur);
            ?>
                <td>2</td>
                <td>Retur Pembelian</td>
                <td><?php echo $jml_retur ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_retur_pembelian/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_mutasi = $this->db->get('transaksi_mutasi');
                $hasil_mutasi = $get_mutasi->result();
                $jml_mutasi = count($hasil_mutasi);
            ?>
                <td>3</td>
                <td>Mutasi Bahan</td>
                <td><?php echo $jml_mutasi; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_mutasi/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_spoil = $this->db->get('transaksi_spoil');
                $hasil_spoil = $get_spoil->result();
                $jml_spoil = count($hasil_spoil);
            ?>
                <td>4</td>
                <td>Spoil</td>
                <td><?php echo $jml_spoil ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_spoil/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_opname = $this->db->get('transaksi_opname');
                $hasil_opname = $get_opname->result();
                $jml_opname = count($hasil_opname);
            ?>
                <td>5</td>
                <td>Opname</td>
                <td><?php echo $jml_opname; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_opname/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_penjualan = $this->db->get('transaksi_penjualan');
                $hasil_penjualan = $get_penjualan->result();
                $jml_penjualan = count($hasil_penjualan);
            ?>
                <td>6</td>
                <td>Penjualan</td>
                <td><?php echo $jml_penjualan; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_penjualan/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
            <?php
                $get_ro = $this->db->get('transaksi_ro');
                $hasil_ro = $get_ro->result();
                $jml_ro = count($hasil_ro);
            ?>
                <td>7</td>
                <td>Request Order</td>
                <td><?php echo $jml_ro; ?> Transaksi</td>
                <td align="center">
                    <div class="btn-group">
                        <a href="<?php echo base_url().'laporan_aktifitas/detail_ro/'; ?>" title="Detail" class="btn btn-icon-only btn-circle green">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>
                </td>
            </tr>
            </tbody>
               
            
                            
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


<script>
  $(document).ready(function() {
    
    

    $("#tabel_daftar").dataTable({
    "paging":   false,
    "ordering": false,
    "info":     false
  });
  });
  
function cari_transaksi(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'laporan_aktifitas/search_aktifitas'; ?>",  
        cache :false,
        data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {
             $("#aktifitas").html(data);
             $(".tunggu").hide(); 
        },  
        error : function(data) {  
          alert("das");  
        }  
      });
}

</script>

