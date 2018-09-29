<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<title>Admin Section</title>
<script type="text/javascript" src="<?php echo base_url() ?>application/js/prototype.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url() ?>application/js/scriptaculous.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>application/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/js/datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/css/admin.css" />
</head>
<body>

<!--LAYOUT-->

<div class="clsContainer">
   <!--HEADER-->
   <div id="header" class="clsClearFixSub">
    <div id="selLeftHeader" class="clsFloatLeft">
      <h1 class="logo"> <a href="<?php echo admin_url('home'); ?>"><?php echo $this->config->item('site_title'); ?></a></h1>
    </div>
	    <div id="selRightHeader" class="clsFloatRight">
		  <ul id="mainnav">
			<li class="clsActive"><a href="<?php echo admin_url('home');?>"><?= t('admin_home'); ?></a></li>
			<li><a href="<?php echo base_url();?>"><?= t('site_home'); ?></a></li>
			<li><a href="<?php echo admin_url('logout');?>"><?= t('log_out'); ?></a></li>
		  </ul>
		  <div style="font-size: 18px;font-weight: bold; left: 315px; position: relative;right: 0; top: 50px;width: 180px;"><?= t('Installed Version'); ?> -<span style="color:#1499E4;font-weight:bold;"> 1.0</span></div>
	    </div>
    </div>
  <!--END OF HEADER-->
  <!--WRAPPERR-->
  <div id="wrapper">
    <!--MAIN-->
  <!--CONTENT BLOCK-->
  <div id="content"> 