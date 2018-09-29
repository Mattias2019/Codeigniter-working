<?php

use Phinx\Migration\AbstractMigration;

class EmailMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO email_templates (type, title, mail_subject, mail_body)
						VALUES ('user_login', 'User Login', 'New sign-in from !browser on !os', 'Hello !username,

Your account !email was just used to sign in from !browser on !os.')");

		$this->execute("CREATE TABLE m_marketplace.email
						(
							id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
							mail_to VARCHAR(100) NOT NULL,
							mail_subject VARCHAR(500) NOT NULL,
							mail_body TEXT,
							time BIGINT(20) NOT NULL,
							sent TINYINT(1) DEFAULT 0 NOT NULL,
							error TEXT
						);");
	}

	public function down()
	{

	}
}