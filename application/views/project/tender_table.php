<?php
    if (isset($this->outputData['projects']) && count($this->outputData['projects']) > 0) {

        foreach ($this->outputData['projects'] as $project) {
?>
            <tr class="table-row" data-id="<?=$project['id']?>">
                <td>
                    <span class="project-status <?php echo $project['status']['class']; ?>"><?php echo $project['status']['name']; ?></span>
                    <?php
                    if ($project['is_feature'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Feature">
                                <?php echo svg('other/ico_feature', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_urgent'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Urgent">
                                <?php echo svg('other/ico_urgent', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_hide_bids'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Hide Bids">
                                <?php echo svg('other/ico_hide', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                    <?php
                    if ($project['is_private'] == 1) {
                        ?>
                        <span class="icon-svg-img" title="Private">
                                <?php echo svg('other/ico_private', TRUE); ?>
                            </span>
                        <?php
                    }
                    ?>
                </td>
                <td><strong><?php echo $project['job_name']; ?></strong></td>
                <td><?php echo currency().number_format($project['budget_min']).'-'.currency().number_format($project['budget_max']); ?></td>
                <td class="col-due-date"><?php echo $project['enddate'] > 0 ? $project['enddate'] : ''; ?></td>
                <td class="col-deadline"><?php echo $project['due_date'] > 0 ? $project['due_date'] : ''; ?></td>
                <td><?php echo number_format($project['quotes_count']); ?></td>
                <td><?php echo currency().number_format($project['quotes_min']); ?></td>
                <td><?php echo currency().number_format($project['quotes_avg']); ?></td>
                <td><?php echo currency().number_format($project['quotes_max']); ?></td>
                <td class="js-actions">
                    <?php if ($project['quotes_count'] > 0) { ?>
                        <a href="#"
                           role="button"
                           class="table-button tooltip-attach button-quotes"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?= t('Show quotes'); ?>">
                            <?php echo svg('table-buttons/details', TRUE); ?>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo site_url('project/create?id='.$project['id']); ?>"
                           role="button"
                           class="table-button tooltip-attach"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="<?= t('Edit tender'); ?>">
                            <?php echo svg('table-buttons/edit', TRUE); ?>
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php if ($project['quotes_count'] > 0) { ?>
                <!-- Quotes -->
                <tr hidden="hidden">
                    <td colspan="10">
                        <div class="table-responsive quote-container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?= t('Status'); ?></th>
                                    <th><?= t('Machine Supplier'); ?></th>
                                    <th><?= t('Country'); ?></th>
                                    <th><?= t('City'); ?></th>
                                    <th><?= t('Quote'); ?></th>
                                    <th><?= t('Offer Date'); ?></th>
                                    <th><?= t('Assign'); ?></th>
                                    <th><?= t('Machine Detail'); ?></th>
                                    <th><?= t('Compare'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($project['quotes'] as $quote) { ?>
                                    <tr>
                                        <td>
                                            <span class="quote-status <?php echo $quote['status']['class']; ?>"><?php echo $quote['status']['name']; ?></span>
                                        </td>
                                        <td><?php echo $quote['supplier']; ?></td>
                                        <td><?php echo $quote['country']; ?></td>
                                        <td><?php echo $quote['city']; ?></td>
                                        <td><?php echo currency().number_format($quote['amount']); ?></td>
                                        <td><?php echo date('Y/m/d', $quote['created']); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('project/assign_quote?id='.$project['id'].'&provider='.$quote['provider_id']); ?>"
                                               role="button"
                                               class="table-button tooltip-attach <?php if ($quote['creator_id'] == $this->logged_in_user->id or $quote['status']['id'] >= 3) echo 'disabled'; ?>"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="<?= t('Assign quote'); ?>">
                                                <?php echo svg('table-buttons/accept', TRUE); ?>
                                            </a>
                                            <a href="<?php echo site_url('project/quote?id='.$project['id'].'&provider='.$quote['provider_id']); ?>"
                                               role="button"
                                               class="table-button tooltip-attach <?php if ($quote['creator_id'] == $this->logged_in_user->id and $quote['status']['id'] == 2 or $quote['status']['id'] >= 3) echo 'disabled'; ?>"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="<?= t('Revise quote'); ?>">
                                                <?php echo svg('table-buttons/edit', TRUE); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('portfolio/view?id='.$project['portfolio_id']); ?>"
                                               role="button"
                                               class="table-button tooltip-attach button-portfolio<?php if ($project['portfolio_id'] == '') echo ' disabled'; ?>"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="<?= t('Machine Detail'); ?>">
                                                <?php echo svg('table-buttons/details', TRUE); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <input class="check-compare" type="checkbox" value="<?php echo $project['portfolio_id']; ?>" <?php if ($project['portfolio_id'] == '') echo 'disabled="disabled"'; ?>/>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
<?php
            }
        }
    }
    else {
?>
        <tr>
            <td valign="top" colspan="10">
                <div class="no-data-found">
                    <h3 align="left"><?= t('Search');?></h3>
                    <p align="left"><?= t('No Projects found');?></p>
                </div>
            </td>
        </tr>
<?php
    }
?>
