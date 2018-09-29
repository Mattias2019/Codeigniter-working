<form method="post" class="form-horizontal" action="<?php echo site_url('account/edit'); ?>" id="user-form">

    <input type="hidden" value="3" name="segment">

    <div class="cls_div-divides">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="cls_page-title clearfix">
                <h2><?php echo t('edit_paypal_info'); ?></h2>
            </div>
            <div class="cls_div-first">
                <div class="row form-group">
                    <?php echo form_error('email'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="form-control-label" for="email">
                            <?php echo t('email')?>:
                        </label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="email" value="<?php echo set_value('email', $this->outputData['paypal']['email']); ?>" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-8 col-md-8 col-sm-6"></div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('save_changes'); ?>"/>
                    </div>
                </div>

            </div>
        </div>
    </div>


</form>

