<tr>
	<td class="text-center">
		<span class="id"><?php echo $payment['id']; ?></span>
	</td>
	<td class="editable-text title" contenteditable="false"><?php echo $payment['title']; ?></td>
	<td>
		<input type="checkbox" name="is_deposit_enabled" value="1" <?php if ($payment['is_deposit_enabled'] == '1') echo 'checked="checked"'; ?> disabled="disabled"/>
	</td>
	<td class="editable-text deposit_description" contenteditable="true"><?php echo $payment['deposit_description']; ?></td>
	<td class="text-center">
		<input name="deposit_minimum" class="table-input inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo $payment['deposit_minimum']; ?>" disabled="disabled"/>
	</td>
	<td class="text-center">
		<input type="checkbox" name="is_withdraw_enabled" value="1" <?php if ($payment['is_withdraw_enabled'] == '1') echo 'checked="checked"'; ?> disabled="disabled"/>
	</td>
	<td class="editable-text withdraw_description" contenteditable="false"><?php echo $payment['withdraw_description']; ?></td>
	<td class="text-center">
		<input name="withdraw_minimum" class="table-input inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo $payment['withdraw_minimum']; ?>" disabled="disabled"/>
	</td>
	<td class="editable-text mail_id" contenteditable="false"><?php echo $payment['mail_id']; ?></td>
	<td class="editable-text url" contenteditable="false"><?php echo $payment['url']; ?></td>
	<td class="text-center">
		<input name="commission" class="table-input inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo $payment['commission']; ?>" disabled="disabled"/>
	</td>
	<td class="text-center">
		<a href="#" class="table-button button-edit"><?php echo svg('table-buttons/edit', TRUE); ?></a>
		<a href="#" class="table-button button-save hidden"><?php echo svg('table-buttons/accept', TRUE); ?></a>
		<a href="#" class="table-button button-cancel hidden"><?php echo svg('table-buttons/reject', TRUE); ?></a>
	</td>
</tr>