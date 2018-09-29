<?php foreach ($this->outputData['earnings'] as $earning) { ?>
	<tr>
		<td><?php echo date('Y/m/d h:i:s', $earning['transaction_time']); ?></td>
		<td><?php echo currency().number_format($earning['amount']); ?></td>
		<td><?php echo $earning['user_name']; ?></td>
		<td><?php echo $earning['type_name']; ?></td>
	</tr>
<?php } ?>