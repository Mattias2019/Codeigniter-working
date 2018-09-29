<?php $this->load->view('header1'); ?>

    <div class="edit-email-template">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Email Template</span>
                </li>
            </ul>
        </div>

        <h1 class="page-title"> Email Template
            <small>Edit Email Template</small>
        </h1>

        <div
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-body">

                        <?php
                            //Show Flash Message
                            if($msg = $this->session->flashdata('flash_message')) {
                                echo $msg;
                            }
                        ?>

                        <?php
                            //Content of a Email Setting
                            if(isset($emailSettings) and $emailSettings->num_rows()>0) {
                                $emailSetting = $emailSettings->row();
                        ?>

                            <form class="inbox-compose form-horizontal" role="form" name="editEmailTemplate" id="editEmailTemplate" method="POST" action="<?php echo admin_url('emailSettings/edit/'.$emailSetting->id); ?>">

                                <div class="form-body">

                                    <input type="hidden" class="form-control" id="email_template_id" name="email_template_id" value="<?php echo $emailSetting->id; ?>">

                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-2 control-label" for="email_title"><?= t('email_title');?>
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="email_title" value="<?php echo set_value('email_title', $emailSetting->title); ?>">
                                            <div class="form-control-focus"> </div>
                                            <?php echo form_error('email_title'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-2 control-label" for="email_subject"><?= t('email_subject');?>
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="email_subject" value="<?php echo set_value('email_subject', $emailSetting->mail_subject); ?>">
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
                                                <textarea class="inbox-editor inbox-wysihtml5 form-control" name="email_body" rows="10" id="email_body"><?php echo $emailSetting->mail_body;?></textarea>
                                                <?php echo form_error('email_body'); ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-10">
                                            <a href="#" onclick="history.go(-1);return false;">
                                                <button type="button" class="btn default"><?= t('Cancel');?></button>
                                            </a>
                                            <input type="submit" name="editEmailSetting" class="btn green" value="<?= t('Submit');?>" />
                                        </div>
                                    </div>
                                </div>

                            </form>
                        <?php
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('footer1'); ?>
