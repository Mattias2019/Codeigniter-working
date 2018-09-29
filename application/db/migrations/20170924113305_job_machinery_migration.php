<?php

use Phinx\Migration\AbstractMigration;

class JobMachineryMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE jobs ADD portfolio_id BIGINT(20) NULL;
						CREATE INDEX fk_jobs_portfolio_idx ON jobs (portfolio_id);
						ALTER TABLE jobs
						ADD CONSTRAINT fk_jobs_portfolio
						FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE;");
	}

	public function down()
	{

	}
}
