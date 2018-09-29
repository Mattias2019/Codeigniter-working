<?php $this->load->view('header1'); ?>

<div class="add-faq-category">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add FAQ Category</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('add_faq_category'); ?>
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
				  
                <?php
                    //Show Flash Message
                    if($msg = $this->session->flashdata('flash_message'))
                    {
                        echo $msg;
                    }
                ?>
                    
		<table class="table" cellpadding="2" cellspacing="0">
		 <form method="post" action="<?php echo admin_url('faq/addFaqCategory')?>">
        <tr>
		    <td><?= t('faq_category_name'); ?><span class="clsRed">*</span></td>
		    <td><input class="clsTextBox" type="text" name="faq_category_name" value="<?php echo set_value('faq_category_name'); ?>"/><?php echo form_error('faq_category_name'); ?></td>
		</tr>
         <tr>
		    <td></td>
			<td> <input type="hidden" name="operation" value="add" />
              <input type="submit" class="clsSubmitBt1" value="<?= t('submit'); ?>"  name="addFaqCategory"/>
		    </td>
		</tr>		  

      </form>
	  </table>
	  
	   </div></div></div></div></div></div></div></div> 
	  
    </div>
  </div>
  <!-- End of clsSettings -->
</div>

<?php $this->load->view('footer1'); ?>
