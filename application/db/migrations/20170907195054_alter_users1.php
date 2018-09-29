<?php

use Phinx\Migration\AbstractMigration;

class AlterUsers1 extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE users
                            CHANGE COLUMN company_address company_address VARCHAR(255) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN vat_id vat_id VARCHAR(128) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN language language VARCHAR(250) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN activation_key activation_key VARCHAR(32) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN country_symbol country_symbol CHAR(2) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN zip_code zip_code VARCHAR(64) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN message_notify message_notify CHAR(10) CHARACTER SET 'utf8' NULL ,
                            CHANGE COLUMN last_activity last_activity INT(11) NULL ,
                            CHANGE COLUMN team_owner team_owner INT(11) NULL;
						");
    }

    public function down()
    {

    }

}
