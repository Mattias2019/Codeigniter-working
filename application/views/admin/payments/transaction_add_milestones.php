<option value="">-- <?= t('Select Milestone'); ?> --</option>
<?php foreach ($this->outputData['milestones'] as $milestone) { ?>
	<option value="<?php echo $milestone['id']; ?>" <?php if ($milestone['id'] == set_value('milestone_id')) echo 'selected="selected"'; ?>><?php echo $milestone['name']; ?></option>
<?php } ?>