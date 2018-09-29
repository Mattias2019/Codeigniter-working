<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <h2><?= t('Add Package'); ?></h2>

			<?php flash_message(); ?>

            <div class="dashboard">
                <form method="post" action="<?php echo admin_url('packages/addPackages');?>" enctype="multipart/form-data">
                    
                    <div class="row form-group">
                        <div class="col-sm-4 col-xs-12">
                            <label for="package_name" class="form-control-label"><?= t('Package Name'); ?></label>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <input id="package_name" name="package_name" class="form-control" value="<?php echo set_value('package_name'); ?>"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4 col-xs-12">
                            <label for="description" class="form-control-label"><?= t('Description'); ?></label>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <textarea id="description" name="description" class="form-control" rows="5"><?php echo set_value('description'); ?></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4 col-xs-12">
                            <label for="description" class="form-control-label"><?= t('Description'); ?></label>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <textarea id="description" name="description" class="form-control" rows="5"><?php echo set_value('description'); ?></textarea>
                        </div>
                    </div>
                    
                    <table class="table1" cellpadding="2" cellspacing="0">
                        <tbody>


                        <tr>
                            <td width="25%"><strong><span id="valuen"><?= t('Number of Credits'); ?></span></strong></td>
                            <td width="55%">:
                                <select name="credits">
									<?php for ($i = 1; $i <= 100; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
                                </select>&nbsp;<?= t('days'); ?>
                                <!-- <input name="duration" type="text" class="textbox" id="duration" value="<?php echo set_value('No.Of.days'); ?>">-->
								<?php echo form_error('credits'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%"><strong><span id="valuen"><?= t('Duration'); ?></span></strong></td>
                            <td width="55%">:
                                <select name="duration">
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                    <option value="90">90</option>
                                </select>&nbsp;<?= t('days'); ?>

								<?php echo form_error('duration'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="25%"><strong><span id="valuen"><?= t('Amount'); ?></span></strong></td>
                            <td width="55%">:
                                <input name="amount" type="text" class="textbox" id="duration" value="<?php echo set_value('amount'); ?>">
								<?php echo form_error('duration'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%"><strong><span id="valuen"><?= t('Active'); ?></span></strong></td>
                            <td width="55%">:
                                <select name="is_active">
                                    <option value="0" <?php echo set_select('is_active', '0', TRUE); ?>><?= t('No'); ?></option>
                                    <option value="1" <?php echo set_select('is_active', '1'); ?>><?= t('Yes'); ?></option>
                                </select>
								<?php echo form_error('is_active'); ?>
                            </td>
                        </tr>
                        <tr id="bansubmit">
                            <td></td>
                            <td height="30" style="padding-left:6px;"><input name="addPackage" type="submit" class="clsSubmitBt1" value="<?= t('Submit'); ?>">
                                &nbsp;
                                <input name="Reset" type="reset" class="clsSubmitBt1" value="<?= t('Reset'); ?>">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>