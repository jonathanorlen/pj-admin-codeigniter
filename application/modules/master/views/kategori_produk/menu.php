<div class="">
  <div class="page-content">

    <a style="padding:13px; margin-bottom:10px;" class="btn btn-app green" href="<?php echo base_url() . 'master/kategori_produk/tambah' ?>"><i class="fa fa-edit"></i> Tambah Kategori Produk</a>
      <a style="padding:13px; margin-bottom:10px;" class="btn btn-app blue" href="<?php echo base_url() . 'master/kategori_produk/daftar_kategori_produk' ?>"><i class="fa fa-list"></i> Daftar Kategori Produk</a>
      


<div id="box_load">
 <?php echo @$konten; ?>
 </div>
</div>
</div>

<script>
 $(document).ready(function(){

  $("#tambah").click(function(){
    window.location = "<?php echo base_url() . 'rak/tambah' ?>";                
  });

  $("#daftar").click(function(){
    window.location = "<?php echo base_url() . 'rak/rak' ?>";            
  });

});
</script>
