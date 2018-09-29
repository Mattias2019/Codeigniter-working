<?php

use Phinx\Migration\AbstractMigration;

class UserBank extends AbstractMigration
{

    protected $table = 'user_bank';

    public function up()
    {
        $this->execute("CREATE TABLE ".$this->table." (
						  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
						  swift_code VARCHAR(11) NOT NULL,
						  name VARCHAR(45) NOT NULL,
                          address VARCHAR(45) NOT NULL,
                          city VARCHAR(45) NOT NULL,
                          country_id INT(10) UNSIGNED NOT NULL,
                          currency_id INT(10) NOT NULL,
                          user_id BIGINT(20) UNSIGNED NOT NULL,                          
						  PRIMARY KEY (id),
						  
						  INDEX fk_ub_user_id_idx (user_id ASC),
						  INDEX fk_ub_country_id_idx (country_id ASC),
						  INDEX fk_ub_currency_id_idx (currency_id ASC),
						  
						  CONSTRAINT fk_ub_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
						  CONSTRAINT fk_ub_country_id FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE NO ACTION ON UPDATE CASCADE,
						  CONSTRAINT fk_ub_currency_id FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE NO ACTION ON UPDATE CASCADE
						  
						  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
