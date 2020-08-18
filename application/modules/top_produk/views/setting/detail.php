<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Detail Pemasukan

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
          <form id="data_form"  method="post">
                                <?php
                                    $uri = $this->uri->segment(3);
                                    if(!empty($uri)){
                                        $data = $this->db->get_where('keuangan_masuk',array('id'=>$uri));
                                        $hasil_data = $data->row();
                                    }
                                ?>
                                <!--<div class="form-group  col-xs-5">
                                  <label>ID Member</label>
                                  <input type="text" class="form-control" name="id_member" readonly="" />
                                </div>-->
                              <div class="row">
                                <input type="hidden" name="id" value="<?php echo @$hasil_data->id ?>" />

                                <div class="form-group  col-xs-5">
                                  <label class="gedhi"><b>Kategori</label>
                                  <?php
                                    $kategori = $this->db->get('keuangan_kategori_akun');
                                    $hasil_kategori = $kategori->result();
                                  ?>
                                  <select class="form-control select2" name="kode_kategori_keuangan" id="kode_kategori_akun" required="" disabled="">
                                    <option selected="true" value="">--Pilih Kategori--</option>
                                    <?php foreach($hasil_kategori as $daftar){ ?>
                                    <option <?php if(@$hasil_data->kode_kategori_keuangan==@$daftar->kode_kategori_akun){ echo "selected"; } ?> value="<?php echo @$daftar->kode_kategori_akun; ?>" ><?php echo @$daftar->nama_kategori_akun; ?></option>
                                    <?php } ?>
                                  </select> 

                                  <input type="hidden" id="nama_kategori_akun" name="nama_kategori_keuangan" value="<?php echo @$hasil_data->nama_kategori_akun ?>" />
                                </div>

                                <div class="form-group  col-xs-5">
                                  <label class="gedhi"><b>Sub Kategori</label>
                                  <?php
                                    $kategori = $this->db->get('keuangan_sub_kategori_akun');
                                    $hasil_kategori = $kategori->result();
                                  ?>
                                  <select class="form-control select2" name="kode_sub_kategori_keuangan" id="kode_sub_kategori_akun" required="" disabled="">
                                    <option selected="true" value="">--Pilih Sub Kategori--</option>
                                    <?php foreach($hasil_kategori as $daftar){ ?>
                                    <option <?php if(@$hasil_data->kode_sub_kategori_keuangan==@$daftar->kode_sub_kategori_akun){ echo "selected"; } ?> value="<?php echo @$daftar->kode_sub_kategori_akun; ?>" ><?php echo @$daftar->nama_sub_kategori_akun; ?></option>
                                    <?php } ?>
                                  </select> 

                                  <input type="hidden" id="nama_sub_kategori_akun" name="nama_sub_kategori_keuangan" value="<?php echo @$hasil_data->nama_sub_kategori_keuangan ?>" />

                                  <input type="hidden" id="kode_jenis_akun" name="kode_jenis_keuangan" value="<?php echo @$hasil_data->kode_jenis_akun ?>" />

                                  <input type="hidden" id="nama_jenis_akun" name="nama_jenis_keuangan" value="<?php echo @$hasil_data->nama_jenis_akun ?>" />

                                </div>
                                
                                <div class="col-md-5">
                                        <label><b>Nominal</label>
                                        <input type="text"  class="form-control" value="<?php echo format_rupiah(@$hasil_data->nominal) ?>" name="nominal" id="nominal" readonly required="">
                                </div>

                                <div class="col-md-5">
                                      <h3><div id="rupiah"></div></h3>
                                </div>

                              </div>
                              <br><br>
                              <div class="row">
                                <div class="col-md-9">
                                        <label><b>Keterangan</label>
                                        <input class="form-control" value="<?php echo @$hasil_data->keterangan ;?>" name="keterangan" id="keterangan" required="" readonly></input>
                                </div>
                              </div>
                              <br>
                            </form>
        </div>
      </div>
    </div>
  </div>
</div>
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
<!------------------------------------------------------------------------------------------------------>



<script type="text/javascript">
  $(document).ready(function(){

    $("#edit_opsi_penjualan_temp").hide();

    $("#data_form").submit( function() {    
      $.ajax( {  
        type :"post",
        url : "<?php echo base_url() . 'pembelian_barang/simpan_transaksi' ?>", 
        cache :false,  
        data :$(this).serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $(".sukses").html(data);   
          setTimeout(function(){$('.sukses').html('');window.location = "<?php echo base_url() . 'pembelian_barang/daftar' ?>";},1500);              
        }  

      });
      return false;                          
    });
  });

  $("#insert_opsi_penjualan_temp").click(function() {
    var kode_transaksi = $("#kode_transaksi").val();
    var supplier = $("#supplier").val();
    var barang = $("#barang").val();
    var qty = $("#qty").val();
    var harga_satuan = $("#harga_satuan").val();
    var position = $("#position").val();
    if(barang!="" && qty!="" && harga_satuan!=""){
      $.ajax( {  
        type :"post",
        url : "<?php echo base_url() . 'pembelian_barang/insert_opsi_penjualan_temp' ?>",  
        cache :false,  
        data :({kode_transaksi:kode_transaksi, barang:barang, qty:qty, harga_satuan:harga_satuan, supplier:supplier, position:position}),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $("#tabel_temp_data_transaksi").html(data);
          $("#qty").val('');
          $("#harga_satuan").val('');

          supplier = $("#supplier").val()
          $.ajax( {  
            type :"post",
            url : "<?php echo base_url() . 'pembelian_barang/get_barang' ?>",  
            cache :false,  
            data :({supplier:supplier}),
            beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
              $("#barang").html(data);
            }  

          });
        }  

      });
    }
    return false;
  });

  $("#edit_opsi_penjualan_temp").click(function() {
    var id = $("#id_item").val();
    var kode_transaksi = $("#kode_transaksi").val();
    var supplier = $("#supplier").val();
    var barang = $("#barang").val();
    var qty = $("#qty").val();
    var harga_satuan = $("#harga_satuan").val();
    var position = $("#position").val();
    if(barang!="" && qty!="" && harga_satuan!=""){
      $.ajax( {  
        type :"post",
        url : "<?php echo base_url() . 'pembelian_barang/edit_opsi_penjualan_temp' ?>",  
        cache :false,  
        data :({id:id, kode_transaksi:kode_transaksi, barang:barang, qty:qty, harga_satuan:harga_satuan, supplier:supplier, position:position}),
        beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
          $("#tabel_temp_data_transaksi").html(data);
          $("#qty").val('');
          $("#harga_satuan").val('');

          supplier = $("#supplier").val()
          $.ajax( {  
            type :"post",
            url : "<?php echo base_url() . 'pembelian_barang/get_barang' ?>",  
            cache :false,  
            data :({supplier:supplier}),
            beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
              $("#barang").html(data);
            } 
          });
          $("#edit_opsi_penjualan_temp").hide();
          $("#insert_opsi_penjualan_temp").show();
        }  

      });
    }
    return false;
  });

  function delData() {
    var kode_transaksi = $("#kode_transaksi").val();
    $.ajax( {  
      type :"post",  
      url :"<?php echo base_url() . 'pembelian_barang/delete_opsi_penjualan_temp' ?>",  
      cache :false,  
      data :({key:$('#id-delete').val(), kode_transaksi:kode_transaksi}),
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) { 
        $("#tabel_temp_data_transaksi").html(data);
        $('#modal-confirm').modal('hide');      
      },  
      error : function() {  
        alert("Data gagal dihapus.");  
      }  
    });
    return false;

  }


  $("#supplier").change(function() {
    supplier = $("#supplier").val()
    $.ajax( {  
      type :"post",
      url : "<?php echo base_url() . 'pembelian_barang/get_barang' ?>",  
      cache :false,  
      data :({supplier:supplier}),
      beforeSend:function(){
          $(".tunggu").show();  
        },
 success : function(data) {  
        $("#barang").html(data);
      }  

    });
    return false;
  });

  $("#qty").keypress(function() {
    return hanyaAngka(event);
  });

  $("#diskon_rupiah").keypress(function() {
    return hanyaAngka(event);
  });

  $("#diskon_rupiah").keyup(function() {

    //diskon persen

    diskon = ($("#diskon_rupiah").val()/$("#grand_total").val()) * 100;
    $("#tb_diskon").text(diskon.toFixed(2) + " %");
    $("#persen").val(diskon.toFixed(2));

    //grand total

    grand_total = $("#grand_total").val() - $("#diskon_rupiah").val();
    var angka = grand_total;
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      $("#tb_grand_total").text('Rp. ' + rupiah.split('',rupiah.length-1).reverse().join('') + ',00');
    $("#grand_total_fix").val(grand_total);

    //diskon rupiah

    var angka_diskon = $("#diskon_rupiah").val();
    var rupiah_diskon = '';
    var angkarev_diskon = angka_diskon.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev_diskon.length; i++) if(i%3 == 0) rupiah_diskon += angkarev_diskon.substr(i,3)+'.';
      $("#tb_diskon_rupiah").text('Rp. ' + rupiah_diskon.split('',rupiah_diskon.length-1).reverse().join('') + ',00');

  });

  $("#persen").keypress(function() {
    return hanyaAngka(event);
  });

  $("#persen").keyup(function() {

    //total

    hitung = $("#grand_total").val() - Math.round($("#grand_total").val() * $("#persen").val() / 100);
    diskon = Math.round($("#grand_total").val() * $("#persen").val() / 100);
    var angka = hitung;
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      $("#tb_grand_total").text('Rp. ' + rupiah.split('',rupiah.length-1).reverse().join('') + ',00');
    $("#grand_total_fix").val(hitung);

    //diskon rupiah

    $("#diskon_rupiah").val(diskon);
    var angka_diskon = diskon;
    var rupiah_diskon = '';
    var angkarev_diskon = angka_diskon.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev_diskon.length; i++) if(i%3 == 0) rupiah_diskon += angkarev_diskon.substr(i,3)+'.';
      $("#tb_diskon_rupiah").text('Rp. ' + rupiah_diskon.split('',rupiah_diskon.length-1).reverse().join('') + ',00');

    //diskon persen

    $("#tb_diskon").text($("#persen").val() + " %");

  });

  $("#dibayar").keypress(function() {
    return hanyaAngka(event);
  });

  $("#dibayar").keyup(function() {
    var angka = $("#dibayar").val();
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      $("#nilai_dibayar").text('Rp. ' + rupiah.split('',rupiah.length-1).reverse().join('') + ',-');
  });

  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }

  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }
  
  function actEdit(id) {
    var id = id;
    var kode_pembelian = $('#kode_pembelian').val();
    var url = "<?php echo base_url().'pembelian_barang/get_temp_pembelian'; ?>";
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      data: {id:id},
      success: function(pembelian){
        $('#barang').html("<option value="+pembelian.kode_bahan+" selected='true'>"+pembelian.nama_bahan+"</option>");
        $("#nama_bahan").val(pembelian.nama_bahan);
        $('#qty').val(pembelian.jumlah);
        $('#harga_satuan').val(pembelian.harga_satuan);
        $('#kode_supplier').val(pembelian.kode_supplier);
        $("#id_item").val(pembelian.id);
        $("#edit_opsi_penjualan_temp").show();
        $("#insert_opsi_penjualan_temp").hide();
      }
    });
  }

</script>

