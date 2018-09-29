<?php $project = $this->outputData['project']; ?>

<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <div class="cls_postmsg col-lg-6 col-md-9 col-sm-12 col-xs-12">

            <div class="cls_page-title clearfix">

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h2 class="clearfix"><?= t('Open new case'); ?></h2>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <span class="clsPostProject">
                        <a href="<?php echo site_url('cancel/index'); ?>" class="button big secondary">
                            <?php echo svg('table-buttons/details', TRUE).' '.t("view open cases"); ?>
                        </a>
                    </span>
                </div>

            </div>

            <div class="clsUpload ">
                <div class="clsSitelinks clsEditProfile create_case">
                    <form method="post" action="<?php echo site_url('cancel/create'); ?>" id="form-case" class="createcase">

                        <input type="hidden" name="job_id" value="<?php echo set_value('job_id', $project['id']); ?>"/>

                        <div class="row form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label class="cls_label"><?= t('Project'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <a href="<?php echo site_url('project/view?id='.$project['id']); ?>" class="glow"><?php echo $project['job_name']; ?></a>
                            </div>
                        </div>

                        <div class="row cls_bg">

                            <div class="form-group clearfix">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label class="cls_label"><?= t('job_id'); ?>:</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <?php echo $project['id']; ?>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label class="cls_label"><?= t('Owner'); ?>:</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <a href="<?php echo site_url('account/index?id='.$project['creator_id']); ?>" class="glow"><?php echo $project['creator_name']; ?></a>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label class="cls_label"><?= t('Employee'); ?>:</label>
                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <a href="<?php echo site_url('account/index?id='.$project['employee_id']); ?>" class="glow"><?php echo $project['employee_name']; ?></a>
                                </div>
                            </div>

                        </div>

                        <div class="row form-group">
                            <?php echo form_error('case_type'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="case_type" class="form-control-label"><?= t('Case Type'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <select class="form-control" name="case_type" id="case_type">
                                    <?php foreach ($this->outputData['case_types'] as $case_type) { ?>
                                        <option value="<?php echo $case_type['id']; ?>" <?php if (set_value('case_type') == $case_type['id']) echo 'selected="selected"'; ?> ><?= t($case_type['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('case_reason'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="case_reason" class="form-control-label"><?= t('Case Reason'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <select class="form-control" name="case_reason" id="case_reason">
                                    <?php foreach ($this->outputData['case_reasons'] as $case_reason) { ?>
                                        <option value="<?php echo $case_reason['id']; ?>" <?php if (set_value('case_reason') == $case_reason['id']) echo 'selected="selected"'; ?> ><?= t($case_reason['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('comments'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="comments" class="form-control-label"><?= t('Comments (Public)'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <textarea rows="10" maxlength='250' class="form-control" name="comments" id="comments" ><?php echo set_value('comments'); ?></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('private_comments'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="private_comments" class="form-control-label"><?= t('Comments (Private)'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <textarea rows="10" maxlength='250' class="form-control" name="private_comments" id="private_comments" ><?php echo set_value('private_comments'); ?></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('review_type'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="review_type" class="form-control-label"><?= t('Review'); ?>*:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <select class="form-control" name="review_type" id="review_type">
                                    <?php foreach ($this->outputData['review_types'] as $review_type) { ?>
                                        <option value="<?php echo $review_type['id']; ?>" <?php if (set_value('review_type') == $review_type['id']) echo 'selected="selected"'; ?> ><?= t($review_type['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('payment'); ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <label for="payment" class="form-control-label"><?= t('Payment need'); ?>:</label>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <input class="form-control inputmask" data-prefix="<?php echo currency(); ?>" name="payment" id="payment" value="<?php echo set_value('payment'); ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3 col-xs-12">
                                <input type="submit" class="button big primary" name="submit" value="<?= t('Submit'); ?>"/>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<style>
    .clsEditProfile {
        text-align: left;

    }

    .clsEditProfile span {
        padding: 0px !important;
    }

    .create_case textarea {
        width: 100%;
    }

    #main {
        padding-left: 20px;
    }

    .cls_page-title h2 {
        display: inline;
        line-height: 55px;
        margin: 0;
    }

    .cls_ptags p {
        text-align: right;
    }

    .cls_inpt {
        width: 100%;
    }

    form.createcase > div {
        margin-right: 30px;
    }

    .button .svg-table {
        width: 24px;
        height: 24px;
        margin-bottom: -6px;
    }
    .button .svg-table .svg-table-inner {
        fill: transparent;
    }

</style>

<?php $this->load->view('footer1'); ?>