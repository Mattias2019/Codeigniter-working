<div class="table-responsive" data-tab="4">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="job_status" data-sort=""></span></th>
                <th><?= t('Project Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Quote'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="budget_min" data-sort=""></span></th>
                <th><?= t('Active Milestone'); ?></th>
                <th><?= t('Milestone Amount'); ?></span></th>
                <th><?= t('Paid'); ?></th>
                <th><?= t('Payment Due'); ?></th>
                <th><?= t('Payment Status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('project/list_completed_table'); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>
