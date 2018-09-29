<?php
    if (isset($this->outputData['feeds']) && count($this->outputData['feeds']) > 0) {

        foreach ($this->outputData['feeds'] as $feed) {
?>
            <tr data-id="<?php echo $feed['id']; ?>">
                <td>
                    <?php
                    $text = '';
                    $short_text = '';
                    foreach ($feed['categories'] as $category) {
                        $text = $text.$category['group_name'].': '.$category['category_name'].'<br>';
                        if ($short_text == '') $short_text = $text;
                    }
                    if ($text != '') {
                        ?>
                        <div class="show">
                            <span><?php echo $short_text; ?></span>
                            <span>
                            <span hidden="hidden"><?php echo $text; ?></span>
                            <a href="#" style="float: right" class="showmoretxt"><?= t('Show More'); ?></a>
                        </span>
                        </div>
                    <?php } ?>
                </td>
                <td><?php echo $feed['limit_feed']; ?></td>
                <td><?php if ($feed['budget_min'] > 0 or $feed['budget_max'] > 0) echo currency().number_format($feed['budget_min']).'-$'.number_format($feed['budget_max']); ?></td>
                <td><?= t(($feed['type'] == 1)?'Titles':'Titles + Description'); ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('rss/show_custom?id='.$feed['id']); ?>"><img class="image-inline" src="<?php echo image_url('rss_icon.jpg'); ?>"/></a>
                </td>
                <td>
                    <a href="<?php echo site_url('rss/edit_custom'); ?>"
                       role="button"
                       class="table-button tooltip-attach edit-feed"
                       data-feed-id="<?php echo $feed['id']; ?>"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Edit Feed'); ?>">
                        <?php echo svg('table-buttons/edit', TRUE); ?>
                    </a>
                    <a href="<?php echo site_url('rss/delete?id='.$feed['id']); ?>"
                       role="button"
                       class="table-button tooltip-attach delete-feed"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Delete Feed'); ?>">
                        <?php echo svg('table-buttons/delete', TRUE); ?>
                    </a>
                </td>
            </tr>
<?php
        }
    }
    else {
?>
        <tr>
            <td valign="top" colspan="6">
                <div class="no-data-found">
                    <h3 align="left"><?= t('Search');?></h3>
                    <p align="left"><?= t('No data found');?></p>
                </div>
            </td>
        </tr>
<?php
    }
?>