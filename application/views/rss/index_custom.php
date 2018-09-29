<div class="index-custom-form">
    <?php $this->load->view('rss/index_custom_form', $this->outputData); ?>
</div>

<div class="table-responsive">
    <table width=100% class="table" data-tab="2">
        <thead data-field="" data-sort="">
            <tr>
                <th><?= t('Feed Content'); ?></th>
                <th><?= t('# of Projects'); ?></th>
                <th><?= t('Budget'); ?></th>
                <th><?= t('Info to display'); ?></th>
                <th><?= t('Feed'); ?></th>
                <th><?= t('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
    		<?php $this->load->view('rss/index_custom_table', $this->outputData); ?>
        </tbody>
    </table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>