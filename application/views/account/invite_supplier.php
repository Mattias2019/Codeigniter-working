<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon clearfix">

			<?php flash_message(); ?>

            <h2><?= t('Invite an external machine supplier by mail'); ?></h2>

            <div class="dashboard border-top border-color-2">
                <form method="post" action="<?php echo site_url('account/invite_supplier'); ?>">

                    <div class="row form-group">
						<?php echo form_error('email'); ?>
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                            <label for="email" class="form-control-label"><?= t('Suppliers mail address'); ?>:</label>
                        </div>
                        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                            <input type="email" name="email" id="email" class="form-control" required/>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                            <label for="mail_subject" class="form-control-label"><?= t('Subject headline'); ?>:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" name="mail_subject" id="mail_subject" class="form-control" value="<?php pifset($_ci_vars, 'subject');?>" required/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                            <label for="mail_content" class="form-control-label"><?= t('Invitation text'); ?>:</label>
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="mail_content" id="mail_content" rows="5" required><?php pifset($_ci_vars, 'custom_message');?></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-10 col-md-9 col-sm-8"></div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                            <input id="submit" name="accountSignup" class="button big primary" type="submit" value="Send Email">
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>