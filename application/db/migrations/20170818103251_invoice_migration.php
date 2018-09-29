<?php

use Phinx\Migration\AbstractMigration;

class InvoiceMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO payment_methods VALUES ('2', 'wire', 'Wire Transfer', 'Wire Transfer', '1', '1', '0', '0', '', '', '0', '0', '0');");

		$this->execute("CREATE TABLE invoice (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  job_id bigint(20) unsigned NOT NULL,
						  milestone_id bigint(20) unsigned DEFAULT NULL,
						  sender_id bigint(20) unsigned NOT NULL,
						  reciever_id bigint(20) unsigned NOT NULL,
						  amount decimal(10,2) NOT NULL DEFAULT '0.00',
						  vat_percent tinyint(3) NOT NULL DEFAULT '0',
						  discount_percent tinyint(3) NOT NULL DEFAULT '0',
						  billing_date bigint(20) NOT NULL,
						  remarks text,
						  PRIMARY KEY (id),
						  UNIQUE KEY uk_invoice (job_id,milestone_id),
						  KEY fk_invoice_milestone_idx (milestone_id),
						  KEY fk_invoice_sender_idx (sender_id),
						  KEY fk_invoice_reciever_idx (reciever_id),
						  CONSTRAINT fk_invoice_job FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_invoice_milestone FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_invoice_reciever FOREIGN KEY (reciever_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_invoice_sender FOREIGN KEY (sender_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}
}
