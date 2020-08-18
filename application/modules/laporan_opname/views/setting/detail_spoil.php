<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Laporan Opname

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
        //$kode_unit = $this->uri->segment(3);
        $kode_default = $this->db->get('setting_gudang');
        $hasil_unit =$kode_default->row();
        $kode_unit = $hasil_unit->kode_unit;
        //echo 'kode unit '.$kode_unit;

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <div class="row">
                <?php
                $kode_spoil =$this->uri->segment(3);
                
                $kode = $this->db->get_where('transaksi_spoil',array('kode_spoil'=>$kode_spoil));
                $hasil_kode = $kode->row();
                

                ?>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="btn btn-app blue">
                      <span style="font-weight:bold;"><i class="fa fa-barcode"></i>&nbsp;&nbsp;&nbsp; Kode Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;"><?php echo @$hasil_kode->kode_spoil; ?></span>
                      
                    </div>
                  </div>
                </div>

                <div class="col-md-6 ">
                  <div class="box-body">
                    <div class="btn btn-app blue pull-right">
                      <span style="font-weight:bold;"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp; Tanggal Spoil &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;</span>
                      <span style="text-align:right;" id="tanggal_opname"><?php echo TanggalIndo(@$hasil_kode->tanggal_spoil); ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
            <br><br>
            

            <div id="list_transaksi_pembelian">
              <div class="box-body"><br>
                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size: 1.5em;">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Produk</th>
                      <th>Nama Unit</th>
                      <th>Nama Blok</th>
                      <th>Qty Spoil</th>
                      
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_opname">
                    <?php
                    $kode_default = $this->db->get('setting_gudang');
                    $hasil_unit =$kode_default->row();
                    $param =$hasil_unit->kode_unit;
                    

                    $spoil = $this->db->get_where('opsi_transaksi_spoil',array('kode_unit' => $param,'kode_spoil' => $kode_spoil));
                    $list_spoil = $spoil->result();
                    $nomor = 1;  

                    foreach($list_spoil as $daftar){ 
                      @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                      @$hasil_satuan_bahan = $satuan_bahan->row();
                      @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                      @$hasil_satuan_barang = $satuan_barang->row();
                      ?> 
                      <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $daftar->nama_bahan; ?></td>
                        <td><?php echo $daftar->nama_unit; ?></td>
                        <td><?php echo $daftar->nama_rak; ?></td>
                        <!-- <td><?php echo $daftar->nama_bahan; ?></td> -->
                        <td><?php echo $daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_stok; echo @$hasil_satuan_barang->satuan_stok;?></td>
                     
                        
                      </tr>

                      <?php }?>

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>
            </div>


            <div class="box-footer clearfix">

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>

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
  window.location = "<?php echo base_url().'laporan_opname/daftar_spoil'; ?>";
});
</script>