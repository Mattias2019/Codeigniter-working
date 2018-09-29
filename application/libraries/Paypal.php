<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\PayPalAPI\MassPayReq;
use PayPal\PayPalAPI\MassPayRequestItemType;
use PayPal\PayPalAPI\MassPayRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\Auth\PPSignatureCredential;
use PayPal\Auth\PPTokenAuthorization;

class Paypal
{
	const paypal_dir = APPPATH . 'vendor/paypal/merchant-sdk-php/samples/';

	public function __construct() {}

	/**
	 * @param $amount
	 * @param $email
	 * @return string
	 * @throws Exception
	 */
	public function send($amount, $email)
	{
		require_once(Paypal::paypal_dir . 'PPBootStrap.php');

		// Get credentials
		$CI = &get_instance();
		$CI->load->model('payment_model');
		$paypal = $CI->payment_model->getPayment('paypal');
		if (!isset($paypal))
		{
			throw new Exception('Error initializing PayPal API');
		}

		$massPayRequest = new MassPayRequestType();
		$massPayRequest->MassPayItem = array();
		$massPayItem = new MassPayRequestItemType();

		$massPayItem->Amount = new BasicAmountType($CI->config->item('currency_type'), $amount);
		$massPayItem->ReceiverEmail = $email;
		$massPayRequest->MassPayItem[] = $massPayItem;

		$massPayReq = new MassPayReq();
		$massPayReq->MassPayRequest = $massPayRequest;

		$config = [
			'mode' => (ENVIRONMENT == 'production')?'live':'sandbox',
			'acct1.UserName' => $paypal['credentials']['api_username']['value'],
			'acct1.Password' => $paypal['credentials']['api_password']['value'],
			'acct1.Signature' => $paypal['credentials']['api_signature']['value']
		];
		$paypalService = new PayPalAPIInterfaceServiceService($config);

		try
		{
			/* wrap API method calls on the service object with a try catch */
			$massPayResponse = $paypalService->MassPay($massPayReq);
		}
		catch (Exception $ex)
		{
			if($ex instanceof PPConnectionException) {
				throw new Exception("Error connecting to " . $ex->getUrl());
			} else if($ex instanceof PPMissingCredentialException || $ex instanceof PPInvalidCredentialException) {
				throw new Exception($ex->errorMessage());
			} else if($ex instanceof PPConfigurationException) {
				throw new Exception("Invalid configuration");
			}
		}

		if (isset($massPayResponse))
		{
			if ($massPayResponse->Errors !== NULL)
			{
				throw new Exception($massPayResponse->Errors->ShortMessage);
			}
			return $massPayResponse->CorrelationID;
		}
		else
		{
			throw new Exception("Error processing request");
		}
	}
}