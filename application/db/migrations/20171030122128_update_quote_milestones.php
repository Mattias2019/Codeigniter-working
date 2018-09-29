<?php

use Phinx\Migration\AbstractMigration;

class UpdateQuoteMilestones extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `quote_milestones`
	ADD COLUMN `platform_required` TINYINT(1) NOT NULL DEFAULT '0' AFTER `escrow_required`;");
    }
}
