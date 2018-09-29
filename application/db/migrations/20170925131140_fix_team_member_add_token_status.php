<?php

use Phinx\Migration\AbstractMigration;

class FixTeamMemberAddTokenStatus extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `team_members`
	ADD COLUMN `status` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `team_leader_id`,
	ADD COLUMN `token` TEXT NULL AFTER `status`;");

    }
}
