<?php
$this->outputData['operation'] = 'deposit';
$this->outputData['operation_text'] = t('Deposit');
$this->outputData['segment'] = 4;
?>

<div class="col-xs-12">
    <h2><?= t('Deposit Funds'); ?></h2>
</div>
<div class="clearfix"></div>

<?php $this->load->view('finance/header_external', $this->outputData); ?>

<div class="col-xs-12">
    <h3><?= t('My Deposit Transactions'); ?></h3>
</div>
<div class="clearfix"></div>

<div class="table-responsive" data-tab="<?php echo $this->outputData['segment']; ?>">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Transaction-ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="id"
                                                           data-sort=""></span></th>
                <th><?= t('Status'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="status"
                                                   data-sort=""></span></th>
                <th><?= t('Payment Method'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field=""
                                                           data-sort=""></span></th>
                <th><?= t('From'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field=""
                                                 data-sort=""></span></th>
                <th><?= t('Amount'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount"
                                                   data-sort=""></span></th>
                <th><?= t('Bank Transaction-ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                                data-field="user_transaction_id" data-sort=""></span></th>
                <th><?= t('Purpose of payment'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                               data-field="user_description" data-sort=""></span></th>
                <th><?= t('Date/Time'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                      data-field="transaction_time" data-sort=""></span></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('finance/deposit_table'); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>