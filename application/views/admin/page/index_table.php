<?php $page = $this->outputData['page']; ?>
<tr>
    <td>
        <input type="hidden" name="id" value="<?php echo $page['id']; ?>"/>
        <input class="table-input" name="url" value="<?php echo $page['url']; ?>" disabled="disabled"/>
    </td>
    <td><input class="table-input" name="name" value="<?php echo $page['name']; ?>" disabled="disabled"/></td>
    <td><input class="table-input" name="page_title" value="<?php echo $page['page_title']; ?>" disabled="disabled"/></td>
    <td>
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="is_active" value="1" <?php if($page['is_active'] == 1) echo 'checked="checked"'; ?> disabled="disabled"/>
            <span></span>
        </label>
    </td>
    <td><?php echo date('Y/m/d', $page['created']); ?></td>
	<td>
		<a href="#" class="table-button button-edit">
			<?php echo svg('table-buttons/edit', TRUE); ?>
		</a>
		<a href="#" class="table-button button-delete">
			<?php echo svg('table-buttons/delete', TRUE); ?>
		</a>
		<a href="#" class="table-button button-save hidden">
			<?php echo svg('table-buttons/accept', TRUE); ?>
		</a>
		<a href="#" class="table-button button-cancel hidden">
			<?php echo svg('table-buttons/reject', TRUE); ?>
		</a>
	</td>
</tr>
<tr class="hidden">
    <td colspan="6" class="editable-text"><?php echo $page['content']; ?></td>
</tr>