

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
          Proses Pembayaran Piutang
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
                              <div class="box-body">
                              <label><h3><b>Detail Transaksi Penjualan</b></h3></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                        $kode = $this->uri->segment(5);
                                        
                                        $transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
                                        $hasil_transaksi_penjualan = $transaksi_penjualan->row();
                                    ?>
                                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_penjualan->kode_penjualan; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_penjualan" />
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="gedhi">Tanggal Transaksi</label>
                                    <input type="text" value="<?php echo TanggalIndo($hasil_transaksi_penjualan->tanggal_penjualan); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Member</label>
                                    <input readonly="true" type="text" value="<?php echo $hasil_transaksi_penjualan->kode_member ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Nama Member</label>
                                    <input readonly="true" type="text" value="<?php echo $hasil_transaksi_penjualan->nama_member ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                                  </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Grand Total</label>
                                    <input readonly="true" type="text" value="<?php echo format_rupiah($hasil_transaksi_penjualan->grand_total) ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label>Petugas</label>
                                    <input readonly="true" type="text" value="<?php echo ($hasil_transaksi_penjualan->petugas) ?>" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" />
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
                                      <th>Nama Menu</th>
                                      <th>QTY</th>
                                      <th>Harga Satuan</th>
                                      <th>Diskon Item</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_transaksi">
                                  
                                <?php
                                  $kode = $this->uri->segment(5);
                                  $penjualan = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode));
                                  $list_penjualan = $penjualan->result();
                                  $nomor = 1;  $total = 0;

                                  foreach($list_penjualan as $daftar){ 
                                ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo $daftar->nama_menu; ?></td>
                                      <td><?php echo $daftar->jumlah; ?></td>
                                      <td><?php echo format_rupiah($daftar->harga_satuan); ?></td>
                                      <td><?php echo $daftar->diskon_item; ?></td>
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
                                  <td id="tb_diskon"><?php echo $hasil_transaksi_penjualan->diskon_persen; ?></td></td>
                                  
                                </tr>
                                
                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Diskon (Rp)</td>
                                  <td id="tb_diskon_rupiah"><?php echo format_rupiah($hasil_transaksi_penjualan->diskon_rupiah); ?></td>
                                  
                                </tr>
                                
                                <tr>
                                  <td colspan="4"></td>
                                  <td style="font-weight:bold;">Grand Total</td>
                                  <td id="tb_grand_total"><?php echo format_rupiah($total-$hasil_transaksi_penjualan->diskon_rupiah); ?></td>
                                  
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
                                        $transaksi_piutang= $this->db->get_where('transaksi_piutang',array('kode_transaksi'=>$kode));
                                        $hasil_transaksi_piutang = $transaksi_piutang->row();
                                        $sisa = $hasil_transaksi_piutang->sisa ;
                                    ?>

                                    <div class="col-md-3">
                                      <label><b>Sisa Hutang</label>
                                      <?php if($sisa==0){ ?>
                                          <div class="input-group">
                                            <a href="<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>"><div style="text-decoration: none;" class="btn red btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div></a>
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
                                    <div class="col-md-3">
                                      <label><b>Jumlah Hutang</label>
                                      <?php if($sisa==0){ ?>
                                          <div class="input-group">
                                            <a href="<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>"><div style="text-decoration: none;" class="btn red btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div></a>
                                          </div>
                                      <?php 
                                            }
                                            else{
                                      ?>
                                          <div class="input-group">
                                            <div style="text-decoration: none;" class="btn blue btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($hasil_transaksi_piutang->nominal_piutang) ; ?></div>
                                            
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
                                        <input type="text" class="form-control" placeholder="Angsuran" name="angsuran" id="angsuran">
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
                                  

                              </div>
                          </div>
                            
                        </form>

          
        </div>
        
        <!------------------------------------------------------------------------------------------------------>

      </div>
    </div>
                
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->

         
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
        <span style="font-weight:bold; font-size:11pt">Apakah anda yakin akan membayar piutang tersebut sebesar <span id="utang"></span> ?</span>
     
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="proses_piutang()" class="btn red">Ya</button>
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
    window.location = "<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>";
  });
  </script>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
    $("#angsuran").keyup(function(){
            var angsuran = $('#angsuran').val();
             var url = "<?php echo base_url().'hutang_piutang/piutang/get_rupiah'; ?>";
             $.ajax({
            type: "POST",
            url: url,
            data: {angsuran:angsuran},
              success: function(rupiah) {              
               $("#nilai_dibayar").html(rupiah);
              }
          });
    });
    
  /*  $("#angsuran").change(function(){
        var angsuran = $('#angsuran').val();
        var nilai_sisa = $('#nilai_sisa').val();
        alert("Angsuran "+angsuran+"Sisa "+nilai_sisa);
        if(angsuran > nilai_sisa){
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


function proses_piutang(){
      var kode_transaksi = $('#kode_penjualan').val();
      var sisa = $("#nilai_sisa").val();
      var angsuran = $("#angsuran").val();    
      var url = "<?php echo base_url().'hutang_piutang/piutang/simpan_piutang'?> ";
      $.ajax({
          type: "POST",
          url: url,
          data: { 
                  kode_transaksi:kode_transaksi,
                  sisa:sisa,
                  angsuran:angsuran
                },
          success: function(hasil)
          {
            
            if(hasil==1){
                $('#modal-confirm').modal('hide');
                $(".sukses").html('<div style="font-size:1.5em" class="alert alert-success">Berhasil Melakukan Pembayaran Piutang.</div>');   
                setTimeout(function(){
                    $('.sukses').html('');
                    window.location = '<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>';                     
              },2000);     
              
            }else{
                $('#modal-confirm').modal('hide');
                $(".sukses").html(hasil);
                setTimeout(function(){
                    $('.sukses').html('');                    
                },2000);
            }
            
                
           
                
            
                               
          }
      });
}

</script>