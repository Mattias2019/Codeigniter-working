<?php

use Phinx\Migration\AbstractMigration;

class FixMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE m_marketplace.transaction_items ALTER COLUMN amount SET DEFAULT 0;");
	}

	public function down()
	{

	}
}