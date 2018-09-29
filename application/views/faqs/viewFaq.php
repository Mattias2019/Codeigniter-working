<?php $this->load->view('header'); ?>
<div class="clsMinContent clearfix">
<?php //$this->load->view('sidebar'); ?>
<!--MAIN-->
<?php
		//Get Work Info
     	$faq = $faqs->row();
?>
<style>
.faq_display{
text-align:left;
}
</style>
<div id="main">
	  <!--POST WORK-->
      <div class="clsContact">
        
                            <div class="clsInnerCommon">
							<div class="container">
							<div class="row">
							
                              <h2><span><?= t('title'); ?></span></h2>
							  

							  <!--FAQ ANSWER-->
							  <div class="faq_display">
							  <p style="color:#039CE2;font-weight:bold;padding-left:1em!important;"><?php echo $faq->question ?></p>
							  <p style="padding:0 0 0 1em !important;"><?php echo $faq->answer ?>.</p>
							<!--  <p><b>Related Topics:</b></p>-->
							<!-- <ul>
									<li><a href="#">Owners</a></li>		
									<li><a href="#">Employees</a></li>
								 </ul>-->
							  </div>
							  <!--END OF FAQ ANSWER-->
							</div>
							</div></div></div></div>

        </div>
      </div>
      <!--END OF POST WORK-->
<!--END OF MAIN-->
   </div>
      </div>
<?php $this->load->view('footer'); ?>
