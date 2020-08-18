<div class="row">               <!-- END STYLE CUSTOMIZER -->
                      <!-- BEGIN PAGE HEADER-->
                      <h3 class="page-title">
                        Master</h3>
                        <div class="page-bar">
                          <ul class="page-breadcrumb">
                            <li>
                              <i class="fa fa-home"></i>
                              <a href="#">Home</a>
                              <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                              <a href="#">Master</a>
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
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<?php
        //ambil total record dari cooling_unit
        //$parameter = $this->uri->segment(2);
        $ambil_data = $this->db->query(" SELECT count(id) as 'total_record' FROM cooling_unit ");
        $hasil_ambil_data_cooling = $ambil_data->row();


        $ambil_data = $this->db->query(" SELECT count(id) as 'total_record' FROM pos_penampungan_susu ");
        $hasil_ambil_data_pos = $ambil_data->row();


        $ambil_data = $this->db->query(" SELECT count(id) as 'total_record' FROM kelompok_anggota ");
        $hasil_ambil_data_kelompok = $ambil_data->row();

        $ambil_data = $this->db->query(" SELECT count(id) as 'total_record' FROM jenis_anggota ");
        $hasil_ambil_data_jenis_anggota = $ambil_data->row();


  ?>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-light blue-soft" id="rak">
      <div class="visual">
        <i class="glyphicon glyphicon-taskss" >></i>
      </div>
      <div class="details" >
        <div class="number">
         <?php echo $hasil_ambil_data_cooling->total_record?>
       </div>
       <div class="desc">
         Rak
       </div>
     </div>
   </a>
 </div>
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light red-soft"  id="bahan_baku">
    <div class="visual">
      <i class="glyphicon glyphicon-shopping-cart"></i>
    </div>
    <div class="details">
      <div class="number">
       <?php echo $hasil_ambil_data_pos->total_record?>
     </div>
     <div class="desc">
       Bahan Baku
     </div>
   </div>
 </a>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light green-soft" id="user">
    <div class="visual">
      <i class="glyphicon glyphicon-th" ></i>
    </div>
    <div class="details">
      <div class="number">
       <?php echo $hasil_ambil_data_kelompok->total_record?>
     </div>
     <div class="desc">
      User
     </div>
   </div>
 </a>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <a class="dashboard-stat dashboard-stat-light purple-soft" id="suplier">
    <div class="visual">
      <i class="glyphicon glyphicon-user" ></i>
    </div>
    <div class="details">
      <div class="number">
        <?php echo $hasil_ambil_data_jenis_anggota->total_record?>
     </div>
     <div class="desc">
        Supplier
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


  $("#rak").click(function(){
    window.location = "<?php echo base_url() . 'master/rak' ?>";

  });
  

  $("#bahan_baku").click(function(){
    window.location = "<?php echo base_url() . 'master/bahan_baku' ?>";
  });

  $("#user").click(function(){
    window.location = "<?php echo base_url() . 'master/user' ?>";
  });

  $("#suplier").click(function(){
    window.location = "<?php echo base_url() . 'master/supplier' ?>";
  });

});
</script>
