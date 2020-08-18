
<div class="row">      

  <div class="col-xs-12">
    <!-- /.box -->
    <div class="portlet box blue">
      <div class="portlet-title">
        <div class="caption">
          Produk
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
          <div class="col-md-4">
            <div class="form-group">
              <label>By Kategori</label>
              <select class="form-control" id="kategori">
                <option value="" selected="true">--Pilih Kategori--</option>
                <?php
                $kategori = $this->db->get('master_kategori_menu');
                $hasil_kategori = $kategori->result();
                foreach($hasil_kategori as $daftar){


                  ?>
                  <option value="<?php echo $daftar->kode_kategori_menu; ?>"><?php echo $daftar->nama_kategori_menu; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control cari-nama" id="nama_produk" />
              </div>
            </div>
            <div class="col-md-3">
              <a onclick="cari_produk()" style="margin-top: 25px;" class="btn btn-md green-seagreen"><i class="fa fa-search"></i> Cari</a>

            </div>
            
          </div>
          <div class="row">
            <div class="col-md-2 pull-right">
              <a onclick="print_produk()" style="margin-top: 25px;" class="btn btn-md blue"><i class="fa fa-print"></i> Print</a>
              <a href="<?php echo base_url().'master/bahan_baku/export'?>" style="margin-top: 25px;" class="btn btn-md green-seagreen"><i class="fa fa-file-excel-o"></i> Export</a>
            </div>
          </div>
          <br>
          <div class="box-body">            
            <div class="sukses" ></div>
            <div id="hasil_cari">
              <table  class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">

                <?php
                $kode_default = $this->db->get('setting_gudang');
                $hasil_unit =$kode_default->row();
                $param=$hasil_unit->kode_unit;
                $this->db->limit(100);
                $bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
                $hasil_bahan_baku = $bahan_baku->result();
                ?>

                <thead>
                  <tr width="100%">
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th style="display:none;">Kategori Produk</th>
                    <th>Unit</th>
                    <th>Block</th>
                    <th>HPP</th>
                    <th>Harga Jual 1</th>
                    <th>Harga Jual 2</th>
                    <th>Harga Jual 3</th>
                    <th>Harga Beli</th>
                    <th>Satuan Pembelian</th>
                    <th>Satuan Stok</th>
                    <th style="width:50px;display:none;">Isi Dalam 1 <br>(Satuan Pembelian)</th>
                    <th>Stok Minimal</th>
                    <th>Real Stock</th>
                    <th>Supplier</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody style="width: 700px;" id="posts">
                  <?php
                  $nomor=1;
                  foreach($hasil_bahan_baku as $daftar){

                // $opsi_bahan_baku = $this->db->get_where('opsi_bahan_baku',array('kode_bahan_baku' => $daftar->kode_bahan_baku));
                // $hasil_opsi_bahan_baku = $opsi_bahan_baku->row();

                    ?>
                    <tr class="table_bahan" id="table_bahan_<?php echo $nomor; ?>" key="<?php echo $nomor; ?>">
                      <td><?php echo $nomor; ?></td>
                      <td><?php echo $daftar->kode_bahan_baku; ?></td>
                      <td width="500px"><?php echo $daftar->nama_bahan_baku; ?></td>
                      <td style="display:none;"><?php echo $daftar->nama_kategori_produk; ?></td>
                      <td><?php echo $daftar->nama_unit; ?></td>
                      <td><?php echo $daftar->nama_rak; ?></td>
                      <td align="right">
                        <?php echo format_rupiah($daftar->hpp); ?>
                      </td>
                      <td align="right">
                        <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                          <input type="hidden" class="form-control" value="<?php echo $daftar->id; ?>" id="id_<?php echo $nomor; ?>">
                          <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_1; ?>" id="hj1_<?php echo $nomor; ?>">
                        </div>
                        <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj1_<?php echo $nomor; ?>">
                          <?php echo format_rupiah($daftar->harga_jual_1); ?>
                        </div>
                      </td>
                      <td align="right">
                        <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                          <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_2; ?>" id="hj2_<?php echo $nomor; ?>">
                        </div>
                        <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj2_<?php echo $nomor; ?>">
                          <?php echo format_rupiah($daftar->harga_jual_2); ?>
                        </div>
                      </td>
                      <td align="right">
                        <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                          <input type="text" class="form-control" value="<?php echo $daftar->harga_jual_3; ?>" id="hj3_<?php echo $nomor; ?>">
                        </div>
                        <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>" id="thj3_<?php echo $nomor; ?>">
                          <?php echo format_rupiah($daftar->harga_jual_3); ?>
                        </div>
                      </td>
                      <td align="right"><?php echo format_rupiah($daftar->harga_beli_akhir); ?></td>
                      <td><?php echo $daftar->satuan_pembelian; ?></td>
                      <td><?php echo $daftar->satuan_stok; ?></td>
                      <td style="display:none;"><?php echo $daftar->jumlah_dalam_satuan_pembelian; ?></td>
                      <td><?php echo $daftar->stok_minimal; ?></td>
                      <td><?php echo $daftar->real_stock; ?></td>
                      <td><?php echo $daftar->nama_supplier; ?></td>
                      <td>
                        <div class="edit_bahan edit_bahan_<?php echo $nomor; ?>">
                          <button key="<?php echo $nomor; ?>" data-toggle="tooltip" title="Simpan" class="btn btn-circle blue simpan_hj"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <div class="normal_bahan normal_bahan_<?php echo $nomor; ?>">
                          <?php echo get_detail_edit_delete_string($daftar->id); ?>
                        </div>
                      </td>
                    </tr>
                    <?php $nomor++; } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                     <th>No</th>
                     <th>Kode Produk</th>
                     <th>Nama Produk</th>
                     <th style="display:none;">Kategori Produk</th>
                     <th>Unit</th>
                     <th>Block</th>
                     <th>HPP</th>
                     <th>Harga Jual 1</th>
                     <th>Harga Jual 2</th>
                     <th>Harga Jual 3</th>
                     <th>Harga Beli</th>
                     <th>Satuan Pembelian</th>
                     <th>Satuan Stok</th>
                     <th style="width:50px;display:none;">Isi Dalam 1 <br>(Satuan Pembelian)</th>
                     <th>Stok Minimal</th>
                     <th>Real Stock</th>
                     <th>Supplier</th>
                     <th>Action</th>
                   </tr>
                 </tfoot>
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


<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:grey">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" style="color:#fff;">Konfirmasi Hapus Data</h4>
      </div>
      <div class="modal-body">
        <span style="font-weight:bold; font-size:12pt">Apakah anda yakin akan menghapus data Produk tersebut ?</span>
        <input id="id-delete" type="hidden">
      </div>
      <div class="modal-footer" style="background-color:#eee">
        <button class="btn red" data-dismiss="modal" aria-hidden="true">Tidak</button>
        <button onclick="delData()"  class="btn green">Ya</button>
      </div>
    </div>
  </div>
</div>
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
    window.location = "<?php echo base_url().'master/produk/'; ?>";
  });
</script>

<script>
  $(window).scroll(function(){
    if (Math.floor($(window).scrollTop()) == ($(document).height() - $(window).height())){
      if(parseInt($(".pagenum").val()) <= parseInt($(".rowcount").val())) {
        var pagenum = parseInt($(".pagenum").val()) + 1;
        $(".pagenum").val(pagenum);
      //$(window).scrollTop(200);
      load_table(pagenum);
    }
  }
});

  function load_table(page){
    var kategori = $("#kategori").val();
    var nama_produk = $("#nama_produk").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'master/bahan_baku/get_table' ?>",
      data: ({kategori: kategori,nama_produk:nama_produk, page:$(".pagenum").val()}),
      beforeSend: function(){
        $(".tunggu").show();  
      },
      success: function(msg)
      {
        $(".tunggu").hide();
        $("#posts").append(msg);
        $('.edit_bahan').hide();
        $('.normal_bahan').show();
        $('.table_bahan').on('dblclick', function(event) {
          $(this).addClass('danger');
          key = $(this).attr('key');
          $('.edit_bahan').hide();
          $('.normal_bahan').show();
          $('.edit_bahan_'+key).show();
          $('.normal_bahan_'+key).hide();
        });
        $('.simpan_hj').on('click', function(event) {
          $('.table_bahan').removeClass('danger');
          key = $(this).attr('key');
          id = $("#id_"+key).val();
          harga_jual_1 = $("#hj1_"+key).val();
          harga_jual_2 = $("#hj2_"+key).val();
          harga_jual_3 = $("#hj3_"+key).val();
          $.ajax({
            url: '<?php echo base_url().'master/bahan_baku/edit_harga_jual'; ?>',
            type: 'POST',
            data: {id:id,harga_jual_1:harga_jual_1,harga_jual_2:harga_jual_2,harga_jual_3:harga_jual_3},
            dataType: 'JSON',
            success: function(data) {
              $('.edit_bahan').hide();
              $('.normal_bahan').show();
              $("#hj1_"+key).val(data.harga_jual_1);
              $("#thj1_"+key).text(toRp(data.harga_jual_1));
              $("#hj2_"+key).val(data.harga_jual_2);
              $("#thj2_"+key).text(toRp(data.harga_jual_2));
              $("#hj3_"+key).val(data.harga_jual_3);
              $("#thj3_"+key).text(toRp(data.harga_jual_3));
              $('#table_bahan_'+key).addClass('success')
              setTimeout(function(){$('#table_bahan_'+key).removeClass('success');},2000);
            }
          });
        });
      }
    });
  }
  function actDelete(Object) {
    $('#id-delete').val(Object);
    $('#modal-confirm').modal('show');
  }

  function print_produk() {
    window.open("<?php echo base_url() . 'master/bahan_baku/print_produk' ?>");
  }


  function delData() {
    var id = $('#id-delete').val();
    var url = '<?php echo base_url().'master/bahan_baku/hapus'; ?>/delete';
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
            // alert(id);
            window.location.reload();
          }
        });
    return false;
  }

  function cari_produk(){
    var kategori = $("#kategori").val();
    var nama_produk = $("#nama_produk").val();
    var url = '<?php echo base_url().'master/bahan_baku/get_produk'; ?>';
    $.ajax({
      type: "POST",
      url: url,
      data: {
        kategori: kategori,nama_produk:nama_produk
      },
      beforeSend:function(){
        $(".tunggu").show();  
      },
      success: function(msg) {
        $("#hasil_cari").html(msg);
        $(".tunggu").hide();
        $('.edit_bahan').hide();
        $('.normal_bahan').show();
      }
    });

  }
  $("#nama_produk").keydown(function(){
    if (event.which == 13) {
      cari_produk();
    }
  });

  $(document).ready(function() {

    $("#tabel_daftar").dataTable({
      "paging":   false,
      "ordering": true,
      "info":     false
    });

  });
  $('.simpan_hj').on('click', function(event) {
    $('.table_bahan').removeClass('danger');
    key = $(this).attr('key');
    id = $("#id_"+key).val();
    harga_jual_1 = $("#hj1_"+key).val();
    harga_jual_2 = $("#hj2_"+key).val();
    harga_jual_3 = $("#hj3_"+key).val();
    $.ajax({
      url: '<?php echo base_url().'master/bahan_baku/edit_harga_jual'; ?>',
      type: 'POST',
      data: {id:id,harga_jual_1:harga_jual_1,harga_jual_2:harga_jual_2,harga_jual_3:harga_jual_3},
      dataType: 'JSON',
      success: function(data) {
        $('.edit_bahan').hide();
        $('.normal_bahan').show();
        $("#hj1_"+key).val(data.harga_jual_1);
        $("#thj1_"+key).text(toRp(data.harga_jual_1));
        $("#hj2_"+key).val(data.harga_jual_2);
        $("#thj2_"+key).text(toRp(data.harga_jual_2));
        $("#hj3_"+key).val(data.harga_jual_3);
        $("#thj3_"+key).text(toRp(data.harga_jual_3));
        $('#table_bahan_'+key).addClass('success')
        setTimeout(function(){$('#table_bahan_'+key).removeClass('success');},3000);
      }
    });
  });
  $('.table_bahan').on('dblclick', function(event) {
    $(this).addClass('danger');
    key = $(this).attr('key');
    $('.edit_bahan').hide();
    $('.normal_bahan').show();
    $('.edit_bahan_'+key).show();
    $('.normal_bahan_'+key).hide();
  });
  $(document).ready(function(){
    $('.edit_bahan').hide();
    $('.normal_bahan').show();
  });
  function toRp(angka){
    if(angka==''){
      angka = 0;
    }
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
      rev2  += rev[i];
      if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
        rev2 += '.';
      }
    }
    return 'Rp ' + rev2.split('').reverse().join('') + ',00';
  }
</script>
