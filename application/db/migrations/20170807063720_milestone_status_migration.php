<?php

use Phinx\Migration\AbstractMigration;

class MilestoneStatusMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE jobs ADD COLUMN start_date BIGINT(20) NULL AFTER description;");

		$this->execute("ALTER TABLE milestones
 						ADD COLUMN status TINYINT(4) NOT NULL DEFAULT 0,
 						ADD COLUMN start_date BIGINT(20) NOT NULL DEFAULT 0 AFTER description,
 						ADD COLUMN completion TINYINT(3) NOT NULL DEFAULT 0;");
	}

	public function down()
	{

	}
}