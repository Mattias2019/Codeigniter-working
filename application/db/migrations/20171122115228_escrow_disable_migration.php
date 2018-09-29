<?php

use Phinx\Migration\AbstractMigration;

class EscrowDisableMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO settings (code, name, setting_type, value_type, int_value, created) VALUES ('DISABLE_ESCROW', 'Disable escrow', 'S', 'I', '0', '0');");
	}
}