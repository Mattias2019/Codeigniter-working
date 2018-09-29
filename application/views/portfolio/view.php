<?php $portfolio = $this->outputData['portfolio']; ?>
<?php
if (!empty($portfolio['custom_items']) && !empty($portfolio['standard_items'])) {
    $itemsArray = array_merge($portfolio['standard_items'], $portfolio['custom_items']);
} elseif (empty($portfolio['custom_items']) && !empty($portfolio['standard_items'])) {
    $itemsArray = $portfolio['standard_items'];
} elseif (!empty($portfolio['custom_items']) && empty($portfolio['standard_items'])) {
    $itemsArray = $portfolio['custom_items'];
} else {
    $itemsArray = [];
}
$ci =& get_instance();
$ci->load->model('file_model');

?>
<?php $this->load->view('header1'); ?>
<?php if (!empty($this->outputData['preview'])) { ?>
    <a href="<?= site_url('portfolio/manage');?>" class="btn btn-primary"><?= t('Back to manage');?></a>
<?php } ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <div class="col-md-9 col-sm-12 col-xs-12">

                <h2><?= t('view_portfolio'); ?></h2>

                <div class="view_portfolio">

                    <?php flash_message(); ?>
                    <?php if (!empty($portfolio['attachments'])) { ?>
                        <div class="col-md-6 c ol-sm-12 col-xs-12">

                            <ul class="js-bxslider">

                                <?php foreach ($portfolio['attachments'] as $key => $portfolio_value) { ?>

                                    <?php if ($ci->file_model->is_image($portfolio_value['url'])) { ?>
                                        <li>
                                            <img width="500" alt="<?php echo $portfolio_value['ori_name']; ?>"
                                                 src="<?php echo $portfolio_value['url']; ?>">
                                        </li>
                                    <?php } ?>
                                <?php } ?>


                            </ul>
                            <div class="row">
                                <?php foreach ($portfolio['attachments'] as $key => $portfolio_value) { ?>
                                    <?php if (!$ci->file_model->is_image($portfolio_value['url'])) { ?>
                                        <div class="col-md-2">
                                            <a style="position: inherit;" data-container="body" data-toggle="popover"
                                               data-placement="top"
                                               data-content="<?= $portfolio_value['ori_name'] ?>"
                                               href="<?= $portfolio_value['url'] ?>">
                                                <img width="50"
                                                     src="<?= base_url($ci->file_model->getImageByExt($portfolio_value['ext'])); ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <br>
                        </div>
                    <?php } ?>
                    <div class="col-md-6 c ol-sm-12 col-xs-12">
                        <!--                        --><?php //$this->load->view('./account/index_rating'); ?>
                        <div class="cls_tileprjct">
                            <div class="cls_prjctname">
                                <span><?= t('Supplier info'); ?></span>
                            </div>
                            <div class="pjct-cont">
                                <div class="col-lg-12 col-xs-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
                                            <div class="image-circle large">
                                                <img src="<?php echo $this->outputData['supplier']['img_logo']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <p class="account-title"><?php echo $this->outputData['supplier']['full_name']; ?>
                                                &nbsp;</p>

                                            <p class="account-title"><?= t('Country'); ?></p>
                                            <p class="account-value"><?php echo $this->outputData['supplier']['country_name']; ?>
                                                &nbsp;</p>

                                            <p class="account-title"><?= t('City'); ?></p>
                                            <p class="account-value"><?php echo $this->outputData['supplier']['city']; ?>
                                                &nbsp;</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                            <input type="hidden" class="rating-value"
                                                   value="<?php echo $this->outputData['supplier']['user_rating']; ?>"/>
                                            <div class="rating"></div>
                                            <br>
                                            <p class="account-title"><?= t('State/Province'); ?></p>
                                            <p class="account-value"><?php echo $this->outputData['supplier']['state']; ?>
                                                &nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 c ol-sm-12 col-xs-12">
                        <div class="cls_tileprjct">
                            <div class="cls_prjctname">
                                <span><?php echo $portfolio['title']; ?></span>
                                <span class="pull-right">Price: <span><?php echo currency() . number_format($portfolio['price']); ?></span></span>
                            </div>
                            <div class="pjct-cont js-description">
                                <p><?php echo $portfolio['machine_description']; ?></p>
                            </div>
                            <br>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table" cellpadding="1" cellspacing="0" style="border:none;">
                                <thead>
                                <tr>
                                    <th><?= t('Characteristics'); ?></th>
                                    <th><?= t('Value'); ?></th>
                                    <th><?= t('Unit'); ?></th>
                                    <th><?= t('Remarks'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($itemsArray as $item) { ?>
                                    <tr>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['value']; ?></td>
                                        <td><?php echo $item['unit']; ?></td>
                                        <td><?php echo $item['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <?php if (isEntrepreneur()) { ?>
                    <div class="cls_rqqut-btn1">
                        <button id="request-quote" class="cls_green-btn"><?= t('Request a Quote'); ?></button>
                    </div>
                <?php } ?>

            </div>
            <div class="cls_sideport col-md-3 col-sm-12 col-xs-12">
                <div class="cls_page-title clearfix">
                    <h2><span class="clsMyOpen"><?= t('RELATED EXPERTS'); ?></span></h2>
                </div>
                <!--<div class="cls_sidebar-port">
                    <div class="portfolio_section">
                        <div class="cls_portfl">
                            <img src="files/portfolios/39bd7a8d5edf3bdaabf14a263131bf67_thumb.png" class="img-responsive"/>
                            <div class="cls_right_div">
                                <h3>Lora Zombie</h3>
                                <div class="cls_optn-link">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>

        </div>

    </div>

    <style>
        .view_img {
            background: none repeat scroll 0 0 #f4f4f4;
            padding: 20px 0 0 20px;
            vertical-align: top;
            width: 110px;
        }

        .view_img_left {
            text-align: left;
            padding: 10px 20px;
        }

        .view_img_left tr {
            border: 1px solid #efefef;
            padding: 5px;
            background: #fff;
        }

        .view_img_left tr td {
            padding: 10px;
        }

        .amazingslider-img-elem-0 {

            padding: 0;
        }

        .amazingslider-bullet-0-0 {

            width: 50% !important;
            height: 100px !important;
        }

        .amazingslider-bullet-image-0 {
            height: 100px !important;
            width: auto !important;
        }

        .amazingslider-bullet-image-0 > img {

            width: auto !important;
            height: 80px !important;
        }

        .amazingslider-bullet-text-0 {
            margin-top: 80px !important;
        }

        .cls_rqqut-btn1 {
            margin: 10px 0;
            text-align: center;
        }

        .cls_green-btn {
            width: 20% !important;
        }

        .profile_thum_cls img {
            width: 50% !important;
        }

        .amazingslider-arrow-left-0:hover {
            background: #1E88E5 url("<?php echo image_url('portright.png'); ?>") no-repeat scroll center center !important;

            border-radius: 50%;
            display: block !important;
        }

        .amazingslider-arrow-right-0:hover {

            background: #1E88E5 url("<?php echo image_url('portleft.png'); ?>") no-repeat scroll center center !important;

            border-radius: 50%;
            display: block !important;
        }

        .amazingslider-arrow-right-0 {
            background: #ECEFF2 url("<?php echo image_url('portleft.png'); ?>") no-repeat scroll center center !important;

            border-radius: 50%;
            display: block !important;
        }

        .amazingslider-arrow-left-0 {
            background: #ECEFF2 url("<?php echo image_url('portright.png'); ?>") no-repeat scroll center center !important;

            border-radius: 50%;
            display: block !important;
        }

        .amazingslider-bullet-0-0 {
            background-color: transparent !important;
            opacity: 1 !important;
        }

        .amazingslider-bullet-0-1 {
            background-color: transparent !important;
            opacity: 1 !important;
        }

    </style>

    <script>

        function requestPost(e) {
            e.preventDefault();
            m.post(
                '<?php echo site_url('search/send_quote_request?id=' . $portfolio['id']); ?>',
                null,
                function (response) {
                    m.toast.success(response.message);
                }
            );
        }

        jQuery(document).ready(function () {
            jQuery('[data-toggle="popover"]').popover({html: true})
            jQuery('.js-description').readmore({
                maxHeight: 240,
                moreLink: '<a href="#" style="    color: #337ab7;">Read more</a>',
                lessLink: '<a href="#" style="    color: #337ab7;">Close</a>'
            });


            jQuery(document).ready(function () {
                jQuery(".rating").each(function (key, data) {
                    jQuery(data).rateYo({
                        rating: jQuery(data).parent().find('.rating-value').val(),
                        starWidth: "16px",
                        ratedFill: jQuery(data).hasClass('review-rating') ? "#1e88e5" : "#ffca28",
                        normalFill: "#e0e0e0",
                        readOnly: true
                    });
                });
                jQuery('.js-bxslider').bxSlider();
            });
            jQuery('#request-quote').click(requestPost);
        })

    </script>

<?php $this->load->view('footer1'); ?>