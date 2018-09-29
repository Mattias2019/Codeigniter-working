<?php $this->load->view('header'); ?>
<div class="clsMinContent clearfix">
<p class="home_top">Home &nbsp;&nbsp;/&nbsp;&nbsp; <span  style="color:#f97fbb;">Faq</span></p>
<?php //$this->load->view('sidebar'); ?>
<!--MAIN-->
<style>
.faq_inner,.faq_inner p
{
float:left;
width:100%;
overflow:hidden;
}
.faq_inner label
{
text-align:left !important;
padding:0px;
}
.faq_inner h4 span
{
padding-left:0px !important;
}
.faq_inner h4
{
overflow:hidden;
margin:0px;
}
.red
{
color:red;
}
.clsOptionalDetails ul
{
    overflow: hidden;
    padding-left: 1em !important;
    padding-top: 10px;
    text-align: left;
	}
</style>
<div id="Innermain">

      <!--POST WORK-->
         <div class="clsContact">
         <div class="container">
<div class="row">
 
                            <div class="clsInnerCommon clsSitelinks outer_faq">
                              <h2><span><?= t('title'); ?></span></h2>
 							  
							   <h3><span class="clsCategory"><?= t('sub_title'); ?></span></h3>
							   <div class="clsOptionalDetails">
								<ul>
								 <?php
									if(isset($frequentFaqs) and $frequentFaqs->num_rows()>0)
									{
										foreach($frequentFaqs->result() as $frequentFaq)
										{
								  ?>		
										<li class="clSNoBack"><a href="<?php echo site_url('faq/view/'.$frequentFaq->id); ?>"><?php echo $frequentFaq->question; ?></a></li>
								   <?php
										 }//Foreach End
									}//If End
								   ?>
								</ul>
							  </div>
 							<div class="clsContactForm clSTextDec faq_inner">
							<h4><span class="clsInvoice"><?= t('Guest Sales Questions'); ?></span></h4>
							
							<form method="post" action="#">
							   <p>
								  <span class="col-md-3"><?= t('your_email'); ?><font class="red">*</font></span>
								  <input class="clsText" type="text" name="faq_email" value="<?php echo set_value('faq_email'); ?>" />
								   <?php echo form_error('faq_email'); ?>
							   </p>
							    <p>
								   <span class="col-md-3"><?= t('subject'); ?><font class="red">*</font></span>
								   <input class="clsText" type="text" name="faq_subject"  value="<?php echo set_value('faq_subject'); ?>"/>
								   <?php echo form_error('faq_subject'); ?>
								</p>
								<p>
								   <span class="col-md-3 clsComments"><?= t('comments'); ?><font class="red">*</font></span>
								   <textarea name="faq_comments" rows="10" cols="70"><?php echo set_value('faq_comments'); ?></textarea>
								   <?php echo form_error('faq_comments'); ?>
								</p>
								<p class="clsSubmitBlock">
								   <span class="col-md-3">&nbsp;</span>
								   <input class="clsLogin_but" style="padding:0 10px !important;" type="submit" value="<?= t('submit_button'); ?>" name="faqPosts"/>
								</p>
						   </form>
				           </div>
                          </div>
                         </div>
         
      <!--END OF WORK JOB-->
  										     </div>
                                          </div>
                                       
                          <!--end of RC -->  
      
     </div>
<!--END OF MAIN-->
</div></div> </div>
      </div>
<?php $this->load->view('footer'); ?>
