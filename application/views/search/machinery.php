<?php $this->load->view('header1'); ?>

    <h2><span><?= t('Search Results'); ?></span></h2>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="dashboard border-left container-fluid">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="keyword" class="form-control-label"><?= t('Keyword'); ?>: </label>
                        <input class="form-control" id="keyword" value="<?php echo set_value('keyword'); ?>"/>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="form-control-label"><?= t('Categories'); ?>: </label>
                        <?php $this->load->view('multiselect'); ?>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <?php echo form_error('budget_min'); ?>
                        <?php echo form_error('budget_max'); ?>
                        <input type="hidden" id="budget_min" name="budget_min"/>
                        <input type="hidden" id="budget_max" name="budget_max"/>

                        <label class="form-control-label" for="amount"><?= t('Budget'); ?>:</label>
                        <button class="double-budget-btn" name="double-budget-btn" id="double-budget-btn">
                            <img src="/application/css/images/2x.png">
                        </button>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php $this->load->view('custom-slider'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="submit" class="form-control-label"></label>
                        <input type="submit" id="submit" class="button big primary"
                               value="<?= t('Refresh'); ?>"/>
                    </div>
                </div>

            </div>

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

            <div class="compare">
                <a href="#" id="compare" class="button big primary">Compare Machinery</a>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>