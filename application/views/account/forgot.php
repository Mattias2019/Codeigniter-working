<?php $this->load->view('header'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <div class="dashboard login-page">

            <h2><?= t('Restore My Password'); ?></h2>

            <?php flash_message(); ?>

            <form method="post" action="<?php echo site_url('account/forgot_password'); ?>" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-xs-12"><?= t('Please enter your E-mail address. A link to reset your password will be sent to you.'); ?></div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12">
                        <input name="email" class="form-control form-control-login user" id="UN" placeholder="Email Address" value="<?php echo set_value('email'); ?>"/>
                        <?php echo form_error('email'); ?>
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