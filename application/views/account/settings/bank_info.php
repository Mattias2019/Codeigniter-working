<form method="post" class="form-horizontal" action="<?php echo site_url('account/edit'); ?>" id="user-form">

    <input type="hidden" value="2" name="segment">

    <div class="cls_div-divides">

        <!-- User Bank -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="cls_page-title clearfix">
                <h2><?php echo t('edit_bank_info'); ?></h2>
            </div>
            <div class="cls_div-first">
                <?php $this->load->view('account/settings/_bank') ?>
            </div>
        </div>
        <!-- -->

        <!-- User Bank Account-->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="cls_page-title clearfix">
                <h2><?php echo t('edit_bank_account_info')?></h2>
            </div>
            <div class="cls_div-scnd">
                <?php $this->load->view('account/settings/_bank_account') ?>

                <div class="row form-group">
                    <div class="col-lg-8 col-md-8 col-sm-6"></div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('Save Changes'); ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- -->
    </div>

</form>

