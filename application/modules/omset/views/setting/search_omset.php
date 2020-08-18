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
                                $this->db->group_by('tanggal_penjualan');
                                $omset = $this->db->get('transaksi_penjualan');
                                 /*$omset = $this->db->query("SELECT tanggal_transaksi,
                                 COUNT(subtotal) AS total_transaksi, SUM(subtotal) as total_omset FROM opsi_transaksi_penjualan
                                  WHERE status_menu = 'reguler' GROUP BY tanggal_transaksi");*/
                                 # echo $this->db->last_query();
                                 $totalnya = 0;
                                  $hasil_omset = $omset->result();
                                 
                            ?>
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
                                        $this->db->select_sum('grand_total');
                                        $this->db->group_by('tanggal_penjualan');
                                        $total_omset = $this->db->get('transaksi_penjualan');
                                        $hasil_total = $total_omset->result();
                                        $totale = 0;
                                        #echo $this->db->last_query();
                                        foreach($hasil_total as $totalan){
                                         $totalnya += $totalan->grand_total;   
                                                                                    
                                        }                                                                                
                                      ?>                            
<label style="font-size: x-large;"><strong>Total Omset : <?php echo format_rupiah($totalnya); ?></strong></label>
<table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total Transaksi</th>
                                <th>Omset</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                                <?php
                                    $nomor = 1;

                                    foreach($hasil_omset as $daftar){ ?> 
                                    <tr>
                                      <td><?php echo $nomor; ?></td>
                                      <td><?php echo TanggalIndo(@$daftar->tanggal_penjualan);?></td>
                                       <?php
                                       $this->db->group_by('kode_penjualan');
                                        $total_trx = $this->db->get_where('transaksi_penjualan',array('tanggal_penjualan'=>$daftar->tanggal_penjualan));
                                        $hasil_total_trx = $total_trx->result();
                                       ?>                                                                                                                 
                                      <td><?php echo count($hasil_total_trx); ?></td>
                                      
                                      <?php
                                      
                                        $this->db->select_sum('grand_total');
                                        $this->db->select('kode_penjualan');
                                        $this->db->group_by('kode_penjualan');
                                        $total_omset = $this->db->get_where('transaksi_penjualan',array('tanggal_penjualan'=>$daftar->tanggal_penjualan));
                                        #echo $this->db->last_query();
                                        $hasil_total = $total_omset->result();
                                        $uang_omset = 0;
                                        foreach($hasil_total as $daftar){
                                            $uang_omset += $daftar->grand_total;
                                        }                                                                                
                                      ?>                                                                                                                  
                                      <td><?php echo format_rupiah(@$uang_omset); ?></td>
                                    </tr>
                                <?php $nomor++; } ?>
                               
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total Transaksi</th>
                                <th>Omset</th>
                              </tr>
                            </tfoot>
                        </table>
<script>
$("#tabel_daftar").dataTable();
</script>