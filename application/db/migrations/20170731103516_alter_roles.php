<?php

use Phinx\Migration\AbstractMigration;

class AlterRoles extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE roles
                            ADD COLUMN label_color VARCHAR(255) NOT NULL AFTER role_name;");

        $this->execute("update roles
                               set label_color = 'default'
                             where role_name = 'entrepreneur';");

        $this->execute("update roles
                               set label_color = 'info'
                             where role_name = 'provider';");

        $this->execute("update roles
                               set label_color = 'success'
                             where role_name = 'admin';");
    }

    public function down()
    {

    }
}
