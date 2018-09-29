
    <?php $no=1;
    if(isset($userDetails) and $userDetails->num_rows()>0)
    {
        foreach($userDetails->result() as $userDetail)
        {
            ?>
            <tr role="row">
                <td width="5%">
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="userlist[]" id="userlist[] value="<?php echo $userDetail->id; ?>">
                        <span></span>
                    </label>
                </td>

                <td width="6%">
                    <?php echo $userDetail->id;?>
                </td>
                <td>
                    <?php echo $userDetail->user_name;?>
                </td>
                <td>
                    <?php echo $userDetail->name;?>
                </td>
                <td>
                    <?php echo $userDetail->email;?>
                </td>
                <td width="10%">
                    <span class="label label-sm label-<?php echo $userDetail->label_color;?>"><?php echo $userDetail->role_name;?></span>
                </td>
                <td>
                    <?php echo $userDetail->rate;?>
                </td>
                <td>
                    <?php echo $userDetail->num_reviews;?>
                </td>
                <td>
                    <?php echo $userDetail->amount;?>
                </td>

                <td width="6%">
                    <div class="btn-group btn-group">
                        <a class="btn btn-sm green btn-edit" title="Edit" href="<?php echo admin_url('users/editUser/'.$userDetail->id);?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-sm red btn-delete" title="Delete" href="<?php echo admin_url('users/deleteUser/'.$userDetail->id);?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>

                </td>
            </tr>

        <?php }
    }
    else{ ?>
        <tr>
            <td colspan="10">
                <?= t('No users found');?>
            </td>
        </tr>
    <?php }
    ?>

