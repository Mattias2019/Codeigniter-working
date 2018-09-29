<?php $this->load->view('header1'); ?>

    <div class="cls_page-title">
        <h2><span><?= t('Tender overview'); ?></span></h2>
    </div>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

			<?php flash_message(); ?>

            <div class="content" id="content">
                <div class="table-responsive">
                    <table id="table-jobs" class="display clsmember table" width="100%" cellspacing="0">
                        <thead data-field="" data-sort="">
                            <tr>
                                <th><?= t('Status'); ?></th>
                                <th><?= t('Project Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                                <th><?= t('Project Budget'); ?> <span role="button" class="table-sort fa fa-sort" data-field="budget_min" data-sort=""></span></th>
                                <th><?= t('Tender Due Date'); ?> <span role="button" class="table-sort fa fa-sort" data-field="enddate" data-sort=""></span></th>
                                <th><?= t('Project Deadline'); ?> <span role="button" class="table-sort fa fa-sort" data-field="due_date" data-sort=""></span></th>
                                <th><?= t('Count of Quotes'); ?></th>
                                <th><?= t('Lowest Quote'); ?> <span role="button" class="table-sort fa fa-sort" data-field="quotes_min" data-sort=""></span></th>
                                <th><?= t('Average Quote'); ?></th>
                                <th><?= t('Highest Quote'); ?> <span role="button" class="table-sort fa fa-sort" data-field="quotes_max" data-sort=""></span></th>
                                <th><?= t('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->load->view('project/tender_table'); ?>
                        </tbody>
                    </table>
                    <?php $this->load->view('pagination', $this->outputData); ?>
                </div>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>