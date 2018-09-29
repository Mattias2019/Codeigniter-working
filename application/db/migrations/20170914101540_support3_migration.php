<?php

use Phinx\Migration\AbstractMigration;

class Support3Migration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE support ADD email VARCHAR(50) NULL;
						ALTER TABLE support MODIFY user_id BIGINT(20) unsigned;");
	}

	public function down()
	{

	}
}