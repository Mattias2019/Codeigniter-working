<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<title>Admin Section</title>
<script type="text/javascript" src="<?php echo base_url() ?>application/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/js/scriptaculous.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/js/script.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/css/admin.css" />
</head>
<style>
#wrapper {
    clear: both;
    margin-bottom: 0;
    margin-left: auto;
    margin-right: auto;
    margin-top: 0;
    min-height: 315px;
    overflow-x: hidden;
    overflow-y: hidden;
    padding-bottom: 10px;
    padding-left: 0;
    padding-right: 0;
    padding-top: 50px;
    width: 1000px;
}
#sellogin {
    padding: 0;
}
.message {
	/*background-color:#F3F5F4;*/
	width:auto;
	margin:0em auto;
	}
.error {
	padding:10px 0px 10px 40px;
	color:red;
	text-align:left;
	font-size:16px;
	width:320px;
	margin:0 auto;
	}
.success {
	padding:11px 0px 10px 40px;
	color:green;
	text-align:left;
	font-size:16px;
	width:250px;
	margin:0 auto;
	}
	
</style>

<body>
<!--LAYOUT-->
<!--HEADER-->
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
        <?php if(isset($adminlogin)) { ?> <li><a href="<?php echo admin_url('logout');?>" class="logout"> <?php  echo t('log_out');?> </a></li> <?php  } ?>
       </ul>
	  </div>
    </div>

<!--END OF HEADER-->
<!--WRAPPERR-->
<div id="wrapper">
  <!--MAIN-->
  <!--CONTENT BLOCK-->
  <div id="sellogin">
   <div class="innercontent">
  <div class="admin_t">
      <div class="admin_r">
        <div class="admin_b">
          <div class="admin_l">
            <div class="admin_tl">
              <div class="admin_tr">
                <div class="admin_bl">
                  <div class="admin_br">
               

    <!--CONTENT-->
   
      <h2><?= t('Member Area');?> - <?= t('login'); ?> </h2>
	  
	      <?php
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
	  	?>
	  
      <div class="form_error"> </div>
      <form method="post" action="<?php echo admin_url('login'); ?>">
        <p>
          <label><?= t('username'); ?><span class="clsRed">*</span></label>
          <input class="focus" type="text" name="username" value="<?php echo set_value('username'); ?>"/>
        </p>
        <?php if(form_error('username')) { ?>
        <p>
          <label>&nbsp;</label>
          <img src="<?php echo image_url('error.jpg');?>" height="12" width="12" /><?php echo form_error('username'); ?></p>
        <?php } ?>
        <p>
          <label><?= t('password'); ?><span class="clsRed">*</span></label>
          <input class="focus" type="password" name="pwd" value=""/>
        </p>
        <p>
          <?php if(form_error('pwd')) { ?>
          <label>&nbsp;</label>
          <img src="<?php echo image_url('error.jpg');?>" height="12" width="12" /><?php echo form_error('pwd'); ?> </p>
        <?php } ?>
        <p>
          <label style="width:31%;">&nbsp;</label>
          <input class="clsSubmitBt1 " value="<?= t('Submit');?>" name="loginAdmin" type="submit">
          <input class="clsSubmitBt1" value="<?= t('Reset');?>" name="reset" type="reset">
        </p>
      </form>
    </div>
    <!--END OF CONTENT-->

<!-- Main Content End-->
</div></div></div></div></div></div></div></div>
<?php $this->load->view('admin/footer'); ?>
</body>