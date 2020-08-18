<?php
$param = $this->input->post();
if(@$param['tgl_awal'] && @$param['tgl_akhir']){
  
  $tgl_awal = $param['tgl_awal'];
  $tgl_akhir = $param['tgl_akhir'];

  $this->db->where('tanggal_transaksi >=', $tgl_awal);
  $this->db->where('tanggal_transaksi <=', $tgl_akhir);
}
if(@$param['petugas']){
  $petugas = $param['petugas'];
  $this->db->where('id_petugas',$petugas);
}
?>
<?php
$this->db->select('*'); 
$this->db->distinct();
$this->db->select('kode_penjualan');

$this->db->group_by('kode_menu');
$penjualan = $this->db->get('opsi_transaksi_penjualan');
$hasil_penjualan = $penjualan->result();
// echo $this->db->last_query();
?>
<div>

</div>
<table id="search_penjualan" class="table table-bordered table-striped" style="font-size:1.5em;">
 <thead>
  <tr>
    <th width="20">No</th>
    
    <th>Nama Menu</th>
    <th>Total</th>
    
  </tr>
</thead>
<tbody>
  <?php
  $nomor = 1;

  foreach($hasil_penjualan as $daftar){
    if(!empty($tgl_awal) and !empty($tgl_akhir)){
     $jumlah_menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_menu' => $daftar->kode_menu,'tanggal_transaksi >=' => @$tgl_awal,'tanggal_transaksi <=' => @$tgl_akhir));   
   }else{
     $jumlah_menu = $this->db->get_where('opsi_transaksi_penjualan',array('kode_menu' => $daftar->kode_menu));    
   }
   
                    //echo $this->db->last_query();
   $hasil_jumlah = $jumlah_menu->result();
   $total_menu=0;
   foreach ($hasil_jumlah as $value) {
    $total_menu+=$value->jumlah;
  }

  $ambil_menu = $this->db->get_where('master_bahan_baku',array('kode_bahan_baku' => $daftar->kode_menu));
  $hasil_menu = $ambil_menu->row();
  
  ?> 
  <tr>
    <td><?php echo $nomor; ?></td>
    
    <td><?php echo @$hasil_menu->nama_bahan_baku; ?></td>
    <td><?php echo @$total_menu; ?></td>
    
  </tr>
  <?php $nomor++; } ?>

</tbody>
<tfoot>
  <tr>
    <th>No</th>
    
    <th>Nama Menu</th>
    <th>Total</th>
    
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