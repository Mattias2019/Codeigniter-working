<?php

use Phinx\Migration\AbstractMigration;

class PackageMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE packages ENGINE = InnoDB;
						ALTER TABLE packages CHANGE COLUMN amount amount DECIMAL(10,2) NOT NULL ;");

		$this->execute("DELETE FROM subscriptionuser
						 WHERE NOT EXISTS (SELECT 1 FROM packages WHERE packages.id = subscriptionuser.package_id)
							OR NOT EXISTS (SELECT 1 FROM users WHERE users.id = subscriptionuser.user_id)");

		$this->execute("ALTER TABLE subscriptionuser ENGINE = InnoDB ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN package_id package_id INT(11) NOT NULL ;
						ALTER TABLE subscriptionuser 
						ADD INDEX fk_subscriptionuser_user_idx (user_id ASC),
						ADD INDEX fk_subscriptionuser_package_idx (package_id ASC);
						ALTER TABLE subscriptionuser 
						ADD CONSTRAINT fk_subscriptionuser_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_subscriptionuser_package
						  FOREIGN KEY (package_id)
						  REFERENCES packages (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("ALTER TABLE transactions 
						CHANGE COLUMN package_id package_id INT(11) NULL DEFAULT NULL ,
						ADD INDEX fk_transactions_package_idx (package_id ASC);
						ALTER TABLE transactions 
						ADD CONSTRAINT fk_transactions_package
						  FOREIGN KEY (package_id)
						  REFERENCES packages (id)
						  ON DELETE SET NULL
						  ON UPDATE NO ACTION;");

		$this->execute("INSERT INTO transaction_type VALUES ('7', 'Package Subscription');");
	}

	public function down()
	{

	}
}