<?php $this->load->view('header'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <div class="dashboard login-page">

            <h2><?= t('Reset My Password'); ?></h2>

            <?php flash_message(); ?>

            <form method="post" action="<?php echo site_url('account/reset_password'); ?>" enctype="multipart/form-data">

                <input type="hidden" name="activation_key" value="<?php echo set_value('activation_key', $this->outputData['activation_key']); ?>"/>

                <div class="row form-group">
                    <div class="col-xs-12">
                        <label class="form-control-label"><?= t('Your user name'); ?>:</label>
                    </div>
                    <div class="col-xs-12">
                        <label><?php if (isset($user_name)) echo $user_name; ?></label>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('password'); ?>
                    <div class="col-xs-12">
                        <label for="password" class="form-control-label"><?= t('Pick new password'); ?>:</label>
                    </div>
                    <div class="col-xs-12">
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo set_value('password'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('repeat_password'); ?>
                    <div class="col-xs-12">
                        <label for="repeat_password" class="form-control-label"><?= t('Repeat password'); ?>:</label>
                    </div>
                    <div class="col-xs-12">
                        <input type="password" name="repeat_password" id="repeat_password" class="form-control" value="<?php echo set_value('repeat_password'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('Submit'); ?>"/>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

<?php $this->load->view('footer'); ?>