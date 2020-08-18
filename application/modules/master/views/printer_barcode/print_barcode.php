<!DOCTYPE html>
<html>
<head>
	<!-- <title>PRINT BARCODE</title> -->
	<style type="text/css">
	
	/*@page {
		size: 9.2cm 2.3cm 0cm 2.3cm; 
	}
	.barcode{
		size: 9.2cm 2.3cm;
		padding-bottom: 0.3cm;
		font-size: 5px;
	}
	table{
		size: 9.2cm 2.3cm 0cm 2.3cm; 
		padding-bottom: 0.3cm;

	}
	body  
	{ 
		margin-left: 0.5cm;
		margin-right: 0.5cm;
	} */
	</style>

</head>

<body onload="print()">
	<?php 
	$param = $this->uri->segment(4);
	$get_barcode = $this->db->get_where('printer_barcode',array('kode_transaksi'=>$param));
	$hasil = $get_barcode->result();

	foreach ($hasil as $value) {

		?>
		<table><tr >
		<?php
		$batas=3;
		for($ulang=1;$ulang <= $batas;$ulang++){


			?>
				
				<!-- <div class="barcode"> -->
				<?php
				$get_bahan = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku'=>$value->kode_bahan_baku));
				$hasil_bahan = $get_bahan->row();

				$barcode_pro=$value->kode_bahan_baku.'.png';

				?>
				<td style="font-size:40px;padding:30px;" ><?php echo substr($hasil_bahan->nama_bahan_baku,0,18);?><br><br>
				<img width="350px" src="<?php echo base_url().'barcode_produk/'.$barcode_pro;?>"></td>
				
				<!-- </div> -->
			
			<?php } ?>
			</tr>
			</table>
			<?php }?>
		</body>

		</html>