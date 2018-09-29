<?php

use Phinx\Migration\AbstractMigration;

class TeamMemberGorupKey extends AbstractMigration
{
    public function up()
    {
            $this->execute("ALTER TABLE `team_members`
	ALTER `group_id` DROP DEFAULT;");
            $this->execute("ALTER TABLE `team_members`
	CHANGE COLUMN `group_id` `group_id` BIGINT(20) UNSIGNED NOT NULL AFTER `token`;");
            $this->execute(" ALTER TABLE `team_members`
	ADD INDEX `group_id` (`group_id`);");
            $this->execute("ALTER TABLE `team_members`
	ADD CONSTRAINT `FK_team_members_team_groups` FOREIGN KEY (`group_id`) REFERENCES `team_groups` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;");

    }
}
