<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>

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
      <div class="clsTop clearfix">
        <div class="clsNav">
          <ul>
            <li><a href="<?php echo admin_url('skills/searchJobs');?>"><b><?= t('Search'); ?></b></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('skills/viewJobs');?>"><b><?= t('View All'); ?></b></a></li>
          </ul>
        </div>
		        <div class="clsTitle">
          <h3>Search Jobs<?php //echo t('Search Projects'); ?></h3>
        </div>

      </div>
      <!--END OF TOP TITLE & RESET-->
	  <table width="700" class="table">
	   <div class="clsTable">
		 <form name="searchTransaction" action="<?php echo admin_url('skills/searchJobs');?>" method="post">
			<input type="hidden" name="name" id="name" />
			 <tr><td><?= t('Enter Job Id'); ?></td><td><input type="text" name="projectid" id="projectid" /></td></tr>
			 <tr><td></td><td><input type="submit" name="search" value="<?= t('search');?>" class="clsSubmitBt1" /></td></tr>
		</form>
				
		</div>
		<div class="clsTable">
		 <form name="searchTransaction" action="<?php echo admin_url('skills/searchJobs');?>" method="post">
			 <input type="hidden" name="id" id="id" />
			 <tr><td><?= t('Enter Job Name'); ?></td><td><input type="text" name="projectname" id="projectname" /></td></tr>
			 <tr><td></td><td><input type="submit" name="search" value="<?= t('search');?>" class="clsSubmitBt1" /></td></tr>
		</form>
		</div>
	  <div id="searchform">
	   <!-- The keyword Field will display here -->
	  </div>
     </table>
	  
	  <!--PAGING-->
	  	<?php if(isset($pagination_outbox)) echo $pagination_outbox;?>
	 <!--END OF PAGING-->
    </div>
    <!--END OF MID WRAPPER-->
	
	</div></div></div></div></div></div></div></div>  
	
	</div>
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
<script type="text/javascript">
function searchtype()
{
	alert('hi');
	var url = '<?php echo $admin_url('skills/searchJobs/search'); ?>';
	new Ajax.Updater('searchform', url, {  method     : 'post',
									parameters :$('search')
					}); //Ajax Object Creation End
}
</script>
