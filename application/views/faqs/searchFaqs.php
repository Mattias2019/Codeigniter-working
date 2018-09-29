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
							<div class="container">
							<div class="row">
							<h2><span><?= t('Search Result');?></span></h2>
							 <h3><span class="clsViewPro"><?= t('Search result for');?> <b><?php echo $keyword;?></b></span></h3>
								  <!--FAQ ANSWER-->
								  <div id="selFAQ" class="clsMarginTop">
								  <ul>
								  <?php
									if(isset($faqs) and $faqs->num_rows()>0)
									{
									foreach($faqs->result() as $faq)
									{
								  ?>
								  <li><a href="<?php echo site_url('faq/view/'.$faq->id); ?>"><?php echo highlight_phrase($faq->question,$keyword,'<b>','</b>');?></a></li>
								  <?php } }
								  else
								  echo t('No records found');?>
								  </ul>
								  </div>
								  <!--END OF FAQ ANSWER-->
								</div>
								</div></div></div>
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
<!--END OF MAIN-->
<?php $this->load->view('footer'); ?>