<?php

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=tax.csv");

echo '"'.t('Status').'",';
echo '"'.t('Client').'",';
echo '"'.t('Project Name').'",';
echo '"'.t('Country').'",';
echo '"'.t('Fiscal Year Report').'",';
echo '"'.t('Payment Overview').'",';
echo '"'.t('Vat').'",';
echo '"'.t('Payments Due Date').'"'."\n";

foreach ($this->outputData['transactions'] as $transaction) {
	if ($transaction['job_id'] != '') {
		echo '"'.$transaction['payment_status']['status'].'",';
		echo '"'.$transaction['client_name'].'",';
		echo '"'.$transaction['job_name'].'",';
		echo '"'.$transaction['country_name'].'",';
		echo '"'.$transaction['fiscal_year'].'",';
		echo '"'.currency().number_format($transaction['amount']).'",';
		echo '"'.currency().number_format($transaction['vat']).'",';
		echo '"'.date('Y/m/d', $transaction['due_date']).'"'."\n";
	} elseif ($transaction['country'] != '') {
		echo '"'.t('Total VAT for').' '.$transaction['country_name'].'",';
		echo '"","","","","",';
		echo '"'.currency().number_format($transaction['vat']).'"'."\n";
	} elseif ($transaction['fiscal_year'] != '') {
		echo '"'.t('Total VAT for').' '.$transaction['fiscal_year'].'",';
		echo '"","","","","",';
		echo '"'.currency().number_format($transaction['vat']).'"'."\n";
	} else {
		echo '"'.t('Total').'",';
		echo '"","","","","",';
		echo '"'.currency().number_format($transaction['vat']).'"';
	}
}