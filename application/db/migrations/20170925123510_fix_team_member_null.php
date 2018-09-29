<?php

use Phinx\Migration\AbstractMigration;

class FixTeamMemberNull extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `team_members`
	ALTER `group_id` DROP DEFAULT,
	ALTER `job_title` DROP DEFAULT;");
        $this->execute("ALTER TABLE `team_members`
	CHANGE COLUMN `group_id` `group_id` BIGINT(20) UNSIGNED NULL AFTER `team_leader_id`,
	CHANGE COLUMN `job_title` `job_title` VARCHAR(150) NULL COLLATE 'latin1_swedish_ci' AFTER `group_id`;");

    }


    public function down()
    {
        $this->execute("ALTER TABLE `team_members`
	ALTER `group_id` DROP DEFAULT,
	ALTER `job_title` DROP DEFAULT;
        ");
        $this->execute("ALTER TABLE `team_members`
	CHANGE COLUMN `group_id` `group_id` BIGINT(20) UNSIGNED NOT NULL AFTER `team_leader_id`,
	CHANGE COLUMN `job_title` `job_title` VARCHAR(150) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `group_id`;");
    }
}
