<?php
require_once('Base_model.php');

/**
 * Class User_bank_account_model
 */
class User_bank_account_model extends Base_model
{

    /**
     * @return string
     */
    protected function table_name() {
        return 'user_bank_account';
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