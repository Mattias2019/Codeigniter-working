<?php

use Phinx\Migration\AbstractMigration;

class PaypalMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE payment_methods DROP url;
						ALTER TABLE payment_methods DROP mail_id;");

		$this->execute("CREATE TABLE payment_method_credentials (
						  id tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
						  payment_method_id tinyint(4) unsigned NOT NULL,
						  credential_key varchar(32) NOT NULL,
						  credential_name varchar(128) NOT NULL,
						  credential_value varchar(128) DEFAULT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY payment_method_credentials_UNIQUE (payment_method_id,credential_key),
						  KEY fk_payment_method_credentials_method_idx (payment_method_id),
						  CONSTRAINT fk_payment_method_credentials_method FOREIGN KEY (payment_method_id) REFERENCES payment_methods (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("INSERT INTO payment_method_credentials (payment_method_id, credential_key, credential_name, credential_value) VALUES ('1', 'mail', 'Email', 'alexey.nekrasov1-facilitator@gmail.com');
						INSERT INTO payment_method_credentials (payment_method_id, credential_key, credential_name, credential_value) VALUES ('1', 'api_username', 'API username', 'alexey.nekrasov1-facilitator_api2.gmail.com');
						INSERT INTO payment_method_credentials (payment_method_id, credential_key, credential_name, credential_value) VALUES ('1', 'api_password', 'API password', 'AEAUTU9ZHSL72AKK');
						INSERT INTO payment_method_credentials (payment_method_id, credential_key, credential_name, credential_value) VALUES ('1', 'api_signature', 'API signature', 'AFcWxV21C7fd0v3bYYYRCpSSRl31Ayy0e9Ok7cDHwfvXwx1D7OMyb4w2');");
	}
}