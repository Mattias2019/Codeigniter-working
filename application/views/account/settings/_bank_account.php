<div class="row form-group">
    <?php echo form_error('user_bank_account[account_number]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank_account[account_number]">
            <?php echo t('account_number')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank_account[account_number]" value="<?php echo set_value('user_bank_account[account_number]', $this->outputData['bank_account']['account_number']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank_account[name_on_account]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank_account[name_on_account]">
            <?php echo t('name_on_account')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank_account[name_on_account]" value="<?php echo set_value('user_bank_account[name_on_account]', $this->outputData['bank_account']['name_on_account']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank_account[address]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank_account[address]">
            <?php echo t('address')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank_account[address]" value="<?php echo set_value('user_bank_account[address]', $this->outputData['bank_account']['address']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank_account[city]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank_account[city]">
            <?php echo t('city')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank_account[city]" value="<?php echo set_value('user_bank_account[city]', $this->outputData['bank_account']['city']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank_account[country_id]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank_account[country_id]">
            <?= t('country'); ?>:
        </label>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <select class="form-control" name="user_bank_account[country_id]">
            <option value="">
                -- <?= t('select_country'); ?> --
            </option>
            <?php
            $sel_country = set_value('user_bank_account[country_id]', $this->outputData['bank_account']['country_id']);
            foreach ($this->outputData['countries'] as $country) { ?>
                <option value="<?php echo $country['id']; ?>" <?php if ($country['id'] == $sel_country) echo 'selected="selected"' ?> >
                    <?php echo $country['country_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>


