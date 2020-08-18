
<?php
if(@$kode){
  $opsi_bb = $this->db->get_where('opsi_bahan_baku',array('kode_input'=>$kode));
  $list_bb = $opsi_bb->result();
  $nomor = 1;  $total = 0;

  foreach($list_bb as $daftar){ 
                                   # echo $daftar->kode_bahan;
    ?> 
    <tr style="font-size: 15px;">
      <td><?php echo $nomor; ?></td>
      <td><?php echo "1 ".@$daftar->nama_satuan; ?></td>
      <td><?php echo @$daftar->jumlah." ".@$daftar->nama_satuan_stok; ?></td>
      
      <td><?php echo format_rupiah(@$daftar->harga); ?></td>
      <td><?php echo get_edit_del_id(@$daftar->id); ?></td>
    </tr>

    <?php 
    
    $nomor++; 
  } 
}
?>

