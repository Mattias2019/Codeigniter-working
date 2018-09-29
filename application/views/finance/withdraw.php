<?php
$this->outputData['operation'] = 'withdraw';
$this->outputData['operation_text'] = t('Withdraw');
$this->outputData['segment'] = 6;
?>

<div class="col-xs-12">
    <h2><?= t('Withdraw Funds'); ?></h2>
</div>
<div class="clearfix"></div>

<?php $this->load->view('finance/header_external', $this->outputData); ?>

<div class="col-xs-12">
    <h3><?= t('My Withdraw Transactions'); ?></h3>
</div>
<div class="clearfix"></div>

<div class="table-responsive" data-tab="<?php echo $this->outputData['segment']; ?>">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Transaction-ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="id"
                                                           data-sort=""></span></th>
                <th><?= t('Status'); ?> <span role="button" class="table-sort fa fa-sort" data-field="status"
                                              data-sort=""></span></th>
                <th><?= t('Payment Method'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field=""
                                                           data-sort=""></span></th>
                <th><?= t('Project'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name"
                                               data-sort=""></span></th>
                <th><?= t('Milestone'); ?> <span role="button" class="table-sort fa fa-sort" data-field="milestone_name"
                                                 data-sort=""></span></th>
                <th><?= t('Amount'); ?> <span role="button" class="table-sort fa fa-sort" data-field="amount"
                                              data-sort=""></span></th>
                <th><?= t('Date/Time'); ?> <span role="button" class="table-sort fa fa-sort" data-field="transaction_time"
                                                 data-sort=""></span></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('finance/withdraw_table'); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>