<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
  <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/apple-touch-startup-image-640x1096.png">
  <meta name="author" content="SINDEVO.COM" />
  <meta name="description" content="biotic - mobile and tablet web app template" />
  <meta name="keywords" content="mobile css template, mobile html template, jquery mobile template, mobile app template, html5 mobile design, mobile design" />
  <title>biotic - mobile and tablet web app template</title>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
  <script src="js/jquery.min.js"></script> 
  <link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.css">
  <link type="text/css" rel="stylesheet" href="style.css" />
  <link type="text/css" rel="stylesheet" href="css/colors/yellow.css" />
  <link type="text/css" rel="stylesheet" href="css/swipebox.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/AdminLTE.min.css">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  
</head>
<body>

  <div data-role="page" id="homepage" data-theme="b">

    <div role="main" class="ui-content" style="padding: 40px;">

     <!--  <div class="logo_container">
        <div class="logo">
          <img src="images/logo.png" alt="biotic" title="biotic" />
          <h2>biotic</h2>
          <span>mobile design</span>                        
        </div>                     
      </div>
      <div class="slide_info">SLIDE RIGHT TO NAVIGATE</div> -->
      <div style="border-top: 3px solid #29d8ff; background-color: #FFF;padding-left: 10px;
      padding-bottom: 10px;">
      <h3>Point Of Sale</h3>
      <p style="margin:0px;color: #8f8f8f">01/09/2016</p>
      <p style="color: #8f8f8f;">Jumat</p>
      <hr>
      

      <h1>Sift 1</h1>
      <p>Nama Kasir :</p>
      <p>Omset      :</p><br>
      <div id="omset" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

      
      <!-- /.box-body -->



      <h1>Sift 2</h1>
      <p>Nama Kasir :</p>
      <p>Omset      :</p><br>
      <div id="omset2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>





      <div class="small-box bg-aqua">
        <div class="inner">
          <h3 class="text-center">Rp.200.000.000</h3>

          <p class="text-center">Total Omset</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>

      </div>


    </div>
  </div><!-- /content -->

  <div data-role="panel" id="left-panel" data-display="reveal" data-position="left">

    <nav class="main-nav">
      <ul>
        <li style="background-color: rgb(203, 32, 37);">
          <a href="http://192.168.100.35/resto_kasir/admin/dashboard" data-transition="slidefade"><img src="images/icons/white/team.png" alt="" title="" /><span>Dashboard</span></a>
        </li>
        <li style="background-color: rgb(248, 179, 52)">
          <a href="http://192.168.100.35/resto_kasir/master/daftar" data-transition="slidefade"><img src="images/icons/white/settings.png" alt="" title="" /><span>Master</span></a>
        </li>
        <li style="background-color: rgb(151, 191, 13);">
          <a href="http://192.168.100.35/resto_kasir/kasir" data-transition="slidefade"><img src="images/icons/white/blog.png" alt="" title="" /><span>Kasir</span></a>
        </li>
        <li style="background-color: rgb(45, 90, 255);">
          <a href="http://192.168.100.35/resto_kasir/kasir/dft_transaksi_kasir" data-transition="slidefade"><img src="images/icons/white/photos.png" alt="" title="" /><span>Transaksi Kasir</span></a>
        </li>


      </ul>
    </nav> 

  </div><!-- /panel -->

  <div data-role="panel" id="right-panel" data-display="reveal" data-position="right">

    <div class="user_login_info">

      <div class="user_thumb_container">
        <img src="images/profile.jpg" alt="" title="" /> 
        <div class="user_thumb">
          <img src="images/author.jpg" alt="" title="" />     
        </div>  
      </div>

      <div class="user_details">
        <p>Sarah Williams</p>
        <ul class="user_social">
          <li><a href="social.html"><img src="images/icons/white/twitter.png" alt="" title="" /></a></li>
          <li><a href="social.html"><img src="images/icons/white/facebook.png" alt="" title="" /></a></li> 
          <li><a href="social.html"><img src="images/icons/white/dribbble.png" alt="" title="" /></a></li>               
        </ul> 
      </div>  


      <nav class="user-nav">
        <ul>
          <li><a href="features.html"><img src="images/icons/white/settings.png" alt="" title="" /><span>Settings</span></a></li>
          <li><a href="features.html"><img src="images/icons/white/briefcase.png" alt="" title="" /><span>Account</span></a></li>
          <li><a href="features.html"><img src="images/icons/white/message.png" alt="" title="" /><span>Messages</span><strong class="yellow">12</strong></a></li>
          <li><a href="features.html"><img src="images/icons/white/download.png" alt="" title="" /><span>Downloads</span><strong class="yellow">5</strong></a></li>
          <li><a href="index.html"><img src="images/icons/white/lock.png" alt="" title="" /><span>Logout</span></a></li>
        </ul>
      </nav>
    </div>
    <div class="close_loginpopup_button"><a href="#" data-rel="close"><img src="images/icons/white/menu_close.png" alt="" title="" /></a></div>

  </div><!-- /panel -->

</div><!-- /page -->

<script src="js/jquery.mobile-1.4.5.min.js"></script>
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/jquery.swipebox.js"></script>
<script src="js/jquery.mobile-custom.js"></script>
<script>
  $(function () {
    $('#omset').highcharts({
      title: {
        text: 'Grafik Omset Kasir',
            x: -20 //center
          },
          subtitle: {
            text: 'Sift 1',
            x: -20
          },
          xAxis: {
            categories: [
            <?php $omset = $this->db->query("SELECT tanggal_transaksi FROM opsi_transaksi_penjualan WHERE status_menu = 'reguler' GROUP BY tanggal_transaksi");
                   $get_tanggal =$omset->result();
                   foreach($get_tanggal as $tgl){
                     $t = $tgl->tanggal_transaksi;
                    
              echo '"'.TanggalIndo($t).'"'.",";
               } ?>
            ]
          },
          yAxis: {
            title: {
              text: 'Jumlah Omset'
            },
            plotLines: [{
              value: 0,
              width: 1,
              color: '#808080'
            }]
          },
          tooltip: {
            valueSuffix: 'RP'
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
          },
          series: [{
            name: 'Omset',
            data: [14000, 90000, 20000, 90000, 80000]
          },]
        });

    $('#omset2').highcharts({
      title: {
        text: 'Grafik Omset Kasir',
            x: -20 //center
          },
          subtitle: {
            text: 'Sift 2',
            x: -20
          },
          xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
          },
          yAxis: {
            title: {
              text: 'Jumlah Omset'
            },
            plotLines: [{
              value: 0,
              width: 1,
              color: '#808080'
            }]
          },
          tooltip: {
            valueSuffix: 'Rp'
          },
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
          },
          series: [{
            name: 'Omset',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
          },]
        });
  });
</script>
</body>
</html>
