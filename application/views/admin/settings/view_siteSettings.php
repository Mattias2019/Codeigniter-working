<?php $this->load->view('header1'); ?>

<script type="text/javascript">
    var base_url = '<?php echo $base_url;?>';
    $(function () {
        site_settings.init(base_url);
    });
</script>

<div class="site-settings">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Site Settings</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> <?= t('website_settings'); ?> </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">

                    <?php
                    //Show Flash Message
                    if ($msg = $this->session->flashdata('flash_message')) {
                        echo $msg;
                    }
                    ?>

                    <form class="form-horizontal" action="<?php echo admin_url('siteSettings'); ?>" method="post"
                          enctype="multipart/form-data">

                        <div class="form-body">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="site_title"><?= t('website_title'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="site_title"
                                           value="<?php if (isset($settings['SITE_TITLE'])) echo set_value('site_title', $settings['SITE_TITLE']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('site_title'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="site_slogan"><?= t('website_slogan'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="site_slogan"
                                           value="<?php if (isset($settings['SITE_SLOGAN'])) echo set_value('site_slogan', $settings['SITE_SLOGAN']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('site_slogan'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="base_url"><?= t('site_url'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="base_url"
                                           value="<?php if (isset($settings['BASE_URL'])) echo set_value('base_url', $settings['BASE_URL']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('base_url'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label"
                                       for="site_admin_mail"><?= t('website_admin_mail'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="site_admin_mail"
                                           value="<?php if (isset($settings['SITE_ADMIN_MAIL'])) echo set_value('site_admin_mail', $settings['SITE_ADMIN_MAIL']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('site_admin_mail'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="site_language"><?= t('language code'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="site_language"
                                           value="<?php if (isset($settings['LANGUAGE_CODE'])) echo set_value('language_code', $settings['LANGUAGE_CODE']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('site_language'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-3 control-label" for="site_status">
                                    <?= t('website_closed'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="site_status"
                                                   value="<?php echo($settings['SITE_STATUS'] ? $settings['SITE_STATUS'] : 0); ?>" <?php if (isset($settings['SITE_STATUS']) and $settings['SITE_STATUS'] == 1) {
                                                echo 'checked';
                                            } else {
                                                echo '';
                                            } ?> id="site_status" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="offline_message"><?= t('closed_message'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="offline_message"
                                              rows="3"><?php if (isset($settings['OFFLINE_MESSAGE'])) echo set_value('offline_message', $settings['OFFLINE_MESSAGE']); ?></textarea>
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('offline_message'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label"
                                       for="file_manager_limit"><?= t('file_manager_limit'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="file_manager_limit"
                                           value="<?php if (isset($settings['USER_FILE_LIMIT'])) echo $settings['USER_FILE_LIMIT']; ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('file_manager_limit'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="facebook">
                                    <?= t('Facebook'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="facebook"
                                           value="<?php if (isset($settings['FACEBOOK'])) echo set_value('facebook', $settings['FACEBOOK']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('facebook'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="twitter">
                                    <?= t('Twitter'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="twitter"
                                           value="<?php if (isset($settings['TWITTER'])) echo set_value('twitter', $settings['TWITTER']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('twitter'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="rss">
                                    <?= t('RSS'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="rss"
                                           value="<?php if (isset($settings['RSS'])) echo set_value('rss', $settings['RSS']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('rss'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="linkedin">
                                    <?= t('LinkedIn'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="linkedin"
                                           value="<?php if (isset($settings['LINKEDIN'])) echo set_value('linkedin', $settings['LINKEDIN']); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('linkedin'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green" name="siteSettings"
                                            value="siteSettings"><?= t('Submit'); ?></button>
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
