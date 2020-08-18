<div class="">
	<div class="page-content">

		<div class="box-footer clearfix">
			
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<a class="dashboard-stat dashboard-stat-light blue-soft" id="po">
						<div class="visual">
							<i class="glyphicon glyphicon-tasks" ></i>
						</div>
						<div class="details" >
							<div class="number">

							</div>
							<div class="desc">
								PO
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<a class="dashboard-stat dashboard-stat-light red-soft" id="pembelian">
						<div class="visual">
							<i class="glyphicon glyphicon-tasks" ></i>
						</div>
						<div class="details" >
							<div class="number">

							</div>
							<div class="desc">
								Pembelian
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<a class="dashboard-stat dashboard-stat-light green-soft"  id="retur_pembelian">
						<div class="visual">
							<i class="glyphicon glyphicon-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">

							</div>
							<div class="desc">
								Retur Pembelian
							</div>
						</div>
					</a>
				</div>
			</div>
   </div>


   <div id="box_load">
   	<?php echo @$konten; ?>
   </div>
</div>
</div><script type="text/javascript">
$(document).ready(function(){
	$("#po").click(function(){
		$('.tunggu').show();
		window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";

	});

	$("#pembelian").click(function(){
		$('.tunggu').show();
		window.location = "<?php echo base_url() . 'pembelian/daftar_pembelian' ?>";

	});

	$("#retur_pembelian").click(function(){
		$('.tunggu').show();
		window.location = "<?php echo base_url() . 'pembelian/retur/daftar_retur_pembelian' ?>";
	});

});
</script>
