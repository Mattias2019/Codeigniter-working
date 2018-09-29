<?php

use Phinx\Migration\AbstractMigration;

class ReviewMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE reviews DROP INDEX job_id_UNIQUE;
						ALTER TABLE reviews ADD UNIQUE INDEX reviews_UNIQUE (reviewer_id ASC, job_id ASC);");
	}
}