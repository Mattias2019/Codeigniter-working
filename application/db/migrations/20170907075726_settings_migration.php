<?php

use Phinx\Migration\AbstractMigration;

class SettingsMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("UPDATE settings SET value_type = 'I', int_value = 1, string_value = NULL WHERE code = 'DAYLIGHT';
						UPDATE settings SET value_type = 'I', int_value = 0, text_value = NULL WHERE code = 'FORCED_ESCROW';");
	}

	public function down()
	{

	}
}