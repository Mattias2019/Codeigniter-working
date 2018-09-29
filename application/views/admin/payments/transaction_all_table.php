<?php if (isset($transactions) and count($transactions) > 0) foreach ($transactions as $transaction) { ?>
    <tr>
        <td><?= $transaction['id']; ?></td>
        <td><?= $transaction['type']; ?></td>
        <td style="width: 100%;"><?= $transaction['user_bank_information']; ?></td>
        <td><?= $transaction['user_transaction_id']; ?></td>
        <td><?= $transaction['user_description']; ?></td>
        <td>
            <img width="50"
                 src="<?= ($transaction['payment_method'] == 'wire') ? image_url('payment-wire.png') : image_url('payment-paypal.png'); ?>"
            />
        </td>
        <td><?= $transaction['sender_name']; ?></td>
        <td><?php if ($transaction['sender_balance'] != NULL) echo currency() . number_format($transaction['sender_balance']); ?></td>
        <td><?= $transaction['receiver_name']; ?></td>
        <td><?php if ($transaction['receiver_balance'] != NULL) echo currency() . number_format($transaction['receiver_balance']); ?></td>
        <td><?php if ($transaction['amount'] != NULL) echo currency() . number_format($transaction['amount']); ?></td>
        <td><?php if ($transaction['fee'] != NULL) echo currency() . number_format($transaction['fee']); ?></td>
        <td><?= get_datetime($transaction['transaction_time']); ?></td>
        <td>
            <span class="transaction-status <?= $transaction['status']['class']; ?>"><?= $transaction['status']['text']; ?></span>
        </td>
        <td>
            <a href="<?= admin_url('payments/confirm?id=' . $transaction['id']); ?>"
               role="button"
               class="table-button tooltip-attach<?php if ($transaction['status']['id'] != 0) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Confirm Transaction'); ?>">
                <?= svg('table-buttons/accept', TRUE); ?>
            </a>
            <a href="<?= admin_url('payments/cancel?id=' . $transaction['id']); ?>"
               role="button"
               class="table-button tooltip-attach<?php if ($transaction['status']['id'] != 0) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Cancel Transaction'); ?>">
                <?= svg('table-buttons/reject', TRUE); ?>
            </a>
        </td>
    </tr>
<?php } ?>