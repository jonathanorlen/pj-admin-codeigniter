<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8"/>
   <title>PATRIOTJAYA-ADMIN</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta content="" name="description"/>
  <meta content="" name="author"/>
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/font-awesome/css/font-awesome.min.css '?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/simple-line-icons/simple-line-icons.min.css '?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css '?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/global/plugins/uniform/css/uniform.default.css '?>" rel="stylesheet" type="text/css"/>
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN PAGE LEVEL STYLES -->
  <link href="<?php echo base_url() . 'component/admin/assets/admin/pages/css/login.css '?>" rel="stylesheet" type="text/css"/>
  <!-- END PAGE LEVEL SCRIPTS -->
  <!-- BEGIN THEME STYLES -->
  <link href="<?php echo base_url() . 'component/admin/assets/global/css/components.css '?>" id="style_components" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/global/css/plugins.css '?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/admin/layout/css/layout.css '?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() . 'component/admin/assets/admin/layout/css/themes/default.css '?>" rel="stylesheet" type="text/css" id="style_color"/>
  <link href="<?php echo base_url() . 'component/admin/assets/admin/layout/css/custom.css '?>" rel="stylesheet" type="text/css"/>
  <!-- END THEME STYLES -->
  <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login" style="background: url(component/img/admin.png)no-repeat center center fixed !important;
-webkit-background-size: cover !important;
  -moz-background-size: cover !important;
  -o-background-size: cover !important;
  background-size: cover !important;">
  <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
  <div class="menu-toggler sidebar-toggler">
  </div>
  <!-- END SIDEBAR TOGGLER BUTTON -->
  <!-- BEGIN LOGO -->
  <div class="logo">
    <!--<a>
      <img src="<?php echo base_url() . 'component/admin/assets/admin/layout2/img/icon-resto.png '?>" alt="" style="width:150px;height:50px;"/>
    </a>-->
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="<?php echo base_url($this->cname).'/login'; ?>" method="post">
      <h3 class="form-title"><img src="<?php echo base_url() . 'component/img/icon-admin.png  '?>" alt="" style="width:150px;height:auto;"/></h3>
      <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>
          Enter any username and password. </span>
        </div>
        <div class="form-group">
          <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
          <label class="control-label visible-ie8 visible-ie9">Username</label>
          <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="login-email"/>
        </div>
        <div class="form-group">
          <label class="control-label visible-ie8 visible-ie9">Password</label>
          <input  onkeydown = "if (event.keyCode == 13)
                        document.getElementById('btn_login').click()" class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="login-password"/>
        </div>
        <div class="form-actions">
          <button type="submit" id="btn_login" class="btn btn-block btn-success uppercase" style="background:#e57716;">Login</button>
         
          </div>

          <div class="create-account" style="background:#29166f;">
            <p>
              <a id="register-btn" class="uppercase">PATRIOTJAYA-ADMIN</a>
            </p>
          </div>
        </form>
        <!-- END LOGIN FORM -->
      </div>
      <div class="copyright" style="color:#fff">
       © Cloud - Astro 2016
     </div>
     <!-- END LOGIN -->
     <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
     <!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/jquery.min.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/jquery-migrate.min.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/bootstrap/js/bootstrap.min.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/jquery.blockui.min.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/uniform/jquery.uniform.min.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/jquery.cokie.min.js '?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url() . 'component/admin/assets/global/plugins/jquery-validation/js/jquery.validate.min.js '?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() . 'component/admin/assets/global/scripts/metronic.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/admin/layout/scripts/layout.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/admin/layout/scripts/demo.js '?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'component/admin/assets/admin/pages/scripts/login.js '?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>