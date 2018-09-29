<?php

use Phinx\Migration\AbstractMigration;

class JobCategoriesMigration extends AbstractMigration
{
    public function up()
    {
		/*$this->execute("CREATE TABLE job_categories (
  						id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  						job_id BIGINT(20) UNSIGNED NULL,
  						category_id INT(10) UNSIGNED NULL,
  						PRIMARY KEY (id));");

		$this->execute("insert into job_categories (job_id, category_id)
						select jobs.id as job_id, categories.id as categoriy_id
  						from jobs join categories on jobs.job_categories like concat('%', categories.category_name, '%');");*/
    }

	public function down()
	{

	}
}
