<?php
    if (isset($this->outputData['transactions']) && count($this->outputData['transactions']) > 0) {

        foreach ($this->outputData['transactions'] as $transaction) { ?>

            <tr>
                <?php if ($transaction['job_id'] != '') { ?>
                    <td>
                        <span class="transaction-status <?php echo $transaction['payment_status']['class']; ?>"><?php echo $transaction['payment_status']['status']; ?></span>
                    </td>
                    <td><?php echo $transaction['client_name']; ?></td>
                    <td><?php echo $transaction['job_name']; ?></td>
                    <td><?php echo $transaction['country_name']; ?></td>
                    <td><?php echo $transaction['fiscal_year']; ?></td>
                    <td><?php echo currency() . number_format($transaction['amount']); ?></td>
                    <td><?php echo number_format($transaction['vat_percent']); ?></td>
                    <td><?php echo currency() . number_format($transaction['vat']); ?></td>
                    <td><?php echo date('Y/m/d', $transaction['due_date']); ?></td>
                    <td>
                        <a href="<?php echo site_url('finance/invoice_print/' . $transaction['job_id']); ?>"
                           role="button"
                           class="table-button tooltip-attach"
                           data-toggle="tooltip"
                           data-placement="top"
                           target="_blank"
                           title="<?= t('Print invoice'); ?>">
                            <img width="32" height="32" src="<?php echo image_url('print.png'); ?>">
                        </a>
                        <a href="<?php echo site_url('project/view?id=' . $transaction['job_id']); ?>"
                           role="button"
                           class="table-button tooltip-attach"
                           data-toggle="tooltip"
                           data-placement="top"
                           target="_blank"
                           title="<?= t('Detailed quote'); ?>">
                            <img width="32" height="32" src="<?php echo image_url('svg/table-buttons/detailed-quote.svg'); ?>">
                        </a>
                    </td>
                <?php } elseif ($transaction['country'] != '') { ?>
                    <td colspan="7"><?= t('Total VAT for'); ?><?php echo $transaction['country_name']; ?></td>
                    <td><?php echo currency() . number_format($transaction['vat']); ?></td>
                    <td colspan="3"></td>
                <?php } elseif ($transaction['fiscal_year'] != '') { ?>
                    <td colspan="7"><?= t('Total VAT for'); ?><?php echo $transaction['fiscal_year']; ?></td>
                    <td><?php echo currency() . number_format($transaction['vat']); ?></td>
                    <td colspan="3"></td>
                <?php } ?>
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