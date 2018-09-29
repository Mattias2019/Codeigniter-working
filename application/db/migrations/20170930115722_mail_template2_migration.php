<?php

use Phinx\Migration\AbstractMigration;

class MailTemplate2Migration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('quote_accepted', 'Quote Accepted', 'Your quote on !project was accepted', 'Hello !username,<br><br>Your quote on !project has been accepted.<br>You can view quotes won by you following this link:<br>!url', '2');
						INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('project_started', 'Project Started', 'Project !project has started', 'Hello !username,<br><br>!provider has started working on project !project.<br>You can view project details following this link:<br>!url', '1');
						INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('quote_declined', 'Quote Declined', 'Declined quote on !project', 'Hello !username,<br><br>!provider has declined your offer on project !project.', '2');
						INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('project_completed', 'Project Completed', 'Project !project has been completed', 'Hello !username,<br><br>Project !project has been successfully completed.<br>You can review your completed projects following this link:<br>!url', '2');
						INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('project_canceled', 'Project Canceled', 'Project !project has been canceled', 'Hello !username,<br><br>Project !project has been canceled.<br>You can review your canceled projects following this link:<br>!url', '2');");
	}
}