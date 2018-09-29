<?php

use Phinx\Migration\AbstractMigration;

class PlatformFeeMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE platform_fee (
						  id tinyint(4) NOT NULL AUTO_INCREMENT,
						  min_amount decimal(10,2) DEFAULT NULL,
						  fee_percent decimal(5,2) DEFAULT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("insert into platform_fee select * from escrow_fee;");
	}
}