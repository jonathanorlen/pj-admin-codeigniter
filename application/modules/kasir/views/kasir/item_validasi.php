 <?php
 $kode_penjualan=$this->uri->segment(3);
 $this->db->where('kode_penjualan',$kode_penjualan);
 $kasir = $this->db->get('opsi_transaksi_penjualan_jasa_temp');
 $hasil_kasir = $kasir->result();
 $nomor=1;
 $total=0;

 
 foreach($hasil_kasir as $daftar){
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $daftar->nama_menu; ?></td>
   
    <td><?php echo $daftar->jumlah; ?></td>
    <td><?php echo @format_rupiah($daftar->harga_satuan); ?></td>
    <td align="right"><?php echo @format_rupiah($daftar->subtotal) ?></td>
    <td align="center"><?php echo get_edit_del_id($daftar->id); ?></td>
  </tr>
  <?php $nomor++; 
  $total +=$daftar->subtotal;
} ?>

<tr>
  <td colspan="4" align="center"><b> Total </b></td>

  <td align="right"><b><?php echo @format_rupiah($total) ?></b></td>
  <td></td>
</tr>