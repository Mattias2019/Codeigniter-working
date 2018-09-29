<?php

use Phinx\Migration\AbstractMigration;

class PortfolioUploadMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("delete from portfolio_uploads where portfolio_id not in (select id from portfolio)");

		$this->execute("ALTER TABLE portfolio_uploads
						CHANGE COLUMN id id BIGINT(20) NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN portfolio_id portfolio_id BIGINT(20) NOT NULL ,
						CHANGE COLUMN folder_id folder_id BIGINT(20) NULL ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NULL ,
						CHANGE COLUMN date date BIGINT(20) NOT NULL ,
						CHANGE COLUMN filesize filesize BIGINT(20) NOT NULL ,
						CHANGE COLUMN description description TEXT NULL ,
						ADD INDEX fk_portfolio_uploads_portfolio_idx (portfolio_id ASC);
						ALTER TABLE portfolio_uploads 
						ADD CONSTRAINT fk_portfolio_uploads_portfolio
						  FOREIGN KEY (portfolio_id)
						  REFERENCES portfolio (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("ALTER TABLE machinery_custom_item_values CHANGE COLUMN id id BIGINT(20) NOT NULL AUTO_INCREMENT;");
	}

	public function down()
	{

	}
}
