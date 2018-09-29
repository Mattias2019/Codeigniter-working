<?php

use Phinx\Migration\AbstractMigration;

class TransacionUpdate extends AbstractMigration
{

    public function up()
    {
        $this->execute("ALTER TABLE `transactions`
	ADD COLUMN `user_bank_information` TEXT NULL DEFAULT NULL AFTER `user_description`;");
    }
}
