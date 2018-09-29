<?php
$this->outputData['operation'] = 'escrow';
$this->outputData['operation_text'] = t('Escrow');
$this->outputData['segment'] = 7;
?>

<div class="col-xs-12">
    <h2><?= t('Escrow Funds'); ?></h2>
</div>
<div class="clearfix"></div>

<?php $this->load->view('finance/header_internal', $this->outputData); ?>

<div class="col-xs-12">
    <h3><?= t('My Escrow Transactions'); ?></h3>
</div>
<div class="clearfix"></div>

<div class="table-responsive" data-tab="<?php echo $this->outputData['segment']; ?>">
	<table class="table" width="100%" cellspacing="0">
		<thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?> <span role="button" class="table-sort fa fa-sort" data-field="status" data-sort=""></span></th>
                <th><?= t('Client'); ?> <span role="button" class="table-sort fa fa-sort" data-field="client_name" data-sort=""></span></th>
                <th><?= t('Project'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Milestone'); ?> <span role="button" class="table-sort fa fa-sort" data-field="milestone_name" data-sort=""></span></th>
                <th><?= t('Payment'); ?> <span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                <th><?= t('Date/Time'); ?> <span role="button" class="table-sort fa fa-sort" data-field="transaction_time" data-sort=""></span></th>
                <th><?= t('Link to Invoice'); ?></th>
            </tr>
		</thead>
		<tbody>
            <?php $this->load->view('finance/escrow_table'); ?>
		</tbody>
	</table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>

<div class="col-xs-12">
    <h3><?= t('Escrow Account'); ?></h3>
</div>
<div class="clearfix"></div>

<div class="table-responsive" data-tab="8">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?> <span role="button" class="table-sort fa fa-sort" data-field="status" data-sort=""></span></th>
                <th><?= t('Client'); ?> <span role="button" class="table-sort fa fa-sort" data-field="client_name" data-sort=""></span></th>
                <th><?= t('Project'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Milestone'); ?> <span role="button" class="table-sort fa fa-sort" data-field="milestone_name" data-sort=""></span></th>
                <th><?= t('Payment'); ?> <span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                <th><?= t('Date/Time'); ?> <span role="button" class="table-sort fa fa-sort" data-field="transaction_time" data-sort=""></span></th>
                <th><?= t('Link to Invoice'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('finance/escrow_account_table'); ?>
        </tbody>
    </table>
	<?php
	$this->outputData['pagination'] = $this->outputData['pagination_account'];
    $this->outputData['page_numbers'] = $this->outputData['page_numbers_account'];
    $this->load->view('pagination', $this->outputData);
    ?>
</div>