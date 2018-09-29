<?php

use Phinx\Migration\AbstractMigration;

class CountryMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE m_marketplace.country ADD active TINYINT(1) DEFAULT 0 NOT NULL;");

		$this->execute("CREATE TABLE import_matrix
						(
						  id BIGINT(20) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
						  country1 INT(10) unsigned NOT NULL,
						  country2 INT(10) unsigned NOT NULL,
						  percent DECIMAL(10,2),
						  CONSTRAINT fk_import_matrix_country1 FOREIGN KEY (country1) REFERENCES country (id) ON DELETE CASCADE,
						  CONSTRAINT fk_import_matrix_country2 FOREIGN KEY (country2) REFERENCES country (id) ON DELETE CASCADE
						);
						CREATE INDEX in_import_matrix_country1 ON import_matrix (country1);
						CREATE INDEX in_import_matrix_country2 ON import_matrix (country2);
						CREATE UNIQUE INDEX in_import_matrix_country_unique ON import_matrix (country1, country2);");
	}

	public function down()
	{

	}
}