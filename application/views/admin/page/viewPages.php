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
  
    <div class="clsMidWrapper">
      <!--MID WRAPPER-->
      <!--TOP TITLE & RESET-->
      <div class="clsTop clearfix">
          <div class="clsNav">
           <ul>
            <li><a href=""><?= t('view_page'); ?></a></li>
			<li><a href="<?php echo admin_url('page/addPage');?>"><?= t('add_page'); ?></a></li>
			<li class="clsNoBorder"><a href="<?php echo admin_url('faq/addFaq');?>"><?= t('add_faq'); ?></a></li>
          </ul>
        </div>
		<div class="clsTitle">
          <h3>View pages<?php //echo t('page'); ?></h3>
        </div>
      </div>
      <!--END OF TOP TITLE & RESET-->
	 
		   
	      <div class="clsTab">
         <table class="table" cellpadding="2" cellspacing="0">
		 <th></th>
            <th><?= t('Sl.No'); ?></th>
            <th><?= t('page_title'); ?></th>
		    <th><?= t('page_url'); ?></th>
			<th><?= t('page_name'); ?></th>
            <th><?= t('Created'); ?></th>
            <th><?= t('action'); ?></th>
        
		<?php $i=1;
			if(isset($pages) and $pages->num_rows()>0)
			{  
				foreach($pages->result() as $page)
				{
		?>
		<form action="" name="managepage" method="post">
			 <tr>
			  <td><input type="checkbox" class="clsNoborder" name="pagelist[]" id="pagelist[]" value="<?php echo $page->id; ?>"  /> </td>
			  <td><?php echo $i++; ?></td>
			  <td><?php echo $page->page_title; ?></td>
			  <td><a href="<?php echo site_url('page').'/'.$page->url; ?>"><li class="clsMailId">/<?php echo $page->url; ?></li></a></td>
			  <td><?php echo $page->name; ?></td>
			  <td><?php echo date('Y-m-d',$page->created); ?></td>
			  <td><a href="<?php echo admin_url('page/editPage/'.$page->id)?>"><img src="<?php echo image_url('edit-new.png'); ?>" alt="Edit" title="Edit" /></a>
			      <a href="<?php echo admin_url('page/deletePage/'.$page->id)?>" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a>
			  </td>
        	</tr>
			
        <?php
				}//Foreach End
			}//If End
			else
			{
			echo '<tr><td colspan="5">'.t('No Pages Found').'</td></tr>';
			}
		?>
		</table>
		</form>
		<br />
    <div class="clscenter clearfix">
	  <div id="selLeftAlign">
	<?= t('With Selected'); ?>
	<a name="delete" href="javascript: document.managepage.action='<?php echo admin_url('page/deletePage'); ?>'; document.managepage.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a></div>
	</div>
	
	</div>
      </div>
	  
	  </div></div></div></div></div></div></div></div>    
	  
    </div>
	
    <!--END OF MID WRAPPER-->
  </div>
  <!-- End of clsSettings -->
</div>
<!-- End Of Main -->
<?php $this->load->view('admin/footer'); ?>
