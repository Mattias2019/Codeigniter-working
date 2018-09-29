<?php $this->load->view('header'); ?>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12">

                    <?php flash_message(); ?>

                    <h2><?= t('Ask Your Question'); ?></h2>

                    <form method="post" action="<?php echo site_url('home/support'); ?>" enctype="multipart/form-data">

                        <div class="row form-group">
							<?php echo form_error('email'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label for="email" class="form-control-label"><?= t('Your e-mail');?>:</label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input name="email" id="email" class="form-control" value="<?php echo set_value('email', $this->logged_in_user?$this->logged_in_user->email:''); ?>" <?php if ($this->logged_in_user) echo 'disabled="disabled"'; ?>/>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('subject'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label for="subject" class="form-control-label"><?= t('Subject');?>:</label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input name="subject" id="subject" class="form-control" value="<?php echo set_value('subject'); ?>"/>
                            </div>
                        </div>

                        <div class="row form-group">
							<?php echo form_error('description'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label for="description" class="form-control-label"><?= t('Description');?>:</label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <textarea name="description" id="description" class="form-control" rows="5"><?php echo set_value('description'); ?></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2 col-sm-4 col-xs-12 col-md-offset-5 col-sm-offset-4">
                                <input type="submit" name="submit" class="button big primary" value="<?= t('Submit'); ?>">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>