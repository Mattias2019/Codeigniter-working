
    <?php $no=1;
    if(isset($feedbacks) and $feedbacks->num_rows()>0)
    {
        foreach($feedbacks->result() as $feedback)
        {
            ?>
            <tr role="row">

                <td width="6%">
                    <?php echo $feedback->feedback_id;?>
                </td>
                <td>
                    <?php echo $feedback->user_name;?>
                </td>
                <td width="12%">
                    <?php echo $feedback->time_stamp;?>
                </td>
                <td>
                    <?php echo $feedback->browser;?>
                </td>
                <td>
                    <?php echo $feedback->language;?>
                </td>
                <td>
                    <?php echo $feedback->feedback_type_name;?>
                </td>
                <td>
                    <?php echo $feedback->memo_text;?>
                </td>
                <td>
                    <?php echo $feedback->page_reference;?>
                </td>
                <td>
                    <?php echo $feedback->geo_location;?>
                </td>
            </tr>

        <?php }
    }
    else{ ?>
        <tr>
            <td colspan="9">
                <?= t('No feedbacks found');?>
            </td>
        </tr>
    <?php }
    ?>

