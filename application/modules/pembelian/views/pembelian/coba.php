<div class="row">      
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

        $kode_pembelian =  $this->uri->segment(3);
        $transaksi_pembelian = $this->db->get_where('transaksi_pembelian',array('kode_pembelian'=>$kode_pembelian));
        $hasil_pembelian = $transaksi_pembelian->row();
        ?>
        <div class="box-body">                   
          <div class="sukses" ></div>
          <form id="data_form" action="" method="post">
            <div class="box-body">
              <div class="notif_nota" ></div>
              <label><h3><b>Transaksi Pembelian</b></h3></label>
              
              <div class="row">


                <?php
                $tgl = date("Y-m-d");
                $no_belakang = 0;
                $this->db->select_max('kode_pembelian');
                $kode = $this->db->get_where('transaksi_pembelian',array('tanggal_pembelian'=>$tgl));
                $hasil_kode = $kode->row();
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


                ?>

                <input type="hidden" id="hasil_kode_po" name="kode_po" >



                


                <?php 
                $kode_po = $hasil_pembelian->kode_po;
                $get_input_jadwal = $this->db->get_where('input_jadwal_barang_datang',array('kode_po'=>$kode_po));
                $hasil_jadwal = $get_input_jadwal->row();
                ?>
                <div class="col-md-6">
                  <div class="form-group">  
                    <label>Kode Penjualan</label>
                    <input readonly="true" type="text" value="<?php echo @$hasil_pembelian->kode_pembelian; ?>" class="form-control" placeholder="Kode Transaksi" name="kode_pembelian" id="kode_pembelian" />
                  </div>
                  <div class="form-group">  
                    <label>Nama</label>
                    <input type="text" class="form-control" placeholder="Nota Referensi" name="nomor_nota" id="nomor_nota" value="<?php echo @$hasil_pembelian->nomor_nota; ?>" required="" readonly=""/>
                  </div>
                  <div class="form-group">  
                    <label>Alamat</label>
                    <input type="text" class="form-control" placeholder="Kode Po" name="kode_po2" id="kode_po2" required="" value="<?php echo $hasil_jadwal->kode_po; ?>" readonly="true" />
                  </div>
                  <div class="form-group">  
                    <label>Sopir</label>
                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan" value="<?php echo $hasil_jadwal->keterangan; ?>"  required=""/>
                  </div>
                  <div class="form-group">  
                    <label>Jam Kembali</label>
                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" id="keterangan" value="<?php echo $hasil_jadwal->keterangan; ?>"  required=""/>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                  <label class="gedhi">Tanggal Penjualan</label>
                  <input type="text" value="<?php echo TanggalIndo($hasil_pembelian->tanggal_pembelian); ?>" readonly="true" class="form-control" placeholder="Tanggal Transaksi" id="tanggal_pembelian"/>
                </div>

                <div class="form-group">
                  <label>No Hp</label>
                  <input type="text" name="no_hp" class="form-control" />
                </div>

                <div class="form-group">
                  <label class="gedhi">Tgl Kirim</label>
                  <input type="date"  class="form-control" placeholder="Tanggal barang datang" name="tgl_barang_datang" value="<?php echo $hasil_jadwal->tanggal_barang_datang; ?>" readonly="true" id="tgl_barang_datang"/>
                </div>
                <div class="form-group">
                  <label class="gedhi">No Kendaraan</label>
                  <input type="date"  class="form-control" placeholder="Tanggal barang datang" name="tgl_barang_datang" value="<?php echo $hasil_jadwal->tanggal_barang_datang; ?>" id="tgl_barang_datang"/>
                </div>
              </div>
            </div>
          </div> 

          <div class="sukses" ></div>


          <div id="list_transaksi_pembelian">
            <div class="box-body">
              <table id="tabel_daftar" class="table table-bordered table-striped" style="font-size:1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama bahan</th>
                    <th>QTY</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>Discon</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody id="table_penjualan1">

                  <?php
                  $kode = 'PEN_161116_005_64_1';
                  if(@$kode){
                    $pembelian = $this->db->get_where('opsi_transaksi_penjualan',array('kode_penjualan'=>$kode));
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
                        <td><?php echo @$daftar->nama_menu; ?></td>
                        <td><?php echo @$daftar->jumlah; ?> <?php echo @$hasil_satuan_bahan->satuan_pembelian; echo @$hasil_satuan_barang->satuan_pembelian;?></td>
                        <td><?php echo format_rupiah(@$daftar->harga_satuan); ?></td>
                        <td><?php echo format_rupiah(@$daftar->subtotal); ?></td>
                        <td><?php echo format_rupiah(@$daftar->diskon_item); ?></td>
                        <td><?php echo @$daftar->status; ?></td>
                        <td><?php echo validasi_penjualan(@$daftar->id); ?></td>

                      </tr>

                      <tr id="tr<?php echo $daftar->id; ?>"  style="display:none" class="detail">
                        <td colspan="10">
                          <span class="closedet pull-right"><strong><h3>X</h3></strong></span><div id="detail<?php echo $daftar->id; ?>" ></div>
                        </td>
                      </tr>

                      <?php 
                      @$total = $total + @$daftar->subtotal;
                      $nomor++; 
                    } 
                  }
                  ?>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Total</td>
                    <td><?php echo format_rupiah(@$total); ?></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Diskon (%)</td>
                    <td id="tb_diskon"><?php echo @$diskon; ?></td></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Diskon (Rp)</td>
                    <td id="tb_diskon_rupiah"></td>

                  </tr>

                  <tr>
                    <td colspan="6"></td>
                    <td style="font-weight:bold;">Grand Total</td>
                    <td id="tb_grand_total"><?php echo format_rupiah(@$total); ?>
                     <input id="grand_total" value="<?php echo @$total; ?>" name="grand_total" type="hidden"/>
                   </td>

                 </tr>
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

            <div class="col-md-3" id="tgl_jatuh_tempo" style="visibility: hidden;">
              <label>Tanggal Jatuh Tempo</label>
              <div class="form-group">
                <input type="date" name="tgl_jatuh_tempo" class="form-control">
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
        <a onclick="confirm_bayar()"  class="btn btn-success pull-right">Simpan</a>
        <div class="box-footer clearfix">

        </div>
      </form>
      <!--  -->
    </div>
  </div>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- Content Wrapper. Contains page content -->
<!-- /.content-wrapper -->
<div id="modal-regular" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="cari_po" method="post">
        <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" onclick="" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="color:#fff;">Transaksi Pembelian</h4>
        </div>
        <div class="modal-body" >
          <div class="form-body">

           <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Kode PO</label>
                <input type="text" id="kode_po" name="kode_po" class="form-control" placeholder="Kode PO" required="">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer" style="background-color:#eee">
        <button onclick="cancel()" class="btn blue" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn green">Cari</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Status</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan mengganti status menjadi sesuai ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
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
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan membayar pembelian bahan sebesar <span id="bayare"></span> ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button id="simpan_transaksi" class="btn red">Ya</button>
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
    function confirm_bayar(){
      var uang = $("#nilai_dibayar").text();
      $("#bayare").text(uang);
      $("#modal-confirm-bayar").modal('show');
    }

    $(document).ready(function(){

      $(".adetail").click(function(){
       $(".detail").fadeOut(); 
       var id = $(this).attr('id');
       if($("#detail"+id).html()!=""){
        $("#tr"+id).fadeIn("slow");
        return;
      }
      var url = "<?php echo base_url().'pembelian/get_form_coba'?>";
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        success: function(html)
        {
          $("#detail"+id).html(html);
          $("#tr"+id).fadeIn("slow");
        }
      }); 
    });

      $(".closedet").click(function(){
   $(this).parent().parent().closest('tr').fadeOut();
 });


      $("#update").hide();

      var kode_pembelian = $('#kode_pembelian').val();
      $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/table_pembelian/'; ?>"+kode_pembelian);
    //$("#modal-regular").modal('show');
//$("#tabel_temp_data_transaksi").load("<?php #echo base_url().'pembelian/get_pembelian/'; ?>");
$("#cari_po").submit(function(){
  var kode_pembelian = $('#kode_pembelian').val();  
  var kode_po = $('#kode_po').val();  
  var keterangan = "<?php echo base_url().'pembelian/get_kode_po'?>";
  $('#kode_po2').val(kode_po);
  $.ajax({
    type: "POST",
    url: keterangan,
    data: {kode_po:kode_po,kode_pembelian:kode_pembelian},
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg)
    {
      var data = msg.split("|");
      if(data[0] == 1){  

        $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
        $('#modal-regular').modal('hide');
        $("#hasil_kode_po").val(data[1]);
        $(".tunggu").hide();
      }
      else{
        $(".gagal").html('<div class="alert alert-danger">Nota Tidak Ditemukan</div>');
        setTimeout(function(){
          $('.gagal').html('');
        },1700);              
        $('#kode_supplier_awal').val('');
        $('#nota').val('');
        $('#tanggal_pembelian_awal').val('');

      }  


    }
  });
  return false;
});
$("#form_setting").submit(function(){
  var keterangan = "<?php echo base_url().'pembelian/keterangan'?>";
  $.ajax({
    type: "POST",
    url: keterangan,
    data: $('#form_setting').serialize(),
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg)
    {
      $(".tunggu").hide();
      $('#modal_setting').modal('hide');  
    }
  });
  return false;
});

var kode_pembelian = $('#kode_pembelian').val() ;  
$("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
//  $("#tabel_daftar").dataTable();
$(".tgl").datepicker();
//$(".select2").select2();
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

$("#kategori_bahan").change(function(){
  var jenis_bahan = $(this).val();
  var url = "<?php echo base_url().'pembelian/get_bahan'; ?>";
  $.ajax({
    type: "POST",
    url: url,
    data: {jenis_bahan:jenis_bahan},
    success: function(pilihan) {              
      $("#kode_bahan").html(pilihan);
    }
  });
});

$("#kode_sub").val('2.1.1');

$("#proses_pembayaran").change(function(){
  var proses_pembayaran = $("#proses_pembayaran").val();
  if(proses_pembayaran== 'cash'){
    $("#kode_sub").val('2.1.1');
    $('#tgl_jatuh_tempo').css('visibility','hidden');
  }
  else if(proses_pembayaran== 'debet'){
    $("#kode_sub").val('2.1.2');
    $('#tgl_jatuh_tempo').css('visibility','hidden');
//kode = $("#kode_sub").val();
//alert(kode);
}else if(proses_pembayaran== 'credit'){
  $('#tgl_jatuh_tempo').css('visibility','visible');
}else{

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
      else if(msg.nama_barang){
        $("#nama_bahan").val(msg.nama_barang);
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

$("#simpan_transaksi").click(function(){
  var simpan_transaksi = "<?php echo base_url().'pembelian/simpan_transaksi_pembayaran/'?>";

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
      $("#modal-confirm-bayar").modal('hide');
      var data = msg.split("|");
      var num = data[0];
      var pesan = data[1];

      if(num > 0){  
        kode = $("#kode_sub").val();
        setTimeout(function(){$('.sukses').html();
          window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";
        },1500);   
      }
      else{
        $(".sukses").html(pesan);   
        setTimeout(function(){$('.sukses').html('');
      },1500); 
        setTimeout(function(){$('.sukses').html();
          window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";
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
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(data)
      {
        $(".tunggu").hide();
        if(data==1){
          $(".sukses").html('<div class="alert alert-danger">Selesaikan Transaksi Sesuai Jenis Barang Terlebih Dahulu</div>');

          setTimeout(function(){$('.sukses').html('');},1800); 
        }else{
          $('.sukses').html('');     
          $("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
//$('#kategori_bahan').val('');
$('#kode_bahan').val('');
$('#jumlah').val('');
$("#nama_satuan").val('');
$('#harga_satuan').val('');
$("#nama_bahan").val('');
$("#kode_satuan").val(''); 
}
}
});
  }
}

function actDelete(Object) {
  $('#id-delete').val(Object);
  $('#modal-confirm').modal('show');
}
function cancel() {
  window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";
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
    beforeSend:function(){
      $(".tunggu").show();  
    },
    success: function(msg) {
      $(".tunggu").hide();
//$('#kode_bahan').load();

$('#modal-confirm').modal('hide');
$("#tabel_temp_data_transaksi").load("<?php echo base_url().'pembelian/get_pembelian/'; ?>"+kode_pembelian);
$('#kategori_bahan').val('bahan baku');
}
});
  return false;
}
</script>

