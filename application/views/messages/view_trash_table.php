<?php
    if (isset($this->outputData['messages']) && count($this->outputData['messages']) > 0) {

        foreach ($this->outputData['messages'] as $message) { ?>

            <tr <?php if ($message['notification_status'] == 0 and $message['to_id'] == $this->logged_in_user->id) echo 'class="unread"'; ?>
                    data-id="<?php echo $message['id']; ?>">
                <td><input type="checkbox" class="message-checkbox"/></td>
                <td>
                    <a href="<?php echo site_url('account/index?id=' . $message['from_id']); ?>"><?php echo $message['from_name']; ?></a>
                </td>
                <td>
                    <a href="<?php echo site_url('account/index?id=' . $message['to_id']); ?>"><?php echo $message['to_name']; ?></a>
                </td>
                <td>
                    <a href="<?php echo site_url('project/view?id=' . $message['job_id']); ?>"><?php echo $message['job_name']; ?></a>
                </td>
                <td><?php echo $message['subject']; ?></td>
                <td><?php echo $message['created']; ?></td>
                <td>
                    <a href="#"
                       role="button"
                       class="table-button button-details tooltip-attach"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="<?= t('Show message'); ?>">
                        <?php echo svg('table-buttons/details', TRUE); ?>
                    </a>
                </td>
            </tr>
            <tr hidden="hidden">
                <td colspan="7"><?php echo $message['message']; ?></td>
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