<?php

use Phinx\Migration\AbstractMigration;

class UsersMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE m_marketplace.users DROP country_symbol;");
	}

	public function down()
	{

	}
}