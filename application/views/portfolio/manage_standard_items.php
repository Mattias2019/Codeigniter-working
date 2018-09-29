<?php
$i = $this->outputData['standard_item_number'];
$item = $this->outputData['standard_item_value'];
?>
<tr>
    <input type="hidden" name="standard_items[<?php echo $i; ?>][id]"
           value="<?php echo array_key_exists('id', $item) ? $item['id'] : NULL; ?>"/>
    <input type="hidden" name="standard_items[<?php echo $i; ?>][item_id]"
           value="<?php echo array_key_exists('item_id', $item) ? $item['item_id'] : NULL; ?>"/>
    <input type="hidden" name="standard_items[<?php echo $i; ?>][name]"
           value="<?php echo array_key_exists('name', $item) ? $item['name'] : NULL; ?>"/>
    <input type="hidden" name="standard_items[<?php echo $i; ?>][unit]"
           value="<?php echo array_key_exists('unit', $item) ? $item['unit'] : NULL; ?>"/>
    <td><?php echo $item['name']; ?></td>
    <td><?php echo $item['unit']; ?></td>
    <td>
        <?php echo form_error('standard_items[' . $i . '][value]'); ?>
        <input class="table-input border" name="standard_items[<?php echo $i; ?>][value]"
               value="<?php echo array_key_exists('value', $item) ? $item['value'] : ''; ?>"/>
    </td>
    <td>
        <input class="table-input border" name="standard_items[<?php echo $i; ?>][remarks]"
               value="<?php echo array_key_exists('remarks', $item) ? $item['remarks'] : ''; ?>"/>
    </td>
</tr>