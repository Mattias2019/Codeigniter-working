<?php if (isset($this->logged_in_user->id)) { ?>
	<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery("#chat-container").load("<?php echo base_url('chat/chatigniter'); ?>");
        });
	</script>
	<a href="javascript:void(0)" id="chat-menu-toggle" class="btn-chat btn">
		<i class="fa fa-commenting">&nbsp;<span class="uppercase"><?= t('Chat'); ?></span></i>
		<span class="badge progress-bar-danger"></span>
	</a>
	<div id="chat-container" class="fixed"></div>
<?php } ?>