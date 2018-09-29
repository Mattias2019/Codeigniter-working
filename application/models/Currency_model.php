<?php
require_once('Base_model.php');

/**
 * Class Currency_model
 */
class Currency_model extends Base_model
{

    protected function table_name()
    {
        return 'currency';
    }

    protected function primary_key()
    {
        return [
            'id'
        ];
    }

}