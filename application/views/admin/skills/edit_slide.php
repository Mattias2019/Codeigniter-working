<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
	
	 <div class="inner_t">
      <div class="inner_r">
        <div class="inner_b">
          <div class="inner_l">
            <div class="inner_tl">
              <div class="inner_tr">
                <div class="inner_bl">
                  <div class="inner_br"> 
	
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($groups) and $groups->num_rows() != 0)
		{
			$group = $groups->row();
	  ?>
	   <div class="clsTitle">
	 	<h3><?php echo "edit slider"; ?></h3>
		</div>
		
       <table width="700" class="table">
		 <form method="post" action="<?php echo admin_url('skills/edit_slide/'.$group->id)?>" enctype="multipart/form-data">
        <tr><td>
          <?= t('group_name'); ?><span class="clsRed">*</span></td><td>
		  
		  <select name="group_name">
		  <option value>--select--</option>
		  <option value="cube,circles" <?php if($group->group_name == 'cube,circles'){ echo "selected"; } ?>>cube,circles</option>
		  <option value="cubeRandom,circlesInside" <?php if($group->group_name == 'cubeRandom,circlesInside'){ echo "selected"; } ?>>cubeRandom,circlesInside</option>
		  <option value="block,circlesRotate"  <?php if($group->group_name == 'block,circlesRotate'){ echo "selected"; } ?>>block,circlesRotate</option>
		  </select>
		  
		  
		  
         
          <?php echo form_error('group_name'); ?> </td></tr>
		  
		  <tr><td>
          <?= t('category_logo'); ?></td><td>
		  <input class="clsTextBox" name="logo" type="file"/>
		  <?php
		  if($group->attachment_url)
		  {
		  ?>
		  <img src="<?php echo base_url(); ?>files/site_logo/<?php  echo $group->attachment_url; ?>" width="80" height="70" id="photoInput" />
		  <?php
		  }
		  ?>
		  <input type="hidden" name="attachment_url" value="<?php  echo $group->attachment_url; ?>"  />
		  <input type="hidden" name="attachment_name" value="<?php  echo $group->attachment_name; ?>"  />
          <?php echo form_error('logo'); ?> </td></tr>
		  <tr><td>
		
        <tr><td>
          <?= t('descritpion'); ?></td><td>
		  <textarea name="descritpion" class="clsTextArea"><?php echo $group->description; ?></textarea>
          <?php echo form_error('descritpion'); ?> </td></tr>
        <tr><td></td><td>
		  <input type="hidden" name="operation" value="edit" />
		  <input type="hidden" name="id"  value="<?php echo $group->id; ?>"/>
          <input type="submit" class="clsSubmitBt1" value="<?= t('submit'); ?>"  name="editGroup"/>
		  <a href="#" onclick="history.go(-1);return false;"><input type="button" value="Back"  class="clsSubmitBt1"></a> 
        </td></tr>
      </form>
	  </table>
	  <?php
	  }
	  ?>
	  
	  
	  </div></div></div></div></div></div></div></div>
	  
	  
    </div>
  </div>
  <!-- End of clsSettings -->
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
var _URL = window.URL;
$("#photoInput").change(function (e) {
 
   var file, img;
    if ((file = this.files[0])) {
        img = new Image(); 
        
img.onload = function () {
           var width = this.width;
           var height = this.height;
if(height <=455 && width <= 1005)
{
alert('correct image size');
}
if(height <400 && width <1000)
{
alert('but too small');
}
if(height >455 && width >1005){
alert("Too large");
}
 };
      img.src = _URL.createObjectURL(file);
   }
});
</script>


<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
