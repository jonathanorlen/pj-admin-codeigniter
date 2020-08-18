
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="">
  <div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            Widget settings form goes here
          </div>
          <div class="modal-footer">
            <button type="button" class="btn blue">Save changes</button>
            <button type="button" class="btn default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN STYLE CUSTOMIZER -->

    <!-- END STYLE CUSTOMIZER -->
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
      Penjualan Jasa</h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            <a href="#">Penjualan Jasa</a>
          </li>
        </ul>
        <div class="page-toolbar">

        </div>
      </div>

      <div class="row">
        

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <a class="dashboard-stat dashboard-stat-light red-soft" style="background-color:#e57716 "  id="kasir">
            <div class="visual">
              <i class="glyphicon glyphicon-shopping-cart" ></i>
            </div>
            <div class="details">
              <div class="number">

              </div>
              <div class="desc">
                Penjualan Jasa
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <a class="dashboard-stat dashboard-stat-light red-soft" style="background-color:#e57716 "  id="daftar_jasa">
            <div class="visual">
              <i class="glyphicon glyphicon-retweet" ></i>
            </div>
            <div class="details">
              <div class="number">

              </div>
              <div class="desc">
                Daftar Penjualan Jasa
              </div>
            </div>
          </a>
        </div>

         
        
      

    

      </div>
      <!-- END DASHBOARD STATS -->
      <div class="clearfix">
      </div>
<div class="row"><!--
<div class="col-md-6 col-sm-6">

<div class="portlet light ">
<div class="portlet-title">
<div class="caption">
<i class="icon-bar-chart font-green-sharp hide"></i>
<span class="caption-subject font-green-sharp bold uppercase">Site Visits</span>
<span class="caption-helper">weekly stats...</span>
</div>
<div class="actions">
<div class="btn-group btn-group-devided" data-toggle="buttons">
<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
<input type="radio" name="options" class="toggle" id="option1">New</label>
<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
<input type="radio" name="options" class="toggle" id="option2">Returning</label>
</div>
</div>
</div>
<div class="portlet-body">
<div id="site_statistics_loading">
<img src="../../assets/admin/layout2/img/loading.gif" alt="loading"/>
</div>
<div id="site_statistics_content" class="display-none">
<div id="site_statistics" class="chart">
</div>
</div>
</div>
</div>

</div>-->


<!--<div class="col-md-6 col-sm-6">
BEGIN PORTLET
<div class="portlet light ">
<div class="portlet-title">
<div class="caption">
<i class="icon-share font-red-sunglo hide"></i>
<span class="caption-subject font-red-sunglo bold uppercase">Revenue</span>
<span class="caption-helper">monthly stats...</span>
</div>
<div class="actions">
<div class="btn-group">
<a href="" class="btn grey-salsa btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
Filter Range&nbsp;<span class="fa fa-angle-down">
</span>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="javascript:;">
Q1 2014 <span class="label label-sm label-default">
past </span>
</a>
</li>
<li>
<a href="javascript:;">
Q2 2014 <span class="label label-sm label-default">
past </span>
</a>
</li>
<li class="active">
<a href="javascript:;">
Q3 2014 <span class="label label-sm label-success">
current </span>
</a>
</li>
<li>
<a href="javascript:;">
Q4 2014 <span class="label label-sm label-warning">
upcoming </span>
</a>
</li>
</ul>
</div>
</div>
</div>
<div class="portlet-body">
<div id="site_activities_loading">
<img src="../../assets/admin/layout2/img/loading.gif" alt="loading"/>
</div>
<div id="site_activities_content" class="display-none">
<div id="site_activities" style="height: 228px;">
</div>
</div>
<div style="margin: 20px 0 10px 30px">
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
<span class="label label-sm label-success">
Revenue: </span>
<h3>$13,234</h3>
</div>
<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
<span class="label label-sm label-danger">
Shipment: </span>
<h3>$1,134</h3>
</div>
<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
<span class="label label-sm label-primary">
Orders: </span>
<h3>235090</h3>
</div>
</div>
</div>
</div>
</div>

</div>-->

</div>
<!--  -->                                        
<!-- END QUICK SIDEBAR -->
</div>    
</div>
<script type="text/javascript">
  $(document).ready(function(){

    $("#po").click(function(){
      $('.tunggu').show();
      window.location = "<?php echo base_url() . 'pre_order/daftar' ?>";

    });
    $("#kasir").click(function(){
      $('.tunggu').show();
      window.location = "<?php echo base_url() . 'kasir/' ?>";

    });
    $("#daftar_jasa").click(function(){
      $('.tunggu').show();
      window.location = "<?php echo base_url() . 'kasir/penjualan_jasa' ?>";

    });

    $("#list_transaksi").click(function(){
      $('.tunggu').show();
      window.location = "<?php echo base_url() . 'kasir/list_transaksi' ?>";

    });
    


  });
</script>
