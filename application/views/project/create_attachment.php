<?php
$n = $this->outputData['milestone_number'];
$attachment = $this->outputData['attachment'];
?>
<div class="attachment">
    <?php if ($n == NULL) { ?>
        <input type="hidden" name="attachments[id][]" value="<?php echo (empty($attachment['id']) ? '' : $attachment['id']); ?>" />
        <input type="hidden" name="attachments[name][]" value="<?php echo $attachment['name']; ?>" />
        <input type="hidden" name="attachments[url][]" value="<?php echo $attachment['url']; ?>" />
        <input type="hidden" name="attachments[img_url][]" value="<?php echo $attachment['img_url']; ?>" />
    <?php } else { ?>
        <input type="hidden" name="milestones[<?php echo $n; ?>][attachments][id][]" value="<?php echo $attachment['id']; ?>" />
        <input type="hidden" name="milestones[<?php echo $n; ?>][attachments][name][]" value="<?php echo $attachment['name']; ?>" />
        <input type="hidden" name="milestones[<?php echo $n; ?>][attachments][url][]" value="<?php echo $attachment['url']; ?>" />
        <input type="hidden" name="milestones[<?php echo $n; ?>][attachments][img_url][]" value="<?php echo $attachment['img_url']; ?>" />
    <?php } ?>
    <a target="_blank" href="<?php echo $attachment['img_url']; ?>">
        <img class="attachment-image" src="<?php echo $attachment['img_url']; ?>" alt="<?php echo $attachment['name']; ?>"/>
    </a>

    <div role="button" class="attachment-delete" title="<?= t('Delete'); ?>">
		<?php echo svg('table-buttons/delete-inverse', TRUE); ?>
    </div>
</div>