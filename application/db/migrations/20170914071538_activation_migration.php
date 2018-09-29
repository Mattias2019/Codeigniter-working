<?php

use Phinx\Migration\AbstractMigration;

class ActivationMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE m_marketplace.users MODIFY activation_key VARCHAR(32);");

		$this->execute("UPDATE users SET activation_key = NULL;");

		$this->execute("INSERT INTO email_templates (type, title, mail_subject, mail_body)
						VALUES ('forgot_password', 'Password Restoration', 'Password restoration for !site_title', 'Hello !username,

To change your password, follow link:
!url

If you did not request to change your password, please notify our support team at !contact_url and delete this letter.')");
	}

	public function down()
	{

	}
}