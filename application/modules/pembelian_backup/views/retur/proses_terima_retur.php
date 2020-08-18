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

            <div class="tabel_sesuai">

              <div class="box-body">
                <label><h3><b>Item Retur</b></h3></label>
                <br>
                <table id="tabel_daftar" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama bahan</th>
                      <th>QTY</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_temp_data_retur">            
                    <?php
                    if($kode){
                      $opsi_pembelian = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode));
                      $list_opsi_pembelian = $opsi_pembelian->result();
                      $nomor = 1;  $total = 0;
                      foreach($list_opsi_pembelian as $daftar){ 
                        ?>
                        <tr>
                          <td><?php echo $nomor; ?></td>
                          <td><?php echo $daftar->nama_bahan; ?></td>
                          <td><?php echo $daftar->jumlah; ?></td>
                          <td><?php echo $daftar->harga_satuan; ?></td>
                          <td><?php echo $daftar->subtotal; ?></td>
                        </tr>
                        <?php 
                        @$total = $total + $daftar->subtotal;
                        @$nominal = $daftar->subtotal;
                        $nomor++; 
                      } 
                    }
                    else{
                      ?>
                      <tr>
                        <td><?php echo @$nomor; ?></td>
                        <td><?php echo @$daftar->nama_bahan; ?></td>
                        <td><?php echo @$daftar->jumlah; ?></td>
                        <td><?php echo @$daftar->harga_satuan; ?></td>
                        <td><?php echo @$daftar->subtotal; ?></td>
                      </tr>
                      <?php
                    }
                    ?>

                    <tr>
                      <td colspan="3"></td>
                      <td style="font-weight:bold;">Total Retur</td>
                      <td><?php echo @$total; ?></td>
                    </tr>

                    <tr>
                      <td colspan="3"></td>
                      <td style="font-weight:bold;">Nominal Retur</td>
                      <td><?php echo @$nominal; ?></td>
                    </tr>

                    <tr>
                      <td colspan="3"></td>
                      <td style="font-weight:bold;">Sisa</td>
                      <td><?php echo (@$total - @$nominal); ?></td>
                    </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>

                </table>
              </div>
            </div>

            <div class="tabel_tidak_sesuai">

              <div class="box-body">
                <label><h3><b>Item Retur</b></h3></label>
                <div class="gagal" ></div>
                <div class="notif" ></div>
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label>Jenis Bahan</label>
                    <select name="kategori_bahan" id="kategori_bahan" class="form-control" tabindex="-1" aria-hidden="true" readonly>
                      <option value="" selected="true">--Pilih Jenis Bahan--</option>
                      <option value="bahan baku">Bahan Baku</option>                     
                      <option value="bahan jadi">Bahan Jadi</option> 
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label>Nama Bahan</label>
                    <select id="kode_bahan" name="kode_bahan" class="form-control" readonly>
                      <option value="">Pilih Bahan</option>
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label>QTY</label>
                    <input type="text" class="form-control" placeholder="QTY" name="jumlah" id="jumlah" />
                  </div>

                  <div class="col-md-2">
                    <label>Satuan</label>
                    <input type="text" class="form-control" placeholder="Satuan Stok" name="nama_satuan" id="nama_satuan" readonly/>
                  </div>

                  <div class="col-md-2">
                    <label>Harga Satuan</label>
                    <input type="text" class="form-control" placeholder="Harga Satuan" name="harga_satuan" id="harga_satuan" readonly/>
                  </div>

                  <div class="col-md-2" style="padding:25px;" id="update_item">
                    <div onclick="update_item()"  class="btn btn-primary">Update</div>
                    <input type="hidden" name="id_item" id="id_item" />
                  </div>
                </div>
              </div>

              <div class="box-body">
                <table id="tabel_daftar" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama bahan</th>
                      <th>QTY</th>
                      <th>Harga Satuan</th>
                      <th width="100px">Subtotal</th>
                      <th width="100px">Action</th>
                    </tr>
                  </thead>
                  <tbody id="tabel_item_terima_retur">

                  </tbody>
                  <tfoot>
                  </tfoot>

                </table>
              </div>

            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <label>Keterangan</label>
                  <input class="form-control" name="keterangan" id="keterangan"  value="" required >
                </div>
              </div>

              <br>

              <div class="row">
                <div class="col-md-2">
                  <label>Status Retur</label>
                  <select name="status_retur" id="status_retur" class="form-control" tabindex="-1" aria-hidden="true">
                    <option value="" selected="true">--Pilih Status--</option>
                    <option value="sesuai">Sesuai</option>                     
                    <option value="tidak_sesuai">Tidak Sesuai</option> 
                  </select>
                  <input hidden="" name="kode_retur" id="kode_retur" value="<?php echo $this->uri->segment(4); ?>" >
                </div>
              </div>
              <br>

              <div class="simpan_sesuai">
                <div class="box-footer clearfix">
                  <div onclick="retur_sesuai()" class="btn btn-success pull-left">Simpan</div>
                </div>
              </div>

              <div class="simpan_tidak_sesuai">
                <div class="box-footer clearfix">
                  <div onclick="retur_tidak_sesuai()" class="btn btn-success pull-left">Simpan</div>
                </div>
              </div>

            </div>
          </div>

        </form>   
      </div>
    </div>
  </div>


  <script type="text/javascript">

  $(document).ready(function(){
  //  $("#tabel_daftar").dataTable();
  $(".tgl").datepicker();
  //$(".select2").select2();
  //begin();

  checking();

  $('.simpan_sesuai').hide();
  $('.simpan_tidak_sesuai').hide();
  $('.tabel_tidak_sesuai').hide();

  $("#status_retur").change(function(){
    var status_retur = $('#status_retur').val();
    if(status_retur=='sesuai'){
      $('.simpan_sesuai').show();
      $('.simpan_tidak_sesuai').hide();
      $('.tabel_tidak_sesuai').hide();
      $('.tabel_sesuai').show();
    }
    else if(status_retur=='tidak_sesuai'){
      $('.simpan_sesuai').hide();
      $('.simpan_tidak_sesuai').show();
      $('.tabel_sesuai').hide();
      $('.tabel_tidak_sesuai').show();
    }
    else{
      $('.simpan_sesuai').hide();
      $('.simpan_tidak_sesuai').hide();
      $('.tabel_sesuai').show();
      $('.tabel_tidak_sesuai').hide();
    }
  });

  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  $('#tabel_item_terima_retur').load("<?php echo base_url().'pembelian/retur/tabel_item_terima_retur/'; ?>"+kode_retur);
  
  $("#kategori_bahan").change(function(){
    var jenis_bahan = $(this).val();
    var url = "<?php echo base_url().'pembelian/retur/get_bahan'; ?>";
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
    var url = "<?php echo base_url() . 'pembelian/retur/get_satuan' ?>";
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

});

function checking() {
  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  var url_status = "<?php echo base_url().'pembelian/retur/cek_status_retur'; ?>";
  $.ajax({
    type: "POST",
    url: url_status,
    data: {kode_retur:kode_retur},
    success: function(status) {     
      if(status=='selesai'){
        alert("Proses Retur dengan kode "+ kode_retur +" telah selesai.");
        window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian'; ?>"; 
      }
      else{

      }         

    }
  });
}


function actEdit(id) {
  var id = id;
  var url = "<?php echo base_url().'pembelian/retur/get_item_terima_retur'; ?>";
  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: {id:id},
    success: function(pembelian){
      $('#kategori_bahan').val(pembelian.kategori_bahan);
            //$("#kode_bahan").empty();
            $('#kode_bahan').html("<option value="+pembelian.kode_bahan+" selected>"+pembelian.nama_bahan+"</option>");
            $('#nama_bahan').val(pembelian.nama_bahan);
            $('#jumlah').val(pembelian.jumlah);
            $('#kode_satuan').val(pembelian.kode_satuan);
            $('#nama_satuan').val(pembelian.nama_satuan);
            $('#harga_satuan').val(pembelian.harga_satuan);
            $('#tabel_item_terima_retur').load("<?php echo base_url().'pembelian/retur/tabel_item_terima_retur/'; ?>"+kode_retur);
            $('#id_item').val(id);
            $('#update_item').show(); 
          }
        });
}

function update_item(){
  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  var kategori_bahan = $('#kategori_bahan').val();
  var kode_bahan = $('#kode_bahan').val();
  var jumlah = $('#jumlah').val();
  var nama_satuan = $("#nama_satuan").val();
  var harga_satuan = $('#harga_satuan').val();
  var id = $('#id_item').val();
  var url = "<?php echo base_url().'pembelian/retur/ubah_item_terima_retur/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { 
      kode_retur:kode_retur,
      kategori_bahan:kategori_bahan,
      kode_bahan:kode_bahan,
      jumlah:jumlah,
      nama_satuan:nama_satuan,
      harga_satuan:harga_satuan,
      id:id
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $("#tabel_item_terima_retur").load("<?php echo base_url().'pembelian/retur/tabel_item_terima_retur/'; ?>"+kode_retur);
        $('#kategori_bahan').val('');
        $('#kode_bahan').val('');
        $('#jumlah').val('');
        $("#nama_satuan").val('');
        $('#harga_satuan').val('');
        $('#add_item').hide(); 
        $('#update_item').show();
        $('#id_item').val('');
      }
      else {
        $(".gagal").html(pesan);   
        setTimeout(function(){
          $('.gagal').html('');
        },1800);
      }
    }
  });
}

function retur_sesuai(){
  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  var keterangan = $("#keterangan").val();
  var url = "<?php echo base_url().'pembelian/retur/simpan_terima_retur/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_retur:kode_retur,
      keterangan:keterangan
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $(".notif").html(pesan);
        setTimeout(function(){$(".notif").html('');
          window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>";
        },1500);
      }
      else {
        $(".notif").html(pesan);   
        setTimeout(function(){
          $('.notif').html('');
        },1800);
      }               
    }
  });
}

function retur_tidak_sesuai(){
  var kode_retur = "<?php echo $this->uri->segment(4); ?>";
  var keterangan = $("#keterangan").val();
  var sisa_nominal = $("#sisa_nominal").val();
  var potongan = $("#potongan").val();
  var url = "<?php echo base_url().'pembelian/retur/simpan_terima_retur_tidak_sesuai/'?> ";

  $.ajax({
    type: "POST",
    url: url,
    data: { kode_retur:kode_retur,
      sisa_nominal:sisa_nominal,
      potongan:potongan,
      keterangan:keterangan
    },
    success: function(hasil)
    {
      var data = hasil.split("|");
      var num = data[0];
      var pesan = data[1];
      if(num==1){
        $(".notif").html(pesan);
        setTimeout(function(){$(".notif").html('');
          window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>";
        },1500);
      }
      else {
        $(".notif").html(pesan);   
        setTimeout(function(){
          $('.notif').html('');
        },1800);
      }               
    }
  });
}

</script>