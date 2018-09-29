<?php

use Phinx\Migration\AbstractMigration;

class LanguageMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE languages (
						  id TINYINT(4) NOT NULL AUTO_INCREMENT,
						  code VARCHAR(2) NOT NULL,
						  name VARCHAR(50) NOT NULL,
						  default_language TINYINT(1) DEFAULT 0 NOT NULL,
						  PRIMARY KEY (id))
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8;");

		$this->execute("INSERT INTO languages (code, name, default_language) VALUES ('en', 'english', 1);
						INSERT INTO languages (code, name) VALUES ('ch', 'chinese');
						INSERT INTO languages (code, name) VALUES ('de', 'german');
						INSERT INTO languages (code, name) VALUES ('fr', 'french');
						INSERT INTO languages (code, name) VALUES ('hi', 'hindi');
						INSERT INTO languages (code, name) VALUES ('ja', 'japanese');
						INSERT INTO languages (code, name) VALUES ('pt', 'portuguese');
						INSERT INTO languages (code, name) VALUES ('ru', 'russian');
						INSERT INTO languages (code, name) VALUES ('sp', 'spanish');");

		$this->execute("CREATE TABLE settings_translations (
						  id int(10) unsigned NOT NULL AUTO_INCREMENT,
						  setting_id int(12) unsigned NOT NULL,
						  language_id tinyint(4) NOT NULL,
						  text_value text,
						  PRIMARY KEY (id),
						  KEY fk_settings_translations_setting_idx (setting_id),
						  KEY fk_settings_translations_language_idx (language_id),
						  CONSTRAINT fk_settings_translations_language FOREIGN KEY (language_id) REFERENCES languages (id) ON DELETE CASCADE,
						  CONSTRAINT fk_settings_translations_setting FOREIGN KEY (setting_id) REFERENCES settings (id) ON DELETE CASCADE
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("UPDATE settings SET value_type='T', string_value=NULL, text_value='Machinery Marketplace' WHERE id='1';
						UPDATE settings SET value_type='T', string_value=NULL, text_value='Join the first global marketplace for industrial machinery' WHERE id='2';
						UPDATE settings SET string_value=NULL WHERE id='10';
						UPDATE settings SET string_value=NULL WHERE id='3';
						UPDATE settings SET string_value=NULL WHERE id='4';");

		$this->execute("INSERT INTO settings_translations (setting_id, language_id, text_value)
						SELECT s.id, l.id, s.text_value
						  FROM settings AS s
						  JOIN languages AS l
						 WHERE s.value_type = 'T';");
	}

	public function down()
	{

	}
}