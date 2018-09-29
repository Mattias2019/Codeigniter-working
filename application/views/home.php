<?php $this->load->view('header'); ?>

<div class="homecontainer">
	<div class="container">
        <div class="col-md-8 col-sm-12 col-xs-12 no-padding">

            <div class="banner-box">
                <h1><?= t($this->config->item('site_title')); ?></h1>
                <p><?= t($this->config->item('site_slogan')); ?></p>
            </div>

            <div class="banner-btn">
                <?php if (!$this->logged_in_user) { ?>
                <div class="col-sm-6 col-xs-12">
                    <a class="cls_signupbox" href="<?php echo site_url('account/signup'); ?>?type=supplier">
                        <div class="cls_signupsel">
                            <span class="cls_hedsign"><?= t('Sign Up to sell'); ?></span>
                            <p><?= t('industrial machines'); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a class="cls_signupbox cls_tentr" href="<?php echo site_url('account/signup'); ?>?type=enterprise">
                        <div class="cls_signupsel cls_signuptendr">
                            <span class="cls_hedsign"><?= t('Sign up to tender'); ?></span>
                            <p><?= t('industrial machinery'); ?></p>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>

        </div>
	</div>
</div>

<div class="cls_industryslide clearfix">

	<div class="cls_title cls_poup clearfix">
    	<h2><?= t('Popular industries & machinery'); ?></h2>
        <p><span class="cls_underlinetilr"></span></p>
    </div>

	<?php if (isEntrepreneur() or isProvider()) { ?>
    <div class="container">
    	<div class="row">
			<div class="search-box-top col-xs-12">
			   <div class="clsSearch">
				  <form action="<?php echo site_url(isEntrepreneur()?'search/machinery':(isProvider()?'search/tender':'')); ?>" method="get" name="search" id="search">
                        <input type="text" id="inputTextboxes" placeholder="Search Projects" name="keyword">
                        <input type="hidden" name="type" value="Search Projects">
                        <input type="hidden" name="category">
                        <img src="<?php echo image_url('search.png');?>" alt="" id="sear">
					  	<input type="submit" value="" class="clsSearch_icon" />
                  </form>
               </div>
			</div>
        </div>
    </div>
    <?php } ?>

	<div class="container cls_skslide_container">
        <div id="carousel-industries" class="fade">
            <?php for ($i = 0; $i < 3; $i++) { ?>
                <div class="cls_divlist mod_fix">
                    <div class="thumbnail clearfix">
                        <img src="<?php echo image_url('industry-img-banr1.png');?>" alt="<?= t('Health & Care'); ?>">
                        <div class="caption">
                            <h5><?= t('Health & Care'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="cls_divlist mod_fix">
                    <div class="thumbnail clearfix">
                        <img src="<?php echo image_url('industry-img-banr2.png');?>" alt="<?= t('IT & Telecommunications'); ?>">
                        <div class="caption">
                            <h5><?= t('IT & Telecommunications'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="cls_divlist mod_fix">
                    <div class="thumbnail clearfix">
                        <img src="<?php echo image_url('industry-img-banr3.png');?>" alt="<?= t('Aerospace Engineering'); ?>">
                        <div class="caption">
                            <h5><?= t('Aerospace Engineering'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="cls_divlist mod_fix">
                    <div class="thumbnail clearfix">
                        <img src="<?php echo image_url('industry-img-banr4.png');?>" alt="<?= t('Automotive Engineering'); ?>">
                        <div class="caption">
                            <h5><?= t('Automotive Engineering'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="cls_divlist mod_fix">
                    <div class="thumbnail clearfix">
                        <img src="<?php echo image_url('industry-img-banr5.png');?>" alt="<?= t('Chemicals & Pharmaceuticals'); ?>">
                        <div class="caption">
                            <h5><?= t('Chemicals & Pharmaceuticals'); ?></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>

<div class="cls_expert clearfix">

    <div class="cls_title clearfix">
        <h2><?= t('Connected Experts'); ?></h2>
        <p><span class="cls_underlinetilr"></span></p>
    </div>

    <div class="container cls_skslide_container">
        <div id="carousel-experts" class="fade">
            <?php for ($i = 0; $i < 3; $i++) { ?>

                <div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_slideimg-cls">
                        <img src="<?php echo image_url(); ?>expert-img-ban1.png" class="img-responsive" alt="Slide14"/>
                    </div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_bgcont">
                        <div class="cls_slide-maincont">
                            <h4><a href="#">Arnold Raynolds</a></h4>
                            <div class="cls_slid-populrhe">
                                <p><span>popular</span></p>
                                <p class="cls_slidercontnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                <p class="cls_slid-learn"><a class="text-primary" href="#"><?= t('Learn'); ?> > </a></p>
                            </div>
                            <p class="cls_slid-calndr">Monday-Friday</p>
                            <p class="cls_slide-location">22 Park str, New York</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_bgcont">
                        <div class="cls_slide-maincont">
                            <h4><a href="#">Arnold Raynolds</a></h4>
                            <div class="cls_slid-populrhe">
                                <p class="cls_slidercontnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                <p class="cls_slid-learn"><a class="text-primary" href="#"><?= t('Learn'); ?> > </a></p>
                            </div>
                            <p class="cls_slid-calndr">Monday-Friday</p>
                            <p class="cls_slide-location">22 Park str, New York</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_slideimg-cls">
                        <img src="<?php echo image_url(); ?>expert-img-ban2.png" class="img-responsive" alt="Slide14"/>
                    </div>
                </div>

                <div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_slideimg-cls">
                        <img src="<?php echo image_url(); ?>expert-img-ban3.png" class="img-responsive" alt="Slide14"/>
                    </div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_bgcont">
                        <div class="cls_slide-maincont">
                            <h4><a href="#">Arnold Raynolds</a></h4>
                            <div class="cls_slid-populrhe">
                                <p class="cls_slidercontnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                <p class="cls_slid-learn"><a class="text-primary" href="#"><?= t('Learn'); ?> > </a></p>
                            </div>
                            <p class="cls_slid-calndr">Monday-Friday</p>
                            <p class="cls_slide-location">22 Park str, New York</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_bgcont">
                        <div class="cls_slide-maincont">
                            <h4><a href="#">Arnold Raynolds</a></h4>
                            <div class="cls_slid-populrhe">
                                <p class="cls_slidercontnt">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                <p class="cls_slid-learn"><a class="text-primary" href="#"><?= t('Learn'); ?> > </a></p>
                            </div>
                            <p class="cls_slid-calndr">Monday-Friday</p>
                            <p class="cls_slide-location">22 Park str, New York</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 no-padding cls_slideimg-cls">
                        <img src="<?php echo image_url(); ?>expert-img-ban4.png" class="img-responsive" alt="Slide14"/>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

</div>

<div class="how-it-work clearfix">

    <div class="cls_title cls_white clearfix">
        <h2><?= t('How it works'); ?></h2>
        <p><span class="cls_underlinetilr"></span></p>
    </div>

    <div class="container">
        <div class="cls_howitwros clearfix">
            <hr class="how-it-work-line"/>
            <div class="how-it-work-steps-box">
                <a href="#">
                    <div class="circl-icon">
                        <img class="circle_icn" src="<?php echo image_url('howit-1.png'); ?>" alt="<?= t('Release payment and comment'); ?>" title=""/>
                    </div>
                    <span>1.</span>
                    <h5><?= t('Post your project'); ?></h5>
                </a>
            </div>
            <div class="how-it-work-steps-box">
                <a href="#">
                    <div class="circl-icon">
                        <img class="circle_icn" src="<?php echo image_url('howit-2.png'); ?>" alt="<?= t('Release payment and comment'); ?>" title=""/>
                    </div>
                    <span>2.</span>
                    <h5><?= t('Select an expert'); ?></h5>
                </a>
            </div>
            <div class="how-it-work-steps-box">
                <a href="#">
                    <div class="circl-icon">
                        <img class="circle_icn" src="<?php echo image_url('howit-3.png'); ?>" alt="<?= t('Release payment and comment'); ?>" title=""/>
                    </div>
                    <span>3.</span>
                    <h5><?= t('Deposit escrow'); ?> <span> (optional)</span></h5>
                </a>
            </div>
            <div class="how-it-work-steps-box">
                <a href="#">
                    <div class="circl-icon">
                        <img class="circle_icn" src="<?php echo image_url('howit-4.png'); ?>" alt="<?= t('Release payment and comment'); ?>" title=""/>
                    </div>
                    <span>4.</span>
                    <h5><?= t('Review and Approve'); ?></h5>
                </a>
            </div>
            <div class="how-it-work-steps-box">
                <a href="#">
                    <div class="circl-icon">
                        <img class="circle_icn" src="<?php echo image_url('howit-5.png'); ?>" alt="<?= t('Release payment and comment'); ?>" title=""/>
                    </div>
                    <span>5.</span>
                    <h5><?= t('Release payment and comment'); ?></h5>
                </a>
            </div>
        </div>

    </div>
</div>

<div class="cls_why-join clearfix">

    <div class="cls_title clearfix">
        <h2><?= t('Why join Machinery Marketplace?'); ?></h2>
        <p><span class="cls_underlinetilr"></span></p>
    </div>

    <div class="container">
        <div class="why-join-container">

            <div id="why-join-st" class="why-join-item title">
                <h3><?= t('Machine supplier'); ?></h3>
            </div>

            <div class="why-join-title"></div>

            <div id="why-join-et" class="why-join-item title">
                <h3><?= t('Enterprises'); ?></h3>
            </div>

            <div id="why-join-s1" class="why-join-item left">
                <p><?= t('Offer your industrial machinery on our global marketplace, cover drops in orders or increase sales in your business.'); ?></p>
                <p><?= t('Offer your machinery to global machine tender.'); ?></p>
            </div>

            <div class="why-join-title">
                <h4><?= t('Global Market'); ?></h4>
            </div>

            <div id="why-join-e1" class="why-join-item right">
                <p><?= t('Find machines which fits perfectly to your business needs. Instantly find the right machine and get projects completed faster'); ?></p>
            </div>

            <div id="why-join-s2" class="why-join-item left">
                <p><?= t('Get found with your products worldwide on our platform and on all search machines.'); ?></p>
            </div>

            <div class="why-join-title">
                <h4><?= t('Visibility'); ?></h4>
            </div>

            <div id="why-join-e2" class="why-join-item right">
                <p><?= t('Have a global overview of all available machines worldwide. Compare performance data of your tendered machinery needs'); ?></p>
            </div>

            <div id="why-join-s3" class="why-join-item left">
                <p><?= t('By using our Escrow service, you make sure that you would get paid after delivery.'); ?></p>
            </div>

            <div class="why-join-title">
                <h4><?= t('Security'); ?></h4>
            </div>

            <div id="why-join-e3" class="why-join-item right">
                <p><?= t('Your payment to our Escrow service will be released after successful delivery and your approval.'); ?></p>
            </div>

            <div id="why-join-s4" class="why-join-item left">
                <p><?= t('Learn from your clients how to improve your products and where they see your position in the global market. Constantly improve and grow with this knowledge.'); ?></p>
            </div>

            <div class="why-join-title">
                <h4><?= t('Quality & Service'); ?></h4>
            </div>

            <div id="why-join-e4" class="why-join-item right">
                <p><?= t('Find the best supplier with the best services. Read the reviews about performance, services, after sales service of your favorite machine supplier. Give your feedback to the supplier, and help toimprove to the next quality level.'); ?></p>
            </div>

            <div id="why-join-s5" class="why-join-item left">
                <p><?= t('As a global player and supplier of world class machinery you optimize your margin by filling your capacities.'); ?></p>
            </div>

            <div class="why-join-title">
                <h4><?= t('Pricing'); ?></h4>
            </div>

            <div id="why-join-e5" class="why-join-item right">
                <p><?= t('Optimize the total cost of ownership and the production cost per production unit.'); ?></p>
            </div>

        </div>
    </div>

</div>

<div class="ceomessage clearfix">

    <div class="cls_title clearfix">
        <h2><?= t('CEO Message'); ?></h2>
        <p><span class="cls_underlinetilr"></span></p>
    </div>

    <div class="container">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="ceo">
                <img class="img-responsive media-object" src="<?php echo image_url('ceo-img1.png'); ?>">
                <p class="cls_img-authr">Arnold Raynolds<span>CEO</span></p>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-12 cls_testi-content">
            <div class="caption">
                <h6 class="text-brand">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h6>
                <p class="text-brand lead no-margin">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu fugiat nulla pariatur. </p>
                <p class="text-brand lead no-margin">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                    accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery('#carousel-industries').slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        arrows: false,
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        arrows: false,
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 513,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                }
            ]
        });

        jQuery('#carousel-experts').slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 513,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        // Show carousel after load to avoid jumping
        jQuery('#carousel-industries, #carousel-experts').addClass('in');

    });
</script>

<?php $this->load->view('footer'); ?>