<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>app/js/datetimepicker.js"></script>

<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
      <?php
	   //if(isset($usersList)) pr($usersList);
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>
    </div>
    <div class="clsMidWrapper">
      <!--MID WRAPPER-->
      <!--TOP TITLE & RESET-->
      <div class="clsTop clsClearFixSub">
        
        <div class="clsNav">
          <ul>
            <li><a href="<?php echo admin_url('packages/addpackages');?>"><b><?= t('Add Package'); ?></b></a></li>
			<li><a href="<?php echo admin_url('packages/searchpackage');?>"><b><?= t('Search Packages'); ?></b></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('packages/viewpackage');?>"><b><?= t('View Packages'); ?></b></a></li>
          </ul>
        </div>
		<div class="clsTitle">
          <h3><?= t('Search Package'); ?></h3>
        </div>
      </div>
      <!--END OF TOP TITLE & RESET-->
	  <br />
      <div class="clsTab">
	  <table class="table" cellpadding="2" cellspacing="0">
		 <form name="searchPackage" action="<?php echo admin_url('packages/searchpackage');?>" method="post">
		    
		     <tr><td class="clsName"><?= t('From'); ?></td><td class="clsMailIds"> <input type="Text" id="from" name="from" maxlength="20" size="20"><a href="javascript:NewCal('from','ddmmmyyyy')"><img src="<?php echo image_url("cal.gif");?>" width="16" height="16" border="0" alt="Pick a date"></a></td></tr>
			 <tr><td class="clsName"><?= t('To'); ?></td><td class="clsMailIds"> <input type="Text" id="to" name="to" maxlength="20" size="20"><a href="javascript:NewCal('to','ddmmmyyyy')"><img src="<?php echo image_url("cal.gif");?>" width="16" height="16" border="0" alt="Pick a date"></a></tr>
			 </tr>
			 <tr><td></td><td><input type="submit" name="searchUsers" value="<?= t('search');?>" class="clsSub" /></td></tr>
		 </form>
	  </table>	 
      </div>
	  <!--PAGING-->
	  	<?php if(isset($pagination_outbox)) echo $pagination_outbox;?>
	 <!--END OF PAGING-->
    </div>
    <!--END OF MID WRAPPER-->
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
