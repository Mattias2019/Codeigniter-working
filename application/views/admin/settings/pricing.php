<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <h2><?= t('Pricing Cockpit'); ?> </h2>

            <?php flash_message(); ?>

            <div class="dashboard">

                <form action="<?php echo admin_url('paymentSettings/pricingCockpit'); ?>" method="post"
                      enctype="multipart/form-data">

                    <div class="form-body">

                        <div class="row form-group">
							<?php echo form_error('disable_escrow'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label" for="disable_escrow"><?= t('Disable Escrow'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="disable_escrow" name="disable_escrow"
                                           value="1" <?php if ($settings['DISABLE_ESCROW'] == 1) echo 'checked="checked"'; ?>/>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('forced_escrow'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label" for="forced_escrow"><?= t('Forced Escrow'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="forced_escrow" name="forced_escrow"
                                           value="1" <?php if ($settings['FORCED_ESCROW'] == 1) echo 'checked="checked"'; ?>/>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('payment_settings'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label" for="currency"><?= t('currency type'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control" id="currency" name="currency">
                                    <option value="">-- <?= t('Select Currency');?> --</option>
                                    <?php foreach ($currency->result() as $curr) { ?>
                                        <option value="<?php echo $curr->currency_type; ?>" <?php if ($settings['CURRENCY_TYPE'] == $curr->currency_type) echo 'selected="selected"'; ?>> <?php echo $curr->currency_name; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('time_zone'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label" for="time_zone"><?= t('time zone'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control" id="time_zone" name="time_zone">
                                    <option value="">-- <?= t('Select Time Zone');?> --</option>
                                    <?php foreach ($timezones as $key => $val) { ?>
                                        <option value="<?php echo $key; ?>" <?php if ($settings['TIME_ZONE'] == $key) echo 'selected="selected"'; ?>> <?= t($key); ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('daylight'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label" for="daylight"><?= t('daylight savings'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="daylight" name="daylight"
                                           value="1" <?php if ($settings['DAYLIGHT'] == 1) echo 'checked="checked"'; ?>/>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('payment_settings'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="payment_settings"><?= t('min_balance'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="payment_settings" name="payment_settings"
                                       value="<?php if (isset($settings['PAYMENT_SETTINGS'])) echo $settings['PAYMENT_SETTINGS']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('featured_jobs_limit'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="featured_jobs_limit"><?= t('featured_jobs_limit'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="featured_jobs_limit"
                                       name="featured_jobs_limit"
                                       value="<?php if (isset($settings['FEATURED_PROJECTS_LIMIT'])) echo $settings['FEATURED_PROJECTS_LIMIT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('urgent_jobs_limit'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="urgent_jobs_limit"><?= t('urgent_jobs_limit'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" name="urgent_jobs_limit"
                                       value="<?php if (isset($settings['URGENT_PROJECTS_LIMIT'])) echo $settings['URGENT_PROJECTS_LIMIT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('latest_jobs_limit'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="latest_jobs_limit"><?= t('latest_jobs_limit'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="latest_jobs_limit" name="latest_jobs_limit"
                                       value="<?php if (isset($settings['LATEST_PROJECTS_LIMIT'])) echo $settings['LATEST_PROJECTS_LIMIT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('provider_commission_amount'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="provider_commission_amount"><?= t('employee_commission_amount'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="provider_commission_amount"
                                       name="provider_commission_amount"
                                       value="<?php if (isset($settings['PROVIDER_COMMISSION_AMOUNT'])) echo $settings['PROVIDER_COMMISSION_AMOUNT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('employee_free_credits'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="employee_free_credits"><?= t('employee_free_credits'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="employee_free_credits"
                                       name="employee_free_credits"
                                       value="<?php if (isset($settings['PROVIDER_FREE_CREDITS'])) echo $settings['PROVIDER_FREE_CREDITS']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('featured_jobs_amount'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="featured_jobs_amount"><?= t('featured_jobs_amount'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="featured_jobs_amount"
                                       name="featured_jobs_amount"
                                       value="<?php if (isset($settings['FEATURED_PROJECT_AMOUNT'])) echo $settings['FEATURED_PROJECT_AMOUNT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('urgent_jobs_amount'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="urgent_jobs_amount"><?= t('urgent_jobs_amount'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="urgent_jobs_amount"
                                       name="urgent_jobs_amount"
                                       value="<?php if (isset($settings['URGENT_PROJECT_AMOUNT'])) echo $settings['URGENT_PROJECT_AMOUNT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('hide_jobs_amount'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="hide_jobs_amount"><?= t('hide_jobs_amount'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="hide_jobs_amount" name="hide_jobs_amount"
                                       value="<?php if (isset($settings['HIDE_PROJECT_AMOUNT'])) echo $settings['HIDE_PROJECT_AMOUNT']; ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('private_job_amount'); ?>
                            <div class="col-sm-4 col-xs-12">
                                <label class="form-control-label"
                                       for="private_job_amount"><?= t('private_job_amount'); ?></label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="private_job_amount"
                                       name="private_job_amount"
                                       value="<?php if (isset($settings['PRIVATE_PROJECT_AMOUNT'])) echo $settings['PRIVATE_PROJECT_AMOUNT']; ?>">
                            </div>
                        </div>

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-5 col-sm-4"></div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <input type="submit" class="button big primary" name="siteSettings"
                                       value="<?= t('Submit'); ?>"/>
                            </div>
                            <div class="col-md-5 col-sm-4"></div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>