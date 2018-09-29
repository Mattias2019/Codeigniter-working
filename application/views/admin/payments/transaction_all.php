<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard border-left border-primary">
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <label for="js-search-id" class="form-control-label"><?= t('Search by transaction ID'); ?>:</label>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <input type="number" id="js-search-id" class="form-control"/>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <label for="js-search-type" class="form-control-label"><?= t('Type'); ?>:</label>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <select id="js-search-type" class="form-control">
                        <option value="">-- <?= t('Select Type'); ?> --</option>
                        <?php foreach ($this->outputData['transaction_types'] as $transaction_type) { ?>
                            <option value="<?php echo $transaction_type['id']; ?>"><?php echo $transaction_type['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="table-responsive" data-tab="1">
        <table class="table" width="100%" cellspacing="0">
            <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Sl.No'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="id"
                                                  data-sort=""></span></th>
                <th><?= t('Description'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="type"
                                                        data-sort=""></span></th>
                <th><?= t('User Bank Info'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="type"
                                                           data-sort=""></span></th>
                <th><?= t('Bank Transaction-ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                                data-field="type" data-sort=""></span></th>
                <th><?= t('Purpose of payment'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                               data-field="type" data-sort=""></span></th>
                <th><?= t('Payment Method'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                           data-field="payment_method" data-sort=""></span></th>
                <th><?= t('Transaction From'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                             data-field="sender_id" data-sort=""></span></th>
                <th><?= t('Balance'); ?></th>
                <th><?= t('Transaction To'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                           data-field="receiver_id" data-sort=""></span></th>
                <th><?= t('Balance'); ?></th>
                <th><?= t('Amount'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount"
                                                   data-sort=""></span></th>
                <th><?= t('Fee'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="fee"
                                                data-sort=""></span></th>
                <th><?= t('Date'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                 data-field="transaction_time" data-sort=""></span></th>
                <th><?= t('Status'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="status"
                                                   data-sort=""></span></th>
                <th><?= t('Actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $this->load->view('admin/payments/transaction_all_table'); ?>
            </tbody>
        </table>
        <?php $this->load->view('pagination', $this->outputData); ?>
    </div>
</div>