<?php

use Phinx\Migration\AbstractMigration;

class FixUserBalanceKey extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `user_balance`
	DROP FOREIGN KEY `fk_user_balance_user`;");
        $this->execute("ALTER TABLE `user_balance`
	ADD CONSTRAINT `fk_user_balance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;");

    }
}
