<?php

use Phinx\Migration\AbstractMigration;

class AlterUsers extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE users
                            ENGINE = InnoDB ,
                            CHANGE COLUMN user_rating user_rating SMALLINT(2) NULL,
                            CHANGE COLUMN num_reviews num_reviews INT(11) NULL,
                            CHANGE COLUMN rating_hold rating_hold INT(11) NULL,
                            CHANGE COLUMN tot_rating tot_rating INT(11) NULL,
                            ADD COLUMN country_id INT(10) NULL AFTER login_status;");

        $this->execute("ALTER TABLE users 
                            CHANGE COLUMN country_id country_id INT(10) UNSIGNED NULL DEFAULT NULL;");

        $this->execute("ALTER TABLE users 
                            ADD INDEX fk_users_1_idx (country_id ASC);
                            
                            ALTER TABLE users 
                            ADD CONSTRAINT fk_users_1
                              FOREIGN KEY (country_id)
                              REFERENCES country (id)
                              ON DELETE NO ACTION
                              ON UPDATE NO ACTION;");

        $this->execute("ALTER TABLE roles 
                            CHANGE COLUMN id id INT(10) NOT NULL AUTO_INCREMENT;
                            
                            ALTER TABLE users 
                            CHANGE COLUMN role_id role_id INT(10) NOT NULL;");

        $this->execute("ALTER TABLE roles ENGINE = InnoDB;");

        $this->execute("ALTER TABLE users 
                            ADD CONSTRAINT fk_users_2
                              FOREIGN KEY (role_id)
                              REFERENCES roles (id)
                              ON DELETE NO ACTION
                              ON UPDATE NO ACTION;");

    }

    public function down()
    {

    }
}
