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

class Email extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('email_model');
	}

	function instantly()
	{
		$this->email_model->send(NULL, Email_model::EMAIL_PERIOD_INSTANTLY);
	}

	function hourly()
	{
		$this->email_model->send(NULL, Email_model::EMAIL_PERIOD_HOURLY);
	}

	function daily()
	{
		$this->email_model->send(NULL, Email_model::EMAIL_PERIOD_DAILY);
	}
}