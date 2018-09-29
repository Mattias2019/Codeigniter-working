<option value="">-- <?= t('Select Project'); ?> --</option>
<?php foreach ($this->outputData['projects'] as $project) { ?>
	<option value="<?php echo $project['id']; ?>" <?php if ($project['id'] == set_value('job_id')) echo 'selected="selected"'; ?>><?php echo $project['job_name']; ?></option>
<?php } ?>