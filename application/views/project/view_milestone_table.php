<?php foreach ($this->outputData['milestones'] as $i => $milestone) { ?>
	<?php
    // Status
	if ($milestone['status'] == 1)
	{
		$milestone_status_text = t('Closed');
		$milestone_status_class = 'milestone-status-closed';
		$color = '#1e88e5';
	}
	elseif ($milestone['status'] == 2)
	{
		$milestone_status_text = t('Canceled');
		$milestone_status_class = 'milestone-status-canceled';
		$color = "#1e88e5";
	}
	elseif ($milestone['due_date'] > 0 && $milestone['due_date'] < get_est_time())
	{
		$milestone_status_text = t('Overdue');
		$milestone_status_class = 'milestone-status-overdue';
		$color = "#ff0000";
	}
	else
	{
		$milestone_status_text = t('Open');
		$milestone_status_class = 'milestone-status-open';
		if ($milestone['completion'] > 0)
		{
			$color = '#1e88e5';
		}
		else
		{
			$color = '#e0e0e0';
		}
	}
	// Closing enabled
	$close_enabled = ($this->outputData['project']['creator_id'] == $this->logged_in_user->id and
		$this->outputData['project']['job_status'] == 4 and
		$milestone['status'] == 0);
	// Change percent enabled
    $percent_enabled = (($this->outputData['project']['creator_id'] == $this->logged_in_user->id or $this->outputData['project']['employee_id'] == $this->logged_in_user->id) and
		$this->outputData['project']['job_status'] == 4 and
		$milestone['status'] == 0);
	?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><strong><?php echo $milestone['name']; ?></strong></td>
		<td><?php echo $milestone['description']; ?></td>
		<td><?php echo currency().number_format($milestone['amount']); ?></td>
		<td><?php echo date('Y/m/d', $milestone['start_date']); ?></td>
		<td><?php echo $milestone['due_date'] > 0 ? date('Y/m/d', $milestone['due_date']) : ''; ?></td>
		<td>
			<span class="cls_round">
                <div class="progress-bar position" data-percent="<?php echo $milestone['completion']; ?>" data-color="#e0e0e0, <?php echo $color; ?>" data-text-color="<?php echo $color; ?>"></div>
            </span>
            <span class="milestone-completion hidden">
                <input class="table-input" name="completion" min="0" max="100" title="<?= t('Completion'); ?>" value="<?php echo $milestone['completion']; ?>"/>
                <span>%</span>
            </span>
		</td>
		<td>
			<span class="milestone-status <?php echo $milestone_status_class; ?>"><?php echo $milestone_status_text; ?></span>
		</td>
		<td><?php echo $this->outputData['client']; ?></td>
        <?php if ($this->outputData['view_mode'] == 'false') { ?>
        <td>
            <a href="#"
               role="button"
               class="table-button button-completion tooltip-attach<?php if (!$percent_enabled) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Change Milestone Completion'); ?>">
				<?php echo svg('table-buttons/edit', TRUE); ?>
            </a>
            <a href="<?php echo site_url('project/close_milestone?id='.$milestone['id']); ?>"
               role="button"
               class="table-button button-close tooltip-attach<?php if (!$close_enabled) echo ' disabled'; ?>"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Close Milestone'); ?>">
                <?php echo svg('table-buttons/accept', TRUE); ?>
            </a>
            <a href="<?php echo site_url('project/save_milestone_completion?id='.$milestone['id']); ?>"
               role="button"
               class="table-button button-ok tooltip-attach hidden"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Save Completion'); ?>">
				<?php echo svg('table-buttons/accept', TRUE); ?>
            </a>
            <a href="#"
               role="button"
               class="table-button button-cancel tooltip-attach hidden"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Cancel'); ?>">
				<?php echo svg('table-buttons/reject', TRUE); ?>
            </a>
        </td>
        <?php } ?>
	</tr>
    <?php if (isset($milestone['attachments']) and is_array($milestone['attachments']) and count($milestone['attachments']) > 0) { ?>
        <tr>
            <td colspan="10">
                <?php
                foreach ($milestone['attachments'] as $this->outputData['attachment'])
                {
                    $this->load->view('project/view_attachment', $this->outputData);
                }
                ?>
            </td>
        </tr>
    <?php } ?>
<?php } ?>