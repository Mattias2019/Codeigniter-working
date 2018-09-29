<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <h2><?= t('payment_settings'); ?></h2>

            <div class="content">
                <div class="table-responsive">
                    <table class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="5%"/>
                            <col width="2%"/>
                            <col width="30%"/>
                            <col width="7%"/>
                            <col width="2%"/>
                            <col width="30%"/>
                            <col width="7%"/>
                            <col width="7%"/>
                            <col width="7%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th rowspan="2" class="text-center table-text-middle"><?= t('#'); ?></th>
                            <th rowspan="2" class="text-center table-text-middle"><?= t('Name'); ?></th>
                            <th colspan="3" class="text-center"><?= t('Deposit'); ?></th>
                            <th colspan="3" class="text-center"><?= t('Withdrawal'); ?></th>
                            <th rowspan="2" class="text-center table-text-middle"><?= t('Comission'); ?></th>
                            <th rowspan="2" class="text-center table-text-middle"><?= t('Actions'); ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center"><?= t('Description'); ?></th>
                            <th class="text-center"><?= t('Min'); ?></th>
                            <th></th>
                            <th class="text-center"><?= t('Description'); ?></th>
                            <th class="text-center"><?= t('Min'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($settings)) {
                            foreach ($settings as $payment) {
                                $this->load->view('admin/settings/payment_row', ['payment' => $payment]);
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>

        function editRow(e) {
            e.preventDefault();
            var row = jQuery(this).closest('tr');
            var hiddenRow = row.next();
            // Enable inputs
            row.find('input').prop('disabled', false);
            hiddenRow.find('input').prop('disabled', false);
            // Enable contenteditable
            row.find('.editable-text').attr('contenteditable', true);
            // Show/hide buttons
            row.find('.button-edit, .button-credentials').addClass('hidden');
            row.find('.button-save, .button-cancel').removeClass('hidden');
        }

        function saveRow(e) {
            e.preventDefault();
            var row = jQuery(this).closest('tr');
            var hiddenRow = row.next();
            m.post(
                "<?php echo admin_url('paymentSettings/savePayment'); ?>",
                {
                    id: row.find('.id').text(),
                    title: row.find('.title').text(),
                    is_deposit_enabled: row.find('input[name=is_deposit_enabled]').is(':checked') ? 1 : 0,
                    deposit_description: row.find('.deposit_description').text(),
                    deposit_minimum: row.find('input[name=deposit_minimum]').val(),
                    is_withdraw_enabled: row.find('input[name=is_withdraw_enabled]').is(':checked') ? 1 : 0,
                    withdraw_description: row.find('.withdraw_description').text(),
                    withdraw_minimum: row.find('input[name=withdraw_minimum]').val(),
                    commission: row.find('input[name=commission]').val(),
                    credentials: hiddenRow.find("input").map(function () {
                        return {key: this.name, value: this.value};
                    }).toArray()
                },
                function (result) {
                    var newRow = jQuery(result.data);
                    row.replaceWith(newRow);
                    hiddenRow.remove();
                    newRow.find('.button-edit').click(editRow);
                    newRow.find('.button-save').click(saveRow);
                    newRow.find('.button-cancel').click(cancelRow);
                    setInputmask();
                    jQuery('[data-toggle="tooltip"]').tooltip();
                    jQuery('.button-credentials').click(showHideDetails);
                }
            );
        }

        function cancelRow(e) {
            e.preventDefault();
            var row = jQuery(this).closest('tr');
            var hiddenRow = row.next();
            m.post(
                "<?php echo admin_url('paymentSettings/refreshPayment'); ?>",
                {
                    id: row.find('.id').text()
                },
                function (result) {
                    var newRow = jQuery(result.data);
                    row.replaceWith(newRow);
                    hiddenRow.remove();
                    newRow.find('.button-edit').click(editRow);
                    newRow.find('.button-save').click(saveRow);
                    newRow.find('.button-cancel').click(cancelRow);
                    setInputmask();
                    jQuery('[data-toggle="tooltip"]').tooltip();
                    jQuery('.button-credentials').click(showHideDetails);
                }
            );
        }

        function showHideDetails(e) {
            e.preventDefault();
            if (!jQuery(this).hasClass('disabled')) {
                var container = jQuery(this).closest('tr').next();
                container.toggleClass('hidden');
            }
        }

        jQuery(document).ready(function () {
            jQuery('.button-edit').click(editRow);
            jQuery('.button-save').click(saveRow);
            jQuery('.button-cancel').click(cancelRow);
            jQuery('[data-toggle="tooltip"]').tooltip();
            jQuery('.button-credentials').click(showHideDetails);
        });

    </script>

<?php $this->load->view('footer1'); ?>