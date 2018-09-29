<?php
    if(isset($banDetails) and $banDetails->num_rows()>0)
    {
        foreach($banDetails->result() as $banDetail)
        {
?>
            <tr role="row">
                <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="banlist[]" id="banlist[]" value="<?php echo $banDetail->id; ?>">
                        <span></span>
                    </label>
                </td>
                <td>
                    <span class="id"><?php echo $banDetail->id; ?></span>
                </td>
                <td><?php echo $banDetail->ban_type;?></td>
                <td><?php echo $banDetail->ban_value;?></td>
                <td>
                    <?php echo date('Y-m-d',$banDetail->ban_time); ?>
                </td>
                <td class="text-center">
                    <a href="#" class="table-button btn-edit"><?php echo svg('table-buttons/edit', TRUE); ?></a>
                    <a href="#" class="table-button btn-delete"><?php echo svg('table-buttons/delete', TRUE); ?></a>
                    <a href="#" class="table-button btn-save hidden"><?php echo svg('table-buttons/accept', TRUE); ?></a>
                    <a href="#" class="table-button btn-cancel hidden"><?php echo svg('table-buttons/reject', TRUE); ?></a>
                </td>
            </tr>
<?php
        }
    }
    else
    {
?>
            <tr class="no-data-found">
                <td colspan="6">
                    <?= t('No Ban Users Found');?>
                </td>
            </tr>
<?php
    }
?>