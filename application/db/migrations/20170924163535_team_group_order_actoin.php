<?php

use Phinx\Migration\AbstractMigration;

class TeamGroupOrderActoin extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE team_groups 
                ADD COLUMN position INT NULL AFTER portfolio,
                ADD COLUMN is_locked INT(1) NOT NULL DEFAULT 0 AFTER position,
                ADD INDEX idx_team_position (team_leader_id ASC, position ASC);
        ");
    }

    public function down()
    {

    }
}
