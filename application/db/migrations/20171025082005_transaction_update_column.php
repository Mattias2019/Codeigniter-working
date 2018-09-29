<?php

use Phinx\Migration\AbstractMigration;

class TransactionUpdateColumn extends AbstractMigration
{

    public function up()
    {
        $this->execute("ALTER TABLE `transactions`
	ADD COLUMN `user_transaction_id` VARCHAR(255) NULL DEFAULT NULL AFTER `paypal_address`,
	ADD COLUMN `user_description` VARCHAR(255) NULL DEFAULT NULL AFTER `user_transaction_id`;"
        );
    }
}
