<?php

use Phinx\Migration\AbstractMigration;

class TeamGroupMemberIndex extends AbstractMigration
{
    public function up()
    {
        $this->execute("
          ALTER TABLE team_members ADD UNIQUE INDEX group_id_user_id_UNIQUE (group_id ASC, user_id ASC);
        ");

    }
}
