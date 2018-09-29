<input type="hidden" name="id" value="<?php echo $this->outputData['file']['id']; ?>" />
<input type="hidden" name="name" value="<?php echo $this->outputData['file']['name']; ?>" />
<input type="hidden" name="url" value="<?php echo $this->outputData['file']['url']; ?>" />
<input type="hidden" name="img_url" value="<?php echo $this->outputData['file']['img_url']; ?>" />
<?php if (isset($this->outputData['file']['img_url'])) { ?>
	<img class="attachment-image" src="<?php echo $this->outputData['file']['img_url']; ?>" alt="<?php echo $this->outputData['file']['name']; ?>"/>
	<?php if ($this->outputData['file']['id'] == '') { ?>
		<div role="button" class="attachment-delete" title="<?= t('Delete'); ?>">
			<?php echo svg('table-buttons/delete-inverse', TRUE); ?>
		</div>
	<?php } ?>
<?php } ?>