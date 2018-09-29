<?php
    if (isset($this->outputData['transactions']) && count($this->outputData['transactions']) > 0) {

        foreach ($this->outputData['transactions'] as $transaction) { ?>

            <tr>
                <?php if ($transaction['job_id'] != '') { ?>
                    <td>
                        <span class="transaction-status <?php echo $transaction['payment_status']['class']; ?>">
                            <?php echo $transaction['payment_status']['status']; ?>
                        </span>
                    </td>
                    <td><?php echo $transaction['client_name']; ?></td>
                    <td><?php echo $transaction['job_name']; ?></td>
                    <td><?php echo $transaction['fiscal_year']; ?></td>
                    <td><?php echo currency() . number_format($transaction['amount']); ?></td>
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
                        <a href="<?php echo site_url('finance/invoice_pdf/' . $transaction['job_id']); ?>"
                           role="button"
                           class="table-button tooltip-attach"
                           data-toggle="tooltip"
                           data-placement="top"
                           target="_blank"
                           title="<?= t('View invoice'); ?>">
                            <img width="32" height="32" src="<?php echo image_url('pdf.png'); ?>">
                        </a>
                        <?php if ($transaction['payment_status']['status'] === OVERDUE): ?>
                            <a href="#" onclick="send_reminder(<?php echo $transaction['client_id']?>, <?php echo $transaction['job_id']?>)"
                               role="button"
                               class="table-button tooltip-attach"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="<?= t('Send reminder'); ?>">
                                <img width="32" height="32" src="<?php echo image_url('svg/table-buttons/send-reminder.svg'); ?>">
                            </a>
                        <?php endif;?>
                        <a href="<?php echo site_url('finance/invoice_edit/' . $transaction['job_id']); ?>"
                           role="button"
                           class="table-button tooltip-attach"
                           data-toggle="tooltip"
                           data-placement="top"
                           target="_blank"
                           title="<?= t('Edit invoice'); ?>">
                            <img width="32" height="32" src="<?php echo image_url('svg/table-buttons/edit.svg'); ?>">
                        </a>
                    </td>
                <?php } elseif ($transaction['fiscal_year'] != '') { ?>
                    <td colspan="4"><?= t('Total amount for'); ?><?php echo $transaction['fiscal_year']; ?></td>
                    <td><?php echo currency() . number_format($transaction['amount']); ?></td>
                    <td colspan="4"></td>
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

<div class="row">
    <div class="col-lg-12">
        <div id="message">
        </div>
    </div>
</div>

<script>
    function send_reminder(userId, job_id)
    {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url() . '/finance/send_reminder/'?>" + userId +'/'+job_id,
            success: function(response){
                var data ="";
                if (response.is_send){
                    data =
                        '<div class="alert alert-info alert-dismissable fade in">' +
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
                            response.message+
                        '</div>';
                } else {
                    data =
                        '<div class="alert alert-danger alert-dismissable fade in">' +
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
                            response.message+
                        '</div>';
                }
                $("#message").empty().append(data);
            }
        });
    }
</script>
