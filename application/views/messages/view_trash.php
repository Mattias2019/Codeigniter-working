<div class="table-responsive" data-tab="3">
	<table class="table" width="100%" cellspacing="0">
		<thead data-field="" data-sort="">
            <tr>
                <th></th>
                <th>
                    <span class="icon-svg-img"><?php echo svg('messages/from', TRUE); ?></span>&nbsp;
                    <?= t('From'); ?>&nbsp;
                    <span role="button" class="table-sort fa fa-sort" data-field="from_name" data-sort=""></span>
                </th>
                <th>
                    <span class="icon-svg-img"><?php echo svg('messages/from', TRUE); ?></span>&nbsp;
                    <?= t('To'); ?>&nbsp;
                    <span role="button" class="table-sort fa fa-sort" data-field="to_name" data-sort=""></span>
                </th>
                <th>
                    <span class="icon-svg-img"><?php echo svg('messages/project', TRUE); ?></span>&nbsp;
                    <?= t('Job Title'); ?>&nbsp;
                    <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span>
                </th>
                <th>
                    <span class="icon-svg-img"><?php echo svg('messages/subject', TRUE); ?></span>&nbsp;
                    <?= t('Subject'); ?>&nbsp;
                    <span role="button" class="table-sort fa fa-sort" data-field="subject" data-sort=""></span>
                </th>
                <th>
                    <span class="icon-svg-img"><?php echo svg('messages/data', TRUE); ?></span>&nbsp;
                    <?= t('Date/Time'); ?>&nbsp;
                    <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span>
                </th>
                <th></th>
            </tr>
		</thead>
		<tbody>
            <?php $this->load->view('messages/view_trash_table'); ?>
		</tbody>
	</table>
	<?php $this->load->view('pagination', $this->outputData); ?>
</div>