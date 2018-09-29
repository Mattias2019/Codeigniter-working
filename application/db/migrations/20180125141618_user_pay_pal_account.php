<?php

use Phinx\Migration\AbstractMigration;

class UserPayPalAccount extends AbstractMigration
{
    protected $table = 'user_paypal_account';

    public function up()
    {
        $this->execute("CREATE TABLE ".$this->table." (
						  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                          email VARCHAR(45) NOT NULL,
						  user_id BIGINT(20) UNSIGNED NOT NULL,                          
						  PRIMARY KEY (id),
						  INDEX fk_upa_user_id_idx (user_id ASC),
						  CONSTRAINT fk_upa_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
						  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
