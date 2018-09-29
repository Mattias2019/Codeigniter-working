<?php
if(isset($jobs) and $jobs->num_rows()>0)
{  $i=0;
    foreach($jobs->result() as $job)
    {
        ?>

        <tr role="row">
            <td width="5%">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" name="projectList[]" id="projectList[]" value="<?php echo $job->id; ?>">
                    <span></span>
                </label>
            </td>
            <td width="6%">
                <?php echo $job->id; ?>
            </td>
            <td>
                <?php echo $job->job_name; ?>
            </td>
            <td>
                <?php echo $job->user_name; ?>
            </td>
            <td width="10%">
                <?php echo date('Y-m-d',$job->created); ?>
            </td>
            <td width="10%">
                <?php echo date('Y-m-d',$job->enddate); ?>
            </td>

            <td width="6%">
                <div class="btn-group btn-group">
                    <a class="btn btn-sm green" title="Edit" href="<?php echo admin_url('skills/editJobs/'.$job->id); ?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm red btn-delete" title="Delete" href="<?php echo admin_url('skills/deleteJobs/'.$job->id); ?>">
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
    <tr><td colspan="8"><?= t('No Jobs Found');?></td></tr>
<?php
}
?>