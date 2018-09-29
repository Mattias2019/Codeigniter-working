<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	function __construct()
	{
		parent::__construct();
	}

	function set_errors($fields)
	{
		if (is_array($fields) and count($fields))
		{
			foreach ($fields as $key => $val)
			{
				$error = $key . '_error';
				if (isset($this->$error) and isset($this->$key) and $this->$error != '')
				{
					$old_error = $this->$error;
					$new_error = $this->_error_prefix . sprintf($val, $this->$key) . $this->_error_suffix;
					$this->error_string = str_replace($old_error, $new_error, $this->error_string);
					$this->$error = $new_error;
				}
			}
		}
	}

	/**
	 * Check that field does not contain phone number
	 *
	 * @param $field
	 * @return bool
	 */
	public function no_phone_number($field)
	{
		$reg="/\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{3}/";
		if(preg_match($reg, $field))
		{
			$this->set_message('no_phone_number', 'The {field} field may not contain phone number');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	/**
	 * Check that field does not contain e-mail address
	 *
	 * @param $field
	 * @return bool
	 */
	public function no_email($field)
	{
		$reg = '/[\s]*[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
		if(preg_match($reg, $field))
		{
			$this->set_message('no_email', 'The {field} field may not contain E-mail address');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}