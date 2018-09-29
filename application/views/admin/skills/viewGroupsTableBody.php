
    <?php
        if(isset($groups) and $groups->num_rows()>0)
        {
            foreach($groups->result() as $group)
            {
                $attachment_url = $this->file_model->get_group_logo_file_path($group->id, $group->attachment_name);
    ?>

        <tr role="row">
            <td>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" name="grouplist[]" id="grouplist[] value="<?php echo $group->id; ?>">
                    <span></span>
                </label>
            </td>
            <td>
                <span class="id"><?php echo $group->id; ?></span>
            </td>
            <td>
                <?php echo $group->group_name; ?>
            </td>
            <td>
                <?php echo $group->description; ?>
            </td>
            <td>
                <img class="logo-image" src="<?php echo $attachment_url; ?>" <?php if ($group->attachment_name == '') echo 'hidden="hidden"'; ?>/>
            </td>
            <td>
                <?php echo date('Y-m-d',$group->created); ?>
            </td>

<!--            <td class="text-center">-->
<!--                <a href="#" class="table-button btn-edit">--><?php //echo svg('table-buttons/edit', TRUE); ?><!--</a>-->
<!--                <a href="#" class="table-button btn-delete">--><?php //echo svg('table-buttons/delete', TRUE); ?><!--</a>-->
<!--                <a href="#" class="table-button btn-save hidden">--><?php //echo svg('table-buttons/accept', TRUE); ?><!--</a>-->
<!--                <a href="#" class="table-button btn-cancel hidden">--><?php //echo svg('table-buttons/reject', TRUE); ?><!--</a>-->
<!--            </td>-->
            <td>
                <div class="btn-group btn-group">
                    <a class="btn btn-sm green" title="Edit" href="<?php echo admin_url('skills/editGroup/'.$group->id)?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm red btn-delete" title="Delete" href="<?php echo admin_url('skills/deleteGroup/'.$group->id)?>">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php
            }//Foreach End
        }//If End
        else
        {
    ?>
        <tr class="no-data-found">
            <td colspan="5" class="text-center">
                <?= t('No Groups Found');?>
            </td>
        </tr>
    <?php
        }
    ?>

