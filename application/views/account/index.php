    <?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="page-content-wrapper col-md-12">

            <?php flash_message(); ?>

            <div class="col-md-5">

                <h2><?= t('Account Overview'); ?></h2>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="dashboard border-top border-primary">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                                    <div class="image-circle large">
                                        <img src="<?php echo $this->outputData['user']['img_logo']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
                                    <p class="account-title"><?php echo $this->outputData['user']['full_name']; ?>
                                        &nbsp;</p>
                                    <p class="account-value"><?php echo $this->outputData['user']['name']; ?>&nbsp;</p>
                                    <p class="account-title"><?= t('Tax number'); ?></p>
                                    <p class="account-value"><?php echo $this->outputData['user']['vat_id']; ?>
                                        &nbsp;</p>
                                    <p class="account-title"><?= t('Email'); ?></p>
                                    <p class="account-value"><?php echo $this->outputData['user']['email']; ?>&nbsp;</p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <p class="account-title"><?= t('Country'); ?></p>
                                    <p class="account-value"><?php echo $this->outputData['user']['country_name']; ?>
                                        &nbsp;</p>
                                    <p class="account-title"><?= t('State/Province'); ?></p>
                                    <p class="account-value"><?php echo $this->outputData['user']['state']; ?>&nbsp;</p>
                                    <p class="account-title"><?= t('City'); ?></p>
                                    <p class="account-value"><?php echo $this->outputData['user']['city']; ?>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <?php $this->load->view('account/dashboard_map'); ?>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <?php $this->load->view('account/index_rating'); ?>

                <?php if (count($this->outputData['reviews']) > 0) { ?>

                    <h2><?= t('Review'); ?><span
                                class="review-number"><?php echo count($this->outputData['reviews']); ?>
                            &nbsp;<?= t('Reviews'); ?></span></h2>

                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12">
                            <div class="dashboard border-top border-primary cls_slider1">
                                <div class="row">

                                    <div id="quote-carousel">
                                        <?php foreach ($this->outputData['reviews'] as $key => $review) { ?>
                                            <div>
                                                <input type="hidden" class="rating-value"
                                                       value="<?php echo $review['rating']; ?>"/>
                                                <div class="rating review-rating"></div>
                                                <p class="review-text"><?php echo $review['comments']; ?></p>
                                                <p class="review-author"><a
                                                            href="<?php echo site_url('account/index?id=' . $review['reviewer_id']); ?>"><?php echo $review['reviewer_name']; ?></a>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

            <div class="page-right-content col-md-3">

                <?php if (count($this->outputData['team_members']) > 0) { ?>

                    <h2><?= t('My Team'); ?></h2>

                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12">
                            <div class="dashboard border-top border-primary no-padding">
                                <div class="container-fluid" style="overflow-y: auto; height:550px;">
                                    <?php foreach ($this->outputData['team_members'] as $team_member) { ?>
                                        <div class="row team-item">
                                            <a href="<?php echo site_url('account/index?id=' . $team_member['user_id']); ?>">
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                    <div class="image-circle medium">
                                                        <img src="<?php echo $team_member['img_logo']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                                                    <p class="team-name"><?php echo $team_member['full_name']; ?></p>
                                                    <p class="team-text"><?php echo $team_member['job_title']; ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>

        <!-- ACTIVE PROJECTS -->
        <?php if ($this->outputData['active_projects_count'] > 0) { ?>
            <div class="page-content-wrapper col-md-12">

                <div class="col-lg-12 col-sm-12 col-xs-12 projects">

                    <h2><?= t('Active projects'); ?>
                        : <?php echo $this->outputData['active_projects_count']; ?></h2>

                    <div class="machinery-gallery-active clearfix">
                        <?php
                        $this->outputData['projects'] = $this->outputData['active_projects'];
                        $this->load->view('account/index_projects', $this->outputData);
                        ?>
                    </div>
                    <?php if (!$this->outputData['active_projects_load_all']) { ?>
                        <div class="load-more load-more-active">
                            <a>
                                <span><?= t('Load More'); ?></span>
                                <span class="fa fa-chevron-right"></span>
                            </a>
                        </div>
                    <?php } ?>

                </div>

            </div>
        <?php } ?>

        <!-- COMPLETED PROJECTS -->
        <?php if ($this->outputData['completed_projects_count'] > 0) { ?>
            <div class="page-content-wrapper col-md-12">

                <div class="col-lg-12 col-sm-12 col-xs-12 projects">

                    <h2><?= t('Completed projects'); ?>
                        : <?php echo $this->outputData['completed_projects_count']; ?></h2>

                    <div class="machinery-gallery-completed clearfix">
                        <?php
                        $this->outputData['projects'] = $this->outputData['completed_projects'];
                        $this->load->view('account/index_projects', $this->outputData);
                        ?>
                    </div>
                    <?php if (!$this->outputData['completed_projects_load_all']) { ?>
                        <div class="load-more load-more-completed">
                            <a>
                                <span><?= t('Load More'); ?></span>
                                <span class="fa fa-chevron-right"></span>
                            </a>
                        </div>
                    <?php } ?>

                </div>

            </div>
        <?php } ?>

    </div>

    <script>

        function updatePortfolio(initial) {
            var item = jQuery('.machinery-item');
            var height = item.width();
            item.css({'height': height + 'px'});
            jQuery('.machinery-characteristics').css({'max-height': (2 * height) + 'px'});
            if (initial) {
                jQuery('.machinery-item-container').addClass('in');
            }
        }

        function loadMore(part) {

            var container;
            var loadMoreLink;
            if (part == 'active') {
                container = jQuery('.machinery-gallery-active');
                loadMoreLink = jQuery('.load-more-active');
            } else {
                container = jQuery('.machinery-gallery-completed');
                loadMoreLink = jQuery('.load-more-completed');
            }
            var offset = container.find('.machinery-item-container').length;

            m.post(
                '<?php echo site_url('account/index'); ?>',
                {
                    part: part,
                    offset: offset
                },
                function (data) {
                    container.append(data.table);
                    updatePortfolio(true);
                    if (data.count_all == container.find('.machinery-item-container').length) {
                        loadMoreLink.addClass('hidden');
                    } else {
                        loadMoreLink.removeClass('hidden');
                    }
                }
            );
        }

        jQuery(document).ready(function () {

            makeMap();

            // Reviews
            jQuery('#quote-carousel').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 513,
                        settings: {
                            arrows: false
                        }
                    }
                ]
            });

            jQuery(".rating").each(function (key, data) {
                jQuery(data).rateYo({
                    rating: jQuery(data).parent().find('.rating-value').val(),
                    starWidth: "16px",
                    ratedFill: jQuery(data).hasClass('review-rating') ? "#1e88e5" : "#ffca28",
                    normalFill: "#e0e0e0",
                    readOnly: true
                });
            });

            // Projects
            updatePortfolio(true);
            jQuery(window).resize(updatePortfolio);

            jQuery('.load-more-active').find('a').click(function (e) {
                e.preventDefault();
                loadMore('active');
            });

            jQuery('.load-more-completed').find('a').click(function (e) {
                e.preventDefault();
                loadMore('completed');
            });

        });

    </script>

<?php $this->load->view('footer1'); ?>