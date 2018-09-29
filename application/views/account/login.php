<?php $this->load->view('header'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <div class="dashboard login-page">

                <h2><?= t('Login'); ?></h2>

                <?php flash_message(); ?>

                <form method="post" action="<?php echo site_url('account/login'); ?>">

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <input tabindex="1" name="username" value="<?php echo set_value('username'); ?>" class="form-control form-control-login user" id="UN" placeholder="<?= t('Login Name'); ?>" />
                            <?php echo form_error('username'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <input tabindex="2" type="password" name="pwd" class="form-control form-control-login password" id="PW" placeholder="<?= t('Password'); ?>" />
                            <?php echo form_error('pwd'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-6">
                            <img src="<?php if (isset($captcha)) echo $captcha['image_src']; ?>" style="float: left;" />
                        </div>
                        <div class="col-xs-6">
                            <label class="form-control-label" for="captcha_code"><?= t('Enter Code'); ?></label>
                            <input size="6" name="captcha_code" id="captcha_code" tabindex="3" class="form-control" />
                        </div>
                        <div class="col-xs-12">
                            <?php echo form_error('captcha_code'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-1">
                            <input type="checkbox" class="checkbox check" name="remember" id="remember"/>
                        </div>
                        <div class="col-xs-11">
                            <label class="form-control-label" for="remember"><?= t('remember me'); ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-1">
                            <input type="checkbox" class="checkbox check" name="keepsignin" id="keepsignin"/>
                        </div>
                        <div class="col-xs-11">
                            <label class="form-control-label" for="keepsignin"><?= t('keep signed in'); ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <a href="<?php echo site_url('account/forgot_password'); ?>"><?= t('I forgot my login details'); ?>?</a>
                        </div>
                        <div class="col-xs-12">
                            <a href="<?php echo site_url('account/signup'); ?>"><?= t('Signup'); ?></a>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6">
                            <input type="submit" name="usersLogin" value="<?= t('Login'); ?>"  class="button big primary"/>
                        </div>
                        <div class="col-xs-3"></div>
                    </div>

                </form>

            </div>

        </div>
    </div>

<?php $this->load->view('footer'); ?>