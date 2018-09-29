<?php

use Phinx\Migration\AbstractMigration;

class RoleRenameMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("update roles set role_name='entrepreneur' where id=1;");
		$this->execute("update roles set role_name='provider' where id=2;");*/
	}

	public function down()
	{

	}
}