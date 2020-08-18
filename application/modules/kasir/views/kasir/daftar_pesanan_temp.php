<?php

$dft_order = $this->db->get_where('opsi_transaksi_penjualan_jasa_deskripsi_temp',array('kode_penjualan'=>@$kode));
$hasil_order = $dft_order->result();
  
$nomor = 1;  
$total=0;
foreach($hasil_order as $daftar){ 
	?> 
	<tr>
		<td><?php echo $nomor; ?></td>
		<td><?php echo @$daftar->deskripsi; ?></td>
		<td><?php echo @$daftar->ukuran; ?></td>
		<td><?php echo @$daftar->nama_satuan; ?></td>
		<td><?php echo @format_rupiah($daftar->harga_satuan); ?></td>

		<td align="center"><?php echo get_edit_del_id(@$daftar->id); ?></td>
	</tr>

	<?php 
	$nomor++; 
	$total+=@$daftar->subtotal;
} 

?>
<tr>
	<td colspan="4" align="center">Total</td>
	
	<th><?php echo @format_rupiah($total); ?></th>

	<td ></td>
</tr>

