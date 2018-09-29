<?php

use Phinx\Migration\AbstractMigration;

class TransactionItemMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE transaction_item_direction (
						  id tinyint(4) NOT NULL,
						  name varchar(50) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO transaction_item_direction VALUES ('1', 'Debit');
						INSERT INTO transaction_item_direction VALUES ('2', 'Credit');");

		$this->execute("CREATE TABLE transaction_items (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  transaction_id bigint(20) unsigned NOT NULL,
						  account_id bigint(20) unsigned NOT NULL,
						  direction tinyint(4) NOT NULL,
						  amount decimal(10,2) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_transaction_items_transaction_idx (transaction_id),
						  KEY fk_transaction_items_account_idx (account_id),
						  KEY fk_transaction_items_direction_idx (direction),
						  CONSTRAINT fk_transaction_items_account FOREIGN KEY (account_id) REFERENCES user_balance (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
						  CONSTRAINT fk_transaction_items_direction FOREIGN KEY (direction) REFERENCES transaction_item_direction (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
						  CONSTRAINT fk_transaction_items_transaction FOREIGN KEY (transaction_id) REFERENCES transactions (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("delete from escrow_release_request;
						delete from transactions;");

		$this->execute("ALTER TABLE transactions 
						DROP FOREIGN KEY fk_transactions_sender,
						DROP FOREIGN KEY fk_transactions_reciever;
						ALTER TABLE transactions 
						DROP COLUMN amount,
						DROP COLUMN reciever_id,
						DROP COLUMN sender_id,
						DROP INDEX fk_transactions_sender_idx ,
						DROP INDEX fk_transactions_reciever_idx ;");

		$this->execute("UPDATE transaction_type SET name='Escrow Request' WHERE id='4';
						UPDATE transaction_type SET name='Withdraw' WHERE id='1';
						UPDATE transaction_type SET name='Project Fee' WHERE id='2';
						INSERT INTO transaction_type VALUES ('5', 'Escrow Release');
						INSERT INTO transaction_type VALUES ('6', 'Escrow Cancel');");

		$this->execute("ALTER TABLE user_balance 
						DROP FOREIGN KEY fk_user_balance_user;
						ALTER TABLE user_balance 
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NULL ,
						ADD COLUMN internal_account_escrow TINYINT(1) NOT NULL DEFAULT 0 AFTER amount,
						ADD COLUMN internal_account_fee TINYINT(1) NOT NULL DEFAULT 0 AFTER internal_account_escrow;
						ALTER TABLE user_balance 
						ADD CONSTRAINT fk_user_balance_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("INSERT INTO user_balance (internal_account_escrow) VALUES ('1');
						INSERT INTO user_balance (internal_account_fee) VALUES ('1');");

		$this->execute("DROP TABLE escrow_release_request;
						DROP TABLE escrow_release_status;");
	}

	public function down()
	{

	}
}
