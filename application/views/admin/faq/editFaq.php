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
	
	   <!--TOP TITLE & RESET-->
      <div class="clsTop clearfix">
       
        <div class="clsNav">
          <ul>
            <li><a href="<?php echo admin_url('users/addAdmin');?>"><b><?= t('Add Admin'); ?></b></a></li>
			<li><a href="<?php echo admin_url('users/searchAdmin');?>"><b><?= t('Search'); ?></b></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('users/viewAdmin');?>"><b><?= t('View All'); ?></b></a></li>
          </ul>
        </div>
		 <div class="clsTitle">
          <h3><?= t('Edit FAQ'); ?></h3>
        </div>
      </div>
      <!--END OF TOP TITLE & RESET-->
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($faqs) and $faqs->num_rows()>0)
		{
			$faq = $faqs->row();
	  ?>
	<!-- 	<h3><?= t('edit_group'); ?></h3>-->
		<table class="table" cellpadding="2" cellspacing="0">
		 <form method="post" action="#">
		  <tr><td  class="clsName">
          <?= t('faq_category'); ?><span class="clsRed">*</span></td><td>
          <select name="faq_category_id" class="usertype">		  	<option value=""><?= t('select_category'); ?></option>
			<?php
				if(isset($faqCategories) and $faqCategories->num_rows()>0)
				{
					foreach($faqCategories->result() as $faqCategory)
					{
			?>
						<option value="<?php echo $faqCategory->id; ?>" <?php if($faq->faq_category_id==$faqCategory->id) echo 'selected="selected"'; ?> ><?php echo $faqCategory->category_name; ?></option>
       		<?php
					}//Foreach End
				}//If End
			?>
		  </select></td></tr>
          <?php echo form_error('faq_category_id'); ?> </p>
         <tr><td class="clsName">
          <?= t('question'); ?><span class="clsRed">*</span></td><td>
		  <textarea class="clsTextArea" name="question"><?php echo $faq->question; ?></textarea>
          <?php echo form_error('question'); ?> <br />
          </td></tr>
	      <tr><td class="clsName">
          <?= t('answer'); ?><span class="clsRed">*</span></td><td>
		  <textarea class="clsTextArea" name="answer"><?php echo $faq->answer; ?></textarea>
          <?php echo form_error('answer'); ?> <br />
          </td></tr>
	      <tr><td class="clsName">
          <?= t('Is frequently asked question?');?></td><td>
		  <input name="is_frequent" value="Y" class="clsNoborder clsRadioBut" type="checkbox"  <?php if($faq->is_frequent=='Y') echo 'checked="checked"'; ?>/><?= t('Yes');?>
          </td></tr>
          <tr><td></td><td>         
		  <input type="hidden" name="id"  value="<?php echo $faq->id; ?>"/>
          <input type="submit" class="clsSubmitBt1" value="<?= t('submit'); ?>"  name="editFaq"/></td></tr>
       
      </form>
	  </table>
	  <?php
	  }
	  ?>
	  
	  </div></div></div></div></div></div></div></div>  
	  
    </div>
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
