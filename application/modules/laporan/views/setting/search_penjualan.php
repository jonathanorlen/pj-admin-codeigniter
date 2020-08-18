<?php
    $param = $this->input->post();
if(@$param['tgl_awal'] && @$param['tgl_akhir']){
    
    $tgl_awal = $param['tgl_awal'];
    $tgl_akhir = $param['tgl_akhir'];

$this->db->where('tanggal_penjualan >=', $tgl_awal);
$this->db->where('tanggal_penjualan <=', $tgl_akhir);
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
             $this->db->order_by('kode_penjualan','desc');
             $this->db->group_by('kode_penjualan');
$penjualan = $this->db->get('transaksi_penjualan');
$hasil_penjualan = $penjualan->result();
// $this->db->last_query();
?>
<div>
<?php
$keuangan = 0;
foreach($hasil_penjualan as $total){
$keuangan += $total->grand_total-$total->nominal_retur;
}

?>
<label><h4><strong>Total Transaksi Penjualan : <?php echo count($hasil_penjualan); ?></strong></h4></label><br />
<span><label><h4><strong>Total Keuangan Penjualan :<?php echo format_rupiah($keuangan); ?></strong></h4></label></span>
</div>
<table id="search_penjualan" class="table table-bordered table-striped" style="font-size:1.5em;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode Penjualan</th>
                                <th>Kode Transaksi</th>
                                <th>Kode Member</th>
                                <th>Nama Member</th>
                                <th>Jenis Transaksi</th>
                                <th>Petugas</th>
                                <th>Total</th>
                                <th class="act">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_penjualan as $daftar){ ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo TanggalIndo(@$daftar->tanggal_penjualan);?></td>
                                      <td><?php echo @$daftar->kode_penjualan; ?></td>
                                      <td><?php echo @$daftar->kode_transaksi; ?></td>
                                      <td><?php echo @$daftar->kode_member; ?></td>
                                      <td><?php echo @$daftar->nama_member; ?></td>
                                      <td><?php echo @$daftar->jenis_transaksi; ?></td>
                                      <td><?php echo @$daftar->petugas; ?></td>
                                      <td><?php echo format_rupiah(@$daftar->grand_total-@$daftar->nominal_retur); ?></td>
                                      <td class="act"><?php echo get_detail_penjualan($daftar->kode_penjualan); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode Penjualan</th>
                                <th>Kode Transaksi</th>
                                <th>Kode Member</th>
                                <th>Nama Member</th>
                                <th>Jenis Transaksi</th>
                                <th>Petugas</th>
                                <th>Total</th>
                                <th class="act">Action</th>
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