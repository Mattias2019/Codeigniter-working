<?php

use Phinx\Migration\AbstractMigration;

class TeamMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE team_groups (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  team_leader_id bigint(20) unsigned NOT NULL,
						  group_name varchar(50) NOT NULL,
						  admin tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - no / 1 - admin',
						  quotes tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - no / 1 - edit own / 2 - edit all',
						  projects tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - no / 1 - view assigned / 2 - view all',
						  portfolio tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - no / 1 - view / 2 - edit own / 3 - edit all',
						  PRIMARY KEY (id),
						  KEY fk_team_groups_leader_idx (team_leader_id),
						  CONSTRAINT fk_team_groups_leader FOREIGN KEY (team_leader_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("ALTER TABLE team_members 
						ENGINE = InnoDB ,
						DROP COLUMN password,
						DROP COLUMN email_address,
						CHANGE COLUMN team_owner_id team_leader_id BIGINT(20) UNSIGNED NOT NULL AFTER user_id,
						CHANGE COLUMN team_member_id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN group_permission_id group_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN telephone telephone VARCHAR(50) NULL ;");

		$this->execute("delete from team_members;");

		$this->execute("ALTER TABLE team_members 
						ADD UNIQUE INDEX user_id_UNIQUE (user_id ASC);
						ADD INDEX fk_team_members_user_idx (user_id ASC),
						ADD INDEX fk_team_members_leader_idx (team_leader_id ASC),
						ADD INDEX fk_team_members_group_idx (group_id ASC);
						ALTER TABLE team_members 
						ADD CONSTRAINT fk_team_members_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_team_members_leader
						  FOREIGN KEY (team_leader_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_team_members_group
						  FOREIGN KEY (group_id)
						  REFERENCES team_groups (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}