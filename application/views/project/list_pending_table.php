<?php
    if (isset($this->outputData['projects']) && count($this->outputData['projects']) > 0) {

        foreach ($this->outputData['projects'] as $project) { ?>
            <tr>
                <td>
                    <span class="project-status <?php echo $project['job_status']['class']; ?>"><?php echo $project['job_status']['name']; ?></span>
                    <?php
                    if ($project['is_feature'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Feature">
                                <?php echo svg('other/ico_feature', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_urgent'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Urgent">
                                <?php echo svg('other/ico_urgent', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_hide_bids'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Hide Bids">
                                <?php echo svg('other/ico_hide', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_private'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Private">
                                <?php echo svg('other/ico_private', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <h5><strong><?php echo $project['job_name']; ?></strong></h5>
                    <h6><?php echo t('End Date'); ?>
                        : <?= $project['enddate'] > 0 ? date('Y-m-d', $project['enddate']) : ''; ?></h6>
                </td>
                <td><?php echo $project['due_date'] > 0 ? date('Y-m-d', $project['due_date']) : ''; ?></td>
                <td><?php echo $project['enddate'] > 0 ? date('Y-m-d', $project['enddate']) : ''; ?></td>
                <td><?php echo currency() . number_format($project['budget_min']) . '-$' . number_format($project['budget_max']); ?></td>
                <td><?php echo currency() . number_format($project['amount']); ?></td>
                <td>
                    <span class="cls_actstn"><span
                                style="color:#1e88e5">1</span>/<?php echo $project['milestone_count']; ?> <?= t('Milestone'); ?></span>
                </td>
                <td>
                    <span class="quote-status <?php echo $project['quote_status']['class']; ?>"><?php echo $project['quote_status']['name']; ?></span>
                </td>
                <td>
                    <a href="<?php echo site_url('project/quote?id=' . $project['job_id']); ?>"
                       role="button"
                       class="table-button tooltip-attach <?php if ($project['quote_creator_id'] == $this->logged_in_user->id and $project['quote_status']['id'] == 2) echo 'disabled'; ?>"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Revise quote'); ?>">
                        <?php echo svg('table-buttons/edit', TRUE); ?>
                    </a>
                </td>
            </tr>
<?php
        }
    }
    else {
?>
            <tr>
                <td valign="top" colspan="9">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No Projects found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>