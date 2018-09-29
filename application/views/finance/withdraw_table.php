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

                <td><?php echo $transaction['job_name']; ?></td>
                <td><?php echo $transaction['milestone_name']; ?></td>
                <td><?php echo currency() . number_format($transaction['amount']); ?></td>
                <td><?php echo date('H:i Y/m/d', $transaction['transaction_time']); ?></td>
            </tr>
<?php
        }
    }
    else {
?>
            <tr>
                <td valign="top" colspan="7">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No data found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>