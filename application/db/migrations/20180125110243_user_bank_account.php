<?php

use Phinx\Migration\AbstractMigration;

class UserBankAccount extends AbstractMigration
{
    protected $table = 'user_bank_account';

    public function up()
    {
        $this->execute("CREATE TABLE ".$this->table." (
                            id BIGINT(20) UNSIGNED NOT NULL,
                            account_number VARCHAR(34) NOT NULL,
                            name_on_account VARCHAR(45) NOT NULL,
                            address VARCHAR(45) NOT NULL,
                            city VARCHAR(45) NOT NULL,
                            country_id INT(10) UNSIGNED NOT NULL,
                            bank_id BIGINT(20) UNSIGNED NOT NULL,
                            PRIMARY KEY (`id`),
                            INDEX `fk_uba_bank_id_idx` (`bank_id` ASC),
                            INDEX `fk_uba_country_id_idx` (`country_id` ASC),
                            CONSTRAINT fk_uba_bank_id
                                FOREIGN KEY (bank_id)
                                REFERENCES user_bank (id)
                                ON DELETE CASCADE
                                ON UPDATE CASCADE,
                            CONSTRAINT fk_uba_country_id
                                FOREIGN KEY (country_id)
                                REFERENCES country (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
                            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
