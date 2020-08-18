
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
  <div class="theme-panel">
    <div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
      <i class="icon-settings"></i>
    </div>
    <div class="toggler-close">
      <i class="icon-close"></i>
    </div>
    <div class="theme-options">
      <div class="theme-option theme-colors clearfix">
        <span>
          THEME COLOR </span>
          <ul>
            <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default">
            </li>
            <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey">
            </li>
            <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue">
            </li>
            <li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark">
            </li>
            <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light">
            </li>
          </ul>
        </div>
        <div class="theme-option">
          <span>
            Theme Style </span>
            <select class="layout-style-option form-control input-small">
              <option value="square" selected="selected">Square corners</option>
              <option value="rounded">Rounded corners</option>
            </select>
          </div>
          <div class="theme-option">
            <span>
              Layout </span>
              <select class="layout-option form-control input-small">
                <option value="fluid" selected="selected">Fluid</option>
                <option value="boxed">Boxed</option>
              </select>
            </div>
            <div class="theme-option">
              <span>
                Header </span>
                <select class="page-header-option form-control input-small">
                  <option value="fixed" selected="selected">Fixed</option>
                  <option value="default">Default</option>
                </select>
              </div>
              <div class="theme-option">
                <span>
                  Top Dropdown</span>
                  <select class="page-header-top-dropdown-style-option form-control input-small">
                    <option value="light" selected="selected">Light</option>
                    <option value="dark">Dark</option>
                  </select>
                </div>
                <div class="theme-option">
                  <span>
                    Sidebar Mode</span>
                    <select class="sidebar-option form-control input-small">
                      <option value="fixed">Fixed</option>
                      <option value="default" selected="selected">Default</option>
                    </select>
                  </div>
                  <div class="theme-option">
                    <span>
                      Sidebar Style</span>
                      <select class="sidebar-style-option form-control input-small">
                        <option value="default" selected="selected">Default</option>
                        <option value="compact">Compact</option>
                      </select>
                    </div>
                    <div class="theme-option">
                      <span>
                        Sidebar Menu </span>
                        <select class="sidebar-menu-option form-control input-small">
                          <option value="accordion" selected="selected">Accordion</option>
                          <option value="hover">Hover</option>
                        </select>
                      </div>
                      <div class="theme-option">
                        <span>
                          Sidebar Position </span>
                          <select class="sidebar-pos-option form-control input-small">
                            <option value="left" selected="selected">Left</option>
                            <option value="right">Right</option>
                          </select>
                        </div>
                        <div class="theme-option">
                          <span>
                            Footer </span>
                            <select class="page-footer-option form-control input-small">
                              <option value="fixed">Fixed</option>
                              <option value="default" selected="selected">Default</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <!-- END STYLE CUSTOMIZER -->
                      <!-- BEGIN PAGE HEADER-->
                      <h3 class="page-title">
                        Dashboard</h3>
                        <div class="page-bar">
                          <ul class="page-breadcrumb">
                            <li>
                              <i class="fa fa-home"></i>
                              <a href="#">Home</a>
                              <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                              <a href="#">Dashboard</a>
                            </li>
                          </ul>
                          <div class="page-toolbar">
                            <div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left" data-original-title="Change dashboard date range">
                              <i class="icon-calendar"></i>
                              &nbsp;&nbsp; <i class="fa fa-angle-down"></i>
              <!-- uncomment this to display selected daterange in the button 
&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp;
<i class="fa fa-angle-down"></i>
-->
</div>
</div>
</div>

<!-- <div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="daftar_cooling">
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" >></i>
      </div>
      <div class="details" >
        <div class="number">
         
       </div>
       <div class="desc">
        Coolling Unit
      </div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light red-soft"  id="daftar_pos"">
    <div class="visual">
      <i class="glyphicon glyphicon-shopping-cart"></i>
    </div>
    <div class="details">
      <div class="number">

     </div>
     <div class="desc">
       POS Penampungan Susu
     </div>
   </div>
 </a>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light green-soft" id="daftar_kelompok">
    <div class="visual">
      <i class="glyphicon glyphicon-th" ></i>
    </div>
    <div class="details">
      <div class="number">
       
     </div>
     <div class="desc">
      Kelompok
    </div>
  </div>
</a>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light purple-soft" id="daftar_jenis">
    <div class="visual">
      <i class="glyphicon glyphicon-user" ></i>
    </div>
    <div class="details">
      <div class="number">
        
      </div>
      <div class="desc">
        Jenis Anggota 
      </div>
    </div>
  </a>
</div> -->

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


        $("#daftar_cooling").click(function(){
          window.location = "<?php echo base_url() . 'cooling_unit/daftar' ?>";

        });


        $("#daftar_pos").click(function(){
          window.location = "<?php echo base_url() . 'pps/daftar' ?>";
        });

        $("#daftar_jenis").click(function(){
          window.location = "<?php echo base_url() . 'jenis_anggota/daftar' ?>";
        });

        $("#daftar_kelompok").click(function(){
          window.location = "<?php echo base_url() . 'Kelompok/daftar' ?>";
        });

      });
    </script>
