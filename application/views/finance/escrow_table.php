<?php
    if (isset($this->outputData['transactions']) && count($this->outputData['transactions']) > 0) {

        foreach ($this->outputData['transactions'] as $transaction) { ?>

            <tr>
                <td>
                    <span class="transaction-status <?php echo $transaction['status']['class']; ?>"><?php echo $transaction['status']['text']; ?></span>
                </td>
                <td><?php echo $transaction['client_name']; ?></td>
                <td><?php echo $transaction['job_name']; ?></td>
                <td><?php echo $transaction['milestone_name']; ?></td>
                <td><?php echo currency() . number_format($transaction['amount']); ?></td>
                <td><?php echo date('H:i Y/m/d', $transaction['transaction_time']); ?></td>
                <td>
                    <a href="<?php echo site_url('finance/invoice_pdf?project=' . $transaction['job_id'] . '&milestone=' . $transaction['milestone_id']); ?>"><?= t('Link'); ?></a>
                </td>
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