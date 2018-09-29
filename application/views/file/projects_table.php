<?php
    if (isset($this->outputData['files']) && count($this->outputData['files']) > 0) {

        foreach ($this->outputData['files'] as $file) {
?>
            <tr>
                <td>
                    <span class="project-status <?php echo $file['job_status']['class']; ?>"><?php echo $file['job_status']['name']; ?></span>
                </td>
                <td><?php echo $file['job_name']; ?></td>
                <td><?php echo $file['milestone_name']; ?></td>
                <td><?php echo $file['name']; ?></td>
                <td>
                    <?php
                    if ($file['size'] < KB) {
                        echo number_format($file['size']) . ' ' . t('B');
                    } elseif ($file['size'] < MB) {
                        echo number_format($file['size'] / KB, 2) . ' ' . t('kB');
                    } elseif ($file['size'] < GB) {
                        echo number_format($file['size'] / MB, 2) . ' ' . t('MB');
                    } else {
                        echo number_format($file['size'] / GB, 2) . ' ' . t('GB');
                    }
                    ?>
                </td>
                <td class="col-exp-date"><?php if ($file['expire_date'] != '') echo $file['expire_date']; ?></td>
                <td><?php echo $file['description']; ?></td>
                <td>
                    <a href="<?php echo site_url('file/index'); ?>"
                       class="btn-edit file-action<?php if ($file['job_status']['id'] >= 3 and $file['job_status']['id'] != 8) echo ' disabled'; ?>"
                       data-id="<?php echo $file['id']; ?>"
                       data-project-id="<?php echo $file['job_id']; ?>"
                       data-milestone-id="<?php echo $file['milestone_id']; ?>"
                    >
                        <span class="file-action-img"><?php echo svg('other/edit', TRUE) ?></span>
                        <span><?= t('Edit'); ?></span>
                    </a>
                    <a href="<?php echo site_url('file/index?id=' . $file['id'] . '&project_id=' . $file['job_id'] . '&milestone_id=' . $file['milestone_id'] . '&action=copy'); ?>"
                       class="btn-copy file-action"
                       data-id="<?php echo $file['id']; ?>"
                       data-project-id="<?php echo $file['job_id']; ?>"
                       data-milestone-id="<?php echo $file['milestone_id']; ?>"
                    >
                        <span class="file-action-img"><?php echo svg('other/move', TRUE) ?></span>
                        <span><?= t('Copy'); ?></span>
                    </a>
                    <a href="<?php echo site_url('file/delete?id=' . $file['id'] . '&project_id=' . $file['job_id'] . '&milestone_id=' . $file['milestone_id']); ?>"
                       class="file-action file-delete<?php if ($file['job_status']['id'] >= 3 and $file['job_status']['id'] != 8) echo ' disabled'; ?>">
                        <span class="file-action-img"><?php echo svg('other/trash', TRUE) ?></span>
                        <span><?= t('Delete'); ?></span>
                    </a>
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
                        <p align="left"><?= t('No data found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>