<?php
$i = $this->outputData['quote_milestone_number'];
$milestone = $this->outputData['quote_milestone'];
$disabled = isset($milestone['costs_total']) && $milestone['costs_total'] > 0 ? "readonly" : "";
$new = (array_key_exists('milestone_new', $this->outputData) and $this->outputData['milestone_new']) ? 1 : 0;
?>
<tr data-num="<?php echo $i; ?>" class="js-row-block">
    <td><?php echo $i; ?></td>
    <td class="milestone-name">
        <strong><?php echo $milestone['name']; ?></strong>
        <?php if ($milestone['is_added']) { ?>
            <span class="milestone-added"><?= t('Added at loop') . ' ' . ($this->outputData['quote']['loop'] - 1); ?></span>
        <?php } elseif ($new or $milestone['is_added_cur']) { ?>
            <span class="milestone-added"><?= t('Added'); ?></span>
        <?php } elseif ($milestone['is_deleted']) { ?>
            <span class="milestone-deleted"><?= t('Deleted at loop') . ' ' . ($this->outputData['quote']['loop'] - 1); ?></span>
        <?php } elseif ($milestone['is_deleted_cur']) { ?>
            <span class="milestone-deleted"><?= t('Deleted'); ?></span>
        <?php } ?>
    </td>
    <td class="milestone-description"><?php echo $milestone['description']; ?></td>
    <td></td>
    <td class="milestone-due_date col-due-date"><?php echo $milestone['due_date'] > 0 ? $milestone['due_date'] : ''; ?></td>
    <td class="milestone-amount"><?php echo currency() . number_format($milestone['amount']); ?></td>
    <td></td>
    <td><a href="#" role="button" class="table-button" data-toggle="tooltip" data-placement="top"
           title="Details"><?php echo svg('table-buttons/details', TRUE); ?></a></td>
</tr>
<tr data-num="<?php echo $i; ?>" hidden="hidden" class="js-data-block">
    <td colspan="8">

        <hr/>

        <div class="container-fluid quote-milestone-container">

            <div class="row">
                <h3><?= t('Milestone') . ' ' . $i; ?></h3>
            </div>

            <input type="hidden" name="milestones[<?php echo $i; ?>][id]" value="<?php echo $milestone['id']; ?>"/>
            <input type="hidden" class="milestone-added-input" name="milestones[<?php echo $i; ?>][is_added]"
                   value="<?php echo $milestone['is_added']; ?>"/>
            <input type="hidden" class="milestone-deleted-input" name="milestones[<?php echo $i; ?>][is_deleted]"
                   value="<?php echo $milestone['is_deleted']; ?>"/>
            <input type="hidden" class="milestone-added-cur-input" name="milestones[<?php echo $i; ?>][is_added_cur]"
                   value="<?php echo $new or $milestone['is_added_cur']; ?>"/>
            <input type="hidden" class="milestone-deleted-cur-input"
                   name="milestones[<?php echo $i; ?>][is_deleted_cur]"
                   value="<?php echo $milestone['is_deleted_cur']; ?>"/>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="col-sm-4 col-xs-12">
                        <label class="form-control-label"><?= t('Name'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input name="milestones[<?php echo $i; ?>][name]" class="form-control milestone-name-input"
                               value="<?php echo $milestone['name']; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-xs-12">
                        <label class="form-control-label"><?= t('Description'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <textarea name="milestones[<?php echo $i; ?>][description]" rows="5"
                                  class="form-control milestone-description-input"><?php echo $milestone['description']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 js-milestone">
                <div class="form-group">
                    <div class="col-sm-4 col-xs-12">
                        <label class="form-control-label"><?= t('Due Date'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12 js-due-date">
                        <input type="hidden" name="milestones[<?php echo $i; ?>][due_date]" class="milestone_due_date"
                               value="<?php echo $milestone['due_date'] > 0 ? $milestone['due_date'] : ''; ?>"/>
                        <input class="form-control js-picker-date"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-xs-12">
                        <label class="form-control-label"><?= t('Quote'); ?></label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input name="milestones[<?php echo $i; ?>][amount]"
                               class="form-control js-milestone-amount-input milestone-amount-input"
                               value="<?php echo $milestone['amount']; ?>" <?php echo $disabled ?>/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-1">
                        <input type="checkbox" name="milestones[<?php echo $i; ?>][notify_lower]"
                               id="notify_lower<?php echo $i; ?>" <?php if (isset($milestone) and array_key_exists('notify_lower', $milestone) and $milestone['notify_lower'] == 1) echo 'checked="checked"'; ?>/>
                    </div>
                    <div class="col-xs-10">
                        <label for="notify_lower<?php echo $i; ?>"
                               class="form-control-label"><?= t('Notify...'); ?></label>
                    </div>
                </div>

				<?php if (empty($this->config->item('disable_escrow'))) { ?>
                <div class="form-group">
                    <div class="col-xs-1">
                        <input type="checkbox" name="milestones[<?php echo $i; ?>][escrow_required]"
                               id="escrow_required<?php echo $i; ?>"
                               class="js-milestone-escrow milestone-escrow" <?php if (isset($milestone) and array_key_exists('escrow_required', $milestone) and $milestone['escrow_required'] == 1) echo 'checked="checked"'; ?>/>
                    </div>
                    <div class="col-xs-10">
                        <label for="escrow_required<?php echo $i; ?>"
                               class="form-control-label"><?= t('Escrow Required'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-xs-12">
                        <span><?= t('Escrow Fee'); ?></span>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <span class="js-milestone-escrow-fee milestone-fee">$<?php echo number_format((isset($milestone) and array_key_exists('escrow_fee', $milestone)) ? $milestone['escrow_fee'] : 0); ?></span>
                    </div>
                </div>
				<?php } ?>

                <!--                platform_required-->
                <div class="form-group">
                    <div class="col-xs-1">
                        <input type="checkbox" name="milestones[<?php echo $i; ?>][platform_required]"
                               id="platform_required<?php echo $i; ?>"
                               class="js-milestone-platform milestone-platform" <?php if (isset($milestone) and array_key_exists('platform_required', $milestone) and $milestone['platform_required'] == 1) echo 'checked="checked"'; ?>/>
                    </div>
                    <div class="col-xs-10">
                        <label for="platform_required<?php echo $i; ?>"
                               class="form-control-label"><?= t('Platform Required'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 col-xs-12">
                        <span><?= t('Platform Fee'); ?></span>
                    </div>
                    <div class="col-sm-7 col-xs-12">
                        <span class="js-milestone-platform-fee milestone-fee">$<?php echo number_format((isset($milestone) and array_key_exists('platform_fee', $milestone)) ? $milestone['platform_fee'] : 0); ?></span>
                    </div>
                </div>
                <!--                platform_required-->
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="dropzone" style="margin-top: 0" data-milestone="<?php echo $i; ?>"></div>
                <div class="attachments">
                    <?php
                    $this->outputData['milestone_number'] = $i;
                    if (is_array($milestone) and array_key_exists('attachments', $milestone)) {
                        if (array_key_exists('id', $milestone['attachments'])) {
                            $milestone['attachments'] = invert_array($milestone['attachments']);
                        }
                        foreach ($milestone['attachments'] as $this->outputData['attachment']) {
                            $this->load->view('project/create_attachment', $this->outputData);
                        }
                    }
                    ?>
                </div>
                <div class="form-group">
                    <a href="#" class="pull-right remove_current_milestone"><?php echo svg('other/trash', TRUE); ?>
                        <span><?php echo $milestone['is_deleted'] ? t('Restore') : t('Delete'); ?></span></a>
                </div>
            </div>

        </div>

        <hr/>

    </td>
</tr>