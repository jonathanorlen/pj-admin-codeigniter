<?php
$param = $this->input->post();
if(@$param['tgl_awal'] && @$param['tgl_akhir']){

  $tgl_awal = $param['tgl_awal'];
  $tgl_akhir = $param['tgl_akhir'];

  $this->db->where('tanggal_retur_keluar >=', $tgl_awal);
  $this->db->where('tanggal_retur_keluar <=', $tgl_akhir);
}
if(@$param['petugas']){
  $petugas = $param['petugas'];
  $this->db->where('id_petugas',$petugas);
}
?>
<?php
$this->db->select('*'); 
$this->db->distinct();
$this->db->select('kode_retur');
$this->db->order_by('kode_retur','desc');
$this->db->group_by('kode_retur');
$penjualan = $this->db->get('transaksi_retur');
$hasil_penjualan = $penjualan->result();
// $this->db->last_query();
?>
<!-- <div>
<?php
$keuangan = 0;
foreach($hasil_penjualan as $total){
$keuangan += $total->grand_total-$total->nominal_retur;
}

?>
<label><h4><strong>Total Transaksi Penjualan : <?php #echo count($hasil_penjualan); ?></strong></h4></label><br />
<span><label><h4><strong>Total Keuangan Penjualan :<?php #echo format_rupiah($keuangan); ?></strong></h4></label></span>
</div> -->
<table id="search_penjualan" class="table table-bordered table-striped" style="font-size:1.5em;">
  <thead>
    <tr>
     <th>No</th>
     <th>Kode</th>
     <th>Tanggal</th>
     <th>Total Retur Pembelian</th>
     <!-- <th>Nominal Retur Pembelian</th> -->
     <th>Action</th>
   </tr>
 </thead>
 <tbody>
  <?php
  $nomor = 1;

  foreach($hasil_penjualan as $daftar){
   $kode_retur = $daftar->kode_retur;
   $get_opsi_retur_penjualan = $this->db->get_where('opsi_transaksi_retur',array('kode_retur'=>$kode_retur));
   $hasil_get_opsi_retur_penjualan = $get_opsi_retur_penjualan->row();

   ?> 
   <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo @$daftar->kode_retur; ?></td>
    <td><?php echo TanggalIndo(@$daftar->tanggal_retur_keluar);?></td>
    <td align="right"><?php echo format_rupiah($daftar->grand_total);?></td>
    <!-- <td align="right"><?php echo format_rupiah($daftar->total_nominal);?></td> -->
    <td align="center"><?php echo get_detail_retur_pembelian($daftar->kode_retur); ?></td>
  </tr>
  <?php $nomor++; } ?>
  
</tbody>
<tfoot>
  <tr>
    <th>No</th>
    <th>Kode</th>
    <th>Tanggal</th>
    <th>Total Retur Pembelian</th>
    <!-- <th>Nominal Retur Pembelian</th> -->
    <th>Action</th>
  </tr>
</tfoot>
</table>
<script>
$('#search_penjualan').dataTable({
  "paging":   false,
  "info":     false
});
$("#export_exel").attr('onclick',"tableToExcel('search_penjualan', 'W3C Example Table')");
</script>