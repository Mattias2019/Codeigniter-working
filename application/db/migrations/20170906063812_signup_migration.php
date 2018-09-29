<?php

use Phinx\Migration\AbstractMigration;

class SignupMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("DROP INDEX user_name_UNIQUE ON m_marketplace.users;
						ALTER TABLE m_marketplace.users MODIFY user_name VARCHAR(128);
						ALTER TABLE m_marketplace.users MODIFY first_name VARCHAR(128);
						ALTER TABLE m_marketplace.users MODIFY last_name VARCHAR(128);
						ALTER TABLE m_marketplace.users MODIFY name VARCHAR(128);
						ALTER TABLE m_marketplace.users MODIFY company_address VARCHAR(255);
						ALTER TABLE m_marketplace.users MODIFY vat_id VARCHAR(128);
						ALTER TABLE m_marketplace.users MODIFY language VARCHAR(250);
						ALTER TABLE m_marketplace.users MODIFY zip_code VARCHAR(64);
						ALTER TABLE m_marketplace.users MODIFY team_owner INT(11);");
	}

	public function down()
	{

	}
}
