<?php
    if (isset($this->outputData['transactions']) && count($this->outputData['transactions']) > 0) {

        foreach ($this->outputData['transactions'] as $transaction) { ?>

            <tr>
                <td>
                    <?= $transaction['id']; ?>
                </td>
                <td>
                    <span class="transaction-status <?= $transaction['status']['class']; ?>"><?= $transaction['status']['text']; ?></span>
                </td>
                <td>
                    <img class="finance-info-image"
                         src="<?= ($transaction['payment_method'] == 2) ? image_url('payment-wire.png') : image_url('payment-paypal.png'); ?>"
                    />
                </td>
                <td><?= $transaction['description']; ?></td>
                <td><?= currency() . number_format($transaction['amount']); ?></td>
                <td><?= $transaction['user_transaction_id']; ?></td>
                <td><?= $transaction['user_description']; ?></td>
                <td><?= date('H:i Y/m/d', $transaction['transaction_time']); ?></td>
            </tr>
<?php
        }
    }
    else {
?>
            <tr>
                <td valign="top" colspan="8">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No data found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>