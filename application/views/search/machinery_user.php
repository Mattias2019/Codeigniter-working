<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="cls_page-title">
                <h2><span><?= t('Search Results'); ?></span></h2>
            </div>

            <div class="clsInnerpageCommon">
                <div class="clsInnerCommon">

                    <div id="content" class="content">
                        <div class="machinery-gallery clearfix">
                            <?php $this->load->view('search/machinery_table'); ?>
                        </div>
                        <?php if (!$this->outputData['load_all']) { ?>
                        <div class="load-more">
                            <a>
                                <span><?= t('Load More'); ?></span>
                                <span class="fa fa-chevron-right"></span>
                            </a>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function loadMore() {

            var offset = jQuery('.machinery-item-container').length;

            m.post(
                '<?php echo site_url('portfolio/user'); ?>',
                {
                    offset: offset
                },
                function(data) {
                    jQuery('.machinery-gallery').append(data.table);
                    updatePortfolio(true);
                    if (data.count_all == jQuery('.machinery-item-container').length) {
                        jQuery('.load-more').addClass('hidden');
                    } else {
                        jQuery('.load-more').removeClass('hidden');
                    }
                }
            );
        }

        function updatePortfolio(initial) {
            var item = jQuery('.machinery-item');
            var height = item.width();
            item.css({'height': height+'px'});
            jQuery('.machinery-characteristics').css({'max-height': (2*height)+'px'});
            if (initial) {
                jQuery('.machinery-item-container').addClass('in');
            }
        }

        jQuery(document).ready(function () {

            jQuery('.load-more').find('a').click(function (e) {
                e.preventDefault();
                loadMore();
            });

            updatePortfolio(true);
            jQuery(window).resize(updatePortfolio);

        });

    </script>

<?php $this->load->view('footer1'); ?>