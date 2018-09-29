<?php

use Phinx\Migration\AbstractMigration;

class MilestoneMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE milestone RENAME TO milestone_old;");

		$this->execute("CREATE TABLE milestones (
						id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
						job_id BIGINT(20) UNSIGNED NOT NULL,
						name VARCHAR(200) NULL,
						description TEXT NULL,
						due_date BIGINT(20) NOT NULL DEFAULT 0,
						amount INT(10) NOT NULL DEFAULT 0,
						PRIMARY KEY (id),
						INDEX fk_milestone_job_idx (job_id ASC),
						CONSTRAINT fk_milestone_job
						FOREIGN KEY (job_id)
						REFERENCES jobs (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION);");
	}

	public function down()
	{

	}
}
