<?php $this->load->view('header1'); ?>

<div class="view-jobs">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Tender/Projects</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('View Projects'); ?>
    </h1>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <form class="form" role="form">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo set_value('id', $view_projects_filter["id"]); ?>">
                    <label for="id"><?= t('Job Id'); ?></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="input-group">

                        <div class="input-group-control">
                            <input type="text" class="form-control" id="job_name" name="job_name" value="<?php echo set_value('job_name', $view_projects_filter["job_name"]); ?>">
                            <label for="id"><?= t('Job Name'); ?></label>
                        </div>

                        <span class="input-group-btn btn-right">
                            <button id="find-projects-btn" name="find-projects-btn" class="btn green"><i class="fa fa-search"></i> <?= t('filter_results');?> </button>
                        </span>

                        <span class="input-group-btn btn-right">
                            <button id="reset-find-projects-btn" name="reset-find-projects-btn" class="btn red"><i class="fa fa-remove"></i> <?= t('reset_filter');?> </button>
                        </span>

                    </div>
                </div>
            </div>

        </div>
    </form>
<!--    <li class="clsNoBorder"><a href="--><?php //echo admin_url('skills/searchJobs')?><!--"><b>--><?php //echo t('Search'); ?><!--</b></a></li>-->

    <div class="table jobs-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="groups_table" role="grid">
            <thead data-field="" data-sort="">
                <tr role="row">

                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox" class="projects-checkable">
                            <span></span>
                        </label>
                    </th>

                    <th rowspan="1" colspan="1"> <?= t('Job Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""> </th>
                    <th rowspan="1" colspan="1"> <?= t('Job Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""> </th>
                    <th rowspan="1" colspan="1"> <?= t('Post By'); ?> <span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""> </th>
                    <th rowspan="1" colspan="1"> <?= t('Start Date'); ?> <span role="button" class="table-sort fa fa-sort" data-field="craeted" data-sort=""> </th>
                    <th rowspan="1" colspan="1"> <?= t('End Date'); ?> <span role="button" class="table-sort fa fa-sort" data-field="enddate" data-sort=""> </th>
                    <th rowspan="1" colspan="1"> <?= t('action'); ?> </th>
                </tr>

            </thead>

            <tbody>
                <?php $this->load->view('admin/skills/viewJobsTableBody', $this->outputData); ?>
            </tbody>

		</table>

        <?php $this->load->view('pagination', $this->outputData); ?>

    </div>

</div>

<?php $this->load->view('footer1'); ?>