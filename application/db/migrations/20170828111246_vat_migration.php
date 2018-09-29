<?php

use Phinx\Migration\AbstractMigration;

class VatMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE vat_matrix (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  country1 int(10) unsigned NOT NULL,
						  country2 int(10) unsigned NOT NULL,
						  percent decimal(10,2) DEFAULT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY in_vat_matrix_country_unique (country1,country2),
						  KEY in_vat_matrix_country1 (country1),
						  KEY in_vat_matrix_country2 (country2),
						  CONSTRAINT fk_vat_matrix_country1 FOREIGN KEY (country1) REFERENCES country (id) ON DELETE CASCADE,
						  CONSTRAINT fk_vat_matrix_country2 FOREIGN KEY (country2) REFERENCES country (id) ON DELETE CASCADE
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}
}