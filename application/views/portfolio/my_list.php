<?php if (!empty($this->outputData['my_portfolios'])) { ?>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">

        <h3><?= t('My Portfolios'); ?></h3>

        <div class="dashboard border-top border-color-2">
            <?php foreach ($this->outputData['my_portfolios'] as $portfolio) { ?>
                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 cls_imgright">
                        <a href="<?php echo site_url('portfolio/view?id=' . $portfolio['id']); ?>">
                            <?php
                            if (isset($portfolio['thumbnail']) && $portfolio['thumbnail'] != "") { ?>
                                <img class="draft-thumbnail" src="<?php echo $portfolio['thumbnail']; ?>"/>
                            <?php
                            }
                            else { ?>
                            <img class="draft-thumbnail" src="<?php echo get_default_portfolio_thumbnail(); ?>">
                            <?php
                            } ?>
                        </a>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <h3 class="cls_h333">
                            <?php echo $portfolio['title']; ?>
                        </h3>

                        <p>
                            <?php if ($this->machinery_model->portfolio_view_allowed($portfolio['id'], $this->logged_in_user->id)) { ?>
                                <a href="<?php echo site_url('portfolio/view?id=' . $portfolio['id']); ?>">
                                    <i class="fa fa-eye"></i>
                                    <span><?= t('View'); ?></span>
                                </a>
                            <?php } ?>

                            <?php if ($this->machinery_model->portfolio_edit_allowed($portfolio['id'], $this->logged_in_user->id)) { ?>
                                <a href="<?php echo site_url('portfolio/manage?id=' . $portfolio['id']); ?>">
                                    <?php echo svg('other/edit', TRUE); ?>
                                    <span><?= t('Edit'); ?></span>
                                </a>
                            <?php } ?>

                            <?php if ($this->machinery_model->portfolio_delete_allowed($portfolio['id'], $this->logged_in_user->id)) { ?>
                                <a href="<?php echo site_url('portfolio/delete?id=' . $portfolio['id']); ?>"
                                   class="delete-portfolio">
                                    <?php echo svg('other/trash', TRUE); ?>
                                    <span><?= t('Delete'); ?></span>
                                </a>
                            <?php } ?>
                        </p>

                    </div>

                </div>
            <?php } ?>
        </div>

    </div>
<?php } ?>