<?php
    if (isset($this->outputData['projects']) && count($this->outputData['projects']) > 0) {

        foreach ($this->outputData['projects'] as $project) {
            ?>
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
                    <h5>
                        <strong><a href="<?php echo site_url('project/view?id=' . $project['id']); ?>"><?php echo $project['job_name']; ?></a></strong>
                    </h5>
                    <h6><?= t('End Date'); ?>: <?php echo date('Y-m-d', $project['enddate']); ?></h6>
                </td>
                <td><?php echo currency() . number_format($project['budget_min']); ?></td>
                <td>
                    <span class="cls_actstn"><span
                                style="color:#1e88e5"><?php echo $project['active_milestone']; ?></span>/<?php echo $project['milestone_count']; ?> <?= t('Milestone'); ?></span>
                </td>
                <td><?php echo currency() . number_format($project['milestone_amount']); ?></td>
                <td><?php echo currency() . number_format($project['payment']['amount']); ?></td>
                <td><?php echo currency() . number_format($project['payment']['due']); ?></td>
                <td>
                    <span class="payment-status <?php echo $project['payment']['class']; ?>"><?php echo $project['payment']['status']; ?></span>
                </td>
            </tr>
<?php
        }
    }
    else {
?>
            <tr>
                <td valign="top" colspan="8">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No Projects found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>

