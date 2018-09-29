<?php

use Phinx\Migration\AbstractMigration;

class FeeModulatorMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE escrow_fee MODIFY min_amount DECIMAL(10,2);
						ALTER TABLE escrow_fee DROP fee_flat;");

		$this->execute("DELETE FROM escrow_fee");

		$this->execute("INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('1000', '25');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('500000', '4');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('1000000', '2.95');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES (NULL, '2.5');");
	}
}