<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>app/js/datetimepicker.js"></script>

<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
	
	<div class="inner_t">
      <div class="inner_r">
        <div class="inner_b">
          <div class="inner_l">
            <div class="inner_tl">
              <div class="inner_tr">
                <div class="inner_bl">
                  <div class="inner_br"> 
				  
      <?php
	   //if(isset($usersList)) pr($usersList);
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>
   
    <div class="clsMidWrapper">
      <!--MID WRAPPER-->
      <!--TOP TITLE & RESET-->
      <div class="clsTop clsClearFixSub">
        
        <div class="clsNav">
          <ul>
          <!-- <li><a href="<?php echo admin_url('packages/addsubscription');?>"><b><?= t('Add Subscription user'); ?></b></a></li>-->
			<li><a href="<?php echo admin_url('packages/searchsubscription');?>"><b><?= t('Search Subscription user'); ?></b></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('packages/viewsubscriptionuser');?>"><b><?= t('View subscribed users'); ?></b></a></li>
          </ul>
        </div>
		<div class="clsTitle">
          <h3><?= t('Search Subscription User'); ?></h3>
        </div>
      </div>
      <!--END OF TOP TITLE & RESET-->
	
      <div class="clsTab">
	  <table class="table" cellpadding="2" cellspacing="0">
		 <form name="searchPackage" action="<?php echo admin_url('packages/searchSubscription');?>" method="post">
		    
		      <tr><td class="clsName"><?= t('Enter Subscription User Id'); ?></td><td class="clsMailIds"><input type="text" name="subuserid" id="subuserid" /></td></tr>
			 <tr><td></td><td><input type="submit" name="search" value="<?= t('search');?>" class="clsSubmitBt1" /></td></tr>
		 </form>
	  </table>	 
      </div>
	  <!--PAGING-->
	  	<?php if(isset($pagination_outbox)) echo $pagination_outbox;?>
	 <!--END OF PAGING-->
	 
	 </div></div></div></div></div></div></div></div> 
	   
    
    </div>
    <!--END OF MID WRAPPER-->
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
