<?php $this->load->view('header'); ?>
<?php //$this->load->view('sidebar'); ?>
<!--MAIN-->

<div id="main">
	  <!--POST WORK-->
      <div class="clsContact">
        <div class="block">
          <div class="inner_t">
            <div class="inner_r">
              <div class="inner_b">
                <div class="inner_l">
                  <div class="inner_tl">
                    <div class="inner_tr">
                      <div class="inner_bl">
                        <div class="inner_br">
                          <div class="cls100_p">
                            <div class="clsInnerCommon">
							  <!--FAQ ALL LINKS-->
							  <div class="container">
							  <div class="row">
							  <div id="selFAQLinks" class="clsMarginTop">
								<h3><span class="clsCategory"><?= t('View FAQ');?></span></h3>
								<ul>
								  <?php
										if(isset($FaqCategoriesWithFaqs) and count($FaqCategoriesWithFaqs)>0 )
										{
											foreach($FaqCategoriesWithFaqs as $FaqCategoriesWithFaq)
											{
												if($FaqCategoriesWithFaq['num_faqs']>0)
												{				
								?>
								  <li><b><a href="#"><?php echo $FaqCategoriesWithFaq['faq_category_name']?></a></b>
									<ul>
									  <?php
											foreach($FaqCategoriesWithFaq['faqs']->result() as $faq)
											{
										 ?>
									  <li><a href="<?php echo site_url('faq/view/'.$faq->id); ?>"><?php echo $faq->question;  ?></a></li>
									  <?php
									} //Foreach End - Traverse Category
								?>
									</ul>
								  </li>
								  <?php
												}//Check For Faq Availability
										} //For Each Travesal - For Faq
									}//If End - Check For Faq Existence
								?>
								</ul>
							  </div></div></div>
							  <!--END OF FAQ ALL LINKS-->
							</div>
							</div>
                           </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--END OF WORK JOB-->
<!--END OF MAIN-->
<?php $this->load->view('footer'); ?>