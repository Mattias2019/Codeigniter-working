<?php
if (isset($this->outputData['milestone_number']))
{
    $n = $this->outputData['milestone_number'];
}
else
{
    $n = 0;
}
if (!isset($this->outputData['milestone_values']))
{
	$this->outputData['milestone_values'] = [
        'id' => NULL,
        'name' => '',
        'description' => '',
        'due_date' => '',
        'amount' => '',
        'attachments' => []
    ];
}
?>
<div class="milestone" data-milestone="<?php echo $n; ?>">
    <div class="row">

        <div class="col-xs-12">
            <h3 class="cls_color-blue"><?= t('Milestone'); ?> <?php echo $n; ?></h3>
        </div>

        <input type="hidden" name="milestones[<?php echo $n; ?>][id]" id="milestone_id<?php echo $n; ?>" class="form-control" value="<?php echo $this->outputData['milestone_values']['id']; ?>"/>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
				<?php echo form_error('milestones['.$n.'][name]'); ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label for="milestone_name<?php echo $n; ?>" class="form-control-label"><?= t('Name'); ?>:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <input name="milestones[<?php echo $n; ?>][name]" id="milestone_name<?php echo $n; ?>" class="form-control" value="<?php echo $this->outputData['milestone_values']['name']; ?>"/>
                </div>
            </div>
            <div class="form-group">
				<?php echo form_error('milestones['.$n.'][description]'); ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label for="milestone_description<?php echo $n; ?>" class="form-control-label"><?= t('Description'); ?>:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <textarea rows="5" name="milestones[<?php echo $n; ?>][description]" id="milestone_description<?php echo $n; ?>" class="form-control"><?php echo $this->outputData['milestone_values']['description']; ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
				<?php echo form_error('milestones['.$n.'][due_date]'); ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label for="milestone_due_date<?php echo $n; ?>" class="form-control-label"><?= t('Due Date'); ?>:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 js-due-date">
                    <input type="hidden" name="milestones[<?php echo $n; ?>][due_date]" id="milestone_due_date<?php echo $n; ?>" class="form-control milestone_due_date" value="<?php echo $this->outputData['milestone_values']['due_date'] ?>"/>
                    <input class="form-control js-picker-date"/>
                </div>
            </div>
            <div class="form-group">
				<?php echo form_error('milestones['.$n.'][amount]'); ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label for="milestone_amount<?php echo $n; ?>" class="form-control-label"><?= t('Amount'); ?>:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <input name="milestones[<?php echo $n; ?>][amount]" id="milestone_amount<?php echo $n; ?>" class="form-control milestone_amount_control inputmask" data-prefix="<?php echo currency(); ?>" min="0" value="<?php echo $this->outputData['milestone_values']['amount']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <a href="#" class="pull-right remove_current_milestone"><?php echo svg('other/trash', TRUE); ?><?= t('Delete'); ?></a>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="dropzone" data-milestone="<?php echo $n; ?>"></div>
        <div class="attachments">
			<?php
			$this->outputData['milestone_number'] = $n;
			foreach ($this->outputData['milestone_values']['attachments'] as $this->outputData['attachment'])
			{
				$this->load->view('project/create_attachment', $this->outputData);
			}
			?>
        </div>
    </div>

</div>