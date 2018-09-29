<?php

use Phinx\Migration\AbstractMigration;

class PortfolioIdMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS = 0;
						ALTER TABLE portfolio CHANGE COLUMN id id BIGINT(20) NOT NULL AUTO_INCREMENT;
						SET FOREIGN_KEY_CHECKS = 1;");
	}
}