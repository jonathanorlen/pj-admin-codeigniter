<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Validasi RO
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
              <section class="content">             
      <!-- Main row -->
      
        <div class="row">
        <!-- Left col -->
            <section class="col-lg-12 connectedSortable">

           

                <div class="box box-info">
                  <div class="box-header">
                      <!-- tools box -->
                      <div class="pull-right box-tools"></div><!-- /. tools -->
                  </div>
                    
                        <form id="data_form" action="" method="post">
                            <div class="box-body">
                              
                              <div class="row">
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label>Kode Transaksi</label>
                                    <?php
                                      $kode_ro=$this->uri->segment(3);
                                      $get_ro=$this->db->query("SELECT * from transaksi_ro where kode_ro='$kode_ro'");
                                      $hasil_get=$get_ro->row();
                                      // print_r($hasil_get);
                                   ?>
                                    <input readonly="true" type="text" value="<?php echo $hasil_get->kode_ro; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_ro" id="kode_ro" />
                                  </div>
                                </div>

                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label class="gedhi">Tanggal Transaksi</label>
                                    <input type="text" value="<?php echo TanggalIndo($hasil_get->tanggal_input); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_input" id="tanggal_input"/>
                                  </div>

                              </div>
                              <?php 
                                $kode_unit=$hasil_get->position;
                                $unit = $this->db->query("SELECT nama_unit from master_unit where kode_unit='$kode_unit'");
                                $nama = $unit->row();
                              ?>
                              <div class="col-md-2">
                                  <div class="form-group">
                                    <label class="gedhi">Unit</label>
                                    <input type="text" value="<?php echo $nama->nama_unit; ?>" readonly="true" class="form-control"/>
                                  </div>

                              </div>
                            </div> 

                           
                            <div class="box-body">
                              <div class="row">
                                <div class="">
                                <input type="hidden" id="status" name="status" value="<?php echo $hasil_get->status; ?>" />
                                  <!-- <div class="col-md-3">
                                    <label>Jenis Bahan</label>
                                    <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                                      <option value="bahan baku">Bahan Baku</option>                     
                                      <option value="bahan jadi">Bahan Jadi</option> 
                                    </select>
                                  </div> -->



                                 <!-- <div class="col-md-4">
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
                                   <div class="col-md-2">
                                    <label>Satuan</label>
                                    <input type="text" readonly="true" class="form-control" placeholder="Satuan Stok" name="nama_satuan" id="nama_satuan" />
                                    <input type="hidden" name="kode_satuan" id="kode_satuan" />
                                    <input type="hidden" name="jenis_bahan" id="jenis_bahan" />
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
                                  </div>
                                  <div class="col-md-1" style="padding:26px; padding-left:0px;" >
                                    <div onclick="add_item()" id="add"  class="btn btn-primary btn-block">Add</div>
                                    <div onclick="update_item()" id="update" class="btn btn-primary btn-block">Edit</div>
                                  </div>-->
                                </div>
                              </div>
                            </div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body">
                                <table style="font-size:1.5em;" id="tabel_daftar" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama bahan</th>
                                      <th>QTY</th>
                                      <th>Keterangan</th>
                                      <th>Status</th>
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
                               
                              </div>
                             
                        </form> 
                        <a onclick="act_selesai()" style="margin-left:5px;width:100px" class="btn btn-info pull-right">Selesai</a>
                         <a onclick="act_proses()" style="margin-left:5px;" class="btn btn-warning pull-right">Proses</a>
                         <a onclick="actbatal_ro()" style="margin-left:5px;" class="btn btn-danger pull-right">Batal</a>
                          </form>
                          <!-- <a onclick="panding()" style="margin-left:5px;width:100px;" class="btn btn-danger pull-right">Panding</a> -->
                         

                      </div>        
                    </div>  

                    
                      
                </div>
            </section><!-- /.Left col -->      
        </div><!-- /.row (main row) -->
        <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
              </div>
              <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus bahan tersebut ? Bahan akan dibatalkan dalam proses Request Order</span>
                <input id="id-delete" type="hidden">
              </div>
              <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="delData()" class="btn red">Ya</button>
              </div>
            </div>
          </div>
        </div>
        
        <div id="modal-confirm-batal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Batal Request Order</h4>
              </div>
              <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan membatalkan Request Order ?</span>
                <input id="id-delete" type="hidden">
              </div>
              <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="batal_ro()" class="btn red">Ya</button>
              </div>
            </div>
          </div>
        </div>
        
        <div id="modal-confirm-proses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Proses Request Order</h4>
              </div>
              <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan melakukan Proses Validasi tersebut ?</span>
                <input id="id-delete" type="hidden">
              </div>
              <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="proses()" class="btn red">Ya</button>
              </div>
            </div>
          </div>
        </div>
        
        <div id="modal-confirm-selesai" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background-color:grey">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#fff;">Konfirmasi Selsai Request Order</h4>
              </div>
              <div class="modal-body">
                <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menyelesaikan validasi order tersebut ?</span>
                <input id="id-delete" type="hidden">
              </div>
              <div class="modal-footer" style="background-color:#eee">
                <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button onclick="simpan_transaksi()" class="btn red">Ya</button>
              </div>
            </div>
          </div>
        </div>
        
    </section><!-- /.content -->
        <div class="box-footer clearfix">


        </div>
 
                     <!-- <a class="btn btn-app blue" id="upload_foto">
                        <i class="fa fa-edit"></i> Upload Logo
                      </a>
                    <div class="box_foto_upload"></div>
                    <div class="foto_upload"></div>   
                   -->
  </div>

  </div>
  </div>
  </div>


  <!------------------------------------------------------------------------------------------------------>


<script>
function actbatal_ro(){
    $("#modal-confirm-batal").modal('show');
}

function act_proses(){
    $("#modal-confirm-proses").modal('show');
}
function setting() {
    $('#modal_setting').modal('show');
}
function act_selesai(){
    $("#modal-confirm-selesai").modal('show');
}

function bahan(){
      var jenis_bahan = 'bahan baku';
           // alert(jenis_bahan);
            var url = "<?php echo base_url().'validasi_request_order/get_bahan'; ?>";
             $.ajax({
            type: "POST",
            url: url,
            data: {jenis_bahan:jenis_bahan},
              success: function(pilihan) {              
               $("#kode_bahan").html(pilihan);
              }
          });
}

  $(document).ready(function(){
    var status =$('#status').val();
    if (status=='0'){
      bahan();
      var kode_ro = $('#kode_ro').val() ;  
      var simpan_transaksi = "<?php echo base_url().'validasi_request_order/simpan_validasi/'?>";
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
                      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
                    },1500);   
                    
                }
                else{
                    $(".sukses").html(pesan);   
                    setTimeout(function(){$('.sukses').html('');
                      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
                    },1500); 
                }     
              }
          });
        }else{
         
        }
        bahan();
          //return false;
        





      $("#update").hide();

      var kode_ro = $('#kode_ro').val() ;  
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
      $(".tgl").datepicker();
      //$(".select2").select2();

      $('#nomor_nota').on('change',function(){
      var nomor_nota = $('#nomor_nota').val();
      var url = "<?php echo base_url() . 'validasi_request_order/get_kode_nota' ?>";
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
      
        // $("#kategori_bahan").change(function(){
            
        // });      
        
        $('#kode_bahan').on('change',function(){
            var jenis_bahan = 'bahan baku';
            var kode_bahan = $('#kode_bahan').val();
            var url = "<?php echo base_url() . 'validasi_request_order/get_satuan' ?>";
            $.ajax({
                type: 'POST',
                url: url,
                dataType:'json',
                data: {kode_bahan:kode_bahan,jenis_bahan:jenis_bahan},
                success: function(msg){
                  $('#nama_satuan').val(msg.satuan_stok);
                  $("#kode_satuan").val(msg.id_satuan_stok);
                  $("#jenis_bahan").val(msg.jenis_bahan);
                  if(msg.nama_bahan_baku){
                      $("#nama_bahan").val(msg.nama_bahan_baku);
                  }else if(msg.nama_bahan_jadi){
                      $("#nama_bahan").val(msg.nama_bahan_jadi);
                  }
                  
                }
            });
        });
        
      $("#data_form").submit(function(){
          

      });

  });

  function add_item(){

      var kode_ro = $('#kode_ro').val();
      var kategori_bahan = 'bahan baku';
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var keterangan = $("#keterangan").val();
      var position='kitchen';
      var url = "<?php echo base_url().'validasi_request_order/simpan_item_temp/'?> ";
      
          $.ajax({
              type: "POST",
              url: url,
              data: { kode_ro:kode_ro,
                      kategori_bahan:kategori_bahan,
                      kode_bahan:kode_bahan,
                      nama_bahan:nama_bahan,
                      keterangan:keterangan,
                      jumlah:jumlah,position:position    
                    },
              success: function(data)
              {
                  $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
                  $('#kategori_bahan').val('');
                  $('#kode_bahan').val('');
                  $('#jumlah').val('');     
                  $("#keterangan").val('');             
              }
          });
      bahan();
  }

  function simpan_transaksi(){
    //selesai();
    var simpan_transaksi = "<?php echo base_url().'validasi_request_order/simpan_transaksi/'?>";
          $.ajax({
              type: "POST",
              url: simpan_transaksi,
              data: $('#data_form').serialize(),
              success: function(msg)
              {
                /*var data = msg.split("|");
                var num = data[0];
                var pesan = data[1];

                if(num == 0){  
                    $(".sukses").html(pesan);   
                    //setTimeout(function(){$('.sukses').html('');
                      //window.location = "<?php //echo base_url() . 'request_order/daftar' ?>";
                    //},1500);   
                    
                }
                else{
                    $(".sukses").html(pesan);   
                    //setTimeout(function(){$('.sukses').html('');
                      //window.location = "<?php// echo base_url() . 'request_order/daftar' ?>";
                    //},1500); 
                }    */ 
                    $("#modal-confirm-selesai").modal('hide');
                 $(".sukses").html(msg);   
                    setTimeout(function(){$('.sukses').html('');
                      window.location = "<?php echo base_url() . 'validasi_request_order/daftar' ?>";
                    },1500); 
              }
          });
  }
  
  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }
  
  function actEdit(id) {
  var id = id;
  var kode_ro = $('#kode_ro').val();
  var url = "<?php echo base_url().'validasi_request_order/get_temp_ro'; ?>";
  $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id:id},
          success: function(pembelian){
            $('#kategori_bahan').val(pembelian.kategori_bahan);
            //$("#kode_bahan").empty();
            //$('#kode_bahan').html("<option value="+pembelian.kode_bahan+" selected='true'>"+pembelian.nama_bahan+"</option>");
            $("#kode_bahan").val(pembelian.kode_bahan);
            $("#nama_bahan").val(pembelian.nama_bahan);
            $("#kode_satuan").val(pembelian.kode_satuan);
            $("#nama_satuan").val(pembelian.nama_satuan);
            $('#jumlah').val(pembelian.jumlah);
            $("#id_item").val(pembelian.id);
            $("#keterangan").val(pembelian.keterangan);
            $("#add").hide();
            $("#update").show();
            $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
          }
      });
}
function selesai(){
      var kode_ro = $('#kode_ro').val();
      
      var url = "<?php echo base_url().'validasi_request_order/update_transaksi/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_ro:kode_ro},
           success: function(data)
          {
              setTimeout(function(){$('.sukses').html('');
                      window.location = "<?php echo base_url() . 'validasi_request_order/daftar' ?>";
                },300);   
          }
          
      });
        }

function panding(){
      var kode_ro = $('#kode_ro').val();
      
      var url = "<?php echo base_url().'validasi_request_order/panding_transaksi/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_ro:kode_ro},
           success: function(data)
          {
              setTimeout(function(){$('.sukses').html('');
                      window.location = "<?php echo base_url() . 'validasi_request_order/daftar' ?>";
                },300);   
          }
          
      });
        }


function proses(){
 // alert('sadsd');
      var kode_ro = $('#kode_ro').val();
      
      var url = "<?php echo base_url().'validasi_request_order/proses_transaksi/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_ro:kode_ro},
           success: function(data)
          {
            $("#modal-confirm-proses").modal('hide');
              setTimeout(function(){$('.sukses').html('');
                      window.location = "<?php echo base_url() . 'validasi_request_order/daftar' ?>";
                },300);   
          }
      });
        }
function batal_ro(){
 // alert('sadsd');
      var kode_ro = $('#kode_ro').val();
      
      var url = "<?php echo base_url().'validasi_request_order/batal_ro/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_ro:kode_ro},
           success: function(data)
          {
            $("#modal-confirm-batal").modal('hide');
              setTimeout(function(){$('.sukses').html(data);
                      window.location = "<?php echo base_url() . 'validasi_request_order/daftar' ?>";
                },300);   
          }
      });
        }

function update_item(){
      var kode_ro = $('#kode_ro').val();
     
      var kategori_bahan = $('#kategori_bahan').val();
      var kode_bahan = $('#kode_bahan').val();
      var jumlah = $('#jumlah').val();
      var nama_bahan = $("#nama_bahan").val();
      var keterangan = $("#keterangan").val();
      var id_item = $("#id_item").val();
      var url = "<?php echo base_url().'validasi_request_order/update_item_temp/'?> ";

      $.ajax({
          type: "POST",
          url: url,
          data: { kode_ro:kode_ro,
                  kategori_bahan:kategori_bahan,
                  kode_bahan:kode_bahan,
                  nama_bahan:nama_bahan,
                  keterangan:keterangan,
                  jumlah:jumlah,
                  id:id_item
                },
          success: function(data)
          {
              $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
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
    var kode_ro = $('#kode_ro').val();
    var status=$('#status').val();
    var url = '<?php echo base_url().'validasi_request_order/hapus_bahan_opsi'; ?>/delete';
    $.ajax({
        type: "POST",
        url: url,
        data: {status:status,id:id,kode_ro:kode_ro
        },
        success: function(msg) {
            $('#modal-confirm').modal('hide');
            $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_request_order/get_po/'; ?>"+kode_ro);
           
        }
    });
    return false;
}
</script>

