<tr class="<?php pifset($item, 'lock_class'); ?>"
    data-group-id="<?php pifset($item, 'id'); ?>"
    data-is-locked="<?php pifset($item, 'is_locked', 0) ?>">
    <td>
        <input class="table-input" name="group_name"
               value="<?php pifset($item, 'group_name'); ?>"
               disabled="disabled"/>
    </td>

    <td class="team-members">
        <?php pifset($item, 'count_members'); ?>
    </td>

    <?php foreach ($item['options'] as $key => $option) { ?>
        <td>
            <?php if ($key != "admin" || ($key == "admin" && $item['is_i_team_lead'])) { ?>
                <input
                        type="checkbox"
                        name="<?php echo $key ?>"
                    <?php echo($option > 0 ? "checked" : "") ?>
                        value="1" disabled="disabled"/>
            <?php } else { ?>
                <p class="admin-yes-label">
                    <?= t('Yes'); ?>
                </p>

            <?php } ?>
        </td>
    <?php } ?>
    <td>
        <?php $this->load->view('team/groups_actions'); ?>
    </td>

</tr>