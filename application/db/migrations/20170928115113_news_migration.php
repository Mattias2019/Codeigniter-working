<?php

use Phinx\Migration\AbstractMigration;

class NewsMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE news (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  title varchar(128) NOT NULL,
						  body text NOT NULL,
						  time bigint(20) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		for ($i = 0; $i < 20; $i++)
		{
			$this->execute("INSERT INTO news (title, body, time) VALUES ('News title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', unix_timestamp());");
		}
	}
}
