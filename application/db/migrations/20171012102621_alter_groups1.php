<?php

use Phinx\Migration\AbstractMigration;

class AlterGroups1 extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE groups ENGINE = InnoDB ;");

        $this->execute("ALTER TABLE groups 
                            CHANGE COLUMN descritpion description TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL ;
        ");
    }
}
