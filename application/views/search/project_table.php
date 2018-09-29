<?php
    if (isset($this->outputData['jobs']) && count($this->outputData['jobs']) > 0) {

        foreach ($this->outputData['jobs'] as $job) { ?>
            <tr class="table-row" data-id="<?= $job['id'] ?>">
                <td>
                    <span class="project-status <?php echo $job['status_class']; ?>"><?php echo $job['status_name']; ?></span>
                    <?php
                    if ($job['is_feature'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Feature">
                            <?php echo svg('other/ico_feature', TRUE); ?>
                        </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($job['is_urgent'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Urgent">
                            <?php echo svg('other/ico_urgent', TRUE); ?>
                        </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($job['is_hide_bids'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Hide Bids">
                            <?php echo svg('other/ico_hide', TRUE); ?>
                        </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($job['is_private'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Private">
                            <?php echo svg('other/ico_private', TRUE); ?>
                        </span>
                        <?php
                    }
                    ?>
                </td>
                <td><?php echo $job['country_name']; ?></td>
                <td><?php echo $job['city']; ?></td>
                <td><?php echo $job['creator_name']; ?></td>
                <td class="svg-td">
                    <a href="<?php echo site_url('project/project_info/' . $job['id']); ?>"
                       role="button"
                       class="table-button-with-label tooltip-attach btn-job-info"
                       data-toggle="tooltip"
                       data-placement="top"
                       data-job-id="<?php echo $job['id']; ?>"
                       data-tooltip="<?= t('View Project details to place your quote'); ?>">
                    <span>
                        <?php echo svg('table-buttons/project-info', TRUE); ?>
                    </span>
                        <span class="svg-label">
                        <strong><?php echo $job['job_name']; ?></strong>
                    </span>
                    </a>
                </td>
                <td>
                    <?php
                    $text = '';
                    $short_text = '';
                    foreach ($job['categories'] as $category) {
                        $text = $text . $category['group_name'] . ': ' . $category['category_name'] . '<br>';
                        if ($short_text == '') $short_text = $text;
                    }
                    if ($text != '') {
                        ?>
                        <div class="show">
                            <span><?php echo $short_text; ?></span>
                            <?php if ($short_text != $text) { ?>
                                <span class="morectnt">
                            <span><?php echo $text; ?></span>
                            <a href="" class="showmoretxt"><?= t('Show More'); ?></a>
                        </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </td>
                <td><?php echo currency() . number_format($job['budget_min']) . '-$' . number_format($job['budget_max']); ?></td>
                <td><?php echo count($job['quotes']); ?></td>
                <td class="col-due-date">
                    <?php
                    if ($job['enddate'] > 0) {
                        echo gmdate("Y/m/d", $job['enddate']);
                    }
                    ?>
                </td>
                <td class="js-actions">
                        <span class="dropdown">
                            <a href="<?php echo site_url('project/quote?id=' . $job['id'] . (array_key_exists('machinery_id', $job) ? '&machinery=' . $job['machinery_id'] : '')); ?>"
                               class="dropdown-toggle table-button <?php if ($job['job_status'] != 8 and (!is_array($job['last_quote']) or count($job['last_quote']) == 0)) echo ' disabled'; ?>"
                               data-toggle="dropdown"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false"
                               title="<?= t('View Project details to place your quote'); ?>" >
                                <?php echo svg('table-buttons/details', TRUE); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a title="<?= t('View Project details to place your quote'); ?>" href="<?php echo site_url('project/quote?id=' . $job['id'] . (array_key_exists('machinery_id', $job) ? '&machinery=' . $job['machinery_id'] : '')); ?>" >Detail</a>
                                </li>
                                <li><a href="<?php echo site_url('project/export_pdf?id=' . $job['id']);  ?>">Download PDF</a></li>
                                <li><a href="<?php echo site_url('project/download_attachments?id=' . $job['id']);  ?>">Download Attachments</a></li>
                            </ul>
                        </span>
                    </a>
                </td>
            </tr>

<?php
        }
    }
    else {
?>
    <tr>
        <td valign="top" colspan="10">
            <div class="no-data-found">
                <h3 align="left"><?= t('Search');?></h3>
                <p align="left"><?= t('No Projects found');?></p>
            </div>
        </td>
    </tr>
<?php
    }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="dropdown"]').bootstrapDropdownHover({
        });
    });
</script>