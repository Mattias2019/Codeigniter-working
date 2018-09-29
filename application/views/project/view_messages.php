<?php foreach ($this->outputData['messages'] as $message) { ?>
	<tr>
		<td><a href="<?php echo site_url('account/index?id='.$message['from_id']); ?>"><?php echo $message['from_name']; ?></a></td>
        <td><a href="<?php echo site_url('account/index?id='.$message['to_id']); ?>"><?php echo $message['to_name']; ?></a></td>
		<td><a href="#" class="show-message"><?php echo $message['subject']; ?></a></td>
		<td><?php echo $message['created']; ?></td>
	</tr>
	<tr hidden="hidden">
		<td colspan="4"><?php echo $message['message']; ?></td>
	</tr>
<?php } ?>