<?php
require_once('Base_model.php');

/**
 * Class User_bank_model
 */
class User_bank_model extends Base_model
{
    /**
     * @return string
     */
    protected function table_name()
    {
        return 'user_bank';
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