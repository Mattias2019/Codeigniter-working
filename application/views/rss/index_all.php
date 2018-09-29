<div class="table-responsive">
	<table width=100% class="table" data-tab="1">
		<thead data-field="" data-sort="">
            <tr>
                <th><?= t('Feed Content'); ?></th>
                <th><?= t('Titles'); ?></th>
                <th><?= t('Titles + Description'); ?></th>
            </tr>
		</thead>
		<tbody>
		    <?php $this->load->view('rss/index_all_table', $this->outputData); ?>
		</tbody>
	</table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>