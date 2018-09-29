<?php

use Phinx\Migration\AbstractMigration;

class TeamGroupOrderActoins2 extends AbstractMigration
{
    public function up()
    {
        $this->execute("

                ALTER TABLE team_groups 
                CHANGE COLUMN quotes quotes_create TINYINT(1) NOT NULL DEFAULT '1',
                ADD COLUMN quotes_edit_all TINYINT(1) NOT NULL DEFAULT '0' AFTER quotes_create,
                ADD COLUMN quotes_edit_own TINYINT(1) NOT NULL DEFAULT '0' AFTER quotes_edit_all;

                ALTER TABLE team_groups 
                CHANGE COLUMN projects projects_all TINYINT(1) NOT NULL DEFAULT '0',
                ADD COLUMN projects_assigned TINYINT(1) NULL AFTER projects_all,
                ADD COLUMN projects_own TINYINT(1) NULL AFTER projects_assigned;

                ALTER TABLE team_groups 
                CHANGE COLUMN portfolio portfolio_create TINYINT(1) NOT NULL DEFAULT '0',
                ADD COLUMN portfolio_edit_all TINYINT(1) NULL AFTER portfolio_create,
                ADD COLUMN portfolio_edit_own TINYINT(1) NULL AFTER portfolio_edit_all,
                ADD COLUMN portfolio_view TINYINT(1) NULL AFTER portfolio_edit_own;

                INSERT INTO roles (role_name, label_color) VALUES ('entrepreneur_owner', 'default');
                INSERT INTO roles (role_name, label_color) VALUES ('provider_owner', 'info');

        ");
    }

    public function down()
    {

    }
}
