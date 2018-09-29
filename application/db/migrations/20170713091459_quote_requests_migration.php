<?php

use Phinx\Migration\AbstractMigration;

class QuoteRequestsMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("CREATE TABLE quote_requests (
  						id BIGINT(20) NOT NULL AUTO_INCREMENT,
  						job_id BIGINT(20) NOT NULL,
 						requester_id BIGINT(20) NOT NULL,
  						requestee_id BIGINT(20) NOT NULL,
  						created BIGINT(20) NOT NULL,
  						PRIMARY KEY (`id`));");*/
	}

	public function down()
	{

	}
}
