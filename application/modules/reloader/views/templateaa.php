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
  <title>Resto - Admin</title>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
  <script src="<?php echo base_url() . 'template/js/jquery.min.js' ?>"></script> 
  <link rel="stylesheet" href="<?php echo base_url() . 'template/css/themes/default/jquery.mobile-1.4.5.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/style.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/css/colors/yellow.css' ?>">
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() . 'template/css/swipebox.css' ?>">
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css '?> " rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'template/css/AdminLTE.min.css' ?>">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>




  
</head>
<body>

  <div data-role="page" id="homepage" data-theme="b">
   <!--  <div data-role="header" data-position="fixed" role="banner" class="ui-header ui-bar-inherit ui-header-fixed slidedown ui-panel-fixed-toolbar ui-panel-animate ui-panel-page-content-position-left ui-panel-page-content-display-reveal ui-panel-page-content-open">
      <div class="nav_left_button"><a href="#" class="nav-toggle ui-link navtoggleon"><span></span></a></div>
      <div class="nav_center_logo">Kasir</div>
     
      <div class="clear"></div>
    </div> -->
    <div role="main" class="ui-content" style="padding: 40px;">


      <div style="border-top: 3px solid #29d8ff; background-color: #FFF;padding: 10px;margin-right: 110px;
      padding-bottom: 10px;">
    
      <div id="omset2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>




      <br><br>
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
      <ul style="">
        <li style="background-color: rgb(203, 32, 37);cursor: pointer;">
          <a style="text-decoration: none;" id="das" data-transition="slidefade">
            <img src="<?php echo base_url().'template/images/icons/white/team.png' ?>" alt="" title="" /><span>Dashboard</span></a>
          </li>
          <li style="background-color: rgb(248, 179, 52);cursor: pointer;">
            <a style="text-decoration: none;" id="pembelian" data-transition="slidefade">
              <img src="<?php echo base_url().'template/images/icons/white/settings.png' ?>" alt="" title="" /><span>Pembelian</span></a>
            </li>
            
            <li style="background-color: #26a69a;cursor: pointer;width:100px;height:100px">
            <a style="text-decoration: none;" id="validasi" data-transition="slidefade">
              <img src="<?php echo base_url().'template/images/icons/white/docs.png' ?>" alt="" title="" /><span>Validasi Request Order</span></a>
            </li>
            <li style="background-color: rgb(151, 191, 13);cursor: pointer;">
              <a style="text-decoration: none;" id="stok" data-transition="slidefade">
                <img src="<?php echo base_url().'template/images/icons/white/blog.png' ?>" alt="" title="" /><span>Stok</span></a>
              </li>
              <li style="background-color: rgb(45, 90, 255);cursor: pointer;">
                <a style="text-decoration: none;" id="transaksional" data-transition="slidefade">
                  <img src="<?php echo base_url().'template/images/icons/white/photos.png' ?>" alt="" title="" /><span>Transaksional</span></a>
                </li>
                <li style="background-color: rgb(82, 213, 52);cursor: pointer;">
                  <a style="text-decoration: none;" id="keuangan" data-transition="slidefade">
                    <img src="<?php echo base_url().'template/images/icons/white/photos.png' ?>" alt="" title="" /><span>Keuangan</span></a>
                  </li>
                  <li style="background-color: rgb(173, 37, 195);cursor: pointer;">
                    <a style="text-decoration: none;" id="analisa" data-transition="slidefade">
                      <img src="<?php echo base_url().'template/images/icons/white/photos.png' ?>" alt="" title="" /><span>Analisa</span></a>
                    </li>

                    <li style="background-color:  #ff4545;cursor: pointer;">
                    <a style="text-decoration: none;" id="laporan" data-transition="slidefade">
                      <img src="<?php echo base_url().'template/images/icons/white/lock.png' ?>" alt="" title="" /><span>Laporan Penjulan</span></a>
                    </li>
                     
                    <li style="background-color:  #28156e;cursor: pointer;">
                    <a style="text-decoration: none;" id="logout" data-transition="slidefade">
                      <img src="<?php echo base_url().'template/images/icons/white/lock.png' ?>" alt="" title="" /><span>Logout</span></a>
                    </li>


                  </ul>
                </nav> 

              </div><!-- /panel -->

         <!--  <div data-role="panel" id="right-panel" data-display="reveal" data-position="right">

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

  </div> --><!-- /panel

</div><!-- /page -->

<script src="<?php echo base_url() . 'template/js/jquery.mobile-1.4.5.min.js' ?>"></script>
<script src="<?php echo base_url() . 'template/js/jquery.validate.min.js' ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() . 'template/js/email.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'template/js/jquery.swipebox.js' ?>"></script>
<script src="<?php echo base_url() . 'template/js/jquery.mobile-custom.js' ?>"></script>
<script>
  $(function () {
    $('#omset').highcharts({
      chart: {
        backgroundColor: '#deffda'
      },
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
            <?php 
            $omset = $this->db->query("SELECT tanggal FROM transaksi_kasir");
            $get_tanggal = $omset->result();
            foreach($get_tanggal as $tgl){
             $t = $tgl->tanggal;

             echo '"'.TanggalIndo($t).'"'.",";
           } 
           ?>


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
          valueSuffix: ''
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle',
          borderWidth: 0
        },
        series: [{
          name: 'Omset',
          data: [
          <?php 
          $omset = $this->db->query("SELECT saldo_awal FROM transaksi_kasir");
          $get_saldo = $omset->result();
          foreach($get_saldo as $jml){

            echo $jml->saldo_awal.",";
          } 
          ?>
          ]
        },]
      });

    $('#omset2').highcharts({
      chart: {
        backgroundColor: '#FFFFFF'
      },
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
          xAxis: {
            alternateGridColor: '#FFFFFF',
          },
          yAxis: {
            alternateGridColor: '#FDFFD5',
            title: {
              text: 'Jumlah Omset'
            },
            plotLines: [{
              value: 0,
              width: 1,
              color: '#FFFFFF'
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
<script>
  $('#das').click(function(){
    window.location = "<?php echo base_url().'admin' ?>";
  });
  $('#pembelian').click(function(){
    window.location = "<?php echo base_url().'pembelian/daftar_pembelian' ?>";
  });

  $('#validasi').click(function(){
    window.location = "<?php echo base_url().'validasi_request_order/' ?>";
  });

  $('#daftar_po').click(function(){
    window.location = "<?php echo base_url().'pre_order/daftar' ?>";
  });
  $('#stok').click(function(){
    window.location = "<?php echo base_url().'stok/gudang' ?>";
  });
  $('#transaksional').click(function(){
    window.location = "<?php echo base_url().'transaksional' ?>";
  });
  $('#keuangan').click(function(){
    window.location = "<?php echo base_url().'keuangan' ?>";
  });
  
  $('#analisa').click(function(){
    window.location = "<?php echo base_url().'analisa' ?>";
  });
  $('#laporan').click(function(){
    window.location = "<?php echo base_url().'laporan' ?>";
  });
  $('#logout').click(function(){
    window.location = "<?php echo base_url() . 'admin/logout' ?>";
  });

</script>
</body>
</html>
