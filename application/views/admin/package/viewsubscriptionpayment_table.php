<?php foreach ($this->outputData['payments'] as $payment) { ?>
	<tr>
        <td><?php echo $payment['user_id'];?></td>
        <td><?php echo $payment['user_name'];?></td>
        <td><?php echo $payment['package_name'];?></td>
        <td><?php echo $payment['valid'];?></td>
        <td><?php echo $payment['amount'];?></td>
	</tr>
<?php } ?>