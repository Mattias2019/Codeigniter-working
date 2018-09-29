<div class="table-responsive" data-tab="3">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?></th>
                <th><?= t('Project Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Project Due Date'); ?></th>
                <th><?= t('Tender Due Date'); ?></th>
                <th><?= t('Budget'); ?></th>
                <th><?= t('Quote'); ?></th>
                <th><?= t('Active Milestone'); ?></th>
                <th><?= t('Quote Status'); ?> <span role="button" class="table-sort fa fa-sort" data-field="quote_status" data-sort=""></span></th>
                <th><?= t('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('project/list_pending_table'); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>
