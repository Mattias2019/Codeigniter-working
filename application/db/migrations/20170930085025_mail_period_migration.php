<?php

use Phinx\Migration\AbstractMigration;

class MailPeriodMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE email ADD COLUMN period TINYINT(1) NOT NULL DEFAULT 0 AFTER time;");

        $this->execute("UPDATE users SET job_notify = '2' WHERE job_notify = 'Daily';
						UPDATE users SET job_notify = '1' WHERE job_notify = 'Hourly';
						UPDATE users SET job_notify = '0' WHERE job_notify NOT IN ('1','2') OR job_notify IS NULL;
						UPDATE users SET bid_notify = '2' WHERE bid_notify = 'Daily';
						UPDATE users SET bid_notify = '1' WHERE bid_notify = 'Hourly';
						UPDATE users SET bid_notify = '0' WHERE bid_notify NOT IN ('1','2') OR bid_notify IS NULL;
						UPDATE users SET message_notify = '2' WHERE message_notify = 'Daily';
						UPDATE users SET message_notify = '1' WHERE message_notify = 'Hourly';
						UPDATE users SET message_notify = '0' WHERE message_notify NOT IN ('1','2') OR message_notify IS NULL;");

		$this->execute("ALTER TABLE users
						CHANGE COLUMN job_notify job_notify TINYINT(1) NULL DEFAULT NULL,
						CHANGE COLUMN bid_notify bid_notify TINYINT(1) NULL DEFAULT NULL,
						CHANGE COLUMN message_notify message_notify TINYINT(1) NULL DEFAULT NULL;");

		$this->execute("ALTER TABLE email_templates ADD COLUMN period_type TINYINT(1) NOT NULL DEFAULT 0 AFTER mail_body;");

		$this->execute("UPDATE email_templates SET period_type='2' WHERE id='48';
						UPDATE email_templates SET period_type='2' WHERE id='49';
						UPDATE email_templates SET period_type='2' WHERE id='50';");
	}
}