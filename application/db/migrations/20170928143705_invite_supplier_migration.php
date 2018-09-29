<?php

use Phinx\Migration\AbstractMigration;

class InviteSupplierMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('invite_supplier_to_project', 'Invite Machine Supplier', 'Machine Supplier Invitation', 'Hello !username,<br><br>!entrepreneur has invited you to participate in the project !project_name.<br>You can place your quote on project following this link:<br>!url');");
	}
}