<?php 
  $this->db->truncate('printer_barcode');
 ?>
<div class="row">      
  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Printer Barcode
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

        <div class="row"> 

          <div class="col-md-12">

            <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'spoil/tambah_spoil/'; ?>"><i class="fa fa-edit"></i> Tambah </a> -->

            <div class="box-body">            
              <div class="sukses" ></div>
              

              <form id="data_form" method="post">
                <div class="box-body">            
                  <div class="row">
                   <div class="col-md-10 " id="">
                    <div class="col-md-5 " id="">
                      <div class="input-group">
                        <span class="input-group-addon">Filter</span>
                        <select class="form-control" id="kategori_filter">
                          <option value="">- PILIH Filter -</option>
                          <option value="kategori">Kategori Produk</option>
                          <option value="blok">Blok</option>
                        </select>
                      </div>
                      <br>
                    </div>
                  </div>

                  <div class="col-md-10 " id="opsi_filter">
                    <div class="col-md-5 " id="">
                      <div class="input-group">
                        <span class="input-group-addon">Filter By</span>
                        <select class="form-control" id="jenis_filter">
                          <option value="">- PILIH Filter -</option>

                        </select>
                      </div>
                      <br>
                    </div>                        
                  </div>  


                  <div class="col-md-10 " id="opsi_filter">

                    <div class="col-md-5" id="">
                      <div class="input-group">
                        <span class="input-group-addon">Nama Produk</span>
                        <input type="text" class="form-control" id="nama_produk">
                      </div>
                      <br>
                    </div>          
                  </div>  



                  <div class="col-md-10 " id="opsi_filter">
                    <div class="col-md-5 " id="">
                      <button style="width: 100px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
                    </div>
                  </div>
                </div>
              </div>
            </form><br><br><br>
            <div class="col-md-12 row" id="cari_transaksi">
              <form method="post" id="opsi_produk">
               <?php
               $this->db->select_max('id');
               $get_max_mo = $this->db->get('printer_barcode');
               $max_mo = $get_max_mo->row();

               $this->db->where('id', $max_mo->id);
               $get_mo = $this->db->get('printer_barcode');
               $mo = $get_mo->row();
               $nomor = substr(@$mo->kode_obat, 2);
               $nomor = $nomor + 1;
               $string = strlen($nomor);
               if($string == 1){
                $kode = 'B_000'.$nomor;
              } else if($string == 2){
                $kode = 'B_00'.$nomor;
              } else if($string == 3){
                $kode = 'B_00'.$nomor;
              } else if($string == 4){
                $kode = 'B_'.$nomor;
              }
              ?>
              <input type="hidden" name="kode_trans" id="kode_trans" value="<?php echo $kode ?>">
              <a style="padding:13px; margin-bottom:10px; margin-right:0px;"  id="barcode_produk" class="btn btn-app green pull-right" ><i class="fa fa-barcode"></i> Barcode </a>
              <table class="table table-striped table-hover table-bordered" id="tabel_daftarr" style="font-size:1.5em;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Nama Blok</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="table_bahan_baku">
                  <?php
                  $kode_default = $this->db->get('setting_gudang');
                  $hasil_unit =$kode_default->row();
                  $param =$hasil_unit->kode_unit;
                  $this->db->limit(100);
                  $spoil = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
                  $list_spoil = $spoil->result();
                  $nomor = 1;  

                  foreach($list_spoil as $daftar){ 
                    ?> 
                    <tr>
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $daftar->nama_bahan_baku; ?></td>
                      <td><?php echo $daftar->real_stock.' '.$daftar->satuan_stok; ?></td>
                      <td><?php echo $daftar->nama_rak; ?></td>
                      <td align="center"><input name="opsi_produk[]" type="checkbox"  id="opsi_pilihan" value="<?php echo $daftar->kode_bahan_baku; ?>"></td>
                    </tr>
                    <?php 
                    $nomor++; 
                  } 
                  ?>

                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Nama Blok</th>
                    <th>Action</th>
                  </tr>
                </tfoot>            
              </table>
              <input type="hidden" name="kode_unit" id="kode_unit" value="<?php echo $param ?>">

              <br><br><br><br><br><br><br><br>
              <br><br><br><br><br><br><br><br>
            </form>
          </div>
          <div class="row" id="" style="height:100px">
            <?php 
            $get_jumlah = $this->db->get_where('master_bahan_baku', array('kode_unit' => $param));
            $jumlah = $get_jumlah->num_rows();
            $jumlah = floor($jumlah/100);
            ?>
            <input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
            <input type="hidden" class="form-control pagenum" value="0">

            <!-- <button type="button" class="btn btn-success btn-block pull-right" id="spoil_tambah"><font size="6"><b>SPOIL</b></font></button> -->
          </div>  
        </div>
      </div>
      <!------------------------------------------------------------------------------------------------------>

    </div>
  </div>
</div><!-- /.col -->
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
        <span style="font-weight:bold; font-size:14pt">Apakah anda yakin akan menghapus data menu tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn green" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()" class="btn red">Ya</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'component/lib/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'component/lib/zebra_datepicker.js'?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'component/lib/css/default.css'?>"/>
<script type="text/javascript">

  $(window).scroll(function(){
    if (Math.round($(window).scrollTop()) == ($(document).height() - $(window).height())){
      if(parseInt($(".pagenum").val()) <= parseInt($(".rowcount").val())) {
        var pagenum = parseInt($(".pagenum").val()) + 1;
        $(".pagenum").val(pagenum);
        load_table(pagenum);
      }
    }
  });

  function load_table(page){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'master/printer_barcode/get_table' ?>",
      data: ({page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#table_bahan_baku").append(msg);

      }
    });
  }
  
  $('#kategori_filter').on('change',function(){
    var kategori_filter = $('#kategori_filter').val();

    var url = "<?php echo base_url() . 'master/printer_barcode/get_jenis_filter' ?>";
    $.ajax({
      type: 'POST',
      url: url,
      data: {kategori_filter:kategori_filter},
      success: function(msg){
        $('#jenis_filter').html(msg);
        $('#opsi_filter').show();
      }
    });
  });

  $('.tgl').Zebra_DatePicker({});

  $('#barcode_produk').click(function(){
    checkedValue = $('#opsi_pilihan:checked').val();
    if(!checkedValue){
      alert("Pilih Barang Yang Akan Di Barcode");
    } else {
      $.ajax( {  
        type :"post",  
        url : "<?php echo base_url().'master/printer_barcode/simpan_barcode_temp'; ?>",  
        cache :false,
        data : $("#opsi_produk").serialize(),
        beforeSend:function(){
          $(".tunggu").show();  
        },
        success : function(data) {
          $(".tunggu").hide();
          var kode_trans =$("#kode_trans").val();
          window.open("<?php echo base_url().'master/printer_barcode/print_barcode/'; ?>"+kode_trans);
          window.location.reload();
        },  
        error : function(data) {
        }  
      });
    }

  });




  $('#cari').click(function(){

    var jenis_filter =$("#jenis_filter").val();
    var kategori_filter =$("#kategori_filter").val();
    var nama_produk =$("#nama_produk").val();


    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'master/printer_barcode/cari_produk'; ?>",  
      cache :false,

      data : {jenis_filter:jenis_filter,kategori_filter:kategori_filter,nama_produk:nama_produk},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  

       $("#cari_transaksi").html(data);
     },  
     error : function(data) {  
         // alert("das");  
       }  
     });


    $('#jenis_filter').val('');
    $('#kategori_filter').val('');
    $('#opsi_filter').hide();

  });

</script>
<script>
  $(document).ready(function(){
    $("#opsi_filter").hide();

    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false
    });
    kosongkan_barcode();
  });

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
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg) {
        $('#modal-confirm').modal('hide');
        window.location.reload();
      }
    });
    return false;
  }
  function kosongkan_barcode() {

    var url = '<?php echo base_url().'master/printer_barcode/kosongkan_barcode';?>';
    $.ajax({
      type: "POST",
      url: url,
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg) {
        $(".tunggu").hide();  

      }
    });
    return false;
  }

</script>
