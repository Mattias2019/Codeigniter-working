<?php
$i = $this->outputData['quote_milestone_number'];
$milestone = $this->outputData['quote_milestone'];
$type = $this->outputData['cost_type'];
$new = (array_key_exists('milestone_new', $this->outputData) and $this->outputData['milestone_new'])?1:0;
?>
<tr data-num="<?php echo $i; ?>">
    <input type="hidden" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][id]" value="<?php echo $milestone['costs'][$type]['id']; ?>"/>
    <input type="hidden" class="js-cost-vat" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][vat_sum]" value="<?php echo $milestone['costs'][$type]['vat_sum']; ?>"/>
    <input type="hidden" class="js-cost-total" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][total]" value="<?php echo $milestone['costs'][$type]['total']; ?>"/>
	<td><?php echo $i; ?></td>
    <td class="milestone-name">
        <strong><?php echo $milestone['name']; ?></strong>
		<?php if ($milestone['is_added']) { ?>
            <span class="milestone-added"><?= t('Added at loop').' '.($this->outputData['quote']['loop']-1); ?></span>
		<?php } elseif ($new or $milestone['is_added_cur']) { ?>
            <span class="milestone-added"><?= t('Added'); ?></span>
		<?php } elseif ($milestone['is_deleted']) { ?>
            <span class="milestone-deleted"><?= t('Deleted at loop').' '.($this->outputData['quote']['loop']-1); ?></span>
		<?php } elseif ($milestone['is_deleted_cur']) { ?>
            <span class="milestone-deleted"><?= t('Deleted'); ?></span>
		<?php } ?>
    </td>
	<td><input class="table-input" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][description]" value="<?php echo $milestone['costs'][$type]['description']; ?>"/></td>
	<td><input class="table-input amount-input" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][amount]" value="<?php echo $milestone['costs'][$type]['amount']; ?>"/></td>
	<td><input class="table-input price-input" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][price]" value="<?php echo $milestone['costs'][$type]['price']; ?>"/></td>
	<td><input class="table-input" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][unit]" value="<?php echo $milestone['costs'][$type]['unit']; ?>"/></td>
	<td><input class="table-input vat-input" name="milestones[<?php echo $i; ?>][costs][<?php echo $type; ?>][vat]" value="<?php echo $milestone['costs'][$type]['vat']; ?>"/></td>
	<td class="cost-vat_sum"><?php echo $milestone['costs'][$type]['vat_sum']; ?></td>
	<td class="cost-total">$<?php echo $milestone['costs'][$type]['total']; ?></td>
    <td>
        <a class="js-clear-cost"><span class="badge">X</span></a>
    </td>
</tr>