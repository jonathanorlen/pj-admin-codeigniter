<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Mutasi

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
        $kode_unit = $this->uri->segment(3);
        $get_unit = $this->db->get_where('master_unit',array('kode_unit' => $kode_unit));
        $hasil_unit = $get_unit->result_array();

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <div class="callout callout-info">
                                  <label><h4><b>Mutasi</b></h4></label>
                              </div>  
                              <?php
                                    $kode = $this->uri->segment(3);
                                    $transaksi_mutasi = $this->db->get_where('transaksi_mutasi',array('kode_mutasi'=>$kode));
                                    $hasil_transaksi_mutasi = $transaksi_mutasi->row();
                              ?>
                              <input type="hidden" value="<?php echo @$hasil_transaksi_mutasi->kode_mutasi; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_mutasi" id="kode_mutasi" readonly/>                           

                              <div class="row">
                                <div class="col-md-3">
                                  <h3>Posisi Asal : </h3>
                                </div>
                                <div class="col-md-3">
                                    <label>Unit </label>
                                    <?php 
                                      $unit = $this->db->get('master_unit');
                                      $hasil_posisi_unit = $unit->result();
                                    ?> 
                                    <select id="unit_awal" name="kode_unit_asal" class="form-control" required="" disabled="">
                                      <option value="">Pilih Unit</option>
                                      <?php foreach($hasil_posisi_unit as $daftar){ ?>
                                        <option <?php if($hasil_transaksi_mutasi->kode_unit_asal==$daftar->kode_unit){ echo "selected='true'"; } ?>  value="<?php echo $daftar->kode_unit ?>"><?php echo $daftar->nama_unit ?></option>
                                      <?php } ?>
                                    </select>
                                    <input type="hidden" id="nama_unit_awal" name="nama_unit_asal" />
                                </div>
                                <div class="col-md-3">
                                    <label>Rak </label>
                                    <?php 
                                      $rak = $this->db->get('master_rak');
                                      $hasil_posisi_rak = $rak->result();
                                    ?>
                                    <select id="rak_awal" name="kode_rak_asal" class="form-control" required="" disabled="">
                                    <?php foreach($hasil_posisi_rak as $daftar){ ?>
                                      <option <?php if($hasil_transaksi_mutasi->kode_rak_asal==$daftar->kode_rak){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_rak ?>"><?php echo $daftar->nama_rak ?></option>
                                    <?php } ?>
                                    </select>
                                    <input type="hidden" id="nama_rak_awal" name="nama_rak_asal" />
                                </div>

                              </div>
                            </div> 
                            <br>
                            <div class="box-body">
                              <div class="row">

                                <div class="col-md-3">
                                  <h3>Posisi Tujuan : </h3>
                                </div>
                                <div class="col-md-3">
                                    <label>Unit </label>
                                    <select id="unit_akhir" name="kode_unit_tujuan" class="form-control" required="" disabled="">
                                      <option value="">Pilih Unit</option>
                                      <?php foreach($hasil_posisi_unit as $daftar){ ?>
                                        <option <?php if($hasil_transaksi_mutasi->kode_unit_tujuan==$daftar->kode_unit){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_unit ?>"><?php echo $daftar->nama_unit ?></option>
                                      <?php } ?>
                                    </select>
                                    <input type="hidden" id="nama_unit_akhir" name="nama_unit_tujuan" />
                                </div>
                                <div class="col-md-3">
                                    <label>Rak </label>
                                    <?php 
                                      $rak = $this->db->get('master_rak');
                                      $hasil_posisi_rak = $rak->result();
                                    ?>
                                    <select id="rak_akhir" name="kode_rak_tujuan" class="form-control" required="" disabled="">
                                    <?php foreach($hasil_posisi_rak as $daftar){ ?>
                                      <option <?php if($hasil_transaksi_mutasi->kode_rak_tujuan==$daftar->kode_rak){ echo "selected='true'"; } ?> value="<?php echo $daftar->kode_rak ?>"><?php echo $daftar->nama_rak ?></option>
                                    <?php } ?>
                                    </select>
                                    <input type="hidden" id="nama_rak_akhir" name="nama_rak_tujuan" />
                                </div>

                              </div>
                            </div> 
                            <div class="sukses" ></div>
                            <br>
                            <br>
                            <div class="gagal" ></div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Kategori Bahan</th>
                                      <th>Nama Bahan</th>
                                      <th>QTY</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_mutasi">
                                    <?php
                                        if($kode){
                                          $pembelian = $this->db->get_where('opsi_transaksi_mutasi',array('kode_mutasi'=>$kode));
                                          $list_pembelian = $pembelian->result();
                                          $nomor = 1;  $total = 0;
                                          foreach($list_pembelian as $daftar){ 
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $daftar->kategori_bahan; ?></td>
                                        <td><?php echo $daftar->nama_bahan; ?></td>
                                        <?php 
                                        $kode_bahan=$daftar->kode_bahan;
                                        //echo $kode_bahan;

                                        @$satuan_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_bahan = $satuan_bahan->row();
                                    @$satuan_barang = $this->db->get_where('master_barang',array('kode_barang'=>@$daftar->kode_bahan));
                                    @$hasil_satuan_barang = $satuan_barang->row();
                                        ?>
                       
                                        <td><?php echo $daftar->jumlah." ". @$hasil_satuan_bahan->satuan_stok; ?> <?php echo @$hasil_satuan_barang->satuan_stok;?></td>
                                    </tr>
                                    <?php 
                                            $nomor++; 
                                          } 
                                      }
                                      else{
                                    ?>
                                    <tr>
                                        <td><?php echo @$nomor; ?></td>
                                        <td><?php echo @$daftar->kategori_bahan; ?></td>
                                        <td><?php echo @$daftar->nama_bahan; ?></td>
                                        <td><?php echo @$daftar->jumlah; ?></td>
                                    </tr>
                                    <?php
                                      }
                                    ?>
                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
                              </div>

                              <div class="box-body">
                                  <div class="row">
                                    <div class="col-md-9">
                                        <label>Keterangan</label>
                                        <input class="form-control" value="<?php echo @$hasil_transaksi_mutasi->keterangan; ?>" name="keterangan" id="keterangan" required="" readonly></input>
                                    </div>
                                  </div>
                              </div>

                            </div>
                        </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!------------------------------------------------------------------------------------------------------>

<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
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
            window.location = "<?php echo base_url().'mutasi/gudang'; ?>";
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