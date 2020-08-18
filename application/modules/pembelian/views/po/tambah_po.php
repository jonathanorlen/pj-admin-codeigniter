<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Pembelian </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin').'/dasboard' ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
<style type="text/css">
 .ombo{
  width: 600px;
 } 

</style>    
    <!-- Main content -->
    <section class="content">             
      <!-- Main row -->
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/pembelian/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/pembelian/daftar_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/retur/tambah'; ?>">
              <i class="fa fa-plus"></i> Tambah Retur Pembelian
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/retur/daftar_retur_pembelian'; ?>">
              <i class="fa fa-list"></i> Daftar Retur Pembelian
            </a>

            <a style="padding:13px; margin-bottom:10px" class="btn btn-app green" href="<?php echo base_url().'pembelian/po/tambah'; ?>">
              <i class="fa fa-plus"></i> Formulir PO
            </a>
            
            <a style="padding:13px; margin-bottom:10px" class="btn btn-app blue" href="<?php echo base_url().'pembelian/po/daftar_po'; ?>">
              <i class="fa fa-list"></i> Daftar PO
            </a>

                <div class="box box-info">
                  <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools"></div><!-- /. tools -->
                  </div>
                    
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              <div class="notif_nota" ></div>
                              <label><h3><b>Transaksi Pembelian</b></h3></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                        $tgl = date("Y-m-d");
                                        $no_belakang = 0;
                                        $this->db->select_max('kode_po');
                                        $kode = $this->db->get_where('transaksi_po',array('tanggal_input'=>$tgl));
                                        $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                                        $this->db->select('kode_po');
                                        $kode_po = $this->db->get('master_setting');
                                        $hasil_kode_po = $kode_po->row();
                                        
                                        if(count($hasil_kode)==0){
                                            $no_belakang = 1;
                                        }
                                        else{
                                            $pecah_kode = explode("_",$hasil_kode->kode_po);
                                            $no_belakang = @$pecah_kode[2]+1;
                                        }
                                        
                                        #echo $this->db->last_query();
                                        
                                    ?>
                                    <input readonly="true" type="text" value="<?php echo @$hasil_kode_po->kode_po."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_po" id="kode_po" />
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="gedhi">Tanggal Transaksi</label>
                                    <input type="text" value="<?php echo TanggalIndo(date("Y-m-d")); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_input" id="tanggal_input"/>
                                  </div>
                                </div>

                              </div>
                            </div> 

                            <div class="sukses" ></div>
                            <div class="box-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="col-md-2">
                                    <label>Jenis Bahan</label>
                                    <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                                      <option value="bahan baku">Bahan Baku</option>                     
                                      <option value="bahan jadi">Bahan Jadi</option> 
                                    </select>
                                  </div>
                                  <div class="col-md-2">
                                    <label>Nama Bahan</label>
                                    <select id="kode_bahan" name="kode_bahan" class="form-control">
                                      <option value="">Pilih Bahan</option>
                                    </select>
                                  </div>
                                  <input type="hidden" id="nama_bahan" name="nama_bahan" />
                                  <div class="col-md-2">
                                    <label>QTY</label>
                                    <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
                                  </div>
                                  <div class="col-md-3">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" placeholder="KET" name="keterangan" id="keterangan" />
                                    <input type="hidden" name="id_item" id="id_item" />
                                  </div>
                                  <!--<div class="col-md-2">
                                    <label>Satuan</label>
                                    <input type="text" readonly="true" class="form-control" placeholder="Satuan Pembelian" name="nama_satuan" id="nama_satuan" />
                                    <input type="hidden" name="kode_satuan" id="kode_satuan" />
                                  </div>
                                  <div class="col-md-2">
                                    <label>Harga Satuan</label>
                                    <input type="text" class="form-control" placeholder="Harga Satuan" name="harga_satuan" id="harga_satuan" />
                                    <input type="hidden" name="id_item" id="id_item" />
                                  </div>-->
                                  <div class="col-md-2" style="padding:25px;">
                                    <div onclick="add_item()" id="add"  class="btn btn-primary">Add</div>
                                    <div onclick="update_item()" id="update"  class="btn btn-primary">Update</div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama bahan</th>
                                      <th>QTY</th>
                                      <th>Keterangan</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tabel_temp_data_transaksi">
                                  
                                  </tbody>
                                  <tfoot>
                                    
                                  </tfoot>
                                </table>
                              </div>
                            </div>

                              

                              <br>
                              <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right">Simpan</button>
                              </div>
                        </form>

                      </div>        
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
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
            </div>
            <div class="modal-body">
                <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus pembelian bahan tersebut ?</span>
                <input id="id-delete" type="hidden">
            </div>
            <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_setting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content" >
            <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                <label><b><i class="fa fa-gears"></i>Setting</b></label>
            </div>

            <form id="form_setting" action="<?php echo base_url().'pembelian/keterangan/' ?>">
            <div class="modal-body">
              <?php
              $setting = $this->db->get('setting_pembelian');
              $hasil_setting = $setting->row();
            ?>
            
              <div class="box-body">
                
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Note</label>
                      <input type="text" name="keterangan"  class="form-control" />
                    </div>
                    
                  </div>
                </div>

              </div>

            <div class="modal-footer" style="background-color:#eee">
                <button class="btn red" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function setting() {
    $('#modal_setting').modal('show');
}


  $(document).ready(function(){
      $("#update").hide();

      var kode_po = $('#kode_po').val() ;  
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/po/get_po/'; ?>"+kode_po);
      //  $("#tabel_daftar").dataTable();
      $(".tgl").datepicker();
      $(".select2").select2();
      //$("#div_dibayar").hide();
    /*  var temp_data = "<?php #echo base_url().'pembelian/tabel_temp_data_transaksi/'?>";
      $.ajax({
        type: "POST",
        url: temp_data,
        data: {},
          success: function(temp) {
            // alert(temp);
            //var data = temp.split("|");
            $("#tabel_temp_data_transaksi").html(temp);
            
          }
      });*/

      $('#nomor_nota').on('change',function(){
      var nomor_nota = $('#nomor_nota').val();
      var url = "<?php echo base_url() . 'pembelian/po/get_kode_nota' ?>";
          $.ajax({
              type: 'POST',
              url: url,
              data: {nomor_nota:nomor_nota},
              success: function(msg){
                  if(msg == 1){
                    $(".notif_nota").html('<div class="alert alert-warning">Kode_Telah_dipakai</div>');
                      setTimeout(function(){
                        $('.notif_nota').html('');
                    },1700);              
                    $('#nomor_nota').val('');
                  }
                  else{

                  }
              }
          });
      });
      
        $("#kategori_bahan").change(function(){
            var jenis_bahan = $(this).val();
             var url = "<?php echo base_url().'pembelian/po/get_bahan'; ?>";
             $.ajax({
            type: "POST",
            url: url,
            data: {jenis_bahan:jenis_bahan},
              success: function(pilihan) {              
               $("#kode_bahan").html(pilihan);
              }
          });
        });      
        
        $('#kode_bahan').on('change',function(){
            var jenis_bahan = $('#kategori_bahan').val();
            var kode_bahan = $('#kode_bahan').val();
            var url = "<?php echo base_url() . 'pembelian/po/get_satuan' ?>";
            $.ajax({
                type: 'POST',
                url: url,
                dataType:'json',
                data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
                success: function(msg){
                  if(msg.satuan_pembelian){
                      $('#nama_satuan').val(msg.satuan_pembelian);
                  }else if(msg.satuan_stok){
                      $('#nama_satuan').val(msg.satuan_stok);
                  }
                  if(msg.id_satuan_pembelian){
                      $("#kode_satuan").val(msg.id_satuan_pembelian);
                  }else if(msg.kode_satuan_stok){
                      $("#kode_satuan").val(msg.kode_satuan_stok);
                  }
                  if(msg.nama_bahan_baku){
                      $("#nama_bahan").val(msg.nama_bahan_baku);
                  }else if(msg.nama_bahan_jadi){
                      $("#nama_bahan").val(msg.nama_bahan_jadi);
                  }
                  
                }
            });
        });

      $("#data_form").submit(function(){
          var simpan_transaksi = "<?php echo base_url().'pembelian/po/simpan_transaksi/'?>";
          $.ajax({
              type: "POST",
              url: simpan_transaksi,
              data: $('#data_form').serialize(),
              success: function(msg)
              {
                var data = msg.split("|");
                var num = data[0];
                var pesan = data[1];

                if(num == 0){  
                    $(".sukses").html(pesan);   
                    setTimeout(function(){$('.sukses').html('');
                      window.location = "<?php echo base_url() . 'pembelian/po/daftar_po' ?>";
                    },1500);   
                    
                }
                else{
                    $(".sukses").html(pesan);   
                    setTimeout(function(){$('.sukses').html('');
                    },1500); 
                }     
              }
          });
          return false;

      });

  });

  function add_item(){
      var kode_po = $('#kode_po').val();
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var keterangan = $("#keterangan").val();
      var url = "<?php echo base_url().'pembelian/po/simpan_item_temp/'?> ";
      
          $.ajax({
              type: "POST",
              url: url,
              data: { kode_po:kode_po,
                      kategori_bahan:kategori_bahan,
                      kode_bahan:kode_bahan,
                      nama_bahan:nama_bahan,
                      keterangan:keterangan,
                      jumlah:jumlah    
                    },
              success: function(data)
              {
                  $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/po/get_po/'; ?>"+kode_po);
                  $('#kategori_bahan').val('');
                  $('#kode_bahan').val('');
                  $('#jumlah').val('');     
                  $("#keterangan").val('');             
              }
          });
      
  }
  
  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }
  
  function actEdit(id) {
  var id = id;
  var kode_po = $('#kode_po').val();
  var url = "<?php echo base_url().'pembelian/po/get_temp_po'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id:id},
          success: function(pembelian){
            $('#kategori_bahan').val(pembelian.kategori_bahan);
            $("#kode_bahan").empty();
            $('#kode_bahan').html("<option value="+pembelian.kode_bahan+" selected='true'>"+pembelian.nama_bahan+"</option>");
            $("#nama_bahan").val(pembelian.nama_bahan);
            $('#jumlah').val(pembelian.jumlah);
            $("#id_item").val(pembelian.id);
            $("#keterangan").val(pembelian.keterangan);
            $("#add").hide();
            $("#update").show();
            $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/po/get_po/'; ?>"+kode_po);
          }
      });
}

function update_item(){
      var kode_po = $('#kode_po').val();
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var keterangan = $("#keterangan").val();
      var id_item = $("#id_item").val();
      var url = "<?php echo base_url().'pembelian/po/update_item_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_po:kode_po,
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  nama_bahan:nama_bahan,
                  keterangan:keterangan,
                  jumlah:jumlah,
                  id:id_item
                },
          success: function(data)
          {
              $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/po/get_po/'; ?>"+kode_po);
              $('#kategori_bahan').val('');
              $('#kode_bahan').val('');
              $('#jumlah').val('');
              $("#nama_bahan").val('');
              $("#keterangan").val('');
              $("#id_item").val('');
              $("#add").show();
              $("#update").hide();
          }
      });
  }

function delData() {
    var id = $('#id-delete').val();
    var kode_po = $('#kode_po').val();
    var url = '<?php echo base_url().'pembelian/po/hapus_bahan_temp'; ?>/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id:id
        },
        success: function(msg) {
            $('#modal-confirm').modal('hide');
            $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/po/get_po/'; ?>"+kode_po);
           
        }
    });
    return false;
}
</script>

