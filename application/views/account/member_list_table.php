<?php
    if (isset($this->outputData['members']) && count($this->outputData['members']) > 0) {

        foreach ($this->outputData['members'] as $member) { ?>

            <tr data-id="<?php echo $member['id']; ?>">
                <td><?php echo $member['name']; ?></td>
                <td><?php echo number_format($member['user_rating'], 2); ?></td>
                <td>
                    <?php
                    $text = '';
                    $short_text = '';
                    foreach ($member['categories'] as $category) {
                        $text = $text . $category['group_name'] . ': ' . $category['category_name'] . '<br>';
                        if ($short_text == '') $short_text = $text;
                    }
                    if ($text != '') {
                        ?>
                        <div class="show">
                            <span><?php echo $short_text; ?></span>
                            <?php if ($short_text != $text) { ?>
                                <span>
                                <span hidden="hidden"><?php echo $text; ?></span>
                                <a href="#" style="float: right" class="showmoretxt"><?= t('Show More'); ?></a>
                            </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </td>
                <td><a href="<?php echo site_url('account/index?id=' . $member['id']); ?>">Link</a></td>
                <td>
                    <?php
                    if (!empty($member['portfolios_total'])) { ?>
                        <a href="<?php echo site_url('portfolio/user?id=' . $member['id']); ?>">Link</a>
                    <?php } else { ?>
                        <span><?= t('user have not portfolio'); ?> </span>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?php echo site_url((($this->outputData['mode'] == 'favorite') ? 'account/delete_favorite_member?id=' : 'account/delete_banned_member?id=') . $member['id']); ?>"
                       role="button"
                       class="table-button tooltip-attach delete-member"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Remove From List'); ?>">
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