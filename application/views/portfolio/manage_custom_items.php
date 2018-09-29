<?php
$i = !empty($this->outputData['custom_item_number']) ? $this->outputData['custom_item_number'] : 0;
//$i = uniqid('custom_items_');
$item = $this->outputData['custom_item_value'];
?>
<tr class="js-custom-items-tr" data-item="<?php echo $i; ?>">
    <input type="hidden" name="custom_items[<?php echo $i; ?>][id]"
           value="<?php echo array_key_exists('id', $item) ? $item['id'] : NULL; ?>"/>
    <td>
        <?php echo form_error('custom_items[' . $i . '][name]'); ?>
        <input class="table-input border" name="custom_items[<?php echo $i; ?>][name]"
               value="<?php echo array_key_exists('name', $item) ? $item['name'] : ''; ?>"/>
    </td>
    <td>
        <input class="table-input border" name="custom_items[<?php echo $i; ?>][unit]"
               value="<?php echo array_key_exists('unit', $item) ? $item['unit'] : ''; ?>"/>
    </td>
    <td>
        <?php echo form_error('custom_items[' . $i . '][value]'); ?>
        <input class="table-input border" name="custom_items[<?php echo $i; ?>][value]"
               value="<?php echo array_key_exists('value', $item) ? $item['value'] : ''; ?>"/>
    </td>
    <td>
        <input class="table-input border" name="custom_items[<?php echo $i; ?>][remarks]"
               value="<?php echo array_key_exists('remarks', $item) ? $item['remarks'] : ''; ?>"/>
    </td>
    <td>
        <div role="button" class="remove-custom-item" title="<?= t('Delete'); ?>">
            <?php echo svg('table-buttons/delete-inverse', TRUE); ?>
        </div>
    </td>
</tr>