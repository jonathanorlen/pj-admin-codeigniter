      
<?php
$param = $this->input->post();
if(@$param['tgl_awal'] && @$param['tgl_akhir']){
  $tgl_awal = $param['tgl_awal'];
  $tgl_akhir = $param['tgl_akhir'];

  $this->db->where('tanggal_transaksi >=', $tgl_awal);
  $this->db->where('tanggal_transaksi <=', $tgl_akhir);

}


$this->db->select('*');
$this->db->from('transaksi_piutang');
$this->db->where('sisa !=',0);
//$this->db->order_by('sisa','asc');
$this->db->order_by('nama_customer', 'asc');
$this->db->order_by('tanggal_transaksi','desc');
$transaksi = $this->db->get();
$hasil_transaksi = $transaksi->result();
$total=0;
//echo $this->db->last_query();
?>

<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-12">

    <table style="font-size: 1.5em;" id="tabel_daftar" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Customer</th>
          <th>Nominal Piutang</th>
          <th>Sisa</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $nomor = 1;
                                // Select Nz(sum(Xcolumn), 0) from [Xtable] where id = "1234"
        foreach($hasil_transaksi as $daftar){ 

          $this->db->where('kode_customer', $daftar->kode_customer);
          $this->db->where('sisa', $daftar->sisa);
          $this->db->select('SUM(nominal_piutang) as piutang, SUM(sisa) as sisa');
                                  //$this->db->select('(SUM(sisa),)');
          $get_total = $this->db->get_where('transaksi_piutang');
          $hasil_total = $get_total->row();
          $tgl = ($daftar->tanggal_transaksi=='0000-00-00' || empty($daftar->tanggal_transaksi)) ? '-' : @TanggalIndo(@$daftar->tanggal_transaksi) ;
          ?> 
          <tr class=" <?php if($daftar->sisa !='0'){ echo "danger"; } ?>">
            <td><?php echo $nomor; ?></td>
            <td><?php echo @$daftar->nama_customer; ?></td>
            <td><?php echo format_rupiah(@$hasil_total->piutang); ?></td>
            <td><?php echo format_rupiah(@$hasil_total->sisa); ?></td>
            <td><?php echo get_detail_hut($daftar->kode_customer)?></td>
          </tr>
          <?php $nomor++; } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Nominal Piutang</th>
            <th>Sisa</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
      <!-- <div class="row">
       <div class="col-md-10" align="right">
        <label style="font-size: 20px"><b>Total :</label>
      </div>
      <div class="col-md-2 pull-right">
        <span><button style="width: 147px" type="button" class="btn btn-warning pull-right" id="cari"><i class=""></i><?php  echo format_rupiah($total); ?></button></span>
      </div>
    </div> -->
  </div>
</div>

<script type="text/javascript">
 $("#tabel_daftar").dataTable({
  "paging":   false,
  "ordering": true,
  "info":     false
});
</script>