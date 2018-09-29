<?php

use Phinx\Migration\AbstractMigration;

class InsertRoles extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE roles 
                            ADD UNIQUE INDEX role_name_UNIQUE (role_name ASC);
        ");

        $this->execute("insert into roles(role_name, label_color)
                                       values('admin', 'success');
        ");
    }

    public function down()
    {

    }
}
