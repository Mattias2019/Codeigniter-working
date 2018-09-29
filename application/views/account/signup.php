<?php $this->load->view('header'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <div class="dashboard login-page">

                <h2><?= t('Sign Up'); ?></h2>

				<?php flash_message(); ?>

                <form method="post" action="<?php echo site_url('account/signup'); ?>" enctype="multipart/form-data">

                    <div class="row form-group">
                        <div class="col-xs-1">
                            <input type="radio" name="acc_type" id="acc_type2" value="2" <?php if (set_value('acc_type') != 1) echo 'checked="checked"'; ?>/>
                        </div>
                        <div class="col-xs-11">
                            <label class="form-control-label" for="acc_type2"><?= t('acc_type_consultant'); ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-1">
                            <input type="radio" name="acc_type" id="acc_type1" value="1" <?php if (set_value('acc_type') == 1 or $this->outputData['type'] == 'enterprise') echo 'checked="checked"'; ?>/>
                        </div>
                        <div class="col-xs-11">
                            <label class="form-control-label" for="acc_type1"><?= t('acc_type_enterprise'); ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12"><?= t('enter_email_prompt'); ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <input required="required" name="email" class="form-control form-control-login user" id="UN" placeholder="Email Address" value="<?php echo set_value('email'); ?>"/>
							<?php echo form_error('email'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-1">
                            <input required="required" type="checkbox" class="checkbox check" name="confirm_terms_condition" id="confirm_terms_condition"/>
                        </div>
                        <div class="col-xs-11">
                            <label class="form-control-label" for="confirm_terms_condition"><?= t('I have read and accept the <a class="text-primary" href="'.site_url('home/page/condition').'" target="_blank">terms and conditions</a>'); ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <a class="text-primary" href="<?php echo site_url('home/page/privacy'); ?>"><?= t('view_privacy_policy'); ?></a>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6">
                            <input type="submit" name="submit" value="<?= t('Submit'); ?>" class="button big primary"/>
                        </div>
                        <div class="col-xs-3"></div>
                    </div>

                </form>

            </div>

        </div>
    </div>

<?php $this->load->view('footer'); ?>