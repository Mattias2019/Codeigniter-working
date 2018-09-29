<?php $this->load->view('header1'); ?>

    <div class="team-group clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="cls_page-title clearfix">
                <h2><?= t('Manage Groups'); ?></h2>
            </div>

            <div class="permission-table">
                <table id="table-groups" class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="14" class="text-center"><?= t('PERMISSIONS'); ?></th>
                        </tr>
                        <tr class="middle-header">
                            <th rowspan="2" class=""><?= t('Group Name'); ?></th>
                            <th rowspan="2" class=""><?= t('Team Members'); ?></th>
                            <th rowspan="2" class="text-center inline-header bordered"><?= t('Admin'); ?></th>
                            <th colspan="3" class="text-center inline-header bordered"><?= t('Quotes'); ?></th>
                            <th colspan="3" class="text-center inline-header bordered"><?= t('View Project'); ?></th>
                            <th colspan="4" class="text-center inline-header bordered"><?= t('Portfolio'); ?></th>
                            <th width="155px" rowspan="2" class=""><?= t('Actions'); ?></th>
                        </tr>
                        <tr class="bottom-header">
                            <th class="text-center bordered">Create</th>
                            <th class="text-center bordered"><?= t('Edit All'); ?></th>
                            <th class="text-center bordered"><?= t('Edit Own'); ?></th>
                            <th class="text-center bordered"><?= t('All'); ?></th>
                            <th class="text-center bordered"><?= t('Assigned'); ?></th>
                            <th class="text-center bordered"><?= t('Own'); ?></th>
                            <th class="text-center bordered"><?= t('Create'); ?></th>
                            <th class="text-center bordered"><?= t('Edit All'); ?></th>
                            <th class="text-center bordered"><?= t('Edit Own'); ?></th>
                            <th class="text-center bordered"><?= t('View'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="team-group-body">

                        <?php pifset($this->outputData, "groups_table"); ?>

                    </tbody>
                </table>
            </div>
            <div class="container-fluid">
                <div class="col-lg-9 col-md-9 col-sm-8"></div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <button type="button" class="button big primary" id="group-button-new"><?= t('Add New Group'); ?></button>
                </div>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>