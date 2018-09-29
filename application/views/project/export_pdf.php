<?php

/**
 *      ____  ____  _________  _________  ____
 *     / __ \/ __ \/ ___/ __ \/ ___/ __ \/ __ \
 *    / /_/ / /_/ / /  / /_/ / /__/ /_/ / / / /
 *    \____/ .___/_/   \____/\___/\____/_/ /_/
 *        /_/
 *
 *          Copyright (C) 2016 Oprocon
 *
 *          You aren't allowed to share any parts of this script!
 *          All rights reserved.
 *
 *          Changelog:
 *              15.04.2016 - Prepare the CI3 integration, initial release of the header
 *
 *          (Please update this any time you edit this script, newest first)
 *
 * @package	    Consultant Marketplace
 * @author	    Oprocon Dev Team
 * @copyright	Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link	    https://consultant-marketplace.com
 * @version     1.0.0
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://
www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
      dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
    #quotes {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        width: 100%;

    }
    table { border-collapse: collapse; }
    table { border-spacing: 0px; border: 0px; }
    table { border-style: outset; }

    #quotes td, #quotes th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    #quotes tr:nth-child(even){background-color: #f2f2f2;}
    #quotes tr:hover {background-color: #ddd;}
    #quotes th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background: #404451 none repeat scroll 0 0;
        color: #fff;
    }
    .header_page{font-size: 18px; text-align: left; text-transform: uppercase}
    .sub_header{font-size: 16px;}

    .project-status {
        border-style: solid;
        border-width: 1px;
        display: inline-block;
        font-size: smaller;
        padding-left: 8px;
        padding-right: 8px;
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .project-status-draft{border-color:#888;color:#888}
    .project-status-new{border-color:#8bc34a;color:#8bc34a}
    .project-status-pending{border-color:#9575cd;color:#9575cd}
    .project-status-placed{border-color:#29b6f6;color:#29b6f6}
    .project-status-in-progress{border-color:#8bc34a;color:#8bc34a}
    .project-status-tbc{border-color:#dd0;color:#dd0}
    .project-status-milestone-overdue{border-color:red;color:red}
    .project-status-project-overdue{border-color:#800;color:#800}
    .project-status-dispute{border-color:#ffa000;color:#ffa000}
    .project-status-completed{border-color:#8bc34a;color:#8bc34a}
    .project-status-canceled{border-color:red;color:red}
    .project-status-declined{border-color:#222;color:#222}
    .project-status-competition{border-color:#888;color:#888}
    .project-status-quote-request{border-color:#888;color:#888}
</style>
</head>
<body>
<h1 class="header_page">
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
</h1>
<h2 class="sub_header">SUMMARY</h2>
<table id="quotes" style="border-spacing: 0;">
    <tr>
        <th>#</th>
        <th>Project/Milestone</th>
        <th>Description</th>
        <th>Client</th>
        <th>Due Date</th>
        <th>Quote</th>
        <th>Status</th>
    </tr>
    <tr>
        <td></td>
        <td><?= $quote['name']; ?></td>
        <td><?= $quote['description']; ?></td>
        <td><?= $quote['client']; ?></td>
        <td><?= $quote['due_date'] > 0 ? $quote['due_date'] : ''; ?></td>
        <td><?= currency() . number_format($quote['amount']); ?></td>
        <td><span class="project-status <?= $quote['job_status']['class']; ?>"><?= $quote['job_status']['name']; ?></td>
    </tr>
    <?php
    if (array_key_exists('milestones', $this->outputData['quote']) and is_array($this->outputData['quote']['milestones'])) {
        foreach ($this->outputData['quote']['milestones'] as $this->outputData['quote_milestone_number'] => $this->outputData['quote_milestone']) {
            ?>
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
            </tr>
            <?php
        }
    }
    ?>
</table>
</body>
</html>
