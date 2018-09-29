<?php

use Phinx\Migration\AbstractMigration;

class AdminCaseMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO job_case_status VALUES ('3', 'Project Canceled', 'Project canceled by admin');
						INSERT INTO job_case_status VALUES ('4', 'Escalated', 'Escalated to third-party lawyer by admin');");

		$this->execute("CREATE TABLE job_case_message_status
						(
							id TINYINT(4) PRIMARY KEY NOT NULL,
							name VARCHAR(50) NOT NULL
						);");

		$this->execute("INSERT INTO job_case_message_status VALUES ('0', 'Pending');
						INSERT INTO job_case_message_status VALUES ('1', 'Approved');
						INSERT INTO job_case_message_status VALUES ('2', 'Rejected');");
	}

	public function down()
	{

	}
}