<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <h2><?php echo (set_value('id') == '')?t('Create Package'):t('Edit Package'); ?></h2>

		<?php flash_message(); ?>

        <div class="dashboard">
            <form method="post" action="<?php echo admin_url('packages/editPackage'); ?>" enctype="multipart/form-data">

                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo set_value('id', $this->outputData['package']['id']); ?>">

                <div class="row form-group">
                    <?php echo form_error('package_name'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="package_name" class="form-control-label"><?= t('Package Name'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input type="text" class="form-control" name="package_name" id="package_name" value="<?php echo set_value('package_name', $this->outputData['package']['package_name']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('description'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="description" class="form-control-label"><?= t('Description'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <textarea class="form-control" name="description" id="description" rows="3"><?php echo set_value('description', $this->outputData['package']['description']); ?></textarea>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('credits'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="credits" class="form-control-label"><?= t('Number of Credits'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <select class="form-control" id="credits" name="credits">
                            <?php for ($i = 1; $i <= 100; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo set_select('credits', $this->outputData['package']['credits']); ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('total_days'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="total_days" class="form-control-label"><?= t('Duration, days'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <select class="form-control" id="total_days" name="total_days">
                            <option value="30" <?php echo set_select('credits', 30, $this->outputData['package']['total_days']); ?>>30</option>
                            <option value="60" <?php echo set_select('credits', 60, $this->outputData['package']['total_days']); ?>>60</option>
                            <option value="90" <?php echo set_select('credits', 90, $this->outputData['package']['total_days']); ?>>90</option>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('amount'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="amount" class="form-control-label"><?= t('Amount'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input class="form-control inputmask" name="amount" id="amount" data-prefix="<?php echo currency(); ?>" value="<?php echo set_value('amount', $this->outputData['package']['amount']); ?>">
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('isactive'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="isactive" class="form-control-label"><?= t('Active'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" id="isactive" name="isactive" value="1" <?php if (set_value('isactive', $this->outputData['package']['isactive']) == 1) echo 'checked="checked"'; ?>/>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-2 col-sm-4 col-xs-12 col-lg-offset-4 col-sm-offset-2">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('Submit'); ?>"/>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-xs-12">
                        <input type="submit" name="cancel" class="button big primary" value="<?= t('Cancel'); ?>"/>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>
