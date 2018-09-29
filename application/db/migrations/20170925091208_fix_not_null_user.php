<?php

use Phinx\Migration\AbstractMigration;

class FixNotNullUser extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `users`
	ALTER `user_name` DROP DEFAULT,
	ALTER `first_name` DROP DEFAULT,
	ALTER `last_name` DROP DEFAULT;
        ");
        $this->execute("ALTER TABLE `users`
CHANGE COLUMN `user_name` `user_name` VARCHAR(128) NULL AFTER `refid`,
CHANGE COLUMN `first_name` `first_name` VARCHAR(128) NULL AFTER `user_name`,
CHANGE COLUMN `last_name` `last_name` VARCHAR(128) NULL AFTER `first_name`;
        ");
    }


    public function down()
    {

    }
}
