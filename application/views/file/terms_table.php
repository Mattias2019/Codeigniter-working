<?php
    if (isset($this->outputData['files']) && count($this->outputData['files']) > 0) {

        foreach ($this->outputData['files'] as $file) { ?>

            <tr>
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
                <td><?php if ($file['expire_date'] != '') echo date('Y/m/d', $file['expire_date']); ?></td>
                <td><?php echo $file['description']; ?></td>
                <td>
                    <a href="<?php echo site_url('file/index/3?id=' . $file['id']); ?>" class="file-action">
                        <span class="file-action-img"><?php echo svg('other/edit', TRUE) ?></span>
                        <span><?= t('Edit'); ?></span>
                    </a>
                    <a href="<?php echo site_url('file/index/3?id=' . $file['id'] . '&action=copy'); ?>"
                       class="file-action">
                        <span class="file-action-img"><?php echo svg('other/move', TRUE) ?></span>
                        <span><?= t('Copy'); ?></span>
                    </a>
                    <a href="<?php echo site_url('file/delete/3?id=' . $file['id']); ?>"
                       class="file-action file-delete">
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
                <td valign="top" colspan="5">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No data found');?></p>
                    </div>
                </td>
            </tr>
<?php
        }
?>