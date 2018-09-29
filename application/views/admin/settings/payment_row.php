<tr>
    <td class="text-center">
        <span class="id"><?php echo $payment['id']; ?></span>
    </td>
    <td class="editable-text title" contenteditable="false"><?php echo $payment['title']; ?></td>
    <td>
        <input type="checkbox" name="is_deposit_enabled"
               value="1" <?php if ($payment['is_deposit_enabled'] == '1') echo 'checked="checked"'; ?>
               disabled="disabled"/>
    </td>
    <td class="editable-text deposit_description"
        contenteditable="false"><?php echo $payment['deposit_description']; ?></td>
    <td>
        <input name="deposit_minimum" class="table-input text-center inputmask" data-prefix="<?php echo currency(); ?>"
               value="<?php echo $payment['deposit_minimum']; ?>" disabled="disabled"/>
    </td>
    <td class="text-center">
        <input type="checkbox" name="is_withdraw_enabled"
               value="1" <?php if ($payment['is_withdraw_enabled'] == '1') echo 'checked="checked"'; ?>
               disabled="disabled"/>
    </td>
    <td class="editable-text withdraw_description"
        contenteditable="false"><?php echo $payment['withdraw_description']; ?></td>
    <td>
        <input name="withdraw_minimum" class="table-input text-center inputmask" data-prefix="<?php echo currency(); ?>"
               value="<?php echo $payment['withdraw_minimum']; ?>" disabled="disabled"/>
    </td>
    <td>
        <input name="commission" class="table-input text-center inputmask" data-prefix="<?php echo currency(); ?>"
               value="<?php echo $payment['commission']; ?>" disabled="disabled"/>
    </td>
    <td class="text-center">
        <a href="#"
           role="button"
           data-toggle="tooltip"
           class="table-button button-edit tooltip-attach"
           title="<?= t('Edit Payment Method'); ?>">
            <?php echo svg('table-buttons/edit', TRUE); ?>
        </a>
        <a href="#"
           role="button"
           data-toggle="tooltip"
           class="table-button button-credentials tooltip-attach<?php if (count($payment['credentials']) == 0) echo ' disabled'; ?>"
           title="<?= t('View Credentials'); ?>">
            <?php echo svg('table-buttons/details', TRUE); ?>
        </a>
        <a href="#"
           role="button"
           data-toggle="tooltip"
           class="table-button button-save hidden tooltip-attach"
           title="<?= t('Save Changes'); ?>">
            <?php echo svg('table-buttons/accept', TRUE); ?>
        </a>
        <a href="#"
           role="button"
           data-toggle="tooltip"
           class="table-button button-cancel hidden tooltip-attach"
           title="<?= t('Cancel'); ?>">
            <?php echo svg('table-buttons/reject', TRUE); ?>
        </a>
    </td>
</tr>
<tr class="hidden">
    <td colspan="10">
        <div class="table-responsive">
            <table class="table">
                <colgroup>
                    <col width="20%"/>
                    <col width="30%"/>
                    <col width="50%"/>
                </colgroup>
                <thead>
                <tr>
                    <th><?= t('Key'); ?></th>
                    <th><?= t('Name'); ?></th>
                    <th><?= t('Value'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($payment['credentials'] as $key => $credential) { ?>
                    <tr>
                        <td><?php echo $key; ?></td>
                        <td><?php echo $credential['name']; ?></td>
                        <td>
                            <input class="table-input" name="<?php echo $key; ?>"
                                   value="<?php echo $credential['value']; ?>" maxlength="128" disabled="disabled"/>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </td>
</tr>