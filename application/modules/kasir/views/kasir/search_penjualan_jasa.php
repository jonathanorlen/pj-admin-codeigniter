 <?php
 $data = $this->input->post();
 if(@$data['tgl_awal'] && @$data['tgl_akhir']){
  
  $tgl_awal = $data['tgl_awal'];
  $tgl_akhir = $data['tgl_akhir'];
  $this->db->where('tanggal_penjualan >=', $tgl_awal);
  $this->db->where('tanggal_penjualan <=', $tgl_akhir);
}
$this->db->order_by('tanggal_penjualan','desc');
$kasir = $this->db->get('transaksi_penjualan_jasa');
$hasil_kasir = $kasir->result();
   #echo $this->db->last_query();                     ?>
   <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>Member</th>
        <th>Total</th>
        
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $nomor=1;
      foreach($hasil_kasir as $daftar){
        ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $daftar->kode_penjualan; ?></td>
          <td><?php echo TanggalIndo($daftar->tanggal_penjualan) ?></td>
          <td><?php echo $daftar->nama_member ?></td>

          <td><?php echo format_rupiah($daftar->grand_total) ?></td>

          <td align="center"><?php #echo get_detail_valid($daftar->kode_penjualan); ?>
            <div class="btn-group">

              <a href="<?php echo base_url().'kasir/detail/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Detail" class="btn btn-icon-only btn-circle green"><i class="fa fa-search"></i></a>
              <?php if(@$daftar->validasi!='valid'){?>
              <a href="<?php echo base_url().'kasir/validasi/'.@$daftar->kode_penjualan?>" data-toggle="tooltip" title="Validasi" class="btn btn-icon-only btn-circle blue"><i class="fa fa-check-square-o"></i></a>
              <?php } ?>
            </div>
          </td>

        </tr>
        <?php $nomor++; } ?>
      </tbody>
      <tfoot>
       <tr>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>Member</th>
        <th>Total</th>
        
        <th>Action</th>
      </tr>
    </tfoot>
  </table>