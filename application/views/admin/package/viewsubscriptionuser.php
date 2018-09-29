
<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <?php
                $user = [];
                if (array_key_exists('user', $this->outputData)) {
                    $new_user=false;
                    $user = $this->outputData['user'];
                }
                else {
                    $new_user=true;
                }
            ?>

            <h2><?php echo (!$new_user)?t('Edit Subscription User'):t('Add Subscription User'); ?></h2>

            <div class="dashboard border-top border-color-2 container-fluid">

                <form id="team-form" action="<?php echo admin_url('packages/viewSubscriptionUser'); ?>" method="post">

                    <input type="hidden" name="id" id="id" value="<?php echo (!$new_user)?set_value('id',$user['id']):null; ?>"/>

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row form-group">
                                <?php echo form_error('user_id'); ?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="user_id" class="form-control-label"><?= t('User Name'); ?>:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <select class="form-control" id="user_id" name="user_id" <?php if (!$new_user) echo 'disabled="disabled"'; ?>>
                                        <option value="">-- <?= t('Select User'); ?> --</option>
                                        <?php
                                            foreach($this->outputData['all_users'] as $user_) {
                                        ?>
                                                <option value="<?php echo $user_['id']; ?>" <?php if ((!$new_user)?set_select('user_id', $user['user_id']):null == $user_['id']) echo "selected"; ?>><?php echo $user_['user_name']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row form-group">
                                <?php echo form_error('valid'); ?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="valid" class="form-control-label"><?= t('Valid'); ?></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input name="valid" id="valid" class="form-control" value="<?php echo (!$new_user)?set_value('valid',$user['valid']):null; ?>"/>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row form-group">
								<?php echo form_error('amount'); ?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="amount" class="form-control-label"><?= t('Amount'); ?></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input name="amount" id="amount" class="form-control" value="<?php echo (!$new_user)?set_value('amount', $user['amount']):null; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row form-group">
                                <?php echo form_error('package_id'); ?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="package_id" class="form-control-label"><?= t('Package'); ?></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <select name="package_id" id="package_id" class="form-control" <?php if (!$new_user) echo 'disabled="disabled"'; ?>>
                                        <option value="">-- <?= t('Select Package'); ?> --</option>
                                        <?php foreach ($this->outputData['packages'] as $package) { ?>
                                            <option value="<?php echo $package['id']; ?>" <?php if ((!$new_user)?set_select('package_id', $user['package_id']):null == $package['id']) echo "selected"; ?>><?php echo $package['package_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-sm-offset-8">
                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <input type="submit" name="submit" class="button big primary" value="<?= (!$new_user?'Update User':'Add New User'); ?>"/>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            <h2><?= t('Subscription Users List'); ?></h2>

            <div class="dashboard border-top border-primary container-fluid">

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_name" class="form-control-label"><?= t('User Name'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <input name="search_name" id="search_name" class="form-control"/>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_email" class="form-control-label"><?= t('Email'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <input name="search_email" id="search_email" class="form-control"/>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_package" class="form-control-label"><?= t('Package'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <select name="search_package" id="search_package" class="form-control">
                            <option value="">-- <?= t('Select Package'); ?> --</option>
							<?php foreach ($this->outputData['packages'] as $package) { ?>
                                <option value="<?php echo $package['id']; ?>"><?php echo $package['package_name']; ?></option>
							<?php } ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table" width="100%" cellspacing="0">
                    <thead data-field="" data-sort="">
                    <tr>
                        <th><?= t('User ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="user_id" data-sort=""></span></th>
                        <th><?= t('User Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""></span></th>
                        <th><?= t('Package'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="package_name" data-sort=""></span></th>
                        <th><?= t('Valid'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="valid" data-sort=""></span></th>
                        <th><?= t('Amount'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                        <th><?= t('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $this->load->view('admin/package/viewsubscriptionuser_table'); ?>
                    </tbody>
                </table>
                <?php $this->load->view('pagination', $this->outputData); ?>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>