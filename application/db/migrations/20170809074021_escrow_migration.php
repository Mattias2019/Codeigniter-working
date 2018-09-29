<?php

use Phinx\Migration\AbstractMigration;

class EscrowMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE escrow_fee (
						  id tinyint(4) NOT NULL AUTO_INCREMENT,
						  min_amount decimal(10,0) NOT NULL,
						  fee_flat decimal(10,0) DEFAULT NULL,
						  fee_percent decimal(5,2) DEFAULT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO escrow_fee (min_amount, fee_flat) VALUES ('0', '250');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('1000', '25');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('500000', '4');
						INSERT INTO escrow_fee (min_amount, fee_percent) VALUES ('1000000', '2.95');");

		$this->execute("CREATE TABLE escrow_release_status (
						  id tinyint(4) NOT NULL,
						  name varchar(50) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO escrow_release_status VALUES ('1', 'Release');
						INSERT INTO escrow_release_status VALUES ('2', 'Cancel');");

		$this->execute("update escrow_release_request set status = 
						(select id from escrow_release_status where escrow_release_request.status = escrow_release_status.name);");

		$this->execute("ALTER TABLE escrow_release_request 
						ENGINE = InnoDB ,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN transaction_id transaction_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN request_date request_date BIGINT(20) NOT NULL ,
						CHANGE COLUMN status status TINYINT(4) NOT NULL ,
						ADD INDEX fk_escrow_release_request_transaction_idx (transaction_id ASC),
						ADD INDEX fk_escrow_release_request_status_idx (status ASC);
						ALTER TABLE escrow_release_request 
						ADD CONSTRAINT fk_escrow_release_request_transaction
						  FOREIGN KEY (transaction_id)
						  REFERENCES transactions (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_escrow_release_request_status
						  FOREIGN KEY (status)
						  REFERENCES escrow_release_status (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}