<?php

use Phinx\Migration\AbstractMigration;

class FinanceEmailMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO email_templates (type, title, mail_subject, mail_body, period_type) VALUES ('deposit', 'Deposit', 'New deposit transaction', 'Hello !username,<br><br>You have successfully deposited money to you !site_name account.<br><br>Amount deposited: !amount<br>Your account balance: !balance<br><br>You can review your deposit transactions following this link:<br>!url', '0');");
	}
}