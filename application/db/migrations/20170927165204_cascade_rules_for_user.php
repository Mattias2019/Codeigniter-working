<?php

use Phinx\Migration\AbstractMigration;

class CascadeRulesForUser extends AbstractMigration
{
    public function up()
    {
        $this->execute("
           
           ALTER TABLE user_categories 
                DROP FOREIGN KEY fk_user_categories_user;
                ALTER TABLE user_categories 
                ADD CONSTRAINT fk_user_categories_user
                  FOREIGN KEY (user_id)
                  REFERENCES users (id)
                  ON DELETE CASCADE
                  ON UPDATE RESTRICT;
           
           ALTER TABLE team_groups 
                DROP FOREIGN KEY fk_team_groups_leader;
                ALTER TABLE team_groups 
                ADD CONSTRAINT fk_team_groups_leader
                  FOREIGN KEY (team_leader_id)
                  REFERENCES users (id)
                  ON DELETE CASCADE
                  ON UPDATE RESTRICT;

            ALTER TABLE team_members 
                DROP FOREIGN KEY fk_team_members_leader;
                ALTER TABLE team_members 
                ADD CONSTRAINT fk_team_members_leader
                  FOREIGN KEY (team_leader_id)
                  REFERENCES users (id)
                  ON DELETE CASCADE
                  ON UPDATE RESTRICT;

        ");
    }
}
