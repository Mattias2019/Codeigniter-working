<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
 <!--MAIN-->
    <div id="main">
      <!--COL-RIGHT-->
     
      <!--CONTENT-->
      <div class="content">
	  
	  <div class="clsLeft_hmenu">
      <div class="clsRight_hmenu">
        <div class="clsCen_hmenu">		
        <h2><b><?= t('Dashboard'); ?></b></h2>
		</div></div></div>
	       
        <div id="selLatest">
		
  <div class="inner_t">
      <div class="inner_r">
        <div class="inner_b">
          <div class="inner_l">
            <div class="inner_tl">
              <div class="inner_tr">
                <div class="inner_bl">
                  <div class="inner_br">
		
		 <h3><?= t('Latest Activity'); ?></h3>
          <div class="selQuickStatus clearfix">
            <div class="selQuickStatusleft clsFloatRight">
      <p><img src="<?php echo image_url('chat.jpg'); ?>" height="80" width="85" alt="img" /></p>
            </div>         
            <div class="selQuickStatusRight clsFloatLeft">
              <h2><span style="padding:9px 0 0 20px; float:right;"><?= t('Admin Balance'); ?>:$<?php if(isset($adminBalance)) echo sprintf("%01.2f",$adminBalance); else echo '0.00'; ?></span><?= t('Quick Status'); ?></h2>
             <ul class="clearfix">
             <li class="clsMember clear"><table width="300"><tr><td width="60%"><?= t('Total Users'); ?> :</td> <td width="10%"><?php if(isset($owners)) echo $owners+$employees; ?></td> <td width="30%"><a href="<?php echo admin_url('users/viewUsers'); ?>"><?= t('Members'); ?></a></td></tr></table></li>
			 
             <li class="clspros"><table width="300"><tr><td width="60%"><?= t('Total Owners'); ?> :</td> <td width="10%"><?php if(isset($owners)) echo $owners; ?></td><td width="30%"><a href="<?php echo admin_url('users/owner'); ?>"> <?= t('Members'); ?></a></td></tr></table></li>
			 
             <li class="clspros clear"><table width="300"><tr><td width="60%"><?= t('Total Employees'); ?> :</td> <td width="10%"> <?php if(isset($employees)) echo $employees; ?></td><td width="30%"><a href="<?php echo admin_url('users/employee'); ?>"> <?= t('Members'); ?></a></td></tr></table></li>
             
			  <li class="clsToday"><table width="300"><tr><td width="60%"><?= t('Today'); ?> : </td> <td width="10%"><?php if(isset($today)) echo $today; ?></td><td width="30%"><a href="<?php echo admin_url('skills/todayJobs'); ?>">  <?= t('Jobs'); ?></a></td></tr></table></li>
			  
                <li class="clsWeek clear"><table width="300"><tr><td width="60%"><?= t('This Week'); ?> :</td> <td width="10%"> <?php if(isset($week)) echo $week; ?></td><td width="30%"><a href="<?php echo admin_url('skills/thisWeek'); ?>"> <?= t('Jobs'); ?> </a></td></tr></table></li>
                 <li class="clsMonth"><table width="300"><tr><td width="60%"><?= t('This Month'); ?> :</td> <td width="10%"><?php if(isset($month)) echo $month; ?></td><td width="30%"><a href="<?php echo admin_url('skills/thisMonth'); ?>"><?= t('Jobs'); ?></a></td></tr></table></li>
				          
				<li class="clsYear clear"><table width="300"><tr><td width="60%"><?= t('This Year'); ?> : </td> <td width="10%"><?php if(isset($year)) echo $year; ?></td><td width="30%"><a href="<?php echo admin_url('skills/thisYear'); ?>">  <?= t('Jobs'); ?></a></td></tr></table></li>
				
                <li class="clsOpenPros"><table width="300"><tr><td width="60%"><?= t('Total Open Jobs'); ?> :</td> <td width="10%"> <?php if(isset($open_jobs)) echo $open_jobs; ?></td><td width="30%"><a href="<?php echo admin_url('skills/openJobs'); ?>"><?= t('Jobs'); ?></a></td></tr></table></li>
				 
                 <li class="clsClosedprojects clear"><table width="300"><tr><td width="60%"><?= t('Total Closed Jobs'); ?> : </td> <td width="10%"><?php if(isset($closed_jobs)) echo $closed_jobs; ?></td><td width="30%"><a href="<?php echo admin_url('skills/closedJobs'); ?>"> <?= t('Jobs'); ?> </a></td></tr></table></li>

	              	 <li class="clsWidthdraw"><table width="300"><tr><td width="60%"><?= t('Latest Open Jobs'); ?> : </td> <td width="10%"><?php if(isset($open)) echo $open; ?></td><td width="30%"><a href="<?php echo admin_url('skills/todayOpen'); ?>"> <?= t('Jobs'); ?></a></td></tr></table></li>
				 
                 <li class="clsLatestClosed clear"><table width="300"><tr><td width="60%"><?= t('Latest Closed Jobs'); ?> :</td> <td width="10%"> <?php if(isset($closed)) echo $closed; ?></td><td width="30%"><a href="<?php echo admin_url('skills/todayClosed'); ?>"><?= t('Jobs'); ?></a></td></tr></table></li>

                <li class="clsReport"><table width="300"><tr><td width="60%"><?= t('Report Violation'); ?> :</td> <td width="10%"> <?php if(isset($reportViolation)) echo $reportViolation; ?></td><td width="30%"><a href="<?php echo admin_url('skills/reportViolation'); ?>"> <?= t('Jobs'); ?></a></td></tr></table></li>
              	
				 
                 <li class="clsOpenPros clear"><table width="300"><tr><td width="60%"><?= t('Withdrawal Request'); ?> : </td> <td width="10%"><?php if(isset($withdraw)) echo $withdraw; ?></td><td width="30%"><a href="<?php echo admin_url('payments/releaseWithdraw'); ?>"><?= t('View'); ?></a></td></tr></table></li>

				 </ul>
            </div>
          </div>
		</div></div></div></div></div></div></div></div>
		
		
        </div>
		<!--<div class="clsBottom clearfix"> 
		<div class="clsBottomleft clsFloatLeft">
		<h3 class="clsNoborder"><?= t('Version'); ?></h3>
		<ul>
		<li><a href="#"><?= t('Installed Version'); ?> - 2.0</a></li>
		</ul>
		</div>
		<div class="clsBottomRight clsFloatRight">
		</div>
      </div>-->
    </div>
    <!--END OF CONTENT-->
  </div>
  <!--END OF MAIN-->
<?php $this->load->view('admin/footer'); ?>