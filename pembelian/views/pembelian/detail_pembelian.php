<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Pembelian

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
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <label><h3><b>Detail Transaksi Pembelian</b></h3></label>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Kode Transaksi</label>
                    <?php
                    $kode = $this->uri->segment(3);
                    
                    $transaksi_pembelian = $this->db->get_where('transaksi_pembelian',array('kode_pembelian'=>$kode));
                    $hasil_transaksi_pembelian = $transaksi_pembelian->row();
                    ?>
                    
                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_pembelian->kode_pembelian; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
                  </div>
                  
                  <div class="form-group">
                    <label class="gedhi">Tanggal Transaksi</label>
                    <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_pembelian->tanggal_pembelian); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nota Referensi</label>
                    <input readonly="true" type="text" value="<?php echo $hasil_transaksi_pembelian->nomor_nota ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <?php
                    $supplier = $this->db->get('master_supplier');
                    $supplier = $supplier->result();
                    ?>
                    <select disabled="true" class="form-control select2" name="kode_supplier" id="kode_supplier">
                     <option selected="true" value="">--Pilih Supplier--</option>
                     <?php foreach($supplier as $daftar){ ?>
                     <option <?php if($hasil_transaksi_pembelian->kode_supplier==$daftar->kode_supplier){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                     <?php } ?>
                   </select> 
                 </div>
               </div>
               <div class="col-md-6">
                <label>Pembayaran</label>
                <div class="form-group">
                  <select disabled="true" class="form-control" name="proses_pembayaran" id="proses_pembayaran">
                    <option <?php if($hasil_transaksi_pembelian->proses_pembayaran=='cash') { echo "selected='true'"; } ?> value="cash">Cash</option>
                    <option <?php if($hasil_transaksi_pembelian->proses_pembayaran=='credit') { echo "selected='true'"; } ?>  value="credit">Credit</option>
                    <option <?php if($hasil_transaksi_pembelian->proses_pembayaran=='konsinyasi') { echo "selected='true'"; } ?> value="konsinyasi">Konsinyasi</option>
                  </select>
                </div>
              </div>
            </div>
          </div> 

          <div id="list_transaksi_pembelian">
            <div class="box-body">
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Jenis Bahan</th>
                    <th>Nama bahan</th>
                    <th>QTY</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody id="tabel_temp_data_transaksi">

                  <?php
                  $kode = $this->uri->segment(3);
                  $pembelian = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode));
                  $list_pembelian = $pembelian->result();
                  $nomor = 1;  $total = 0;

                  foreach($list_pembelian as $daftar){ 
                    @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                    @$hasil_satuan_bahan = $satuan_bahan->row();
                    @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                    @$hasil_satuan_barang = $satuan_barang->row();
                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $daftar->kategori_bahan ?></td>
                      <td><?php echo $daftar->nama_bahan; ?></td>
                      <td><?php echo $daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                      <td><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                      <td><?php echo format_rupiah($daftar->subtotal); ?></td>
                    </tr>
                    <?php 
                    $total = $total + $daftar->subtotal;
                    $nomor++; 
                  } 
                  ?>
                  
                  <tr>
                    <td colspan="4"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td><?php echo format_rupiah($total); ?></td>
                  </tr>

                  <tr>
                    <td colspan="4"></td>
                    <td style="font-weight:bold;">Diskon (%)</td>
                    <td id="tb_diskon"><?php echo $hasil_transaksi_pembelian->diskon_persen; ?></td></td>
                    
                  </tr>
                  
                  <tr>
                    <td colspan="4"></td>
                    <td style="font-weight:bold;">Diskon (Rp)</td>
                    <td id="tb_diskon_rupiah"><?php echo format_rupiah($hasil_transaksi_pembelian->diskon_rupiah); ?></td>
                    
                  </tr>
                  
                  <tr>
                    <td colspan="4"></td>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td id="tb_grand_total"><?php echo format_rupiah($total-$hasil_transaksi_pembelian->diskon_rupiah); ?></td>
                    
                  </tr>
                </tbody>
                <tfoot>

                </tfoot>
              </table>
              <br>
              <div style="text-decoration: none;" class="btn green btn-lg"><i class="fa fa-tags"></i> Dibayar <?php echo format_rupiah($hasil_transaksi_pembelian->dibayar) ; ?>
              </div>
            </div>
          </div>
        </form>
      </div>
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
            window.location = "<?php echo base_url().'pembelian/daftar_pembelian'; ?>";
          });
        </script>

