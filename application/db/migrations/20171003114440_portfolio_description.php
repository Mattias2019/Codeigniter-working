<?php

use Phinx\Migration\AbstractMigration;

class PortfolioDescription extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `portfolio`
	ALTER `machine_description` DROP DEFAULT;");
        $this->execute("ALTER TABLE `portfolio`
	CHANGE COLUMN `machine_description` `machine_description` TEXT NULL COLLATE 'latin1_swedish_ci' AFTER `thumbnail_img`;");
    }
}
