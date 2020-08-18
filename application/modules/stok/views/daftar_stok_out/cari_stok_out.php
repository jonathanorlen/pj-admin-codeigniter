<table class="table table-striped table-hover table-bordered" id="tabel_daftarr"  style="font-size:1.5em;">
 <thead>
  <tr>
   <th>No</th>
   <th>Kode Stock Out</th>
   <th>Tanggal Transaksi</th>
   <th>Petugas</th>
   <th>Action</th>
 </tr>
</thead>
<tbody id="">  
  <?php 
  $tgl_awal=$this->input->post('tgl_awal');
  $tgl_akhir=$this->input->post('tgl_akhir');
  if (!empty($tgl_awal) and !empty($tgl_akhir)) {
    $this->db->where('tanggal_input >=',$tgl_awal);
    $this->db->where('tanggal_input <=',$tgl_akhir);
  }
  $get_transaksi_stok_out=$this->db->get('transaksi_stok_out');
  $hasil_get_transaksi_stok_out=$get_transaksi_stok_out->result();
  $no=1;
  foreach ($hasil_get_transaksi_stok_out as $list) { ?>


  <tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $list->kode_stok_out; ?></td>
    <td><?php echo tanggalIndo($list->tanggal_input); ?></td>
    <td><?php echo $list->petugas ?></td>
    <td><a class="btn btn-primary" href="<?php echo base_url().'stok/detail_stok_out/'.$list->kode_stok_out ?>"><i class="fa fa-search"></i> Detail</a></td>
  </tr>
  <?php } ?> 
</tbody>
<tfoot>
  <tr>
   <th>No</th>
   <th>Kode Stock Out</th>
   <th>Tanggal Transaksi</th>
   <th>Petugas</th>
   <th>Action</th>
 </tr>
</tfoot>
<tbody>

</tbody>                
</table>