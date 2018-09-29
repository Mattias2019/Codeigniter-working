<?php

use Phinx\Migration\AbstractMigration;

class DropTables extends AbstractMigration
{
    public function up()
    {
        $this->execute("drop table admins;");
    }

    public function down()
    {

    }
}
