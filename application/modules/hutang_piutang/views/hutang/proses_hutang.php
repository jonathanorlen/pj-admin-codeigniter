

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
            Proses Pembayaran Hutang
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
            
            <form id="data_form" action="" method="post">
              <div class="box-body">
                <label><h3><b>Detail Transaksi Pembelian</b></h3></label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kode Transaksi</label>
                      <?php
                      $kode = $this->uri->segment(5);
                      
                      $transaksi_pembelian = $this->db->get_where('transaksi_pembelian',array('kode_pembelian'=>$kode));
                      $hasil_transaksi_pembelian = $transaksi_pembelian->row();
                      ?>
                      <input readonly="true" type="text" value="<?php echo @$kode; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
                    </div>
                    
                    <div class="form-group">
                      <label class="gedhi">Tanggal Transaksi</label>
                      <input type="text" value="<?php  if(@$hasil_transaksi_pembelian->tanggal_pembelian != ""){echo TanggalIndo(@$hasil_transaksi_pembelian->tanggal_pembelian);}else{echo "";}  ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nota Referensi</label>
                      <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_pembelian->nomor_nota ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
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
                       <option <?php if($hasil_transaksi_pembelian->kode_supplier==$daftar->kode_supplier){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_supplier ?>"><?php echo @$daftar->nama_supplier ?></option>
                       <?php } ?>
                     </select> 
                   </div>
                 </div>
                 <div class="col-md-6">
                  <label>Pembayaran</label>
                  <div class="form-group">
                    <select disabled="true" class="form-control" name="proses_pembayaran" id="proses_pembayaran">
                      <option >--pilih--</option>
                      <option <?php if(@$hasil_transaksi_pembelian->proses_pembayaran=='cash') { echo "selected='true'"; } ?> value="cash">Cash</option>
                      <option <?php if(@$hasil_transaksi_pembelian->proses_pembayaran=='credit') { echo "selected='true'"; } ?>  value="credit">Credit</option>
                      <option <?php if(@$hasil_transaksi_pembelian->proses_pembayaran=='konsinyasi') { echo "selected='true'"; } ?> value="konsinyasi">Konsinyasi</option>
                    </select>
                  </div>
                </div>
              </div>
            </div> 

            <div class="sukses" ></div>

            <div id="list_transaksi_pembelian">
              <div class="box-body">
                <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
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
                    $kode = $this->uri->segment(5);
                    $pembelian = $this->db->get_where('opsi_transaksi_pembelian',array('kode_pembelian'=>$kode));
                    $list_pembelian = $pembelian->result();
                    $nomor = 1;  $total = 0;

                    foreach($list_pembelian as $daftar){ 
                      ?> 
                      <tr>
                        <td><?php echo @$nomor; ?></td>
                        <td><?php echo @$daftar->kategori_bahan ?></td>
                        <td><?php echo @$daftar->nama_bahan; ?></td>
                        <td><?php echo @$daftar->jumlah; ?></td>
                        <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                        <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                      </tr>
                      <?php 
                      $total = $total + $daftar->subtotal;
                      $nomor++; 
                    } 
                    ?>
                    
                    <tr>
                      <td colspan="4"></td>
                      <td style="font-weight:bold;">Total</td>
                      <td><?php echo format_rupiah(@$total); ?></td>
                    </tr>

                    <tr>
                      <td colspan="4"></td>
                      <td style="font-weight:bold;">Diskon (%)</td>
                      <td id="tb_diskon"><?php echo @$hasil_transaksi_pembelian->diskon_persen; ?></td></td>
                      
                    </tr>
                    
                    <tr>
                      <td colspan="4"></td>
                      <td style="font-weight:bold;">Diskon (Rp)</td>
                      <td id="tb_diskon_rupiah"><?php echo format_rupiah(@$hasil_transaksi_pembelian->diskon_rupiah); ?></td>
                      
                    </tr>
                    
                    <tr>
                      <td colspan="4"></td>
                      <td style="font-weight:bold;">Grand Total</td>
                      <td id="tb_grand_total"><?php echo format_rupiah(@$total-@$hasil_transaksi_pembelian->diskon_rupiah); ?></td>
                      
                    </tr>
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <?php
                $transaksi_hutang= $this->db->get_where('transaksi_hutang',array('kode_transaksi'=>$kode));
                $hasil_transaksi_hutang = $transaksi_hutang->row();
                $sisa = $hasil_transaksi_hutang->sisa ;
                ?>

                <div class="col-md-3">
                  <label><b>Sisa Hutang</label>
                  <?php if($sisa==0){ ?>
                  <div class="input-group">
                    <a href="<?php echo base_url().'hutang_piutang/hutang/daftar_hutang'; ?>"><div style="text-decoration: none;" class="btn red btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div></a>
                  </div>
                  <?php 
                }
                else{
                  ?>
                  <div class="input-group">
                    <div style="text-decoration: none;" class="btn green btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div>
                    <input type="hidden" id="nilai_sisa" value="<?php echo $sisa; ?>">
                  </div>
                  <?php 
                }
                ?>
              </div>
            </div>
            <br>
            <div class="row" <?php if($sisa==0) {echo 'style="display:none;"'; } else{} ?> >
              
              
              <div class="col-md-3" id="div_dibayar">
                <label><b>Dibayar</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                  <input type="text" class="form-control" placeholder="angsuran" name="angsuran" id="angsuran">
                </div>
              </div>
              <div class="col-md-3" id="div_potongan">
                <label><b>Potongan Hutang</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                  <input type="text" class="form-control" placeholder="Potongan Hutang" name="potongan_hutang" id="potongan_hutang">
                </div>
              </div>
              <div class="col-md-3" id="div_dibayar">
                <label><b>Jenis Transaksi</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                  <select class="form-control" name="jenis_transaksi" id="jenis_transaksi">
                    <option value="Cash">Cash</option>
                    <option value="Transfer">Transfer</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2" style="padding:25px;">
                <div onclick="actbayar()" id="proses_hutang"  class="btn btn-success">Bayar</div>
              </div>
              
              <div class="col-md-3">
                <div class="input-group">
                  <h3><div id="nilai_dibayar"></div></h3>
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <h3><div id="potongan_h"></div></h3>
                </div>
              </div>
              

            </div>
          </div>
          
        </form>

        
      </div>
      
      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
  
</section><!-- /.Left col -->      
</div><!-- /.row (main row) -->

<div class="row">
  <!-- Left col -->
  <section class="col-lg-12 connectedSortable">
    <div class="box box-info">
      
      

    </div>        
  </div> 
</section><!-- /.Left col -->      
</div><!-- /.row (main row) -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembayaran</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:11pt">Apakah anda yakin akan membayar hutang tersebut sebesar <span id="utang"></span> ?</span>
        
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="proses_hutang()" class="btn red">Ya</button>
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
    window.location = "<?php echo base_url().'hutang_piutang/hutang/daftar_hutang'; ?>";
  });
</script>
<script>
  $(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  $("#angsuran").keyup(function(){
    var angsuran = $('#angsuran').val();
    var nilai_sisa = $('#nilai_sisa').val();
    var url = "<?php echo base_url().'hutang_piutang/hutang/get_rupiah'; ?>";

    $.ajax({
      type: "POST",
      url: url,
      data: {angsuran:angsuran},
      success: function(rupiah) {              
       $("#nilai_dibayar").html(rupiah);

     }
   });
  });

  $("#potongan_hutang").keyup(function(){
    var potongan_hutang = $('#potongan_hutang').val();
    var url = "<?php echo base_url().'hutang_piutang/hutang/get_potongan'; ?>";

    $.ajax({
      type: "POST",
      url: url,
      data: {potongan_hutang:potongan_hutang},
      success: function(rupiah) {              
       $("#potongan_h").html(rupiah);

     }
   });
  });

    /*$("#angsuran").change(function(){
        var angsuran = $('#angsuran').val();
        var nilai_sisa = $('#nilai_sisa').val();

        if(nilai_sisa < angsuran ){
            $(".sukses").html('<div class="alert alert-danger">angsuran lebih besar dari sisa.</div>');   
                setTimeout(function(){
                    $('.sukses').html('');                    
            },1800);
            $('#angsuran').val('');
            $("#nilai_dibayar").html('');
        }
          
      });*/
  
  
})
  function actbayar() {
    var nilai_dibayar = $("#nilai_dibayar").text();
    $("#utang").text(nilai_dibayar);
    $('#modal-confirm').modal('show');
  }


  function proses_hutang(){
    var kode_transaksi = $('#kode_pembelian').val();
    var nilai_sisa = $('#nilai_sisa').val();
    var jenis_transaksi = $('#jenis_transaksi').val();
    var angsuran = $("#angsuran").val();    
    var potongan_hutang = $("#potongan_hutang").val();    
    var cek_sisa = "<?php echo base_url().'hutang_piutang/hutang/cek_sisa'?> ";
    var url = "<?php echo base_url().'hutang_piutang/hutang/simpan_hutang'?> ";

    $.ajax({
      type: "POST",
      url: url,
      data: { 
        kode_transaksi:kode_transaksi,
        angsuran:angsuran,jenis_transaksi:jenis_transaksi,potongan_hutang:potongan_hutang
      },
      success: function(hasil)
      {
       
        if(hasil==1){
          $('#modal-confirm').modal('hide');
          $(".sukses").html('<div style="font-size:1.5em" class="alert alert-success">Berhasil Disimpan.</div>');   
          setTimeout(function(){
            $('.sukses').html('');                    
          },1500);
          window.location = "<?php echo base_url().'hutang_piutang/hutang/daftar_hutang'; ?>"; 
        }else{
          $('#modal-confirm').modal('hide');
          $(".sukses").html(hasil);   
          setTimeout(function(){
            $('.sukses').html('');                    
          },1500);    
        }                  
      }
    }); 
    
  }

</script>