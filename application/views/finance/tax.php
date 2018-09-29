<?php
$this->outputData['segment'] = 3;
?>

<div class="col-xs-12">
    <h2><?= t('Tax Report For The Fiscal Period'); ?></h2>
</div>
<div class="clearfix"></div>

<?php $this->load->view('finance/header_summary', $this->outputData); ?>

<div class="table-responsive" data-tab="<?php echo $this->outputData['segment']; ?>">
	<table class="table" width="100%" cellspacing="0">
		<thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?></th>
                <th><?= t('Client'); ?></th>
                <th><?= t('Project Name'); ?></th>
                <th><?= t('Country'); ?></th>
                <th><?= t('Fiscal Year Report'); ?></th>
                <th><?= t('Payment Overview'); ?></th>
                <th><?= t('Vat %'); ?></th>
                <th><?= t('Vat'); ?></th>
                <th><?= t('Due Date'); ?></th>
                <th><?= t('Action'); ?></th>
            </tr>
		</thead>
		<tbody>
            <?php $this->load->view('finance/tax_table'); ?>
		</tbody>
	</table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>