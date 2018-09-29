<?php

use Phinx\Migration\AbstractMigration;

class UpdateQuote extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `quotes`
	ADD COLUMN `platform_required` TINYINT(1) NOT NULL DEFAULT '0' AFTER `escrow_required`;");
    }
}
