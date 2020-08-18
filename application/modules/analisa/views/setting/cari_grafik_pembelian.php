<?php 
  $tgl_awal=$this->input->post('tgl_awal');
  $tgl_akhir=$this->input->post('tgl_akhir');

?>

<div class="col-md-12">

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
      text: 'Grafik Pembelian'
    },
    subtitle: {
      text: '<?php echo @TanggalIndo($tgl_awal)." "."-"." ".@TanggalIndo($tgl_akhir)  ?>'
    },
    xAxis: {
     categories: [

     <?php 

      if (!empty($tgl_awal) && !empty($tgl_akhir)) {
        $omset = $this->db->query("SELECT tanggal_pembelian,SUM(grand_total) as total_pembelian from transaksi_pembelian where tanggal_pembelian >= '$tgl_awal' and tanggal_pembelian <= '$tgl_akhir' group by tanggal_pembelian");
      } else {
        $omset = $this->db->query("SELECT  tanggal_pembelian,SUM(grand_total) as total_pembelian from transaksi_pembelian group by tanggal_pembelian");
      }
      
      $get_tanggal =$omset->result();
      foreach($get_tanggal as $tgl){
        $t = $tgl->tanggal_pembelian;

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
      text: 'Nominal '
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
    $omset = $this->db->query("SELECT tanggal_pembelian,SUM(grand_total) as total_pembelian from transaksi_pembelian where tanggal_pembelian >= '$tgl_awal' and tanggal_pembelian <= '$tgl_akhir' group by tanggal_pembelian");
  } else {
    $omset = $this->db->query("SELECT tanggal_pembelian,SUM(grand_total) as total_pembelian from transaksi_pembelian group by tanggal_pembelian");
  }

  
  $totalnya = 0;
  $hasil_omset = $omset->result();

  foreach($hasil_omset as $daftar){
        
   echo "$daftar->total_pembelian,";
 } ?>],

 }]
});


</script>