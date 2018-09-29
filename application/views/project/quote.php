<?php
    $quote = $this->outputData['quote'];
?>

<?php $this->load->view('header1'); ?>

<?php flash_message(); ?>

<div class="cls_page-title">
    <h2>
        <span><?= t('Quote on Project'); ?>: </span>
        <span class="header-em"><?php echo $quote['name']; ?></span>
        <span> (<?= t('Loop'); ?> </span>
        <span class="header-em"><?php echo $quote['loop']; ?></span>
        <span>)</span>
        <?php if ($quote['status'] == '0') { ?>
            <span class="caption-subject header-warning bold uppercase"> <?= t('Draft'); ?></span>
        <?php } elseif ($quote['status'] == '1') { ?>
            <span class="caption-subject header-em bold uppercase"> <?= t('New'); ?></span>
        <?php } ?>
    </h2>
</div>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <ul id="tabs" class="nav nav-tabs">
            <li id="tab-summary" class="active">
                <a href="#"><?= t('Summary'); ?></a>
            </li>
            <li id="tab-labor">
                <a href="#"><?= t('Labor Cost'); ?></a>
            </li>
            <li id="tab-material">
                <a href="#"><?= t('Material Cost'); ?></a>
            </li>
            <li id="tab-third-party">
                <a href="#"><?= t('Third Party Cost'); ?></a>
            </li>
            <li id="tab-travel">
                <a href="#"><?= t('Travel Cost'); ?></a>
            </li>
        </ul>

        <div class="content">
            <form method="post" id="quote-form"
                  action="<?php echo site_url('project/quote?id=' . $this->outputData['project_id'] . "&provider=" . $this->outputData['provider_id']); ?>"
                  enctype="multipart/form-data" class="form-horizontal">

                <input type="hidden" name="id" value="<?php echo $this->outputData['quote']['id'] ?>"/>
                <input type="hidden" name="job_id" value="<?php echo $this->outputData['quote']['job_id'] ?>"/>
                <input type="hidden" name="status" value="<?php echo $this->outputData['quote']['status'] ?>"/>
                <input type="hidden" name="loop" value="<?php echo $this->outputData['quote']['loop'] ?>"/>
                <input type="hidden" name="provider_id"
                       value="<?php echo $this->outputData['quote']['provider_id'] ?>"/>
                <input type="hidden" name="machinery_id"
                       value="<?php echo $this->outputData['quote']['machinery_id'] ?>"/>

                <input type="hidden" name="client" value="<?php echo $this->outputData['quote']['client'] ?>"/>
                <input type="hidden" name="job_status[class]"
                       value="<?php echo $this->outputData['quote']['job_status']['class'] ?>"/>
                <input type="hidden" name="job_status[name]"
                       value="<?php echo $this->outputData['quote']['job_status']['name'] ?>"/>

                <div id="tab-summary-data" class="tab-data table-responsive">
                    <table id="table-summary" class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="18%"/>
                            <col width="30%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Project/Milestone'); ?></th>
                            <th><?= t('Description'); ?></th>
                            <th><?= t('Client'); ?></th>
                            <th><?= t('Due Date'); ?></th>
                            <th><?= t('Quote'); ?></th>
                            <th><?= t('Status'); ?></th>
                            <th><?= t('Details'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $this->load->view('project/quote_cost_summary', $this->outputData);
                        if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
                            foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
                                $this->load->view('project/quote_milestone_cost_summary', $this->outputData);
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                    <div class="container-fluid">
                        <a href="#" id="create-milestone"><span
                                    class="fa fa-plus"></span><span><?= t('Add Milestone'); ?></span></a>
                    </div>
                </div>

                <div id="tab-labor-data" class="tab-data table-responsive" hidden="hidden">
                    <table id="table-labor" class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="13%"/>
                            <col width="25%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Project/Milestone'); ?></th>
                            <th><?= t('Cost Description'); ?></th>
                            <th><?= t('Amount'); ?></th>
                            <th><?= t('Cost Per Unit'); ?></th>
                            <th><?= t('Unit'); ?></th>
                            <th><?= t('VAT in %'); ?></th>
                            <th><?= t('VAT $'); ?></th>
                            <th><?= t('Total'); ?></th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $this->outputData['cost_type'] = 'labor';
                        $this->load->view('project/quote_cost', $this->outputData);
                        if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
                            foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
                                $this->load->view('project/quote_milestone_cost', $this->outputData);
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div id="tab-material-data" class="tab-data table-responsive" hidden="hidden">
                    <table id="table-material" class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="13%"/>
                            <col width="25%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Project/Milestone'); ?></th>
                            <th><?= t('Cost Description'); ?></th>
                            <th><?= t('Amount'); ?></th>
                            <th><?= t('Cost Per Unit'); ?></th>
                            <th><?= t('Unit'); ?></th>
                            <th><?= t('VAT in %'); ?></th>
                            <th><?= t('VAT $'); ?></th>
                            <th><?= t('Total'); ?></th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $this->outputData['cost_type'] = 'material';
                        $this->load->view('project/quote_cost', $this->outputData);
                        if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
                            foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
                                $this->load->view('project/quote_milestone_cost', $this->outputData);
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div id="tab-third-party-data" class="tab-data table-responsive" hidden="hidden">
                    <table id="table-third-party" class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="13%"/>
                            <col width="25%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Project/Milestone'); ?></th>
                            <th><?= t('Cost Description'); ?></th>
                            <th><?= t('Amount'); ?></th>
                            <th><?= t('Cost Per Unit'); ?></th>
                            <th><?= t('Unit'); ?></th>
                            <th><?= t('VAT in %'); ?></th>
                            <th><?= t('VAT $'); ?></th>
                            <th><?= t('Total'); ?></th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $this->outputData['cost_type'] = 'third_party';
                        $this->load->view('project/quote_cost', $this->outputData);
                        if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
                            foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
                                $this->load->view('project/quote_milestone_cost', $this->outputData);
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div id="tab-travel-data" class="tab-data table-responsive" hidden="hidden">
                    <table id="table-travel" class="table">
                        <colgroup>
                            <col width="2%"/>
                            <col width="13%"/>
                            <col width="25%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Project/Milestone'); ?></th>
                            <th><?= t('Cost Description'); ?></th>
                            <th><?= t('Amount'); ?></th>
                            <th><?= t('Cost Per Unit'); ?></th>
                            <th><?= t('Unit'); ?></th>
                            <th><?= t('VAT in %'); ?></th>
                            <th><?= t('VAT $'); ?></th>
                            <th><?= t('Total'); ?></th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $this->outputData['cost_type'] = 'travel';
                        $this->load->view('project/quote_cost', $this->outputData);
                        if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
                            foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
                                $this->load->view('project/quote_milestone_cost', $this->outputData);
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div class="container-fluid submit-buttons">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <button type="submit" name="submit" value="draft"
                                class="button big primary"><?= t('Save As Draft'); ?></button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <button type="submit" name="submit" value="new"
                                class="button big primary"><?= t('Save Changes'); ?></button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <button type="submit" name="submit" value="publish"
                                class="button big secondary"><?= t('Publish'); ?></button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>

