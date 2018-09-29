<?php

use Phinx\Migration\AbstractMigration;

class JobFixMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("DELETE FROM job_categories;");

		$this->execute("ALTER TABLE job_categories
						ADD INDEX fk_job_categories_job_idx (job_id ASC);
						ALTER TABLE job_categories
						ADD CONSTRAINT fk_job_categories_job
						FOREIGN KEY (job_id)
						REFERENCES jobs (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION;");

		$this->execute("DROP TABLE jobs_preview;
						DROP TABLE draftjobs;");

		$this->execute("DELETE FROM quote_requests;");

		$this->execute("ALTER TABLE quote_requests
						DROP COLUMN job_id,
						ADD COLUMN machinery_id BIGINT(20) NOT NULL AFTER id,
						ADD INDEX fk_quote_requests_machinery_idx (machinery_id ASC);
						ALTER TABLE quote_requests
						ADD CONSTRAINT fk_quote_requests_machinery
						FOREIGN KEY (machinery_id)
						REFERENCES portfolio (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}
