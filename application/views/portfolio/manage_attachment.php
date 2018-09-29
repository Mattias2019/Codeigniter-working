<?php $attachment = $this->outputData['attachment']; ?>
<div class="attachment">
	<input type="hidden" name="attachments[id][]" value="<?php echo $attachment['id']; ?>" />
	<input type="hidden" name="attachments[name][]" value="<?php echo $attachment['name']; ?>" />
	<input type="hidden" name="attachments[ori_name][]" value="<?php echo $attachment['ori_name']; ?>" />
	<input type="hidden" name="attachments[ext][]" value="<?php echo $attachment['ext']; ?>" />
	<input type="hidden" name="attachments[filesize][]" value="<?php echo $attachment['filesize']; ?>" />
    <input type="hidden" name="attachments[url][]" value="<?php echo $attachment['url']; ?>" />
    <img class="attachment-image" src="<?php echo $attachment['url']; ?>" alt="<?php echo $attachment['ori_name']; ?>"/>
    <div role="button" class="attachment-delete" title="<?= t('Delete'); ?>">
		<?php echo svg('table-buttons/delete-inverse', TRUE); ?>
    </div>
</div>