<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= t('Invoice'); ?></title>
	<style>

		/* All */
		@page
		{
			margin: 0;
		}
		body
		{
			margin: 0;
			font-family: Helvetica, sans-serif;
			font-size: 12px;
		}

		/* Tables */
		table
		{
			border-style: none;
			border-collapse: collapse;
			margin: 0;
			width: 100%;
		}

		/* Header */
		.header
		{
			position: fixed;
			top: 0;
			width: 100%;
			background-color: #2a2a2a;
			color: #fff;
			padding-top: 16px;
			padding-bottom: 16px;
		}
		.header-logo
		{
			width: 33%;
			vertical-align: middle;
			text-align: center;
		}
		.header-logo img
		{
			/*height: 64px;*/
            height: 100%;
            width: auto;
		}
		.header-title
		{
			width: 33%;
			text-align: center;
			vertical-align: middle;
			font-size: 32px;
			font-weight: bold;
			text-transform: uppercase;
		}
		.header-property
		{
			width: 40%;
			vertical-align: middle;
			font-size: 12px;
			font-weight: bold;
			text-transform: uppercase;
		}
		.header-value
		{
			width: 40%;
			vertical-align: middle;
			text-transform: uppercase;
		}

		/* Content */
		.content
		{
			margin-top: 110px;
			margin-bottom: 280px;
		}

		/* Subheader */
		.subheader
		{
			background-color: #e1e1e1;
		}
		.subheader-block
		{
			width: 30%;
			padding: 16px;
		}
		.subheader-title
		{
			font-size: 18px;
			font-weight: bold;
			text-transform: uppercase;
		}
		.subheader-name
		{
			font-weight: bold;
		}

		/* Main */
		.main
		{
			padding: 16px;
		}
		.main-head
		{
			background-color: #2a2a2a;
			color: #fff;
		}
		.main-row td
		{
			border-bottom: 2px solid #e1e1e1;
		}
		.main-first, .main-data
		{
			padding: 12px;
		}
		.main-first
		{
			width: 50%;
		}
		.main-data
		{
			width: 10%;
			text-align: center;
		}
		.main-title
		{
			font-weight: bold;
			margin: 2px;
		}
		.main-block
		{
			margin: 2px;
		}
		.main-subfooter
		{
			width: 20%;
			padding-left: 12px;
		}
		.main-foot
		{
			background-color: #2a2a2a;
			color: #fff;
			text-transform: uppercase;
		}

			/* Footer */
		.footer
		{
			position: fixed;
			bottom: 280px;
			width: 100%;
		}
		.footer-caption
		{
			vertical-align: middle;
			font-weight: bold;
			text-transform: uppercase;
			color: #9a9a9a;
			padding: 16px;
		}
		.footer-field
		{
			width: 100%;
			height: 96px;
			background-color: #e1e1e1;
		}

	</style>
</head>
<body>

	<div class="header">
		<table>
			<tbody>
			<tr>
<!--				<td class="header-logo"><img src="files/0/0/0/0/0/0/5/6/logo/13db9b7ca46ca8ea1d61b9f7e59dfbe2.png"/></td>-->
				<td class="header-logo"><img src="<?php echo $this->outputData['logo']?>"/></td>
				<td class="header-title"><?= t('Invoice'); ?></td>
				<td>
					<table>
						<tbody>
						<tr>
							<td></td>
							<td class="header-property"><?= t('Reference'); ?>:</td>
							<td class="header-value"></td>
						</tr>
						<tr>
							<td></td>
							<td class="header-property"><?= t('VAT/Tax-ID'); ?>:</td>
							<td class="header-value"></td>
						</tr>
						<tr>
							<td></td>
							<td class="header-property"><?= t('Billing Date'); ?>:</td>
							<td class="header-value"><?php echo date('Y/m/d', $this->outputData['invoice'][0]['billing_date']); ?></td>
						</tr>
						<tr>
							<td></td>
							<td class="header-property"><?= t('Due Date'); ?>:</td>
							<td class="header-value"><?php echo date('Y/m/d', $this->outputData['invoice'][0]['due_date']); ?></td>
						</tr>
						<tr>
							<td></td>
							<td class="header-property"><?= t('Delivery Date'); ?>:</td>
							<td class="header-value"><?php echo date('Y/m/d', $this->outputData['invoice'][0]['billing_date']); ?></td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="footer">
		<table>
			<tbody>
			<tr>
				<td class="footer-caption"><?= t('Reference of contracted discount or bonus for turnover or sales'); ?>:</td>
			</tr>
			<tr>
				<td>
					<div class="footer-field"></div>
				</td>
			</tr>
			<tr>
				<td class="footer-caption"><?= t('Supplier remarks'); ?>:</td>
			</tr>
			<tr>
				<td>
					<div class="footer-field"><?php echo $this->outputData['invoice'][0]['remarks']; ?></div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="content">

		<div class="subheader">
			<table>
				<tbody>
				<tr>
					<td class="subheader-block">
						<p class="subheader-title"><?= t('Billing From'); ?></p>
						<hr class="subheader-line"/>
						<p class="subheader-name"><?php echo $this->outputData['billing_from']; ?></p>
						<p class="subheader-text"></p>
					</td>
					<td></td>
					<td class="subheader-block">
						<p class="subheader-title"><?= t('Billing To'); ?></p>
						<hr class="subheader-line"/>
						<p class="subheader-name"><?php echo $this->outputData['billing_to']; ?></p>
						<p class="subheader-text"></p>
					</td>
					<td></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="main">
			<table>
				<thead>
				<tr>
					<td class="main-head main-first"><?= t('Project / Milestone / Detail'); ?></td>
					<td class="main-head main-data"><?= t('QTY'); ?></td>
					<td class="main-head main-data"><?= t('VAT'); ?></td>
					<td class="main-head main-data"><?= t('Price'); ?></td>
					<td class="main-head main-data"><?= t('Discount'); ?></td>
					<td class="main-head main-data"><?= t('Total'); ?></td>
				</tr>
				</thead>
				<tbody>
				<?php
				    // For totals
                    $total_amount = 0;
				    $total_vat = 0;
				    $total_discount = 0;
                    $total_total = 0;
				?>
				<?php foreach ($this->outputData['invoice'] as $item) { ?>
                    <tr class="main-row">
                        <td class="main-first">
                            <p class="main-title"><?php echo $item['job_name']; ?></p>
                            <p class="main-title"><?php echo $item['milestone_name']; ?></p>
                            <p class="main-block"><?php echo $item['description']; ?></p>
                        </td>
                        <td class="main-data">1</td>
                        <td class="main-data"><?php echo number_format($item['vat_percent']).'%'; ?></td>
                        <td class="main-data"><?php echo currency().number_format($item['amount'], 2); ?></td>
                        <td class="main-data"><?php echo number_format($item['discount_percent']).'%'; ?></td>
                        <td class="main-data"><?php echo currency().number_format($item['total'], 2); ?></td>
                    </tr>
                    <?php
                        // Calculate totals
                        $total_amount += $item['amount'];
                        $total_vat += $item['amount']*$item['vat_percent']/100;
                        $total_discount += $item['amount']*$item['discount_percent']/100;
                        $total_total += $item['total'];
                    ?>
				<?php } ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="3"></td>
					<td colspan="2" class="main-subfooter"><?= t('Sub Total'); ?>:</td>
					<td class="main-data"><?php echo currency().number_format($total_amount, 2); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2" class="main-subfooter"><?= t('Vat %'); ?>:</td>
					<td class="main-data"><?php echo currency().number_format($total_vat, 2); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2" class="main-subfooter"><?= t('Discount %'); ?>:</td>
					<td class="main-data"><?php echo currency().number_format($total_discount, 2); ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2" class="main-foot main-subfooter"><?= t('Total'); ?>:</td>
					<td class="main-foot main-data"><?php echo currency().number_format($total_total, 2); ?></td>
				</tr>
				</tfoot>
			</table>
		</div>

	</div>

</body>
</html>