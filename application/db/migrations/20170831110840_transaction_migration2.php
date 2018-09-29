<?php

use Phinx\Migration\AbstractMigration;

class TransactionMigration2 extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE m_marketplace.transactions ADD creator_id BIGINT(20) UNSIGNED NULL;
						ALTER TABLE m_marketplace.transactions ADD closing_id BIGINT(20) UNSIGNED NULL;
						ALTER TABLE m_marketplace.transactions ADD closing_date BIGINT(20) NULL;
						CREATE INDEX fk_transactions_creator_index ON m_marketplace.transactions (creator_id);
						CREATE INDEX fk_transactions_closing_index ON m_marketplace.transactions (closing_id);
						ALTER TABLE m_marketplace.transactions
						ADD CONSTRAINT fk_transactions_creator_fk
						FOREIGN KEY (creator_id) REFERENCES users (id);
						ALTER TABLE m_marketplace.transactions
						ADD CONSTRAINT fk_transactions_closing_fk
						FOREIGN KEY (closing_id) REFERENCES users (id);");
	}

	public function down()
	{

	}
}
