<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Pembelian 

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
        $param = $this->uri->segment(4);
        if(!empty($param)){
          $bahan_baku = $this->db->get_where('master_bahan_baku',array('id'=>$param));
          $hasil_bahan_baku = $bahan_baku->row();
        }    

        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
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
                    $this->db->select_max('kode_pembelian');
                    $kode = $this->db->get_where('transaksi_pembelian',array('tanggal_pembelian'=>$tgl));
                    $hasil_kode = $kode->row();
                                        #$pecah_kode = explode("_",$hasil_kode_pembelian->kode_pembelian);
                                        #echo $pecah_kode[0];
                                        #echo $pecah_kode[2];
                    $this->db->select('kode_pembelian');
                    $kode_pembelian = $this->db->get('master_setting');
                    $hasil_kode_pembelian = $kode_pembelian->row();

                    if(count($hasil_kode)==0){
                      $no_belakang = 1;
                    }
                    else{
                      $pecah_kode = explode("_",$hasil_kode->kode_pembelian);
                      $no_belakang = @$pecah_kode[2]+1;
                    }

                                        #echo $this->db->last_query();

                    ?>
                    <input readonly="true" type="text" value="<?php echo @$hasil_kode_pembelian->kode_pembelian."_".date("dmyHis")."_".$no_belakang ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
                  </div>
                  <div class="form-group">
                    <label>Nota Referensi</label>
                    <input type="text" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" required=""/>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="gedhi">Tanggal Transaksi</label>
                    <input type="text" value="<?php echo TanggalIndo(date("Y-m-d")); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" name="tanggal_pembelian" id="tanggal_pembelian"/>
                  </div>

                  <div class="form-group">
                    <label>Supplier</label>
                    <?php
                    $supplier = $this->db->get_where('master_supplier',array('status_supplier' => '1'));
                    $supplier = $supplier->result();
                    ?>
                    <select class="form-control select2" name="kode_supplier" id="kode_supplier" required="">
                     <option selected="true" value="">--Pilih Supplier--</option>
                     <?php foreach($supplier as $daftar){ ?>
                     <option value="<?php echo $daftar->kode_supplier ?>"><?php echo $daftar->nama_supplier ?></option>
                     <?php } ?>
                   </select> 
                 </div>
               </div>
             </div>
           </div> 

           <div class="sukses" ></div>
           <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                  <div class="col-md-2">
                 <label>Jenis Barang</label>
                  <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true" hidden>
                    <option value="" selected="true">--Pilih Jenis Barang--</option>
                    <option value="bahan baku">Bahan Baku</option>                     
                    <option value="bahan jadi">Barang</option> 
                  </select>

                </div> 
                <input type="hidden" class="form-control" placeholder="QTY" name="kategori_bahan" id="kategori_bahan" value="bahan baku"/>
                <div class="col-md-2">
                  <label>Nama Bahan</label>
                  <select id="kode_bahan" name="kode_bahan" class="form-control select2">
                    <option value="">Pilih Bahan</option>
                    <?php 
                    $ambil_data = $this->db->get('master_bahan_baku');
                    $hasil_ambil_data = $ambil_data->result();
                    foreach ($hasil_ambil_data as $key => $value) {
                     ?>
                     <option value="<?php echo $value->kode_bahan_baku ;?>"><?php echo $value->nama_bahan_baku ;?></option>
                     <?php
                    }
                    ?>
                  </select>
                </div>
                <input type="hidden" id="nama_bahan" name="nama_bahan" />
                <div class="col-md-2">
                  <label>QTY</label>
                  <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
                </div>
                <div class="col-md-2">
                  <label>Satuan</label>
                  <input type="text" readonly="true" class="form-control" placeholder="Satuan Pembelian" name="nama_satuan" id="nama_satuan" />
                  <input type="hidden" name="kode_satuan" id="kode_satuan" />
                </div>
                <div class="col-md-2">
                  <label>Harga Satuan</label>
                  <input type="text" class="form-control" placeholder="Harga Satuan" name="harga_satuan" id="harga_satuan" />
                  <input type="hidden" name="id_item" id="id_item" />
                </div>
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
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
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

          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label>Diskon (Rp)</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                  <input type="text" class="form-control" placeholder="Diskon (Rp)" name="diskon_rupiah" id="diskon_rupiah">
                </div>
              </div>

              <div class="col-md-3">
                <label>Pembayaran</label>
                <div class="form-group">
                  <select class="form-control" name="proses_pembayaran" id="proses_pembayaran">
                    <option value="cash">Cash</option>
                    <option value="debet">Debet</option>
                    <option value="credit">Credit</option>
                  </select>
                  <input type="hidden" class="form-control"  name="kode_sub" id="kode_sub">
                </div>
              </div>

              <div class="col-md-3">
                <div class="input-group">
                  <h3><div id="nilai_dibayar"></div></h3>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-3">
                <label>Diskon (%)</label>
                <div class="input-group">
                  <span class="input-group-addon">%</span>
                  <input type="text" class="form-control" placeholder="Diskon (%)" name="diskon_persen" id="diskon_persen">
                </div>
              </div>

              <div class="col-md-3" id="div_dibayar">
                <label>Dibayar</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                  <input type="text" class="form-control" placeholder="dibayar" name="dibayar" id="dibayar">
                </div>
              </div>



            </div>
          </div>

          <br>
          <button type="submit"  class="btn btn-success pull-right">Simpan</button>
          <div class="box-footer clearfix">
            
          </div>
        </form>
        <?php 
        $user = $this->session->userdata('astrosession');
        $modul = $user->modul;
        $modul_pecah = explode("|",$modul);
        if(in_array('Setting',$modul_pecah)){ 
          ?>
          <div onclick="setting()" class="btn green " style="position: fixed; bottom: 29px; right: 0px; " ><i class="fa fa-gears ngeling"></i></div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- Content Wrapper. Contains page content -->
<!-- /.content-wrapper -->
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

      <form id="form_setting" >
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


  <script type="text/javascript">
  function setting() {
    $('#modal_setting').modal('show');
  }
  $(document).ready(function(){
    $("#update").hide();
    //$("#tabel_temp_data_transaksi").load("<?php #echo base_url().'pembelian/get_pembelian/'; ?>");
    $("#form_setting").submit(function(){
      var keterangan = "<?php echo base_url().'pembelian/keterangan'?>";
      $.ajax({
        type: "POST",
        url: keterangan,
        data: $('#form_setting').serialize(),
        success: function(msg)
        {
          $('#modal_setting').modal('hide');  
        }
      });
      return false;
    });

    var kode_pembelian = $('#kode_pembelian').val() ;  
    $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
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
  var url = "<?php echo base_url() . 'pembelian/get_kode_nota' ?>";
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
//   var jenis_bahan = $(this).val();
//   var url = "<?php echo base_url().'pembelian/get_bahan'; ?>";
//   $.ajax({
//     type: "POST",
//     url: url,
//     data: {jenis_bahan:jenis_bahan},
//     success: function(pilihan) {              
//      $("#kode_bahan").html(pilihan);
//    }
//  });
// });

$("#kode_sub").val('2.1.1');

$("#proses_pembayaran").change(function(){
  var proses_pembayaran = $("#proses_pembayaran").val();
  if(proses_pembayaran== 'cash'){
    $("#kode_sub").val('2.1.1');
  }
  else if(proses_pembayaran== 'debet'){
   $("#kode_sub").val('2.1.2');
                 //kode = $("#kode_sub").val();
                 //alert(kode);
               }
               else{
                 $("#kode_sub").val('2.1.3');
               }
             });

$('#kode_bahan').on('change',function(){
  var jenis_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var url = "<?php echo base_url() . 'pembelian/get_satuan' ?>";
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

$("#diskon_rupiah").keyup(function(){
  var temp_data = "<?php echo base_url().'pembelian/temp_data_transaksi/'?>";
  var kode_pembelian = $('#kode_pembelian').val() ;

  $.ajax({
    type: "POST",
    url: temp_data,
    data: {kode_pembelian:kode_pembelian},
    success: function(hasil) {              
      var diskon_rupiah = $('#diskon_rupiah').val() ;
      var diskon_persen = Math.round(diskon_rupiah/hasil*100);
      $('#diskon_persen').val(diskon_persen) ;
      $("#tb_diskon").text(diskon_persen+"%");

      var diskon_tabel = "<?php echo base_url().'pembelian/diskon_tabel/'?>" ;
      $.ajax({
        type: "POST",
        url: diskon_tabel,
        data: {diskon:diskon_persen},
        success: function(diskon) {      
          $('.diskon_value_rupiah').val(diskon) ;
          $("#tb_diskon").text(diskon+"%");
          $("#tb_diskon_rupiah").text(diskon_rupiah);
          var grand_diskon = $("#grand_total").val() - diskon_rupiah;
          $("#tb_grand_total").text(grand_diskon);     
        }
      });

    }
  });

});

$("#diskon_persen").keyup(function(){
  var temp_data = "<?php echo base_url().'pembelian/temp_data_transaksi/'?>";
  var kode_pembelian = $('#kode_pembelian').val() ;
  $.ajax({
    type: "POST",
    url: temp_data,
    data: {kode_pembelian:kode_pembelian},
    success: function(hasil) {              
      var diskon_persen = $('#diskon_persen').val() ;
      var diskon_rupiah = (diskon_persen / 100) * hasil ;
      $('#diskon_rupiah').val(diskon_rupiah) ;

      var diskon_tabel = "<?php echo base_url().'pembelian/diskon_tabel/'?>" ;
      $.ajax({
        type: "POST",
        url: diskon_tabel,
        data: {diskon:diskon_rupiah},
        success: function(diskon) {   
          $('.diskon_value_rupiah').val(diskon) ;
          $("#tb_diskon").text(diskon_persen+"%");
          $("#tb_diskon_rupiah").text(diskon);
          var grand_diskon = $("#grand_total").val() - diskon;
          $("#tb_grand_total").text(grand_diskon);
        }
      });

    }
  });

});


$("#dibayar").keyup(function(){
  var dibayar = $("#dibayar").val();
  var kode_pembelian = $('#kode_pembelian').val() ;
  var grand = $("#tb_grand_total").text();
  var proses_pembayaran = $('#proses_pembayaran').val() ;
  var url = "<?php echo base_url().'pembelian/get_rupiah'; ?>";
  var url_kredit = "<?php echo base_url().'pembelian/get_rupiah_kredit'; ?>";
  if(proses_pembayaran==''){
    alert('Pembayaran Harus Diisi');
  }
  else{
    if(proses_pembayaran=='cash' || proses_pembayaran=='debet'){
      $.ajax({
        type: "POST",
        url: url,
        data: {dibayar:dibayar,kode_pembelian:kode_pembelian,grand:grand},
        success: function(msg) {            
          var data = msg.split("|");  
          var nilai_dibayar = data[1];
          var nilai_kembali = data[0];
          $("#nilai_dibayar").html(nilai_dibayar);
                          //$("#nilai_kembali").html(nilai_kembali);
                        }
                      });
    }
    else if(proses_pembayaran=='credit'){
      $.ajax({
        type: "POST",
        url: url_kredit,
        data: {dibayar:dibayar,kode_pembelian:kode_pembelian,grand:grand},
        success: function(msg) {            
          var data = msg.split("|");  
          var nilai_dibayar = data[1];
          var nilai_kembali = data[0];
          $("#nilai_dibayar").html(nilai_dibayar);
          $("#nilai_kembali").html(nilai_kembali);
        }
      });
    }
  }

})

$("#data_form").submit(function(){
  var simpan_transaksi = "<?php echo base_url().'pembelian/simpan_transaksi/'?>";
  $.ajax({
    type: "POST",
    url: simpan_transaksi,
    data: $('#data_form').serialize(),
    success: function(msg)
    {
      var data = msg.split("|");
      var num = data[0];
      var pesan = data[1];

      if(num > 0){  
        kode = $("#kode_sub").val();
        setTimeout(function(){$('.sukses').html('');
        window.location = "<?php echo base_url() . 'pembelian/pembelian/daftar_pembelian' ?>";
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
  var kode_pembelian = $('#kode_pembelian').val();
  var nomor_nota = $('#nomor_nota').val();
  var kode_supplier = $('#kode_supplier').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_satuan = $('#kode_satuan').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var nama_bahan = $("#nama_bahan").val();
  var url = "<?php echo base_url().'pembelian/simpan_item_temp/'?> ";
  if(nomor_nota == '' && kode_supplier == ''){
    $(".sukses").html('<div class="alert alert-danger">Nomor Nota dan Supplier harus diisi.</div>');   
    setTimeout(function(){
      $('.sukses').html('');     
    },1500);
  }
  else{
    $.ajax({
      type: "POST",
      url: url,
      data: { kode_pembelian:kode_pembelian,
        kategori_bahan:kategori_bahan,
        kode_bahan:kode_bahan,
        nama_bahan:nama_bahan,
        jumlah:jumlah,
        kode_satuan:kode_satuan,
        nama_satuan:nama_satuan,
        harga_satuan:harga_satuan,
        kode_supplier:kode_supplier
      },
      success: function(data)
      {
        $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
        //$('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
        $("#nama_satuan").val('');
        $('#harga_satuan').val('');
        $("#nama_bahan").val('');
        $("#kode_satuan").val('');

      }
    });
  }
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}

function actEdit(id) {
  var id = id;
  var kode_pembelian = $('#kode_pembelian').val();
  var url = "<?php echo base_url().'pembelian/get_temp_pembelian'; ?>";
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
      $('#jumlah').val(pembelian.jumlah);
      $('#kode_satuan').val(pembelian.kode_satuan);
      $("#nama_satuan").val(pembelian.nama_satuan);
      $('#harga_satuan').val(pembelian.harga_satuan);
      $('#kode_supplier').val(pembelian.kode_supplier);
      $("#id_item").val(pembelian.id);
      $("#add").hide();
      $("#update").show();
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
    }
  });
}

function update_item(){
  var kode_pembelian = $('#kode_pembelian').val();
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var kode_satuan = $('#kode_satuan').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var nama_bahan = $("#nama_bahan").val();
  var id_item = $("#id_item").val();
  var url = "<?php echo base_url().'pembelian/update_item_temp/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_pembelian:kode_pembelian,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      nama_bahan:nama_bahan,
      jumlah:jumlah,
      kode_satuan:kode_satuan,
      nama_satuan:nama_satuan,
      harga_satuan:harga_satuan,
      id:id_item
    },
    success: function(data)
    {
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
      $('#kategori_bahan').val('');
      $('#kode_bahan').val('');
      $('#jumlah').val('');
      $("#nama_satuan").val('');
      $('#harga_satuan').val('');
      $("#nama_bahan").val('');
      $("#kode_satuan").val('');
      $("#id_item").val('');
      $("#add").show();
      $("#update").hide();
    }
  });
}

function delData() {
  var id = $('#id-delete').val();
  var kode_pembelian = $('#kode_pembelian').val();
  var url = '<?php echo base_url().'pembelian/hapus_bahan_temp'; ?>/delete';
  $.ajax({
    type: "POST",
    url: url,
    data: {
      id:id
    },
    success: function(msg) {
      //$('#kode_bahan').load();
      
      $('#modal-confirm').modal('hide');
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
      $('#kategori_bahan').val('bahan baku');
    }
  });
  return false;
}
</script>

