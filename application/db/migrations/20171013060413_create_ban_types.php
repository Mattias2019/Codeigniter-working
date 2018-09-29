<?php

use Phinx\Migration\AbstractMigration;

class CreateBanTypes extends AbstractMigration
{
    public function up()
    {
        $this->execute("CREATE TABLE ban_types (
                            id BIGINT(20) NOT NULL AUTO_INCREMENT,
                            type VARCHAR(255) NOT NULL,
                            PRIMARY KEY (id));"
        );

        $this->execute("ALTER TABLE bans
                            CHANGE COLUMN ban_type ban_type BIGINT(20) NOT NULL;"
        );

        $this->execute("ALTER TABLE bans
                            ADD INDEX fk_bans_1_idx (ban_type ASC);
                            ALTER TABLE bans
                            ADD CONSTRAINT fk_bans_1
                              FOREIGN KEY (ban_type)
                              REFERENCES ban_types (id)
                              ON DELETE CASCADE
                              ON UPDATE NO ACTION;"
        );

        $this->execute("INSERT INTO ban_types (type) VALUES ('EMAIL');
                            INSERT INTO ban_types (type) VALUES ('USERNAME');"
        );

        $this->execute("ALTER TABLE bans 
                            DROP FOREIGN KEY fk_bans_1;
                            ALTER TABLE bans 
                            CHANGE COLUMN ban_type ban_type_id BIGINT(20) NOT NULL ;
                            ALTER TABLE bans 
                            ADD CONSTRAINT fk_bans_1
                              FOREIGN KEY (ban_type_id)
                              REFERENCES ban_types (id)
                              ON DELETE CASCADE
                              ON UPDATE NO ACTION;"
        );

    }
}
