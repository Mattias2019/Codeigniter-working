<?php

use Phinx\Migration\AbstractMigration;

class AlterUserBalance extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE user_balance ENGINE = InnoDB;");
    }

    public function down()
    {

    }
}
