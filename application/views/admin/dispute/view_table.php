<?php foreach ($this->outputData['messages'] as $message) { ?>
	<tr data-id="<?php echo $message['id']; ?>">
		<td><a href="<?php echo site_url('account/index?id='.$message['user_id']); ?>"><?php echo $message['from_name']; ?></a></td>
		<td><a href="<?php echo site_url('project/view?id='.$message['job_id']); ?>"><?php echo $message['job_name']; ?></a></td>
		<td><?php echo $message['subject']; ?></td>
		<td><?php echo $message['created']; ?></td>
        <td><span class="case-message-status <?php echo $message['status']['class']; ?>"><?php echo $message['status']['text']; ?></span></td>
        <td>
            <a href="#"
               role="button"
               class="table-button button-details tooltip-attach"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Show message'); ?>">
				<?php echo svg('table-buttons/details', TRUE); ?>
            </a>
            <a href="<?php echo admin_url('dispute/approve_message?id='.$message['id']); ?>"
               role="button"
               class="table-button tooltip-attach<?php if ($message['admin_approved'] != 0) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Confirm'); ?>">
				<?php echo svg('table-buttons/accept', TRUE); ?>
            </a>
            <a href="<?php echo admin_url('dispute/reject_message?id='.$message['id']); ?>"
               role="button"
               class="table-button tooltip-attach<?php if ($message['admin_approved'] != 0) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Cancel'); ?>">
				<?php echo svg('table-buttons/reject', TRUE); ?>
            </a>
        </td>
	</tr>
	<tr hidden="hidden">
		<td colspan="6">
            <p><?php echo $message['message']; ?></p>
        </td>
	</tr>
<?php } ?>