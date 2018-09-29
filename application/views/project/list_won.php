<div class="table-responsive" data-tab="2">
    <table class="table" width="100%" cellspacing="0">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Status'); ?></th>
                <th><?= t('Project Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span></th>
                <th><?= t('Project Due Date'); ?> <span role="button" class="table-sort fa fa-sort" data-field="due_date" data-sort=""></span></th>
                <th><?= t('Budget'); ?></th>
                <th><?= t('Quote'); ?></th>
                <th><?= t('Active Milestone'); ?></th>
                <th><?= t('Milestone Amount'); ?></th>
                <th><?= t('Payment'); ?></th>
                <th><?= t('Payment Due'); ?></th>
                <th><?= t('Payment Status'); ?></th>
                <th><?= t('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->load->view('project/list_won_table', $this->outputData); ?>
        </tbody>
    </table>
    <?php $this->load->view('pagination', $this->outputData); ?>
</div>