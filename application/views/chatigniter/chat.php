<link rel="stylesheet" href="<?php echo base_url(); ?>application/views/chatigniter/css/font-awesome.min.css">
<style>
	.popover{
		z-index:999999 !important;
	}
</style>
<h2 class="chat-header" style="text-transform:none;">
	<a href="javascript:;" class="chat-form-close" style="width:100%;"><i class="fa fa-users"></i> <?= t('Contact List'); ?></a>
</h2>
<!--
| CHAT CONTACTS LIST SECTION
-->
<div class="chat-inner" id="chat-inner" style="position:relative;">
<div class="chat-group">
 <?php foreach ($users as $user) { ?>
    <a href="javascript: void(0)" data-toggle="popover" >
    <div class="contact-wrap">
      <input type="hidden" value="<?php echo $user['id']; ?>" name="user_id" />
       <div class="contact-profile-img">
           <div class="profile-img">
            <?php
			if(!empty($user['img_logo']) ) { ?>
				<img src="<?php echo $user['img_logo'];?>" title="<?php echo $user['name'];?>" class="img-responsive"/>
			<?php }else{ ?>
				<img src="<?php echo image_url('noImageblue.jpg');?>" class="img-responsive"/>
			<?php } ?>
            
            <span class="user_status">
                <?php $status = $user['is_online'] == 1 ? 'is-online' : 'is-offline'; ?>
                <span class="user-status <?php echo $status; ?>"></span>
            </span>
            
             
           </div>
           <div class="profile-img-hidden" style="display:none;">
            <?php
			if(!empty($user['img_logo']) ) { ?>
				<img src="<?php echo $user['img_logo'];?>" title="<?php echo $user['name'];?>" class="img-responsive" height="120" width="120" />
			<?php }else{ ?>
				<img src="<?php echo image_url('noImageblue.jpg');?>" class="img-responsive" height="120" width="120" />
			<?php } ?> 
           </div>
       </div>
        <span class="contact-name">
            <small class="user-name"><?php echo ucwords($user['name']); ?></small>
            <span class="badge progress-bar-danger" rel="<?php echo $user['id']; ?>"><?php /*echo $user->unread;*/ ?></span>
        </span>
    </div>
    </a>
 <?php  } ?>
</div>
</div>
<!--
| CHAT CONTACT HOVER SECTION
-->
<div class="popover" id="popover-content" style="left:830px;">
    <div id="contact-image"></div>
    <div class="contact-user-info">
        <div id="contact-user-name"></div>
        <div id="contact-user-status" class="online-status"></div>
    </div>
</div>
<!--
| INDIVIDUAL CHAT SECTION
-->
<div id="chat-box" style="top: 400px">
<div class="chat-box-header">
    <span class="display-name" style="margin-left:10px;"></span>
    <span class="user-status is-online"></span>
    <small style="color:#ddd;"></small>
    <a href="javascript: void(0);" class="chat-box-close">
        <i class="fa fa-remove"></i>
    </a>
</div>

<div class="chat-container">
    <div class="chat-content">
        <input type="hidden" name="chat_buddy_id" id="chat_buddy_id"/>
        <ul class="chat-box-body"></ul>
    </div>
    <div class="chat-textarea">
        <input placeholder="<?= t('Type your message'); ?>" class="form-control" />
    </div>
</div>
</div>
<!--------------------------------------------------------------------------------------------------------------------->

