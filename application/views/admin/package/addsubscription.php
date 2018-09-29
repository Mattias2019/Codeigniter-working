<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>app/js/datetimepicker.js"></script>
<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
	<div class="clsTop clsClearFixSub">
          <div class="clsNav">
          <ul>
           <li><a href="<?php echo admin_url('packages/addsubscription');?>"><b><?= t('Add Subscription user'); ?></b></a></li>
			<li><a href="<?php echo admin_url('packages/searchsubscription');?>"><b><?= t('Search Subscription user'); ?></b></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('packages/viewsubscriptionuser');?>"><b><?= t('View subscribed users'); ?></b></a></li>
          </ul>
        </div>
		<div class="clsTitle">
            <h3><?= t('Add Subscription users'); ?></h3>
        </div>
      </div>
	     <?php
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
				  	?>
		<form method="post" action="">
	  <table class="table1" cellpadding="2" cellspacing="0">
		<tbody>
		 <tr>
            <td class="clsName"><?= t('Username');?> </td>
            <td class="clsMailIds">:
			<input name="username" type="text" id="username" value="<?php echo set_value('package'); ?>">
			<?php echo form_error('Username'); ?>
		    </td>
          </tr>
      
           <tr>
            <td class="clsName"><?= t('Package Name');?> </td>
            <td class="clsMailIds">:
			 <select name="package_name"  class="usertype" id="from_usertype" >
		    <option value=""><?= t('choose package'); ?></option>
			<?php foreach($package->result() as $pack)
			  {  ?>
			  <option value="<?php echo $pack->id;?>"><?php echo $pack->package_name; ?></option>
			 
			  <?php
			    
			  } ?>
		  </select>
			<?php echo form_error('package Name'); ?>
		    </td>
          </tr>
           <tr>
            <td width="25%"><?= t('valid');?></td>
            <td width="55%">:
                <input type="Text" id="valid" name="valid" maxlength="25" size="25"><a href="javascript:NewCal('valid','ddmmmyyyy')"><img src="<?php echo image_url("cal.gif");?>" width="16" height="16" border="0" alt="Pick a date"></a><?php echo form_error('valid'); ?></td>
          </tr>
		  
		  <tr>
            <td width="25%"><strong><span id="valuen"><?= t('Payment Type');?></span></strong></td>
            <td width="55%">:
            <select name="payment_type">
		  	<option value="<?= t('Pay Pal'); ?>"><?= t('Pay Pal'); ?></option>
			<option value="<?= t('Escrow'); ?>"><?= t('Escrow'); ?></option>
		  </select>
          <?php echo form_error('Payment Type'); ?>
				</td>
          </tr>
		   <tr>
            <td width="25%"><strong><span id="valuen"><?= t('Amount');?></span></strong></td>
            <td width="55%">:
                <input name="amount" type="text" class="textbox" id="duration" value="<?php echo set_value('Amount'); ?>">
				<?php echo form_error('Amount'); ?>
				</td>
				
          </tr>
             <tr id="bansubmit" >
            <td></td>
            <td height="30" style="padding-left:6px;"><input name="addsubscrber" type="submit" class="clsSub" value="<?= t('Submit');?>">
			&nbsp;
            <input name="Reset" type="reset" class="clsSub" value="<?= t('Reset');?>">
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php $this->load->view('admin/footer'); ?>