<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
 <div class="clsTitle">
            <h3><?php echo "Send E-mail"; ?></h3>
 </div>
<div align="center">
<?php
if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		} ?> </div>
<form action="<?php echo site_url('siteadmin/support/sendMail/'.$this->uri->segment(4,0).'/'.$this->uri->segment(5,0)); ?>" method="post">
	<table width="900" >
	
   <tr>
     <td>
		<div class="clsCompose"> <label >To :</label> 	 <textarea name="to" cols="0" rows="0" ><?php if(isset($to_mail))echo $to_mail; ?> </textarea> </div>
	 <?php if(form_error('to')) { echo '<p><span>&nbsp;</span>';echo form_error('to'); echo '</p>'; }?>
	</td>
  </tr>
  <tr>
    <td>
	 <div class="clsCompose"> <label>Subject :</label> <input type="text" name="subject" class="clsSubject" value="<?php if(!isset($success))echo set_value('subject'); ?>" /></div>
	 <?php if(form_error('subject')) { echo '<p><span>&nbsp;</span>';echo form_error('subject'); echo '</p>'; }?>
	</td>
  </tr>
  <tr>
    <td>
	<div class="clsCompose"> <label>Content :</label>  <textarea name="content" cols="70" rows="10" style="height:40%;"><?php if(!isset($success))echo set_value('content'); ?> </textarea></div>
	 <?php if(form_error('content')) { echo '<p><span>&nbsp;</span>';echo form_error('content'); echo '</p>'; }?>
	</td>
  </tr>
  <tr>
    <td>
	 <div class="clsCompose"> <label>&nbsp;</label>   <input type="submit" name="email_to_all" value="Send Email"/></div>
	</td>
  </tr>
</table>
   
<a href="<?php echo admin_url('support/viewSupport');?>"> << Back</a>   
	
<?php $this->load->view('admin/footer'); ?>
</form>
</body>