<?php $attachment = $this->outputData['attachment']; ?>
<div class="attachment">
	<a href="<?php echo $attachment['img_url']; ?>" target="_blank">
        <img class="attachment-image" src="<?php echo $attachment['img_url']; ?>" alt="<?php echo $attachment['name']; ?>"/>
    </a>
</div>