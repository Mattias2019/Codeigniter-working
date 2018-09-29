<?php

use Phinx\Migration\AbstractMigration;

class MachineryCharacteristicsMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("ALTER TABLE portfolio
                         ENGINE = InnoDB,
                         CHANGE COLUMN id id BIGINT(20) NOT NULL,
                         DROP COLUMN attachment5,
                         DROP COLUMN attachment4,
                         DROP COLUMN attachment3,
                         DROP COLUMN attachment2,
                         DROP COLUMN attachment1,
                         DROP COLUMN main_img,
                         DROP COLUMN remarks,
                         DROP COLUMN value,
                         DROP COLUMN characteristics;");

		$this->execute("CREATE TABLE machinery_characteristics (
                         id BIGINT(20) NOT NULL AUTO_INCREMENT,
                         name VARCHAR(200) NOT NULL,
                         unit VARCHAR(20) NULL,
                         main_characteristic TINYINT(1) NOT NULL,
                         PRIMARY KEY (id),
                         UNIQUE INDEX name_UNIQUE (name ASC));");

		$this->execute("CREATE TABLE machinery_characteristic_values (
                         id BIGINT(20) NOT NULL AUTO_INCREMENT,
                         machinery_id BIGINT(20) NOT NULL,
                         characteristic_id BIGINT(20) NOT NULL,
                         value VARCHAR(200) NULL,
                         remarks TEXT NULL,
                         PRIMARY KEY (id),
                         INDEX fk_mcv_machinery_idx (machinery_id ASC),
                         CONSTRAINT fk_mcv_machinery
                         FOREIGN KEY (machinery_id)
                         REFERENCES portfolio (id)
                         ON DELETE CASCADE
                         ON UPDATE NO ACTION,
                         INDEX fk_mcv_characteristic_idx (characteristic_id ASC),
                         CONSTRAINT fk_mcv_fk_characteristic
                         FOREIGN KEY (characteristic_id)
                         REFERENCES machinery_characteristics (id)
                         ON DELETE CASCADE
                         ON UPDATE NO ACTION);");*/
	}

	public function down()
	{

	}
}
