<div class="row">      
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
         Tambah PO
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
        <div class="" ></div>
        <section class="content">             
          <!-- Main row -->

          <div class="row">
            <div class="col-md-12">
              <a href="<?php echo base_url().'pre_order/tambah_produk' ?>" style="padding:13px; margin-bottom:10px;" class="btn btn-app green pull-right"><i class="fa fa-edit"></i> Tambah Produk</a>
            </div>
          </div>
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
                    <div class="sukses" ></div>
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Kode Transaksi</label>
                          <?php
                          $this->db->select_max('id');
                          $get_max_po = $this->db->get('transaksi_po');
                          $max_po = $get_max_po->row();

                          $this->db->where('id', $max_po->id);
                          $get_po = $this->db->get('transaksi_po');
                          $po = $get_po->row();
                          $tahun = substr(@$po->kode_transaksi, 3,4);
                          if(date('Y')==$tahun){
                            $nomor = substr(@$po->kode_transaksi, 8);
                            $nomor = $nomor + 1;
                            $string = strlen($nomor);
                            if($string == 1){
                              $kode_trans = 'PO_'.date('Y').'_00000'.$nomor;
                            } else if($string == 2){
                              $kode_trans = 'PO_'.date('Y').'_0000'.$nomor;
                            } else if($string == 3){
                              $kode_trans = 'PO_'.date('Y').'_000'.$nomor;
                            } else if($string == 4){
                              $kode_trans = 'PO_'.date('Y').'_00'.$nomor;
                            } else if($string == 5){
                              $kode_trans = 'PO_'.date('Y').'_0'.$nomor;
                            } else if($string == 6){
                              $kode_trans = 'PO_'.date('Y').'_'.$nomor;
                            }
                          } else {
                            $kode_trans = 'PO_'.date('Y').'_000001';
                          }
                          
                          ?>
                          <input readonly="true" type="text" value="<?php echo $kode_trans; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_po" id="kode_po" />
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="gedhi">Tanggal Transaksi</label>
                          <input type="text" value="<?php echo TanggalIndo(date("Y-m-d")); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_input" id="tanggal_input"/>
                        </div>
                      </div>
                      
                      <?php
                      $get_ses = $this->session->userdata('astrosession');
                      ?>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="gedhi">Operator</label>
                          <input type="text" readonly="" value="<?php echo $get_ses->uname; ?>" class="form-control" placeholder="Tanggal Transaksi" name="operator" id="operator"/>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="gedhi">Tanggal Barang Datang</label>
                          <input type="date" value="" class="form-control" placeholder="Tanggal Barang Datang" name="tgl_barang_datang" id="tgl_barang_datang"/>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="gedhi">Keterangan</label>
                          <input type="text"  value="" class="form-control " placeholder="Keterangan" name="keterangan_po" id="keterangan_po"/>
                        </div>
                      </div>
                      

                    </div>
                  </div> 


                  <div class="box-body">
                    <div class="row">
                      <div class="">
                       <div class="col-md-2" hidden>
                        <label>Jenis Bahan</label>
                        <!-- <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true">
                          <option value="" >--Pilih Jenis Bahan--</option>
                          <option value="bahan baku" selected="true">Bahan Baku</option>                     
                          <option value="barang">Barang</option> 
                        </select> -->
                        <!--<input type="hidden" class="form-control" value="bahan baku" placeholder="QTY" name="kategori_bahan" id="kategori_bahan" />-->
                        <input type="hidden" class="form-control" value="stok" placeholder="QTY" name="kategori_bahan" id="kategori_bahan" />
                      </div>
                      <div class="col-md-2">
                        <label>Suplier</label>
                        <select required class="form-control" name="supplier">
                          <option value="">Pilih Suplier</option>
                          <?php
                          $this->db->where('status_supplier', '1');
                          $get_suplier=$this->db->get('master_supplier');
                          $hasil_supplier=$get_suplier->result();
                          foreach ($hasil_supplier as $list) {
                            ?>
                            <option value="<?php echo $list->kode_supplier; ?>"><?php echo $list->nama_supplier; ?></option>
                            <?php 
                          } ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label>Nama Produk</label>
                        <select id="kode_bahan" name="kode_bahan" class="form-control select2" >
                          <option value="">Pilih Produk</option>
                        </select>
                      </div>

                      <div class="col-md-2">
                        <label>QTY</label>
                        <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
                      </div>
                      <div class="col-md-2">
                        <label>Satuan</label>
                        <input type="text" readonly="true" class="form-control" placeholder="Satuan Pembelian" name="nama_satuan" id="nama_satuan" />
                        <input type="hidden" name="kode_satuan" id="kode_satuan" />
                      </div>
                      <div class="col-md-3">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" placeholder="KET" name="keterangan" id="keterangan" />
                        <input type="hidden" name="id_item" id="id_item" />
                        <?php
                        $query=$this->db->query("SELECT kode_unit from setting_gudang");
                        $kode_unit=$query->row();


                        ?>
                        <input type="hidden" id="nama_bahan" name="nama_bahan" />

                        <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $kode_unit->kode_unit;?>" />
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
                                  <div class="col-md-1" style="padding-top:26px; padding-left:0px;" >
                                    <div onclick="add_item()" id="add"  class="btn btn-primary btn-block">Add</div>
                                    <div onclick="update_item()" id="update" class="btn btn-primary btn-block">Edit</div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="list_transaksi_pembelian">
                              <div class="box-body"><br>
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
                            <!-- <div class="box-footer"> <button type="submit" class="btn btn-success pull-right">Simpan</button> -->
                          </div>
                        </form>
                        <a onclick="confirm_bayar();" class="btn btn-success pull-right">Simpan</a>

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
                      <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus produk tersebut ?</span>
                      <input id="id-delete" type="hidden">
                    </div>
                    <div class="modal-footer" style="background-color:#eee">
                      <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
                      <button onclick="delData()"  class="btn green">Ya</button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="modal_cetak_po" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color:grey">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title" style="color:#fff;">Konfirmasi Print Data</h4>
                    </div>
                    <div class="modal-body">
                      <span style="font-weight:bold; font-size:14pt">Apakah anda mencetak data PO tersebut ?</span>
                      <input id="id-delete" type="hidden">
                    </div>
                    <div class="modal-footer" style="background-color:#eee">
                      <button onclick="daftar_po()" class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
                      <button onclick="print_po()"  class="btn green">Ya</button>
                    </div>
                  </div>
                </div>
              </div>

              <div id="modal-confirm-bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color:grey">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title" style="color:#fff;">Konfirmasi Pembayaran</h4>
                    </div>
                    <div class="modal-body">
                      <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan Pembelian ini <span id="bayare"></span> ?</span>
                      <input id="id-delete" type="hidden">
                    </div>
                    <div class="modal-footer" style="background-color:#eee">
                      <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
                      <button id="ok"  class="btn green">Ya</button>
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
              window.location = "<?php echo base_url().'pre_order/daftar'; ?>";
            });
          </script>


          <script>
            function setting() {
              $('#modal_setting').modal('show');
            }
            function confirm_bayar(){
              $("#modal-confirm-bayar").modal('show');
            }


            $(document).ready(function(){
              $("#update").hide();

              var kode_po = $('#kode_po').val() ;  
              
              $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pre_order/get_po/'; ?>"+kode_po);
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
        $('#ok').on('click',function(){
         var simpan_transaksi = "<?php echo base_url().'pre_order/simpan_transaksi/'?>";
         $.ajax({
          type: "POST",
          url: simpan_transaksi,
          data: $('#data_form').serialize(),
          beforeSend:function(){
            $(".tunggu").show();  
          },
          success: function(msg)
          {

            $(".tunggu").hide();
            var data = msg.split("|");
            var num = data[0];
            var pesan = data[1];
           
            if(num == 0){  
              $(".sukses").html(pesan);   
              setTimeout(function(){$('.sukses').html('');
                 $("#modal_cetak_po").modal('show');
               // window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";
              },1500);   

            }
            else{
              $(".sukses").html(pesan);   
              setTimeout(function(){$('.sukses').html('');
                 $("#modal_cetak_po").modal('show');
                //window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";
            },1500); 
            }  

            $("#modal-confirm-bayar").modal('hide');   
          }
        });
         return false;

       });
        $('#nomor_nota').on('change',function(){
          var nomor_nota = $('#nomor_nota').val();
          var url = "<?php echo base_url() . 'pre_order/get_kode_nota' ?>";
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
          var jenis_bahan = $(this).val();
           // alert(jenis_bahan);
           var url = "<?php echo base_url().'pre_order/get_bahan'; ?>";
           $.ajax({
            type: "POST",
            url: url,
            data: {jenis_bahan:jenis_bahan},
            success: function(pilihan) {              
             $("#kode_bahan").html(pilihan);
           }
         });
         // });      

         $('#kode_bahan').on('change',function(){
          var jenis_bahan = $('#kategori_bahan').val();
          var kode_bahan = $('#kode_bahan').val();
          var url = "<?php echo base_url() . 'pre_order/get_satuan' ?>";
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
              }else if(msg.nama_barang){
                $("#nama_bahan").val(msg.nama_barang);
              }

            }
          });
        });

         $("#data_form").submit(function(){
          var simpan_transaksi = "<?php echo base_url().'pre_order/simpan_transaksi/'?>";
          $.ajax({
            type: "POST",
            url: simpan_transaksi,
            data: $('#data_form').serialize(),
            beforeSend:function(){
              $(".tunggu").show();  
            },
            success: function(msg)
            {
              $(".tunggu").hide();
              var data = msg.split("|");
              var num = data[0];
              var pesan = data[1];

              if(num == 0){  
                $(".sukses").html(pesan);   
                setTimeout(function(){$('.sukses').html('');
                  window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";
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
  var position = $("#kode_unit").val();
  var url = "<?php echo base_url().'pre_order/simpan_item_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_po:kode_po,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      keterangan:keterangan,
      jumlah:jumlah,position:position    
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(data)
    {
     $(".tunggu").hide(); 
     $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pre_order/get_po/'; ?>"+kode_po);
     //$('#kategori_bahan').val('');
     $('#kode_bahan').val('');
     $('#jumlah').val('');
     $('#nama_satuan').val('');      
     $("#keterangan").val('');             
   }
 });

}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}
function print_po() {
  var kode_po = $('#kode_po').val();
  window.open("<?php echo base_url().'pre_order/print_po_transaksi/'; ?>"+kode_po);
  setTimeout(function(){$('.sukses').html('');
                window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";
            },1500); 
}
function daftar_po() {
  
                window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";

}

function actEdit(id) {
  var id = id;
  var kode_po = $('#kode_po').val();
  var url = "<?php echo base_url().'pre_order/get_temp_po'; ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(pembelian){
      $('#kategori_bahan').val(pembelian.kategori_bahan);
      //$("#kode_bahan").val(pembelian.kode_bahan);
      $("#kode_bahan").select2().select2('val', pembelian.kode_bahan);
            //$('#kode_bahan').html("<option value="+pembelian.kode_bahan+" selected='true'>"+pembelian.nama_bahan+"</option>");
            //$("#nama_bahan").val(pembelian.nama_bahan);
            $('#jumlah').val(pembelian.jumlah);
            $("#id_item").val(pembelian.id);
            $("#keterangan").val(pembelian.keterangan);
            $("#add").hide();
            $("#update").show();
            $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pre_order/get_po/'; ?>"+kode_po);
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
  var url = "<?php echo base_url().'pre_order/update_item_temp/'?> ";

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
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pre_order/get_po/'; ?>"+kode_po);
      //$('#kategori_bahan').val('');
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
  var url = '<?php echo base_url().'pre_order/hapus_bahan_temp'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id
    },
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg) {
      $(".tunggu").hide();
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pre_order/get_po/'; ?>"+kode_po);

    }
  });
  return false;
}
</script>

