<?php

use Phinx\Migration\AbstractMigration;

class FeeMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("DELETE FROM escrow_fee;
						INSERT INTO escrow_fee VALUES (0, 0, 250, null);
						INSERT INTO escrow_fee VALUES (0, 1000, null, 25);
						INSERT INTO escrow_fee VALUES (0, 500000, null, 4);
						INSERT INTO escrow_fee VALUES (0, 1000000, null, 2.95);
						INSERT INTO escrow_fee VALUES (0, 10000000, null, 2.5);");
	}

	public function down()
	{

	}
}
