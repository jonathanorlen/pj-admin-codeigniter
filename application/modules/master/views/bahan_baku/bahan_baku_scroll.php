<?php
$kode_default = $this->db->get('setting_gudang');
$hasil_unit =$kode_default->row();
$param=$hasil_unit->kode_unit;
$this->db->limit('20','11');
$bahan_baku = $this->db->get_where('master_bahan_baku',array('kode_unit' => $param));
$hasil_bahan_baku = $bahan_baku->result();
?>
<?php
$nomor=1;
foreach($hasil_bahan_baku as $daftar){
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $daftar->kode_bahan_baku; ?></td>
    <td width="200px"><?php echo $daftar->nama_bahan_baku; ?></td>
    <td><?php echo $daftar->nama_kategori_produk; ?></td>
    <td><?php echo $daftar->nama_unit; ?></td>
    <td><?php echo $daftar->nama_rak; ?></td>
    <td><?php echo $daftar->satuan_pembelian; ?></td>
    <td><?php echo $daftar->satuan_stok; ?></td>
    <td><?php echo $daftar->jumlah_dalam_satuan_pembelian; ?></td>
    <td><?php echo $daftar->stok_minimal; ?></td>
    <td><?php echo $daftar->nama_supplier; ?></td>
    <td><?php echo get_detail_edit_delete_string($daftar->id); ?></td>
  </tr>
  <?php $nomor++; } ?>