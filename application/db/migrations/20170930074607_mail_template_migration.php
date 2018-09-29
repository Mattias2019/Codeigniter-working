<?php

use Phinx\Migration\AbstractMigration;

class MailTemplateMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("UPDATE email_templates SET title='Invite Team Member', mail_subject='Team Member Invitation' WHERE id='45';
						UPDATE email_templates SET title='Invite Machine Supplier to Project' WHERE id='46';
						INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('quote_request', 'Quote Request', 'Quote Request on !machinery_title', 'Hello !username,<br><br>\n!entrepreneur has requested a quote on !machinery_title.<br>\nYou can place your quote following this link:<br>\n!url');
						INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('quote_placed', 'Quote Placed', 'Quote Placed on !project', 'Hello !username,<br><br>\n!user has placed a quote on !project.<br>\nYou can revise a quote following this link:<br>\n!url');
						INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('quote_revised', 'Quote Revised', 'Quote Revised on !project', 'Hello !username,<br><br>\n!user has revised a quote on !project.<br>\nYou can revise a quote following this link:<br>\n!url');
						INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('quote_lower', 'Lower Quote Placed', 'Quote Lower than Yours Placed on !project', 'Hello !username,<br><br>\nA quote lower than yours was placed on !project.');");
	}
}