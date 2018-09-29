<?php

use Phinx\Migration\AbstractMigration;

class FixTeamMembers extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `team_members`
	DROP INDEX `user_id_UNIQUE`,
	ADD INDEX `user_id_UNIQUE` (`user_id`);
        ");

    }


    public function down()
    {
        $this->execute("ALTER TABLE `team_members`
	DROP INDEX `user_id_UNIQUE`,
	ADD UNIQUE INDEX `user_id_UNIQUE` (`user_id`);
        ");
    }
}
