<?php

use Phinx\Migration\AbstractMigration;

class FileMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE job_attachments 
						ADD COLUMN description TEXT NULL AFTER url,
						ADD COLUMN expire_date BIGINT(20) NULL AFTER description;");

		$this->execute("ALTER TABLE milestone_attachments 
						ADD COLUMN description TEXT NULL AFTER url,
						ADD COLUMN expire_date BIGINT(20) NULL AFTER description;");

		$this->execute("ALTER TABLE quote_attachments 
						ADD COLUMN description TEXT NULL AFTER url,
						ADD COLUMN expire_date BIGINT(20) NULL AFTER description;");

		$this->execute("ALTER TABLE quote_milestone_attachments 
						ADD COLUMN description TEXT NULL AFTER url,
						ADD COLUMN expire_date BIGINT(20) NULL AFTER description;");
	}

	public function down()
	{

	}
}
