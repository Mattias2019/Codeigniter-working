<?php
$disabled = isset($this->outputData['quote']['costs_total']) && $this->outputData['quote']['costs_total'] > 0 ? "readonly" : "";
?>
<tr data-num="0" class="js-row-block">
    <td></td>
    <td class="milestone-name"><strong><?= $quote['name']; ?></strong></td>
    <td class="milestone-description"><?= $quote['description']; ?></td>
    <td><?= $quote['client']; ?></td>
    <td class="milestone-due_date col-due-date"><?= $quote['due_date'] > 0 ? $quote['due_date'] : ''; ?></td>
    <td class="js-milestone-amount-all milestone-amount"><?= currency() . number_format($quote['amount']); ?></td>
    <td><span class="project-status <?= $quote['job_status']['class']; ?>"><?= $quote['job_status']['name']; ?></span>
    </td>
    <td><a href="#" role="button" class="table-button" data-toggle="tooltip" data-placement="top"
           title="Details"><?= svg('table-buttons/details', TRUE); ?></a></td>
</tr>
<tr data-num="0" hidden="hidden" class="js-data-block">
    <td colspan="8">

        <div class="container-fluid quote-milestone-container">

            <div class="row">
                <h3><?= t('Project'); ?></h3>
            </div>

            <input type="hidden" name="id" value="<?= $quote['id']; ?>"/>

            <form role="form">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 js-milestone">

                        <div class="form-group">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label class="form-control-label"><?= t('Name'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-8 col-xs-12">
                                <input name="name" class="form-control milestone-name-input" value="<?= $quote['name']; ?>"/>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label class="form-control-label"><?= t('Quote'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-8 col-xs-12">
                                <input name="amount" class="form-control js-milestone-amount-input milestone-amount-input"
                                       value="<?= $quote['amount']; ?>" <?= $disabled ?>/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label class="form-control-label"><?= t('Due Date'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-8 col-xs-12 js-due-date">
                                <input type="hidden" name="due_date" class="milestone_due_date"
                                       value="<?= $quote['due_date'] > 0 ? $quote['due_date'] : ''; ?>"/>
                                <input class="form-control js-picker-date"/>
                            </div>

                            <div class="col-md-1 col-xs-1">
                                <input type="checkbox" name="notify_lower"
                                       id="notify_lower" <?php if (array_key_exists('notify_lower', $quote) and $quote['notify_lower'] == 1) echo 'checked="checked"'; ?>/>
                            </div>
                            <div class="col-md-5 col-xs-10">
                                <label for="notify_lower" class="form-control-label"><?= t('Notify...'); ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php if (empty($this->config->item('disable_escrow'))) { ?>
                                <div class="col-xs-offset-6 col-xs-1">
                                    <input type="checkbox" name="escrow_required" id="escrow_required"
                                           class="js-milestone-escrow milestone-escrow" <?php if (array_key_exists('escrow_required', $quote) and $quote['escrow_required'] == 1) echo 'checked="checked"'; ?>/>
                                </div>
                                <div class="col-xs-5">
                                    <label for="escrow_required" class="form-control-label"><?= t('Escrow Required'); ?></label>
                                </div>
                                <div class="col-sm-offset-6 col-sm-2 col-xs-12">
                                    <span><?= t('Escrow Fee'); ?></span>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <span class="js-milestone-escrow-fee milestone-fee">$<?= number_format(array_key_exists('escrow_fee', $quote) ? $quote['escrow_fee'] : 0); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-offset-6 col-xs-1">
                                <input type="checkbox" name="platform_required" id="platform_required"
                                       class="js-milestone-platform milestone-platform" <?php if (array_key_exists('platform_required', $quote) and $quote['platform_required'] == 1) echo 'checked="checked"'; ?>/>
                            </div>
                            <div class="col-xs-5">
                                <label for="platform_required" class="form-control-label"><?= t('Platform Required'); ?></label>
                            </div>
                            <div class="col-sm-offset-6 col-sm-2 col-xs-12">
                                <span><?= t('Platform Fee'); ?></span>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <span class="js-milestone-platform-fee milestone-fee">$<?= number_format(array_key_exists('platform_fee', $quote) ? $quote['platform_fee'] : 0); ?></span>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="dropzone" style="margin-top: 0"></div>
                        <div class="attachments">
                            <?php
                            $this->outputData['milestone_number'] = NULL;
                            if (is_array($quote) and array_key_exists('attachments', $quote)) {
                                if (array_key_exists('id', $quote['attachments'])) {
                                    $quote['attachments'] = invert_array($quote['attachments']);
                                }
                                foreach ($quote['attachments'] as $this->outputData['attachment']) {
                                    $this->load->view('project/create_attachment', $this->outputData);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <label class="form-control-label"><?= t('Description'); ?></label>
                            </div>
                            <div class="col-md-10 col-sm-8 col-xs-12">
                            <textarea name="description" rows="5"
                                      class="form-control milestone-description-input"><?= $quote['description']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </td>
</tr>