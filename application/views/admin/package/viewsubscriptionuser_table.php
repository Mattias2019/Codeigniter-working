<?php foreach ($this->outputData['users'] as $user) { ?>
	<tr>
        <td><?php echo $user['user_id'];?></td>
        <td><?php echo $user['user_name'];?></td>
        <td><?php echo $user['package_name'];?></td>
        <td><?php echo $user['valid'];?></td>
        <td><?php echo $user['amount'];?></td>
		<td>
            <a href="<?php echo admin_url('packages/viewSubscriptionUser?id='.$user['id']); ?>"
               role="button"
               class="table-button tooltip-attach"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Edit User'); ?>">
				<?php echo svg('table-buttons/edit', TRUE); ?>
            </a>
			<a href="<?php echo admin_url('packages/deleteSubscriptionUser?id='.$user['id']); ?>"
			   role="button"
			   class="table-button tooltip-attach delete"
			   data-toggle="tooltip"
			   data-placement="top"
			   title="<?= t('Delete User'); ?>">
				<?php echo svg('table-buttons/delete', TRUE); ?>
			</a>
		</td>
	</tr>
<?php } ?>