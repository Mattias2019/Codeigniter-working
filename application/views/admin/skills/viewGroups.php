<?php $this->load->view('header1'); ?>

<div class="view-groups">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Groups</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('view_group'); ?>
    </h1>
    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-12" align="right">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo admin_url('skills/addGroup')?>"><i class="fa fa-plus"></i> <?= t('create_new_group'); ?></a>
                </div>
                <div class="btn-group">
                    <button id="del_groups" class="btn red">
                        <i class="fa fa-trash"></i>
                        Delete selected Groups
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="groups-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="groups_table" role="grid">
            <thead data-field="" data-sort="">
                <tr role="row">
                    <th width="5%" class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox" class="group-checkable">
                            <span></span>
                        </label>
                    </th>

                    <th width="5%" rowspan="1" colspan="1"> <?= t('Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
                    <th rowspan="1" colspan="1"> <?= t('group_name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="group_name" data-sort=""></span> </th>
                    <th rowspan="1" colspan="1"> <?= t('description'); ?> <span role="button" class="table-sort fa fa-sort" data-field="description" data-sort=""></span> </th>
                    <th width="10%" rowspan="1" colspan="1"> <?= t('logo'); ?> </th>
                    <th width="10%" rowspan="1" colspan="1"> <?= t('created'); ?> <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span> </th>
                    <th width="6%" rowspan="1" colspan="1"> <?= t('action'); ?> </th>
                </tr>
            </thead>

            <tbody>
                <?php $this->load->view('admin/skills/viewGroupsTableBody', $this->outputData); ?>
            </tbody>

	    </table>

        <?php $this->load->view('pagination', $this->outputData); ?>

<!--	<a name="delete" href="javascript: document.manageGroup.action='--><?php //echo admin_url('skills/deleteGroup'); ?><!--'; document.manageGroup.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="--><?php //echo image_url('delete-new.png'); ?><!--" alt="Delete" title="Delete" /></a></div>-->
    </div>
</div>

<?php $this->load->view('footer1'); ?>
