<?php
$quote = $this->outputData['quote'];
$type = $this->outputData['cost_type'];
$disabled ="";
if (!empty($this->outputData['quote']['milestones']) && is_array($this->outputData['quote']['milestones'])) {
    // Check if user input any value to milestones inputs, we need to block input of project totals for this "cost_type"
    // so user is not able to change totals for cost type. Only milestone inputs will be available for editing.
    $total = 0;
    foreach ($this->outputData['quote']['milestones'] as $item) {
        if (!empty($item['costs']) && is_array($item['costs'][$type])) {
            $total += $item['costs'][$type]['total'];
        }
    }
    $disabled = $total > 0?"readonly":"";
}
$disabledCss = empty($disabled)?"":"disabled-row";
?>
<tr data-num="0" class="<?php echo $disabledCss ?>">
    <input type="hidden" name="costs[<?php echo $type; ?>][id]" value="<?php echo $quote['costs'][$type]['id']; ?>"/>
    <input type="hidden" class="js-cost-vat" name="costs[<?php echo $type; ?>][vat_sum]" value="<?php echo $quote['costs'][$type]['vat_sum']; ?>"/>
    <input type="hidden" class="js-cost-total" name="costs[<?php echo $type; ?>][total]" value="<?php echo $quote['costs'][$type]['total']; ?>"/>
	<td></td>
    <td class="milestone-name"><strong><?php echo $quote['name']; ?></strong></td>
	<td><input class="table-input" name="costs[<?php echo $type; ?>][description]" value="<?php echo $quote['costs'][$type]['description']; ?>" <?php echo $disabled ?>/></td>
	<td><input class="table-input amount-input" name="costs[<?php echo $type; ?>][amount]" value="<?php echo $quote['costs'][$type]['amount']; ?>" <?php echo $disabled ?>/></td>
	<td><input class="table-input price-input" name="costs[<?php echo $type; ?>][price]" value="<?php echo $quote['costs'][$type]['price']; ?>" <?php echo $disabled ?>/></td>
	<td><input class="table-input" name="costs[<?php echo $type; ?>][unit]" value="<?php echo $quote['costs'][$type]['unit']; ?>" <?php echo $disabled ?>/></td>
	<td><input class="table-input vat-input" name="costs[<?php echo $type; ?>][vat]" value="<?php echo $quote['costs'][$type]['vat']; ?>" <?php echo $disabled ?>/></td>
	<td class="cost-vat_sum"><?php echo $quote['costs'][$type]['vat_sum']; ?></td>
	<td class="cost-total">$<?php echo $quote['costs'][$type]['total']; ?></td>
    <td>&nbsp;</td>
</tr>