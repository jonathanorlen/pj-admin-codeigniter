 <?php
 $data = $this->input->post();
 if(@$data['tgl_awal'] && @$data['tgl_akhir']){
  
  $tgl_awal = $data['tgl_awal'];
  $tgl_akhir = $data['tgl_akhir'];
  $this->db->where('tanggal >=', $tgl_awal);
  $this->db->where('tanggal <=', $tgl_akhir);
 }
 $this->db->order_by('tanggal','desc');
  $kasir = $this->db->get('transaksi_kasir');
  $hasil_kasir = $kasir->result();
   #echo $this->db->last_query();                     ?>
<table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Petugas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Nominal Penjualan</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor=1;
                        foreach($hasil_kasir as $daftar){
                        ?>
                        <tr class="<?php if($daftar->status=="open"){ echo "danger"; } ?>">
                          <td><?php echo $nomor; ?></td>
                          <td><?php echo $daftar->kode_transaksi; ?></td>
                          <td><?php echo TanggalIndo($daftar->tanggal) ?></td>
                          <td><?php echo $daftar->check_in ?></td>
                          <td><?php echo $daftar->check_out ?></td>
                          <td><?php echo $daftar->petugas ?></td>
                          <td><?php echo format_rupiah($daftar->saldo_awal) ?></td>
                          <td><?php echo format_rupiah($daftar->saldo_akhir) ?></td>
                          <td><?php echo format_rupiah($daftar->nominal_penjualan) ?></td>
                          <td><?php echo $daftar->status ?></td>
                          <td><?php echo get_detail($daftar->kode_transaksi); ?></td>
                          
                        </tr>
                       <?php $nomor++; } ?>
                    </tbody>
                      <tfoot>
                        <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Petugas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Nominal Penjualan</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                     </tfoot>
                   </table>