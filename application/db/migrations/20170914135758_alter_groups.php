<?php

use Phinx\Migration\AbstractMigration;

class AlterGroups extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE groups
                            ENGINE = InnoDB ,
                            CHANGE COLUMN id id BIGINT(20) NOT NULL AUTO_INCREMENT ,
                            CHANGE COLUMN created created BIGINT(20) NULL DEFAULT NULL ,
                            CHANGE COLUMN modified modified BIGINT(20) NULL DEFAULT NULL ;");
    }

    public function down()
    {

    }

}
