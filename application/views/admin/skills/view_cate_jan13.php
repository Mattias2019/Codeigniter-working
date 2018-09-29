
<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<style type="text/css" class="init">

	th, td { white-space: nowrap; }
	div.dataTables_wrapper {
		width: 800px;
		margin: 0 auto;
	}

	</style>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url(); ?>/application/css/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/application/css/demo.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 

	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/application/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/application/js/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/application/js/demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">



$(document).ready(function() {
	$('#example').dataTable( {
		"scrollX": true
	} );
	

    $("#img_change").mouseover(function(){
    $("#img_change").css("background-color","yellow");
  });
  

} );

	</script>
	
	
<li class="clsNoBorder"><a href="<?php echo admin_url('skills/addCategory');?>"><?= t('add_category'); ?></a></li>

 <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>

	
<?php
$no=t('Sl.No');
$category_name=t('category_name');
$group=t('group');
$status=t('status');
$created=t('created');
$action=t('action');

$tablehead="<table width='100%' id='example' class='display'><thead><tr>
						<th></th>
          <th>$no</th>
          <th>$category_name</th>
          <th>$group</th>
          <th>Description</th>
		  <th>Attachment url</th>
		  <th>Attachment name</th>
		  <th>Page title</th>
		  <th>Meta keywords</th>
		  <th>Meta descrption</th>
		  <th>$status</th>
		  <th>$created</th>
		  <th>Modified</th>
		  <th>$action</th>
		  
		  
					</tr></thead><tbody>";
					echo $tablehead;
foreach($categories->result() as $category)
	{			

$id=$category->id;
?>

<form name='managecategory' method='post' action=''/>

<tr id='<?php echo $id;  ?>' class='edit_tr'>
<td><input type='checkbox' class='clsNoborder' name='categoryList[]' id='categoryList[]' value='<?php echo $id;  ?>'  /> </td>

<td><?php echo $category->id; ?></td>
<td class='edit_td' >
<span id='one_<?php echo $id;  ?>' class='text'><?php echo $category->category_name; ?></span>
<input type='text' value='<?php echo $category->category_name; ?>' class='editbox' id='one_input_<?php echo $id;  ?>' />
</td>

<td class='edit_td' >
<span id='two_<?php echo $id;  ?>' class='text'><?php echo $category->group_id; ?></span> 
<input type='text' value='<?php echo $category->group_id; ?>' class='editbox' id='two_input_<?php echo $id;  ?>'/>
</td>

<td class='edit_td' >
<span id='three_<?php echo $id;  ?>' class='text'><?php echo $category->description; ?> </span> 
<input type='text' value='<?php echo $category->description; ?>' class='editbox' id='three_input_<?php echo $id;  ?>'/>
</td>

<td >
<?php
if($category->attachment_url !="")
{
?>
<a href="<?php echo admin_url('skills/view_cat/'.$category->id) ?>" title="click here to change"><?php echo $category->attachment_url; ?></a></td>
<?php
}
else
{
?>
<a href="<?php echo admin_url('skills/view_cat/'.$category->id) ?>" title="click here to change">click here to add images</a></td>
<?php
}
?>
<td>
<?php echo $category->attachment_name; ?>
</td>

<td class='edit_td' >
<span id='six_<?php echo $id;  ?>' class='text'><?php echo $category->page_title; ?></span> 
<input type='text' value='<?php echo $category->page_title; ?>' class='editbox' id='six_input_<?php echo $id;  ?>'/>
</td>

<td class='edit_td' >
<span id='seven_<?php echo $id;  ?>' class='text'><?php echo $category->meta_keywords; ?></span> 
<input type='text' value='<?php echo $category->meta_keywords; ?>' class='editbox' id='seven_input_<?php echo $id;  ?>'/>
</td>

<td class='edit_td' >
<span id='eight_<?php echo $id;  ?>' class='text'><?php echo $category->meta_description; ?></span> 
<input type='text' value='<?php echo $category->meta_description; ?>' class='editbox' id='eight_input_<?php echo $id;  ?>'/>
</td>

<td class='edit_td' >
<span id='nine_<?php echo $id;  ?>' class='text'><?php echo $category->is_active; ?></span> 
<input type='text' value='<?php echo $category->is_active; ?>' class='editbox' id='nine_input_<?php echo $id;  ?>'/>
</td>

<td><?php echo date('Y-m-d',$category->created); ?></td>
<td><?php echo date('Y-m-d',$category->modified); ?></td>
<td>
 <a href="<?php echo admin_url('skills/deleteCategory/'.$category->id)?>" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a>
			 
			  </td>
</tr>

<?php

}
echo "</tbody></table>";
?>
</form>
<div id="selLeftAlign">
	<?= t('With Selected'); ?>
	<a name="delete" href="javascript: document.manageGroup.action='<?php echo admin_url('skills/deleteGroup'); ?>'; document.manageGroup.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a></div>
	 
	  
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> 
		 <script type="text/javascript" src="<?php echo base_url() ?>application/js/EditDeletePage.js"></script> 
        

        <style type="text/css">
           
            #loading{
                width: 100%;
                position: absolute;
                top: 100px;
                left: 100px;
				margin-top:200px;
            }
            
			.go_button
			{
			background-color:#f2f2f2;border:1px solid #006699;color:#cc0000;padding:2px 6px 2px 6px;cursor:pointer;position:absolute;margin-top:-1px;
			}
			.total
			{
			float:right;font-family:arial;color:#999;
			}
			.editbox
			{
			display:none;
			
			}
			
			.editbox
			{
			padding:4px;
			
			}
			
			

        </style>
<div id="loading"></div>
    
<div id="container"></div>


<?php $this->load->view('admin/footer'); ?>
			
