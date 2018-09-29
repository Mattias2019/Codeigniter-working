<?php
    if (isset($this->outputData['feeds']) && count($this->outputData['feeds']) > 0) {
        foreach ($this->outputData['feeds'] as $feed) {
?>
            <tr>
                <td><?php echo $feed['group_name']; if ($feed['category_id'] != NULL) { ?>&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;<?php echo $feed['category_name']; } ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('rss/show/?cat='.urlencode($feed['category_id_concat'])); ?>"><img class="image-inline" src="<?php echo image_url('rss_icon.jpg'); ?>"/></a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo site_url('rss/show/?type=2&amp;cat='.urlencode($feed['category_id_concat'])); ?>"><img class="image-inline" src="<?php echo image_url('rss_icon.jpg'); ?>"/></a>
                </td>
            </tr>
<?php
        }
    }
    else {
?>
        <tr>
            <td valign="top" colspan="3">
                <div class="no-data-found">
                    <h3 align="left"><?= t('Search');?></h3>
                    <p align="left"><?= t('No data found');?></p>
                </div>
            </td>
        </tr>
<?php
    }
?>