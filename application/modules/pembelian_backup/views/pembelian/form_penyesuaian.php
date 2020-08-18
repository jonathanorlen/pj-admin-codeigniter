<?php
if(@$id){
  $get_produk = $this->db->get_where('opsi_transaksi_penjualan',array('id'=>$id));
  $hasil_get = $get_produk->row();
}
?>
<div class="box-body">
  <div class="row">
    <div class="col-md-12">

      <div class="col-md-4">
        <label>Nama Produk</label>
        <input readonly="true" type="text" class="form-control" value="<?php echo $hasil_get->nama_menu; ?>" placeholder="QTY" name="nama_product" id="nama_product" />
        <input type="hidden" class="form-control" value="<?php echo $hasil_get->kode_menu; ?>" name="kode_menu" id="kode_menu" />
        <input type="hidden" class="form-control" value="<?php echo $hasil_get->kode_penjualan; ?>" name="kode_penjualan" id="kode_penjualan" />
        <input type="hidden"  value="<?php echo $hasil_get->id; ?>" name="id" id="id" />
      </div>

     
      <div class="col-md-3">
        <label>QTY Retur</label>
        <input type="text" class="form-control" placeholder="QTY" name="qty_retur" id="qty_retur" value=""/>
      </div>
     
    
      <div style="margin-top: 25px;" class="col-md-2">
        <a onclick="update_item()" class="btn btn-primary">Simpan</a>
      </div>

    </div>
  </div>
</div>
<script>
  $(".tgl").datepicker();
  function update_item(){
   var kode_penjualan = $('#kode_penjualan').val();
   var kode_produk = $("#kode_menu").val();
   var qty_retur = $("#qty_retur").val();
   var id = $("#id").val();

   var url = "<?php echo base_url().'validasi_penjualan/validasi_penjualan/update_item_penjualan_temp'; ?> ";

   $.ajax({
    type: "POST",
    url: url,
    data: { kode_penjualan:kode_penjualan,
      kode_produk:kode_produk,
      jumlah:jumlah,
      kode_faktur_penjualan:kode_faktur_penjualan,
      jumlah_konversi:jumlah_konversi,
      nama_menu:nama_menu,
      harga_satuan:harga_satuan,
      diskon_item:diskon_item,
      //id_member:id_member,
      //nama_member:nama_member,
      status_member:status_member,
      id:id
    },
    success: function(data)
    {
      if(data == 'tidak cukup'){
        $(".notif_stok").html('<div class="alert alert-warning">Stok Produk Tidak Mencukupi</div>');
        setTimeout(function(){
          $('.notif_stok').html('');
        },1700);              
      }else if(data == 'formkosong'){
        $(".notif_stok").html('<div class="alert alert-warning">Inputan KG/PC kosong.</div>');
        setTimeout(function(){
          $('.notif_stok').html('');
        },1700);              
      }
      else{
        $(".detail").fadeOut();
        $("#tabel_temp_data_transaksi").load("<?php echo base_url().'validasi_penjualan/get_penjualan/'; ?>"+kode_penjualan);
      }
    }
  });
}
</script>