<?php
require_once('Base_model.php');

/**
 * Class User_bank_model
 */
class User_paypal_model extends Base_model
{
    /**
     * @return string
     */
    protected function table_name()
    {
        return 'user_paypal_account';
    }

    /**
     * @return array
     */
    protected function primary_key()
    {
        return [
            'id'
        ];
    }

}