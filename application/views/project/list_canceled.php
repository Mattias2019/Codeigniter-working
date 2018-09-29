<div class="table-responsive" data-tab="5">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="job_status" data-sort=""></span></th>
                <th><?= t('Project Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Quote'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="budget_min" data-sort=""></span></th>
                <th><?= t('Active Milestone'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('project/list_canceled_table'); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>