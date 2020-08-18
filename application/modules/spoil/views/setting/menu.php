<?php 
$position = $this->uri->segment(2);
if($position == 'detail' || $position == 'edit'){
	$position = $this->uri->segment(3);
}
?>
<div class="">
  <div class="page-content">
    
    <div id="box_load">
      <?php echo @$konten; ?>
    </div>
  </div>
</div>

