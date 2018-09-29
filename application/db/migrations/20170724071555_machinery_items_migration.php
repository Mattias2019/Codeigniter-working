<?php

use Phinx\Migration\AbstractMigration;

class MachineryItemsMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("ALTER TABLE categories ENGINE = InnoDB ;");

		$this->execute("ALTER TABLE machinery_characteristics
						DROP COLUMN main_characteristic, RENAME TO machinery_standard_items ;");*/

		$this->execute("ALTER TABLE machinery_characteristic_values
						DROP FOREIGN KEY fk_mcv_characteristic;
						ALTER TABLE machinery_characteristic_values
						CHANGE COLUMN characteristic_id item_id BIGINT(20) NOT NULL ,
						RENAME TO machinery_standard_item_values ;
						ALTER TABLE machinery_standard_item_values
						ADD CONSTRAINT fk_mcv_items
						FOREIGN KEY (item_id)
						REFERENCES machinery_standard_items (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION;");

		$this->execute("CREATE TABLE machinery_standard_item_categories (
						id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						item_id bigint(20) NOT NULL,
						category_id int(10) unsigned NOT NULL,
						PRIMARY KEY (id),
						KEY fk_mcc_characteristics_idx (item_id),
						KEY fk_mcc_categories_idx (category_id),
						CONSTRAINT fk_mcc_categories FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						CONSTRAINT fk_mcc_items FOREIGN KEY (item_id) REFERENCES machinery_standard_items (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE machinery_custom_item_values (
						id BIGINT(20) NOT NULL,
						machinery_id BIGINT(20) NOT NULL,
						name VARCHAR(200) NOT NULL,
						unit VARCHAR(20) NULL,
						value VARCHAR(200) NULL,
						remarks TEXT NULL,
						PRIMARY KEY (id),
						INDEX fk_mci_machinery_idx (machinery_id ASC),
						CONSTRAINT fk_mci_machinery
						FOREIGN KEY (machinery_id)
						REFERENCES portfolio (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION);");

		$this->execute("insert into machinery_standard_item_categories (item_id, category_id)
						select i.id, c.id
						from machinery_standard_items i join categories c");

		$this->execute("ALTER TABLE portfolio
						CHANGE COLUMN use_range use_range TINYINT(4) NULL COMMENT '0- not selected 1- seleted' ,
						CHANGE COLUMN skill skill INT(11) NULL ,
						CHANGE COLUMN header_img header_img INT(11) NULL ,
						CHANGE COLUMN thumbnail_img thumbnail_img INT(11) NULL ,
						CHANGE COLUMN team_member_id team_member_id INT(11) NULL ;");
	}

	public function down()
	{

	}
}
