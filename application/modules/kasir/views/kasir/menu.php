<div class="">
  <div class="page-content">

    


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
