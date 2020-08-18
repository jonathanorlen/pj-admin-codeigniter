<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Stok Produk Minimal
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
          <!-- <form id="data_form" method="post">
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
        </form> -->
        <form id="data_stok_min">
          <div id="cari_transaksi">
            <table class="table table-striped table-hover table-bordered" id="tabel_daftar"  style="font-size:1.5em;">
             <thead>
              <tr>
                <th>No.</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Nama Blok</th>
                <th align="right">Real Stok</th>
                <th align="right">Stok Min</th>
                <th>HPP</th>
                <th>Aset</th>
                <th>Supplier</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="daftar_list_stock">

              <?php

              $kode_default = $this->db->get('setting_gudang');
              $hasil_unit =$kode_default->row();
              $param=$hasil_unit->kode_unit;
             //$kode_unit =$this->uri->segment(3);
            // $get_rak = $this->db->get_where('master_rak',array('kode_unit' => $kode_unit));
            // $hasil_rak = $get_rak->row();

              $get_stok = $this->db->query("SELECT * from master_bahan_baku where kode_unit='$param' and (real_stock <= stok_minimal or  status_view_opname='Tidak Cukup') ");
              $hasil_stok = $get_stok->result_array();
              $no=1;
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
                <tr <?php if($item['real_stock']<=$hasil_stok_min->stok_minimal or $item['status_view_opname']=='Tidak Cukup'){echo'class="danger"';}?>>
                  <td><?php echo $no++;?></td>
                  <td><?php echo $item['kode_bahan_baku'];?></td>
                  <td><?php echo $item['nama_bahan_baku'];?></td>
                  <td><?php echo $item['nama_rak'];?></td>
                  <td align="right"><?php echo $item['real_stock'];?> <?php echo $item['satuan_stok'];?></td>
                  <td align="right"><?php echo $item['stok_minimal'];?> <?php echo $item['satuan_stok'];?></td>


                  <td align="right"><?php echo format_rupiah($item['hpp']);?></td>
                  <td align="right"><?php echo format_rupiah($item['hpp']*$item['real_stock']);?></td>
                  <!--<td><?php echo format_rupiah(($item['real_stock'] <= 0) ? (@$hasil_get_hpp->hpp * 0) : (@$hasil_get_hpp->hpp * $item['real_stock']));?></td>-->
                  <td><?php echo @$item['nama_supplier'];?></td>
                  <td align="center"><input type="checkbox" id="opsi_pilihan" name="bahan_stokmin[]" value="<?php echo $item['kode_bahan_baku']; ?>"></td>
                </tr>

                <?php } ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th>Nama Blok</th>
                  <th align="right">Real Stok</th>
                  <th align="right">Stok Min</th>
                  <th>HPP</th>
                  <th>Aset</th>
                  <th>Supplier</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>

              </tbody>                
            </table>

          </div>

        </form>
        <div class="row">
          <a style="padding:13px; margin-bottom:10px; margin-right:15px;" id="po" class="btn btn-app green pull-right" ><i class="fa fa-edit"></i> PO </a>
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
  })


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

    var url = "<?php echo base_url() . 'stok/stok/get_jenis_filter' ?>";
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
      url : "<?php echo base_url().'stok/stok/cari_stok'; ?>",  
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

  });
  $('#po').click(function(){


    $.ajax( {  
      type :"post",  
      url : "<?php echo base_url().'stok/stok/simpan_po_stokmin_temp'; ?>",  
      cache :false,

      data :$('#data_stok_min').serialize(),
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success : function(data) {
       $(".tunggu").hide();  
       window.location = "<?php echo base_url() . 'pre_order/pendaftaran/' ; ?>";

     },  
     error : function(data) {  
         // alert("das");  
       }  
     });
  });
</script>