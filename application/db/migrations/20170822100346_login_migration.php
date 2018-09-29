<?php

use Phinx\Migration\AbstractMigration;

class LoginMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE login_failure_reason (
						  id tinyint(4) NOT NULL,
						  name varchar(50) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO login_failure_reason VALUES ('0', 'Wrong username');
						INSERT INTO login_failure_reason VALUES ('1', 'Wrong password');
						INSERT INTO login_failure_reason VALUES ('2', 'Wrong captcha');
						INSERT INTO login_failure_reason VALUES ('3', 'User is inactive');
						INSERT INTO login_failure_reason VALUES ('4', 'User is banned');
						INSERT INTO login_failure_reason VALUES ('5', 'Incorrect \'Remember me\' token');");

		$this->execute("CREATE TABLE user_logins (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  user_name varchar(128) DEFAULT NULL,
						  time bigint(20) NOT NULL,
						  success tinyint(1) NOT NULL DEFAULT '0',
						  failure_reason tinyint(4) DEFAULT NULL,
						  user_agent varchar(200) DEFAULT NULL,
						  ip varchar(200) DEFAULT NULL,
						  PRIMARY KEY (id),
						  KEY fk_user_logins_reason_idx (failure_reason),
						  CONSTRAINT fk_user_logins_reason FOREIGN KEY (failure_reason) REFERENCES login_failure_reason (id) ON DELETE NO ACTION ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("DELETE FROM users WHERE user_name IS NULL OR user_name = '';");

		$this->execute("ALTER TABLE users 
						CHANGE COLUMN user_name user_name VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
						ADD COLUMN login_series VARCHAR(128) NULL,
						ADD COLUMN login_token VARCHAR(128) NULL,
						ADD UNIQUE INDEX user_name_UNIQUE (user_name ASC);");
	}

	public function down()
	{

	}
}
