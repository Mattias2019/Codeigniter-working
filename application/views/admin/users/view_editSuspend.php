<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>

<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
	 <div class="clsTop clsClearFixSub">
	 
	 	<div class="inner_t">
      <div class="inner_r">
        <div class="inner_b">
          <div class="inner_l">
            <div class="inner_tl">
              <div class="inner_tr">
                <div class="inner_bl">
                  <div class="inner_br"> 
				  
          <div class="clsNav">
        </div>
	
		<div class="clsTitle">
          <h3><?= t('Edit Suspend'); ?></h3>
		  <?php
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
	  	?>
        </div>
   	   
           <table width="400" class="table">
        <thead>
		  <tr>
		  <th></th>
		     <th><?= t('S.No');?></th>
            <th><?= t('Suspend Type');?></th>
            <th><?= t('Suspend Value');?></th>
            <th><?= t('Options');?></th>
            <!--<th colspan="2"><span class="functions text-center" id="tip" style="opacity: 1;"> </span></th>-->
          </tr>
        </thead>
        <tbody>
		<?php 
		if(isset($suspend) and $suspend->num_rows()>0)
		{$i=0;
		foreach($suspend->result() as $suspend1)
			{
		?>
		<form name="managesuspend" method="post" action="" >
            <tr>
		    <td><input type="checkbox" class="clsNoborder" name="suspendlist[]" id="suspendlist[]" value="<?php echo $suspend1->id; ?>"  /> </td>
			<td><?php echo $i=$i+1; ?> </td>
            <td><?php echo $suspend1->suspend_type;?></td>
            <td><?php echo $suspend1->suspend_value;?></td>
            <td class="functions">
			<a title="Edit" class="icon edit tip" href="<?php echo admin_url('users/viewSuspend/'.$suspend1->id);?>"><img src="<?php echo image_url('edit-new.png'); ?>" height="20" width="20"/></a>
			 <a name="delete" href="javascript: document.managesuspend.action='<?php echo admin_url('users/deleteSuspend/'.$suspend1->id); ?>'; document.managesuspend.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a> 
			</td>
          </tr>
		  <?php }
		  }
		  else
		  {
		   echo '<tr><td colspan="5">'.t('No suspend users Found').'</td></tr>';
		  }
		  ?>
        </tbody>
      </table>
</form>
<br />
    <div class="clscenter clearfix">
	  <div id="selLeftAlign">
	<?= t('With Selected'); ?>
	 <a name="delete" href="javascript: document.managesuspend.action='<?php echo admin_url('users/deleteSuspend'); ?>'; document.managesuspend.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a>
	 
	</div>
	</div>
	<?php if(isset($pagination)) echo $pagination;?>
	
	  </div></div></div></div></div></div></div></div>   
	
	
  </div>
</div>
</div>
<?php $this->load->view('admin/footer'); ?>