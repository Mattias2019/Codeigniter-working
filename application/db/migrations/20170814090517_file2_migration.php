<?php

use Phinx\Migration\AbstractMigration;

class File2Migration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE user_file_type (
						  id tinyint(4) NOT NULL,
						  name varchar(50) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO user_file_type VALUES ('1', 'Templates');
						INSERT INTO user_file_type VALUES ('2', 'Terms & Conditions');");

		$this->execute("ALTER TABLE user_files 
						ENGINE = InnoDB ,
						DROP COLUMN folder_id,
						DROP COLUMN portfolio_id,
						CHANGE COLUMN user_file_id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL AFTER id,
						CHANGE COLUMN file_id file_type TINYINT(4) NOT NULL ,
						ADD COLUMN name VARCHAR(50) NOT NULL AFTER file_type,
						ADD COLUMN url VARCHAR(50) NOT NULL AFTER name,
						ADD COLUMN description TEXT NULL AFTER url,
						ADD COLUMN expire_date BIGINT(20) NULL AFTER description,
						ADD INDEX fk_user_files_user_idx (user_id ASC),
						ADD INDEX fk_user_files_type_idx (file_type ASC);
						ALTER TABLE user_files 
						ADD CONSTRAINT fk_user_files_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_user_files_type
						  FOREIGN KEY (file_type)
						  REFERENCES user_file_type (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}