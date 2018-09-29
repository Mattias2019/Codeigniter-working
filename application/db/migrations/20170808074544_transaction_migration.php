<?php

use Phinx\Migration\AbstractMigration;

class TransactionMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE transaction_type (
						  id tinyint(4) NOT NULL,
						  name varchar(45) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO transaction_type VALUES ('0', 'Deposit');
						INSERT INTO transaction_type VALUES ('1', 'Project Fee');
						INSERT INTO transaction_type VALUES ('2', 'Escrow Transfer');
						INSERT INTO transaction_type VALUES ('3', 'Transfer');
						INSERT INTO transaction_type VALUES ('4', 'Withdraw');");

		$this->execute("update transactions 
						   set type = (select id from transaction_type where transaction_type.name = transactions.type)
						 where type not in ('0', '1', '2', '3', '4');");

		$this->execute("CREATE TABLE transaction_status (
						  id tinyint(4) NOT NULL,
						  name varchar(45) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO transaction_status VALUES ('0', 'Pending');
						INSERT INTO transaction_status VALUES ('1', 'Success');
						INSERT INTO transaction_status VALUES ('2', 'Failure');");

		$this->execute("update transactions set status = 0 where status in ('Pending');
						update transactions set status = 1 where status in ('Completed', 'success');");

		$this->execute("ALTER TABLE payments ENGINE = InnoDB, RENAME TO payment_methods;");

		$this->execute("ALTER TABLE transactions 
						ENGINE = InnoDB ,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN type type TINYINT(4) NOT NULL ,
						CHANGE COLUMN status status TINYINT(4) NOT NULL ,
						ADD COLUMN payment_method TINYINT(4) UNSIGNED NULL AFTER type,
						ADD INDEX fk_transactions_type_idx (type ASC),
						ADD INDEX fk_transactions_status_idx (status ASC),
						ADD INDEX fk_transactions_method_idx (payment_method ASC);
						ALTER TABLE transactions 
						ADD CONSTRAINT fk_transactions_type
						  FOREIGN KEY (type)
						  REFERENCES transaction_type (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_transactions_status
						  FOREIGN KEY (status)
						  REFERENCES transaction_status (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_transactions_method
						  FOREIGN KEY (payment_method)
						  REFERENCES payment_methods (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");

		$this->execute("update transactions set reciever_id = 0 where reciever_id = '';
						update transactions set job_id = 0 where job_id = '';");

		$this->execute("ALTER TABLE transactions 
						DROP COLUMN user_type,
						DROP COLUMN employee_id,
						DROP COLUMN owner_id,
						CHANGE COLUMN creator_id sender_id BIGINT(20) UNSIGNED NULL ,
						CHANGE COLUMN reciever_id reciever_id BIGINT(20) UNSIGNED NULL AFTER sender_id,
						CHANGE COLUMN job_id job_id BIGINT(20) UNSIGNED NULL AFTER reciever_id,
						CHANGE COLUMN amount amount DECIMAL NOT NULL AFTER job_id,
						CHANGE COLUMN transaction_time transaction_time BIGINT(20) NOT NULL ,
						CHANGE COLUMN description description TEXT CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN paypal_address paypal_address VARCHAR(256) NULL ,
						CHANGE COLUMN package_id package_id SMALLINT(6) NULL ,
						CHANGE COLUMN update_flag update_flag TINYINT(14) NULL ,
						ADD COLUMN milestone_id BIGINT(20) UNSIGNED NULL AFTER job_id;");

		$this->execute("update transactions set reciever_id = NULL where reciever_id = 0;
						update transactions set job_id = NULL;");

		$this->execute("delete from user_balance where not exists (select 1 from users where user_balance.user_id = users.id);");

		$this->execute("ALTER TABLE user_balance 
						ENGINE = InnoDB ,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN amount amount DECIMAL(10,2) NOT NULL DEFAULT '0' ,
						ADD UNIQUE INDEX user_id_UNIQUE (user_id ASC) ;
						ALTER TABLE user_balance 
						ADD CONSTRAINT fk_user_balance_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("ALTER TABLE transactions 
						ADD INDEX fk_transactions_sender_idx (sender_id ASC),
						ADD INDEX fk_transactions_reciever_idx (reciever_id ASC),
						ADD INDEX fk_transactions_job_idx (job_id ASC),
						ADD INDEX fk_transactions_milestone_idx (milestone_id ASC);
						ALTER TABLE transactions 
						ADD CONSTRAINT fk_transactions_sender
						  FOREIGN KEY (sender_id)
						  REFERENCES user_balance (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_transactions_reciever
						  FOREIGN KEY (reciever_id)
						  REFERENCES user_balance (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_transactions_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_transactions_milestone
						  FOREIGN KEY (milestone_id)
						  REFERENCES milestones (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}