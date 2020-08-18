<?php 
$tgl_awal=$this->input->post('tgl_awal');
$tgl_akhir=$this->input->post('tgl_akhir');

?>

<div class="col-md-10">

</div>
<div class="col-md-3">
  <?php 
  if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $pendapatan = $this->db->query("SELECT SUM(nominal) as total_pendapatan from keuangan_masuk where tanggal_transaksi >= '$tgl_awal' and tanggal_transaksi <= '$tgl_akhir'");

    $pengeluaran = $this->db->query("SELECT SUM(nominal) as total_pengeluaran from keuangan_keluar where tanggal_transaksi >= '$tgl_awal' and tanggal_transaksi <= '$tgl_akhir'");
   
  } else {
    $pendapatan = $this->db->query("SELECT SUM(nominal) as total_pendapatan from keuangan_masuk");
    $pengeluaran = $this->db->query("SELECT SUM(nominal) as total_pengeluaran from keuangan_keluar");
  }
  if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $this->db->where('tanggal_transaksi >=',$tgl_awal);
    $this->db->where('tanggal_transaksi <=',$tgl_akhir);
  }
  
  $hpp = $this->db->get('opsi_transaksi_penjualan');
  $hasil_hpp = $hpp->result();
  $total_hpp = 0;
  $hasil = 0;
  foreach ($hasil_hpp as $daftar) {
    $total_hpp += $daftar->jumlah * $daftar->hpp;
    $hasil+=$total_hpp;
   
  }

  if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $this->db->where('tanggal_transaksi >=',$tgl_awal);
    $this->db->where('tanggal_transaksi <=',$tgl_akhir);
  }
  
  $hpp_jasa = $this->db->get('opsi_transaksi_penjualan_jasa');
  $hasil_hpp_jasa = $hpp_jasa->result();
 
  foreach ($hasil_hpp_jasa as $value) {
    $total_hpp += $value->jumlah * $value->harga_satuan;
    
   
  }
//echo $this->db->last_query();
  $hasil_pendapatan  = $pendapatan->row();
  $hasil_pengeluaran = $pengeluaran->row();

  ?>
  <br>


  <a class="btn btn-danger btn-lg btn-block" >Pendapatan : <?php echo format_rupiah($hasil_pendapatan->total_pendapatan) ?></a><br>
  <a  class="btn btn-primary btn-lg btn-block">Pengeluaran : <?php echo format_rupiah($hasil_pengeluaran->total_pengeluaran  + @$total_hpp) ?></a> 


</div>
<div class="">


  <div class=" col-md-11" id="container" >

  </div>
</div>

<!------------------------------------------------------------------------------------------------------>

<script type="text/javascript">

Highcharts.chart('container', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Grafik Laba Rugi'
  },
  subtitle: {
    text: '<?php echo @TanggalIndo($tgl_awal)." "."-"." ".@TanggalIndo($tgl_akhir)  ?>'
  },
  xAxis: {
   categories: [




   'Pendapatan','Pengeluaran']
 },
 tooltip: {
  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
  '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
  footerFormat: '</table>',
  shared: true,
  useHTML: true
},
yAxis: {
  min: 0,
  title: {
    text: 'Nilai '
  }
},
plotOptions: {
  column: {
    pointPadding: 0,
    borderWidth: 0
  }
},
series: [{
  name: ' ',



  <?php



     //echo "$daftar->total_penjualan,";
  ?>
  data: [<?php echo $hasil_pendapatan->total_pendapatan ?>,<?php echo $hasil_pengeluaran->total_pengeluaran + @$total_hpp ?>],

}]
});


</script>