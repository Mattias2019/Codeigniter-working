<?php

use Phinx\Migration\AbstractMigration;

class PaymentMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE quotes 
						ADD COLUMN escrow_required TINYINT(1) NOT NULL DEFAULT 0 AFTER created,
						ADD COLUMN notify_lower TINYINT(1) NOT NULL DEFAULT 0 AFTER escrow_required;");

		$this->execute("ALTER TABLE quote_milestones 
						ADD COLUMN escrow_required TINYINT(1) NOT NULL DEFAULT 0,
						ADD COLUMN notify_lower TINYINT(1) NOT NULL DEFAULT 0 AFTER escrow_required;");

		$this->execute("ALTER TABLE jobs
						ADD COLUMN vat_percent TINYINT(3) NOT NULL DEFAULT 0 AFTER budget_max;");

		$this->execute("ALTER TABLE milestones
						ADD COLUMN vat_percent TINYINT(3) NOT NULL DEFAULT 0 AFTER amount;");
	}

	public function down()
	{

	}
}