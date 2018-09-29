<?php

use Phinx\Migration\AbstractMigration;

class TablesMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("DROP TABLE clickthroughs;");
		$this->execute("DROP TABLE contacts;");
		$this->execute("DROP TABLE dispute_agree;");
		$this->execute("DROP TABLE ipn_return;");
		$this->execute("DROP TABLE milestone_old;");
		$this->execute("DROP TABLE owner_milestone;");
		$this->execute("DROP TABLE owner_milestone_upload;");
		$this->execute("DROP TABLE popular_search;");
		$this->execute("DROP TABLE sales;");
		$this->execute("DROP TABLE sessions;");
	}

	public function down()
	{

	}
}
