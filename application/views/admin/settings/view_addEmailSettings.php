<?php $this->load->view('header1'); ?>

<div class="edit-email-template">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Email Templates</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('add_email_settings'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> Groups
        <small><?= t('add_email_settings'); ?></small>
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>

                    <form role="form" class="inbox-compose form-horizontal" name="addEmailTemplate" id="addEmailTemplate" method="post" action="<?php echo admin_url('emailSettings/addemailSettings'); ?>">

                        <div class="form-body">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="email_type">
                                    <?= t('email_type');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="email_type" value="<?php echo set_value('email_type'); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('email_type'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="email_title">
                                    <?= t('email_title');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="email_title" value="<?php echo set_value('email_title'); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('email_title'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="email_subject">
                                    <?= t('email_subject');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="email_subject" value="<?php echo set_value('email_subject'); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('email_subject'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="email_body"><?= t('email_body'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-10">
                                    <div class="inbox-form-group input-body">
                                        <textarea class="inbox-editor inbox-wysihtml5 form-control" name="email_body" rows="10" id="email_body"><?php echo set_value('email_body');?></textarea>
                                        <?php echo form_error('email_body'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">

                                    <input type="hidden" name="operation" value="add" />

                                    <div class="col-md-offset-2 col-md-4" align="left">
                                        <a href="<?php echo admin_url('emailSettings/index') ?>">
                                            <button type="button" class="btn default"><?= t('Cancel');?></button>
                                        </a>
                                        <input type="submit" name="addEmailSettings" class="btn blue" value="<?= t('Submit');?>" />
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer1'); ?>
