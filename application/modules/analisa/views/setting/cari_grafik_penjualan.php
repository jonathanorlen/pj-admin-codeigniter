<?php 
  $tgl_awal=$this->input->post('tgl_awal');
  $tgl_akhir=$this->input->post('tgl_akhir');

?>

<div class="col-md-12">
  <!-- <a class="label label-warning">Grafik Pembelian Barang <?php echo TanggalIndo($tgl_awal)." "."-"." ".TanggalIndo($tgl_akhir) ?></a> -->
</div>
<div class="col-md-12" id="container" >

</div>

<!------------------------------------------------------------------------------------------------------>

<script type="text/javascript">

  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Grafik Penjualan'
    },
    subtitle: {
      text: '<?php echo @TanggalIndo($tgl_awal)." "."-"." ".@TanggalIndo($tgl_akhir)  ?>'
    },
    xAxis: {
     categories: [

     <?php 

      if (!empty($tgl_awal) && !empty($tgl_akhir)) {
        $omset = $this->db->query("SELECT tanggal_penjualan,SUM(grand_total) as total_penjualan from transaksi_penjualan where tanggal_penjualan >= '$tgl_awal' and tanggal_penjualan <= '$tgl_akhir' group by tanggal_penjualan");
      } else {
        $omset = $this->db->query("SELECT tanggal_penjualan,SUM(grand_total) as total_penjualan from transaksi_penjualan group by tanggal_penjualan");
      }
      
      $get_tanggal =$omset->result();
      foreach($get_tanggal as $tgl){
        $t = $tgl->tanggal_penjualan;

        echo '"'.@TanggalIndo($t).'"'.",";
      } ?>
    ]
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
      text: 'Nominal'
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
  data: [
  <?php

  if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $omset = $this->db->query("SELECT tanggal_penjualan,SUM(grand_total) as total_penjualan from transaksi_penjualan where tanggal_penjualan >= '$tgl_awal' and tanggal_penjualan <= '$tgl_akhir' group by tanggal_penjualan");
  } else {
    $omset = $this->db->query("SELECT tanggal_penjualan,SUM(grand_total) as total_penjualan from transaksi_penjualan group by tanggal_penjualan");
  }

  
  $totalnya = 0;
  $hasil_omset = $omset->result();

  foreach($hasil_omset as $daftar){
        
   echo "$daftar->total_penjualan,";
 } ?>],

 }]
});


</script>