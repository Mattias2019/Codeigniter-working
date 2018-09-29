<?php
$this->outputData['multiselect_dropdown'] = FALSE;
$feed = [];
if (array_key_exists('feed', $this->outputData)) {
    $new_rss=false;
    $feed = $this->outputData['feed'];
}
else {
    $new_rss=true;
}
?>

<form id="rss-form" method="post" action="<?php echo site_url('rss/custom'); ?>">

    <input type="hidden" name="id" value="<?php echo (!$new_rss)?set_value('id',$feed['id']):null; ?>"/>

    <div class="container-fluid">

        <div class="row form-group">
            <div class="col-xs-12">
                <?= t('Create'); ?>
            </div>
        </div>

        <div class="row form-group">
            <?php echo form_error('limit_feed'); ?>
            <?php echo form_error('type'); ?>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <label class="form-control-label" for="limit_feed"><?= t('No of projects to display'); ?>:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <input type="number" class="form-control" id="limit_feed" name="limit_feed" value="<?php echo (!$new_rss)?set_value('limit_feed',$feed['limit_feed']):null; ?>"/>
            </div>
            <div class="col-lg-1 col-md-2"></div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <label class="form-control-label" for="type"><?= t('Info to display'); ?>:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <select id="type" name="type" class="form-control">
                    <option value="">-- <?= t('Select Value'); ?> --</option>
                    <option value="1" <?php if ((!$new_rss?set_value('type', $feed['type']):null) == 1) { echo ' selected="selected"'; } ?>><?= t('Titles'); ?></option>
                    <option value="2" <?php if ((!$new_rss?set_value('type', $feed['type']):null) == 2) { echo ' selected="selected"'; } ?>><?= t('Titles + Description'); ?></option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <?php echo form_error('budget_min'); ?>
            <?php echo form_error('budget_max'); ?>
            <input type="hidden" id="budget_min" name="budget_min" value="<?php echo (!$new_rss)?set_value('budget_min',$feed['budget_min']):null; ?>"/>
            <input type="hidden" id="budget_max" name="budget_max" value="<?php echo (!$new_rss)?set_value('budget_max',$feed['budget_max']):null; ?>"/>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <label class="form-control-label" for="amount"><?= t('Budget'); ?>:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <?php $this->load->view('custom-slider'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <?php
                $this->outputData['multiselect_id'] = 's1_';
                $this->load->view('multiselect', $this->outputData);
                ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin: 90px 0">
                <a id="rss-add"
                   href="#"
                   role="button"
                   class="rss-button tooltip-attach"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="<?= t('Add Category'); ?>">
                    <?php echo svg('rss/add', TRUE); ?>
                </a>
                <a id="rss-delete"
                   href="#"
                   role="button"
                   class="rss-button tooltip-attach"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="<?= t('Delete Selection'); ?>">
                    <?php echo svg('rss/delete', TRUE); ?>
                </a>
                <a id="rss-delete-all"
                   href="#"
                   role="button"
                   class="rss-button tooltip-attach"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="<?= t('Clear All'); ?>">
                    <?php echo svg('rss/delete-all', TRUE); ?>
                </a>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <?php echo form_error('categories'); ?>
                <input type="hidden" id="categories" name="categories"/>
                <?php
                $this->outputData['groups_with_categories'] = [];
                $this->outputData['multiselect_id'] = 's2_';
                $this->load->view('multiselect', $this->outputData);
                ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-lg-9 col-md-9 col-sm-9"></div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <input type="submit" name="submit" class="button big primary" value="<?= (!$new_rss?'Update RSS Feed':'Create RSS Feed'); ?>"/>
            </div>
        </div>

    </div>

</form>