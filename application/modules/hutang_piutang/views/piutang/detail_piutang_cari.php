

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
          Detail Piutang
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
                              <label><h3><b>Detail Transaksi Penjualan</b></h3></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                        $kode = $this->uri->segment(4);
                                        
                                        $transaksi_penjualan = $this->db->get_where('transaksi_penjualan',array('kode_penjualan'=>$kode));
                                        $hasil_transaksi_penjualan = $transaksi_penjualan->row();
                                    ?>
                                    <input readonly="true" type="text" value="<?php echo @$hasil_transaksi_penjualan->kode_penjualan; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
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
                                  $kode = $this->uri->segment(4);
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

                            <br>
                            
                            <div class="box-body">
                            <div style="margin-bottom: 20px;" class="col-md-3">
                            <?php
                                        $transaksi_piutang= $this->db->get_where('transaksi_piutang',array('kode_transaksi'=>$kode));
                                        $hasil_transaksi_piutang = $transaksi_piutang->row();
                                        $sisa = $hasil_transaksi_piutang->sisa ;
                                    ?>
                                      
                                      <?php if($sisa==0){ ?>
                                          <div class="input-group">
                                            <a href="<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>"><div style="text-decoration: none;" class="btn red btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div></a>
                                          </div>
                                      <?php 
                                            }
                                            else{
                                      ?>
                                      <label><b>Sisa Piutang</label>
                                          <div class="input-group">
                                            <div style="text-decoration: none;" class="btn green btn-lg"><i class="fa fa-tags"></i> <?php echo ($sisa==0) ? 'LUNAS' :  format_rupiah($sisa) ; ?></div>
                                            </div>
                                      <?php 
                                            }
                                      ?>
                                    </div>
                                <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Kode Transaksi</th>
                                      <th>Angsuran</th>
                                      <th>Tanggal Angsuran</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_mutasi">
                                    <?php
                                        if($kode){
                                          $penjualan = $this->db->get_where('opsi_piutang',array('kode_transaksi'=>$kode));
                                          $hasil_penjualan = $penjualan->result();
                                          $nomor = 1;  $total = 0;
                                          $num = $penjualan->num_rows();
                                          if($num > 0){
                                            foreach($hasil_penjualan as $daftar){ 
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $daftar->kode_transaksi; ?></td>
                                        <td><?php echo format_rupiah($daftar->angsuran); ?></td>
                                        <td><?php echo TanggalIndo($daftar->tanggal_angsuran); ?></td>
                                    </tr>
                                    <?php 
                                              $nomor++; 
                                            } 
                                          }
                                          else{
                                    ?>
                                    <tr>
                                        <td colspan="4" align="center"><h3>BELUM ADA ANGSURAN</h3></td>
                                    </tr>
                                    <?php 
                                          }
                                      }
                                      else{
                                    ?>
                                    <tr>
                                        <td><?php echo @$nomor; ?></td>
                                        <td><?php echo @$daftar->kode_transaksi; ?></td>
                                        <td><?php echo @$daftar->angsuran; ?></td>
                                        <td><?php echo TanggalIndo(@$daftar->tanggal_angsuran); ?></td>
                                    </tr>
                                    <?php
                                      }
                                    ?>
                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
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
            <!-- /.Left col -->      
        </div><!-- /.row (main row) -->
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
            window.location = "<?php echo base_url().'hutang_piutang/piutang/daftar_piutang'; ?>";
          });
        </script>
<script>
$(document).ready(function(){
  //$("#tabel_daftar").dataTable();
  
})

function add_item(){
      var kategori_bahan = $('#kategori_bahan').val();
      var unit_awal = $("#unit_awal").val();
      var rak_awal = $("#rak_awal").val();    
      var kode_bahan = $('#kode_bahan').val();
      var nama_bahan = $('#nama_bahan').val();
      var jumlah = $('#jumlah').val();
      var kode_mutasi = $('#kode_mutasi').val();

      var url = "<?php echo base_url().'stok/mutasi/simpan_item_mutasi_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { 
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  jumlah:jumlah,
                  nama_bahan:nama_bahan,
                  kode_mutasi:kode_mutasi,
                  kode_unit_asal:unit_awal,
                  kode_rak_asal:rak_awal
                },
          success: function(hasil)
          {
              var data = hasil.split("|");
              var num = data[0];
              var pesan = data[1];
              if(num==1){
                $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
                $('#kategori_bahan').val('');
                $('#kode_bahan').val('');
                $('#jumlah').val('');
              }
              else {
                $(".gagal").html(pesan);   
                setTimeout(function(){
                    $('.gagal').html('');
                },1500);
              }               
          }
      });
}

function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
}

function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/menu_resto/hapus_bahan_jadi'; ?>/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id: id
        },
        success: function(msg) {
            $('#modal-confirm').modal('hide');
            // alert(id);
            window.location.reload();
        }
    });
    return false;
}
  
function actEdit(id) {
  var id = id;
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/get_temp_mutasi'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id:id},
          success: function(mutasi){
            $('#kategori_bahan').val(mutasi.kategori_bahan);
            $("#kode_bahan").empty();
            $('#kode_bahan').html("<option value="+mutasi.kode_bahan+" selected='true'>"+mutasi.nama_bahan+"</option>");
            $("#nama_bahan").val(mutasi.nama_bahan);
            $('#jumlah').val(mutasi.jumlah);
            $("#id_item_temp").val(mutasi.id);
            $("#add").hide();
            $("#update").show();
            $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
          }
      });
}

function update_item(){
      var kode_mutasi = $('#kode_mutasi').val();
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var id_item_temp = $("#id_item_temp").val();
      var url = "<?php echo base_url().'stok/mutasi/ubah_item_mutasi_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_mutasi:kode_mutasi,
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  nama_bahan:nama_bahan,
                  jumlah:jumlah,
                  id:id_item_temp
                },
          success: function(data)
          {
              $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
              $('#kategori_bahan').val('');
              $('#kode_bahan').val('');
              $('#jumlah').val('');
              $("#nama_bahan").val('');
              $("#id_item_temp").val('');
              $("#add").show();
              $("#update").hide();
              
          }
      });
  }

function delData() {
  var id = $('#id-delete').val();
  var kode_mutasi = $('#kode_mutasi').val();
  var url = "<?php echo base_url().'stok/mutasi/hapus_temp'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          data: {id:id},
          success: function(pembelian){
              $('#modal-confirm').modal('hide');
              $("#tabel_temp_data_mutasi").load("<?php echo base_url().'stok/mutasi/tabel_item_mutasi_temp/'; ?>"+kode_mutasi);
              $('#kategori_bahan').val('');
              $('#kode_bahan').val('');
              $('#jumlah').val('');
          }
      });
}

</script>