<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($faqCategories) and $faqCategories->num_rows()>0)
		{
			$faqCategory = $faqCategories->row();
	  ?>
	 	<h3><?= t('edit_group'); ?></h3>
	 	<table class="table" cellpadding="2" cellspacing="0">
		 <form method="post" action="#">
          <tr><td>
          <label><?= t('faq_category_name'); ?><span class="clsRed">*</span></label></td><td>
          <input class="clsTextBox" type="text" name="faq_category_name" value="<?php echo $faqCategory->category_name; ?>"/>
          <?php echo form_error('faq_category_name'); ?></td></tr>
          <tr><td></td><td>
		  <input type="hidden" name="operation" value="edit" />
		  <input type="hidden" name="id"  value="<?php echo $faqCategory->id; ?>"/>
          <input type="submit" class="clsSubmitBt1" value="<?= t('submit'); ?>"  name="editFaqCategory"/></td></tr>
        </p>
      </form>
	  </table>
	  <?php
	  }
	  ?>
    </div>
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
