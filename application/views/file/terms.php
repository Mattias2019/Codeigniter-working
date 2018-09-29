
<?php $this->outputData['tab'] = 3; ?>

<div class="file-upload">
    <?php $this->load->view('file/upload', $this->outputData); ?>
</div>

<div class="table-responsive" data-tab="<?php echo $this->outputData['tab']; ?>">
	<table class="table" width="100%" cellspacing="0">
		<thead data-field="" data-sort="">
            <tr>
                <th><?= t('File Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="name" data-sort=""></span></th>
                <th><?= t('Size'); ?></th>
                <th><?= t('Expire Date'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="expire_date" data-sort=""></span></th>
                <th><?= t('Description'); ?></th>
                <th width="15%"><?= t('Action'); ?></th>
            </tr>
		</thead>
		<tbody>
            <?php $this->load->view('file/terms_table'); ?>
		</tbody>
	</table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>