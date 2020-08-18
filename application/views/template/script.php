<meta name="description" content="">
<meta name="author" content="Utomo Sakti">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>public/img/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo base_url(); ?>public/img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>public/img/apple-touch-icon-57x57-precomposed.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>public/img/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>public/img/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href='<?php echo base_url(); ?>public/css/fonts.css'>
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap-1.03.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/plugins-1.03.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/main-1.03.css">

<?php
	$url = $this->uri->segment(2);
	if($url==NULL || $url=='dashboard'){
		$this->load->view('template/dashboard-js-top');
	} else {
		$this->load->view('template/js-top');
	}
?>

<script src="<?php echo base_url(); ?>public/js/vendor/modernizr-2.6.2-respond-1.3.0.min.js"></script>