<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stock Out
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
        <!-- <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_stok'; ?>"><i class="fa fa-list"></i> Bahan Baku </a>
        <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url().'stok/daftar_barang'; ?>"><i class="fa fa-list"></i> Barang </a> -->
        <div class="box-body">            
          <div class="sukses" ></div>
          <form id="data_form" method="post">
            <div class="box-body">            
              <div class="row">
               <div class="" id="">
                <div class="col-md-5 " id="">
                  <div class="input-group">
                    <span class="input-group-addon">Tanggal Awal</span>
                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                  </div>
                  <br>
                </div>
              </div>

              <div class=" " id="">
                <div class="col-md-6 " id="">
                  <div class="input-group">
                    <span class="input-group-addon">Tanggal Akhir</span>
                     <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                  </div>
                  <br>
                </div>                        
              </div>                      
              <div class="" id="">
                <div class="col-md-1 " id="">
                  <button style="width: 100px" type="button" class="btn btn-warning pull-right" id="cari"><i class="fa fa-search"></i> Cari</button>
                </div>
              </div>
            </div>
          </div>
        </form><br><br><br>
        <div id="cari_transaksi">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">
           <thead>
            <tr>
               <th>No</th>
              <th>Kode Stock Out</th>
              <th>Tanggal Transaksi</th>
              <th>Petugas</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="daftar_list_stock">  
          <?php 
            $get_transaksi_stok_out=$this->db->get('transaksi_stok_out');
            $hasil_get_transaksi_stok_out=$get_transaksi_stok_out->result();
            $no=1;
          foreach ($hasil_get_transaksi_stok_out as $list) { ?>
           
                     
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $list->kode_stok_out; ?></td>
            <td><?php echo tanggalIndo( $list->tanggal_input); ?></td>
            <td><?php echo $list->petugas ?></td>
            <td><a class="btn btn-primary" href="<?php echo base_url().'stok/detail_stok_out/'.$list->kode_stok_out ?>"><i class="fa fa-search"></i> Detail</a></td>
          </tr>
          <?php } ?> 
          </tbody>
          <tfoot>
          <tr>
               <th>No</th>
              <th>Kode Stock Out</th>
              <th>Tanggal Transaksi</th>
              <th>Petugas</th>
              <th>Action</th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>                
      </table>
      <br><br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br><br>
      <?php 
      $get_jumlah = $this->db->get('transaksi_stok_out');
      $jumlah = $get_jumlah->num_rows();
      $jumlah = floor($jumlah/100);
      ?>
      <input type="hidden" class="form-control rowcount" value="<?php echo $jumlah ?>">
      <input type="hidden" class="form-control pagenum" value="0">
    </div>
  </div>

  <!------------------------------------------------------------------------------------------------------>

</div>
</div>
</div><!-- /.col -->
</div>
</div>    
</div>  
<!-- /.content-wrapper -->
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
<script>
  $(document).ready(function(){
    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false
    });
    $('#opsi_filter').hide();
  });
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
      url: "<?php echo base_url() . 'stok/get_table_stok_out' ?>",
      data: ({page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#daftar_list_stock").append(msg);

      }
    });
  }


  function list_stock(){
    var kode_rak = $('#kode_rak').val();
    var kode_unit = $('#kode_unit').val();
    var url = "<?php echo base_url(). 'stok/stok/list_stock'; ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {kode_rak:kode_rak,kode_unit,kode_unit},
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg) {
                // alert(msg);
                $('#daftar_list_stock').html(msg);
              }
            });
  }
  $(".stok_min").css("background-color", "red");

  $('#kategori_filter').on('change',function(){
    var kategori_filter = $('#kategori_filter').val();

    var url = "<?php echo base_url() . 'stok/get_jenis_filter' ?>";
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

  $('#cari').click(function(){
    var tgl_awal =$("#tgl_awal").val();
    var tgl_akhir =$("#tgl_akhir").val();
    //alert(tgl_awal);


    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'stok/cari_stok_out'; ?>",  
      cache :false,

      data : {tgl_awal:tgl_awal,tgl_akhir:tgl_akhir},
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
  });
</script>