<div class="row form-group">
    <?php echo form_error('user_bank[swift_code]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[swift_code]">
            <?php echo t('swift_code')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank[swift_code]" value="<?php echo set_value('user_bank[swift_code]', $this->outputData['bank']['swift_code']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank[name]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[name]">
            <?php echo t('name')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank[name]" value="<?php echo set_value('user_bank[name]', $this->outputData['bank']['name']); ?>" required>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank[address]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[address]">
            <?php echo t('address')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank[address]" value="<?php echo set_value('user_bank[address]', $this->outputData['bank']['address']); ?>" required>
    </div>
</div>


<div class="row form-group">
    <?php echo form_error('user_bank[city]'); ?>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[city]">
            <?php echo t('city')?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="user_bank[city]" value="<?php echo set_value('user_bank[city]', $this->outputData['bank']['city']); ?>" required>
    </div>
</div>


<div class="row form-group">
    <?php echo form_error('user_bank[country_id]'); ?>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[country_id]">
            <?= t('country'); ?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <select class="form-control" name="user_bank[country_id]">
            <option value="">
                -- <?= t('select_country'); ?> --
            </option>
            <?php
            $sel_country = set_value('user_bank[country_id]', $this->outputData['bank']['country_id']);
            foreach ($this->outputData['countries'] as $country) { ?>
                <option value="<?php echo $country['id']; ?>" <?php if ($country['id'] == $sel_country) echo 'selected="selected"' ?> >
                    <?php echo $country['country_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="row form-group">
    <?php echo form_error('user_bank[currency_id]'); ?>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <label class="form-control-label" for="user_bank[currency_id]">
            <?= t('currency'); ?>:
        </label>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <select class="form-control" name="user_bank[currency_id]">
            <option value="">
                -- <?= t('select_currency'); ?> --
            </option>
            <?php
            $sel_currency = set_value('user_bank[currency_id]', $this->outputData['bank']['currency_id']);
            foreach ($this->outputData['currencies'] as $currency) { ?>
                <option value="<?php echo $currency['id']; ?>" <?php if ($currency['id'] == $sel_currency) echo 'selected="selected"' ?> >
                    <?php echo $currency['currency_name'] . ' ('.$currency['currency_type'].')'; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>