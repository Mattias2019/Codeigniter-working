<option value="">-- <?= t('Select Reciever'); ?> --</option>
<?php foreach ($this->outputData['recievers'] as $reciever) { ?>
	<option value="<?php echo $reciever['id']; ?>" <?php if ($reciever['id'] == set_value('reciever_id')) echo 'selected="selected"'; ?> ><?php echo $reciever['name']; ?></option>
<?php } ?>