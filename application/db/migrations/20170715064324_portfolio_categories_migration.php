<?php

use Phinx\Migration\AbstractMigration;

class PortfolioCategoriesMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("CREATE TABLE portfolio_categories (
  						id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  						portfolio_id BIGINT(20) UNSIGNED NULL,
  						category_id INT(10) UNSIGNED NULL,
  						PRIMARY KEY (id));");

		$this->execute("insert into portfolio_categories (portfolio_id, category_id)
						select portfolio.id as portfolio_id, categories.id as categoriy_id
  						from portfolio join categories on concat(',', portfolio.categories, ',') like concat('%,', categories.id, ',%');");

		$this->execute("ALTER TABLE portfolio DROP COLUMN categories;");*/
	}

	public function down()
	{

	}
}