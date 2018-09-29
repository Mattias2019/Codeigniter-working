<?php foreach ($this->outputData['logins'] as $login) { ?>
	<tr>
		<td><?php echo $login['user_name']; ?></td>
        <td><?php echo date('Y/m/d h:i:s', $login['time']); ?></td>
        <td><?php echo $login['reason']; ?></td>
        <td><?php echo $login['user_agent']; ?></td>
        <td><?php echo $login['ip']; ?></td>
	</tr>
<?php } ?>