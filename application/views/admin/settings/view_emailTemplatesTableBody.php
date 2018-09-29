<?php
    if(isset($email_settings) and $email_settings->num_rows()>0)
    {
        foreach($email_settings->result() as $email_setting)
        {
            ?>
            <tr role="row">
                <td><?php echo $email_setting->id; ?></td>
                <td><?php echo $email_setting->title; ?></td>
                <td><?php echo $email_setting->mail_subject; ?></td>

                <td>
                    <div class="btn-group btn-group">
                        <a class="btn btn-sm green" title="Edit" href="<?php echo admin_url('emailSettings/edit/'.$email_setting->id);?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-sm red" title="Delete" href="<?php echo admin_url('emailSettings/delete/'.$email_setting->id);?>" onclick="return confirm('Are you sure want to delete??');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>

                </td>
            </tr>
            <?php
        }
    }
    else
    {
        echo '<tr><td colspan="3">'.t('No Templates Found').'</td></tr>';
    }
?>