
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Detail Retur Pembelian
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
        <br>
        <form id="data_form" action="" method="post">

          <div class="box-body">
            <div id="list_retur_pembelian">
              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama bahan</th>
                      <th>QTY</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_retur">            
                    <?php
                    if($kode){
                      $opsi_pembelian = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode));
                      $list_opsi_pembelian = $opsi_pembelian->result();
                      $nomor = 1;  $total = 0;
                      foreach($list_opsi_pembelian as $daftar){ 
                       @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                       @$hasil_satuan_bahan = $satuan_bahan->row();
                       @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                       @$hasil_satuan_barang = $satuan_barang->row(); 
                       ?>
                       <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <td><?php echo $daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                        <td><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                        <td><?php echo format_rupiah($daftar->subtotal); ?></td>
                      </tr>
                      <?php 
                      @$total = $total + $daftar->subtotal;
                      $nomor++; 
                    } 
                  }
                  else{

                    ?>
                    <tr>
                      <td><?php echo @$nomor; ?></td>
                      <td><?php echo @$daftar->nama_bahan; ?></td>
                      <td><?php echo @$daftar->jumlah; ?></td>
                      <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                      <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                    </tr>
                    <?php
                  }
                  ?>

                  <tr>
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td><?php echo format_rupiah(@$total); ?></td>
                  </tr>

                  <tr>
                    <td colspan="3"></td>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td><?php echo format_rupiah(@$total); ?></td>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>

              </table>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <?php 
                $pembelian = $this->db->get_where('transaksi_retur',array('kode_retur'=>$kode));
                $list_pembelian = $pembelian->row();
                ?>
                <label>Keterangan</label>
                <input class="form-control" value="<?php echo @$list_pembelian->keterangan; ?>" readonly >
              </div>
            </div>
          </div>
        </div>

      </form>
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
            window.location = "<?php echo base_url().'pembelian/retur/daftar_retur_pembelian'; ?>";
          });
        </script>
