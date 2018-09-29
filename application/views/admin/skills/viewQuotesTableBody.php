<?php
if(isset($quotes) and $quotes->num_rows()>0)
{
    foreach($quotes->result() as $quote)
    {
        ?>

        <tr role="row">
            <td width="5%">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" name="projectList[]" id="projectList[] value="<?php echo $quote->id; ?>">
                    <span></span>
                </label>
            </td>
            <td><?php echo $quote->id; ?></td>
            <td><?php echo $quote->job_id; ?></td>
            <td>
                <?php //Show the Job name
                foreach($jobs->result() as $job)
                {
                    if($job->id == $quote->job_id)
                        echo $job->job_name;
                }
                ?>
            </td>
            <td><?php echo $quote->creator_id; ?> </td>
            <td><?php echo $quote->user_name; ?> </td>
            <td><?php echo $quote->amount; ?> </td>
            <td width="10%"><?php echo date('Y-m-d',$quote->created); ?> </td>

            <td width="6%">
                <div class="btn-group btn-group">
                    <a class="btn btn-sm green" title="Edit" href="<?php echo admin_url('skills/manageQuotes/'.$quote->id); ?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm red" title="Delete" href="<?php echo admin_url('skills/deleteBids'); ?>" onclick="return confirm('Are you sure want to delete??');">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>

        <?php
    }//Foreach End
}//If End
else
{ ?>
        <tr><td colspan="9"><?= t('No Quotes Found');?></td></tr>
<?php
}
?>