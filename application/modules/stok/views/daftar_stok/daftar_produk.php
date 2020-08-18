<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stok Produk
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
                <div class="col-md-5 " id="">
                  <button style="width: 100px" type="button" class="btn btn-warning " id="cari"><i class="fa fa-search"></i> Cari</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div id="cari_transaksi">
          <table class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">
           <thead>
            <tr>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
              <th>Nama Blok</th>
              <th align="right">Qty Stok</th>
              <!-- <th align="right">Stok Terkecil</th> -->
              <th align="right">Stok Min</th>
              <th>HPP</th>
              <th>Aset</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="daftar_list_stock">

            <?php

            $kode_default = $this->db->get('setting_gudang');
            $hasil_unit =$kode_default->row();
            $param=$hasil_unit->kode_unit;
            $this->db->limit(100);
            $get_stok = $this->db->get_where("master_bahan_baku", array('kode_unit' => $param));
            $hasil_stok = $get_stok->result_array();
            foreach ($hasil_stok as $item) {

              $kode_bahan = $item['kode_bahan_baku']; 
              $this->db->select_max('id');                       
              $get_kode_bahan = $this->db->get_where('transaksi_stok',array('kode_bahan'=>$kode_bahan,'jenis_transaksi'=>'pembelian'));
              $hasil_hpp_bahan = $get_kode_bahan->row();
              #echo $this->db->last_query();

              $get_hpp = $this->db->get_where('transaksi_stok',array('id'=>$hasil_hpp_bahan->id));
              $hasil_get_hpp = $get_hpp->row();

              $get_stok_min = $this->db->get_where('master_bahan_baku',array('id'=>$item['id']));
              $hasil_stok_min = $get_stok_min->row();
                                  //echo count($hasil_stok_min);
              ?>   
              <tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal or $item['status_view_opname'] =='Tidak Cukup'){echo'class="danger"';}?>>
                <td><?php echo $item['kode_bahan_baku'];?></td>
                <td><?php echo $item['nama_bahan_baku'];?></td>
                <td><?php echo $item['nama_rak'];?></td>
                <td align="right"> <!--<?php

                 $jumlah_stok =  round($item['real_stock'] / $item['jumlah_dalam_satuan_pembelian'],2);

                 $pecah_stok = explode(".", $jumlah_stok);
                 echo $pecah_stok[0];

                 ?>--> <?php echo $item['real_stock']; ?> <?php echo $item['satuan_stok'];
                 
                 ?>

               </td>
               <!-- <td align="right"><?php #if(@$pecah_stok[1]){ echo  @$pecah_stok[1]." ". $item['satuan_stok']; } else{ echo "-"; }    ;?></td> -->
               <td align="right"><?php echo $item['stok_minimal'];?> <?php echo $item['satuan_stok'];?></td>


               <td align="right"><?php echo format_rupiah($item['hpp']);?></td>
               <td align="right"><?php echo format_rupiah($item['hpp']*$item['real_stock']);?></td>
               <!--<td align="right"><?php echo format_rupiah(($item['real_stock'] <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item['real_stock']));?></td>-->
               <td align="center"><?php echo get_detail($item['id']); ?></td>
             </tr>

             <?php } ?>

           </tbody>
           <tfoot>
            <tr>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
              <th>Nama Blok</th>
              <th align="right">Qty Stok</th>
              <!-- <th align="right">Stok Terkecil</th> -->
              <th align="right">Stok Min</th>
              <th>HPP</th>
              <th>Aset</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>                
        </table>
        <br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br>
        <?php 
        $get_jumlah = $this->db->get_where('master_bahan_baku', array('kode_unit' => $param));
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
      url: "<?php echo base_url() . 'stok/get_table' ?>",
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

    var jenis_filter =$("#jenis_filter").val();
    var kategori_filter =$("#kategori_filter").val();


    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'stok/cari_stok'; ?>",  
      cache :false,

      data : {jenis_filter:jenis_filter,kategori_filter:kategori_filter},
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