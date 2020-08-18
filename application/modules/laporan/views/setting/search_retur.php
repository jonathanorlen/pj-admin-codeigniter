<table id="tabel_daftar" class="table table-bordered" style="font-size: 1.5em;">
  <?php
  $data = $this->input->post();
  if(@$data['tgl_awal'] && @$data['tgl_akhir']){

    $tgl_awal = $data['tgl_awal'];
    $tgl_akhir = $data['tgl_akhir'];
    $this->db->where('tanggal_retur >=', $tgl_awal);
    $this->db->where('tanggal_retur <=', $tgl_akhir);
  }
  
  $get_retur_penjualan = $this->db->get('transaksi_retur_penjualan');
  $hasil_get_retur_penjualan = $get_retur_penjualan->result();
  ?>
  <thead>
   <tr>
    <th>No</th>
    <th>Kode</th>
    <th>Tanggal</th>
    <th>Total Retur Penjualan</th>
    <th>Nominal Retur Penjualan</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
  <?php
  $nomor = 1;
  $total= 0;
  foreach($hasil_get_retur_penjualan as $daftar){ 
    $kode_retur = $daftar->kode_retur;
    $get_opsi_retur_penjualan = $this->db->get_where('opsi_transaksi_retur_penjualan',array('kode_retur'=>$kode_retur));
    $hasil_get_opsi_retur_penjualan = $get_opsi_retur_penjualan->row();

    ?> 
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo @$daftar->kode_retur; ?></td>
      <td><?php echo TanggalIndo(@$daftar->tanggal_retur);?></td>
      <td align="right"><?php echo format_rupiah($daftar->grand_total);?></td>
      <td align="right"><?php echo format_rupiah($daftar->nominal_retur);?></td>
      <td align="center"><?php echo get_detail_retur_penjualan($daftar->kode_retur); ?></td>
    </tr>
    <?php $nomor++; } ?>
  </tbody>
  <tfoot>
   <tr>
    <th>No</th>
    <th>Kode</th>
    <th>Tanggal</th>
    <th>Total Retur Penjualan</th>
    <th>Nominal Retur Penjualan</th>
    <th>Action</th>
  </tr>
</tfoot>
</table>