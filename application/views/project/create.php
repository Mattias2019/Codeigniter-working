<?php
if (array_key_exists('project', $this->outputData))
{
	$project = $this->outputData['project'];
	$this->outputData['project_milestones'] = $project['milestones'];
	$this->outputData['project_attachments'] = $project['attachments'];
}
else
{
	$proj_files_sess = $this->session->userdata('proj_files');
    if (!empty($proj_files_sess[0])) {
	    $proj_files_sess = $proj_files_sess[0];
    } else {
        $proj_files_sess = [];
    }
	$sess_attachments = array_filter($proj_files_sess, function($el){return empty($el['milestone']);});

	$proj_form_data = $this->session->userdata('proj_form_data');
    if (!empty($proj_form_data[0])) {
        $proj_form_data = $proj_form_data[0];
    } else {
        $proj_form_data = [];
    }
    $sess_milestiones = empty($proj_form_data['milestones']) ? [] : $proj_form_data['milestones'];
    //attachments are in their own array
    foreach($sess_milestiones as $sm_key => $sm_val) {
        unset($sess_milestiones[$sm_key]['attachments']);
    }

    $project = empty($proj_form_data) ? null : $proj_form_data;
    if ($project && !empty($project['category'])) {
        $project['categories'] = $project['category'][0];
    }

	$this->outputData['project_milestones'] = empty($sess_milestiones) ? [] : $sess_milestiones;
	$this->outputData['project_attachments'] = empty($sess_attachments) ? [] : $sess_attachments;
}
if (!isset($urgent_project)) $urgent_project = 0;
if (!isset($feature_project)) $feature_project = 0;
if (!isset($hide_project)) $hide_project = 0;
if (!isset($private_project)) $private_project = 0;
?>

<?php $this->load->view('header1'); ?>

		<?php flash_message(); ?>

        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <form method="post" id="post_project_frm" action="<?php echo site_url('project/create'); ?>" name="form" enctype="multipart/form-data" class="req_post form-horizontal postprjform">

                <input type="hidden" name="id" value="<?php echo set_value('id', $project['id']); ?>"/>
                <input type="hidden" id="job_status" name="job_status" value="<?php echo set_value('job_status', $project['job_status']); ?>"/>

                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase"><?= t('Post Job'); ?></span>
                    </div>
                </div>

                <div class="cls_postpjrt">

                    <div class="cls_ppage-bg-white">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php if (set_value('job_status', $project['job_status']) == Project_model::PROJECT_STATUS_DRAFT) { ?>
                                    <span class="caption-subject header-warning bold uppercase"><?= t('Draft'); ?></span>
                                <?php } elseif (set_value('job_status', $project['job_status']) == Project_model::PROJECT_STATUS_PENDING) { ?>
                                    <span class="caption-subject header-em bold uppercase"><?= t('Published'); ?></span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <?php echo form_error('job_name'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="job_name" class="form-control-label"><?= t('Project Name'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input name="job_name" id="job_name" class="form-control" value="<?php echo set_value('job_name', $project['job_name']); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('description'); ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="description" class="form-control-label"><?= t('Project Description'); ?>:</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea rows="5" name="description" id="description" class="form-control project_description"><?php echo set_value('description', $project['description']); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('enddate'); ?>
                                    <input type="hidden" name="enddate" id="enddate" value="<?php echo set_value('enddate', $project['enddate']); ?>"/>
                                    <input type="hidden" name="open_days_changed" id="open_days_changed" value="<?php echo set_value('open_days_changed', 0); ?>"/>
                                    <?php echo form_error('open_days'); ?>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label for="open_days" class="form-control-label"><?= t('I want my project to stay open for bidding for'); ?>:</label>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8">
                                        <input type="number" name="open_days" id="open_days" min="0" class="form-control" value="<?php echo set_value('open_days', ($project['enddate']==NULL || $project['enddate']==0)?NULL:((round(($project['enddate']-get_est_time())/DAY)) > 0)?((round(($project['enddate']-get_est_time())/DAY)) > 0):NULL ); ?>"/>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-4 days-label">
                                        <label for="open_days" class="form-control-label"><?= t('day(s)'); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('budget_min'); ?>
                                    <?php echo form_error('budget_max'); ?>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label class="form-control-label"><?= t('Budget'); ?></label>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                        <label for="budget_min" class=" form-control-label"><?= t('from'); ?>:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input name="budget_min" id="budget_min" min="0" class="form-control inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo set_value('budget_min', $project['budget_min']); ?>"/>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                                        <label for="budget_max" class="form-control-label"><?= t('to'); ?>:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input name="budget_max" id="budget_max" min="0" class="form-control inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo set_value('budget_max', $project['budget_max']); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('due_date'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="due_date" class="form-control-label"><?= t('Due Date'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input id="due_date" name="due_date" type="hidden" value="<?php echo(set_value('due_date', $project['due_date'])); ?>"/>
                                        <input id="picker_date" class="form-control"/>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <?php echo form_error('category'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="form-control-label"><?= t('Job Type'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" id="category" name="category"/>
                                        <?php
                                        $this->outputData['selectedCategories'] = set_value('category', empty($project['categories']) ? null : $project['categories']);
                                        $this->load->view('multiselect');
                                        ?>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <?php echo form_error('country'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="country" class="form-control-label"><?= t('Country'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="country" id="country" tabindex="1">
                                            <?php
                                            $sel_country = set_value('country', $project['country']);
                                            $sel_country = $sel_country?$sel_country:$this->outputData['user_country']->country_id;
                                            foreach ($this->outputData['countries'] as $country) { ?>
                                                <option value="<?php echo $country['id']; ?>" <?php if ($country['id'] == $sel_country) echo 'selected="selected"' ?> > <?php echo $country['country_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('city'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="city" class="form-control-label"><?= t('City'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input name="city" id="city" class="form-control" value="<?php echo set_value('city', $project['city']); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_error('state'); ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="state" class="form-control-label"><?= t('State'); ?>:</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input name="state" id="state" class="form-control" value="<?php echo set_value('state', $project['state']); ?>"/>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12">

                                <div class="accordion" id="invite-supplier-accordion">

                                    <div class="panel panel-default">

                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#invite-supplier-accordion" href="#collapse_3_1">
                                                    <i class="fa fa-users"></i>
                                                    <?= t('Invite Machine Supplier');?>
                                                </a>
                                            </h4>
                                        </div>

                                    </div>

                                    <div id="collapse_3_1" class="panel-collapse collapse">

                                        <div class="panel-body">

                                            <div class="row">

                                                <div class="invited-suppliers-list col-md-4">

                                                    <div class="invited-suppliers-list-header">
                                                        <h2>Invited suppliers</h2>
                                                    </div>

                                                    <div class="invited-suppliers-list-body">
                                                        <input type="hidden" id="invite_suppliers" name="invite_suppliers"/>
                                                        <?php $this->load->view('project/invited_suppliers_list'); ?>
                                                    </div>
                                                </div>

                                                <div class="suppliers-list col-md-8">

                                                    <div class="suppliers-list-header">
                                                        <h2>All Suppliers</h2>
                                                    </div>

                                                    <div class="dashboard container-fluid">

                                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                                            <div class="form-group">
                                                                <label for="supplier_name" class="form-control-label">
                                                                    <?=t('Name or Email:');?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 col-sm-5 col-xs-8">
                                                            <div class="form-group">
                                                                <input name="supplier_name" id="supplier_name" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                                            <div class="form-group">
                                                                <input type="button" id="find-supplier-btn" name="find-supplier-btn" class="button primary"
                                                                       value="<?= t('Search'); ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                                            <div class="form-group">
                                                                <input type="button" id="invite-supplier-btn" name="invite-supplier-btn" class="button primary"
                                                                       value="<?= t('Invite'); ?>"
                                                                       data-project-id="<?php echo $project['id']; ?>"
                                                                />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="suppliers-table">
                                                        <table class="table" width="100%" cellspacing="0">
                                                            <thead data-field="" data-sort="">
                                                                <tr>
                                                                    <th width="5%"></th>
                                                                    <th></th>
                                                                    <th>
                                                                        <?= t('Name'); ?>
                                                                        <span role="button" class="table-sort fa fa-sort" data-field="full_name" data-sort=""></span>
                                                                    </th>
                                                                    <th>
                                                                        <?= t('Email'); ?>
                                                                        <span role="button" class="table-sort fa fa-sort" data-field="u.email" data-sort=""></span>
                                                                    </th>
                                                                    <th>
                                                                        <?= t('Action'); ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php $this->load->view('project/suppliers_table'); ?>
                                                            </tbody>

                                                        </table>
                                                        <?php $this->load->view('pagination', $this->outputData); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="cls_post-type clearfix">

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="cls_right-blue cls_right-border">
                                        <?php echo form_error('is_feature'); ?>
                                        <h3>
                                            <input name="is_feature" value="1" id="is_feature" class="check" type="checkbox"
                                                <?php echo set_checkbox('is_feature', '1'); ?>
                                                <?= empty($project['is_feature']) ? '' : 'checked'; ?>
                                            />
                                            <span class="icon-svg-img">
                                                <?php echo svg('other/ico_feature', TRUE); ?>
                                            </span>
                                            <label for="is_feature" class="feature"><?= t('Featured'); ?></label>
                                            <span class="pull-right feature">$<?php echo $feature_project; ?></span>
                                        </h3>
                                        <p><?= t('pro1'); ?></p>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="cls_right-red cls_right-border">
                                        <?php echo form_error('is_urgent'); ?>
                                        <h3>
                                            <input name="is_urgent" value="1" id="is_urgent" class="check" type="checkbox"
                                                <?php echo set_checkbox('is_urgent', '1'); ?>
                                                <?= empty($project['is_urgent']) ? '' : 'checked'; ?>
                                            />
                                            <span class="icon-svg-img">
                                                <?php echo svg('other/ico_urgent', TRUE); ?>
                                            </span>
                                            <label for="is_urgent" class="urgent"><?= t('Urgent'); ?></label>
                                            <span class="pull-right urgent">$<?php echo $urgent_project; ?></span>
                                        </h3>
                                        <p><?= t('pro2'); ?></p>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="cls_right-grey cls_right-border">
                                        <?php echo form_error('is_hide_bids'); ?>
                                        <h3>
                                            <input class="check" name="is_hide_bids" id="is_hide_bids" value="1" type="checkbox"
                                                <?php echo set_checkbox('is_hide_bids', '1'); ?>
                                                <?= empty($project['is_hide_bids']) ? '' : 'checked'; ?>
                                            />
                                            <span class="icon-svg-img">
                                                <?php echo svg('other/ico_hide', TRUE); ?>
                                            </span>
                                            <label for="is_hide_bids" class="hide_bids"><?= t('Hide Bids'); ?></label>
                                            <span class="pull-right hide_bids">$<?php echo $hide_project; ?></span>
                                        </h3>
                                        <p><?= t('pro3'); ?></p>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="cls_right-violet cls_right-border">
                                        <?php echo form_error('is_private'); ?>
                                        <h3>
                                            <input type="checkbox" class="check"
                                                <?php echo set_checkbox('is_private', '1'); ?>
                                                   name="is_private" id="is_private" value="1"
                                                    <?= empty($project['is_private']) ? '' : 'checked'; ?>
                                            />
                                            <span class="icon-svg-img">
                                                <?php echo svg('other/ico_private', TRUE); ?>
                                            </span>
                                            <label for="is_private" class="private"><?= t('Private'); ?></label>
                                            <span class="pull-right private">$<?php echo $private_project; ?></span>
                                        </h3>
                                        <p><?= t('Private Messages'); ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12">
                                <div class="dropzone"></div>
                                <div class="attachments">
									<?php
									$this->outputData['milestone_number'] = NULL;
									if (is_array(set_value('attachments')))
									{
										$this->outputData['project_attachments'] = invert_array(set_value('attachments'));
									}
									foreach ($this->outputData['project_attachments'] as $this->outputData['attachment'])
									{
										$this->load->view('project/create_attachment', $this->outputData);
									}
									?>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xs-12">
                                <div class="milestone-wrapper">
                                    <?php
                                    if (is_array(set_value('milestones')))
                                    {
                                        $this->outputData['project_milestones'] = set_value('milestones');
                                    }
                                    if (is_array($this->outputData['project_milestones']))
                                    {
                                        $this->outputData['milestone_number'] = 1;
                                        foreach ($this->outputData['project_milestones'] as $this->outputData['milestone_values'])
                                        {
                                            if (!array_key_exists('attachments', $this->outputData['milestone_values']))
                                            {
                                                if (!empty($proj_files_sess)) {
                                                    $milestone_attachments = array_filter($proj_files_sess, function ($el) {
                                                        return $el['milestone'] == $this->outputData['milestone_number'];
                                                    });
                                                }
                                                $this->outputData['milestone_values']['attachments'] = empty($milestone_attachments) ? [] : $milestone_attachments;
                                            }
                                            elseif (is_array(set_value('milestones')))
                                            {
                                                $this->outputData['milestone_values']['attachments'] = invert_array($this->outputData['milestone_values']['attachments']);
                                            }
                                            $this->load->view('project/create_milestone');
                                            $this->outputData['milestone_number']++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col-lg-offset-8 col-md-offset-8 col-sm-offset-6">
                                <a type="button" id="add_milestone" class="button big primary"><?= t('Add Milestone'); ?></a>
                            </div>
                        </div>

                    </div>

                </div>

                <input type="submit" id="form-submit" name="submit" class="hidden" value=""/>

            </form>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="cls_form-fulbtns clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <a href="<?= site_url('/project/reset_form'.(empty($project['id']) ? '' : '/'.$project['id'])); ?>" class="button big danger">
                            <?= t('Discard Changes'); ?>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <input type="submit" id="submit-draft" class="button big primary" value="<?= t('Save As Draft'); ?>" <?php if (set_value('job_status', array_key_exists('project', $this->outputData)?$this->outputData['project']['job_status']:0) > 0) echo 'disabled="disabled"'; ?> />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <input type="submit" id="submit-new" class="button big primary" value="<?= t('Save Changes'); ?>" <?php if (set_value('job_status', array_key_exists('project', $this->outputData)?$this->outputData['project']['job_status']:0) > 1) echo 'disabled="disabled"'; ?> />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <input type="submit" id="submit-publish" class="button big secondary" value="<?= t('Publish'); ?>"/>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->load->view('project/draft_list'); ?>


<?php $this->load->view('footer1'); ?>