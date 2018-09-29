<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 cls_sidebar_align">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?= t('Saved Drafts'); ?></span>
        </div>
    </div>

    <div class="cls_top-green-border cls_sav-templt">
		<?php foreach ($this->outputData['drafts'] as $draft) { ?>
            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 cls_imgright">
                    <?php
                    if (isset($draft['thumbnail']) && $draft['thumbnail'] != "") { ?>
                        <img class="draft-thumbnail" src="<?php echo $draft['thumbnail']; ?>"/>
                        <?php
                    }
                    else { ?>
                        <img class="draft-thumbnail" src="<?php echo get_default_portfolio_thumbnail(); ?>">
                        <?php
                    } ?>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h3 class="cls_h333"><?php echo $draft['job_name']; ?></h3>
                    <p>
                        <a href="<?php echo site_url('project/create?id='.$draft['id']); ?>">
							<?php echo svg('other/edit', TRUE); ?>
                            <span><?= t('Edit'); ?></span>
                        </a>
                        <a href="<?php echo site_url('project/delete?id='.$draft['id']); ?>" class="delete-project">
							<?php echo svg('other/trash', TRUE); ?>
                            <span><?= t('Delete'); ?></span>
                        </a>
                    </p>
                </div>

            </div>
		<?php } ?>
    </div>

</div>