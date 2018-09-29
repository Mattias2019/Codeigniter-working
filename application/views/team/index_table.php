<?php
    if (isset($this->outputData['members']) && count($this->outputData['members']) > 0) {

        foreach ($this->outputData['members'] as $member) { ?>
            <tr data-id="<?php echo $member['id']; ?>">
                <td>
                    <div class="image-circle small">
                        <img src="<?php echo $member['img_logo']; ?>"/>
                    </div>
                </td>
                <td><?php echo $member['full_name']; ?></td>
                <td><?php echo $member['group_name']; ?></td>
                <td><?php echo $member['telephone']; ?></td>
                <td><?php echo $member['email']; ?></td>
                <td><?php echo $member['job_title']; ?></td>
                <td>
                    <a href="<?php echo site_url('team/index?id=' . $member['id']); ?>"
                       role="button"
                       class="table-button tooltip-attach"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Edit Member'); ?>">
                        <?php echo svg('table-buttons/edit', TRUE); ?>
                    </a>
                    <a href="<?php echo site_url('team/delete?id=' . $member['id']); ?>"
                       role="button"
                       class="table-button tooltip-attach delete-member"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Delete Member'); ?>">
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
                <td valign="top" colspan="7">
                    <div class="no-data-found">
                        <h3 align="left"><?= t('Search');?></h3>
                        <p align="left"><?= t('No data found');?></p>
                    </div>
                </td>
            </tr>
<?php
    }
?>