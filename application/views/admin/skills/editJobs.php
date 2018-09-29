<?php $this->load->view('header1'); ?>

<div class="edit-category">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Categories</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('Edit Jobs'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> Jobs
        <small><?= t('Edit Jobs'); ?></small>
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
	
                    <?php
                        //Show Flash Message
                        if($msg = $this->session->flashdata('flash_message'))
                        {
                            echo $msg;
                        }
                    ?>

                    <?php
                        $i=0;

                        //Content of a group
                        if(isset($projects) and $projects->num_rows()>0) {

                            $project = $projects->row();
                    ?>

                    <form role="form" name="editProjects" id="editProjects" class="form-horizontal" method="post" action="<?php echo admin_url('skills/editJobs/'.$project->id)?>">

                        <div class="form-body">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="job_id">
                                    <?= t('Job Id'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="job_id" readonly value="<?php echo set_value('Job Id', $project->id); ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="job_status">
                                    <?= t('Job Status'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" id="job_status" name="job_status">
                                        <option value=""></option>

                                        <?php
                                        if(isset($project_statuses) and $project_statuses->num_rows()>0)
                                        {
                                            foreach($project_statuses->result() as $project_status)
                                            {
                                                ?>
                                                <option value="<?php echo $project_status->id; ?>" <?php if($project->job_status == $project_status->id) echo "selected"; ?> ><?php echo $project_status->name; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('job_status'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="job_name">
                                    <?= t('Job Name');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="job_name" value="<?php echo set_value('job_name', $project->job_name); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('job_name'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="description">
                                    <?= t('Job Description'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="description" rows="3"><?php echo set_value('description',$project->description); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="budget_min">
                                    <?= t('Job Min');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="budget_min" value="<?php echo set_value('budget_min', $project->budget_min); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('budget_min'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="budget_max">
                                    <?= t('Job Max');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="budget_max" value="<?php echo set_value('budget_max', $project->budget_max); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('budget_max'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-2 control-label" for="is_feature">
                                    <?= t('Job Featured'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="is_feature" value="<?php echo ($project->is_feature?$project->is_feature:0); ?>" <?php if(isset($project->is_feature) and $project->is_feature==1) { echo 'checked';  } else { echo ''; } ?> id="is_feature" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-2 control-label" for="is_urgent">
                                    <?= t('Job Urgent'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="is_urgent" value="<?php echo ($project->is_urgent?$project->is_urgent:0); ?>" <?php if(isset($project->is_urgent) and $project->is_urgent==1) { echo 'checked';  } else { echo ''; } ?> id="is_urgent" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-2 control-label" for="is_hide_bids">
                                    <?= t('Job Hidden'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="is_hide_bids" value="<?php echo ($project->is_hide_bids?$project->is_hide_bids:0); ?>" <?php if(isset($project->is_hide_bids) and $project->is_hide_bids==1) { echo 'checked';  } else { echo ''; } ?> id="is_hide_bids" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-2 control-label" for="is_private">
                                    <?= t('Job Private'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="is_private" value="<?php echo ($project->is_private?$project->is_private:0); ?>" <?php if(isset($project->is_private) and $project->is_private==1) { echo 'checked';  } else { echo ''; } ?> id="is_private" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="today" value="<?php if(isset($today)) echo $today; ?>" />
                            <input type="hidden" name="todayOpen" value="<?php if(isset($todayOpen)) echo $todayOpen; ?>" />
                            <input type="hidden" name="todayClosed" value="<?php if(isset($todayClosed)) echo $todayClosed; ?>" />
                            <input type="hidden" name="thisWeek" value="<?php if(isset($thisWeek)) echo $thisWeek; ?>" />
                            <input type="hidden" name="thisMonth" value="<?php if(isset($thisMonth)) echo $thisMonth; ?>" />
                            <input type="hidden" name="thisYear" value="<?php if(isset($thisYear)) echo $thisYear; ?>" />

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-4" align="left">
                                        <a href="#" onclick="history.go(-1);return false;">
                                            <a href="<?php echo admin_url('skills/viewJobs') ?>">
                                                <button type="button" class="btn default"><?= t('Cancel');?></button>
                                            </a>
                                        </a>
                                        <input type="submit" name="manageProject" class="btn green" value="<?= t('Submit'); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

			        <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer1'); ?>
