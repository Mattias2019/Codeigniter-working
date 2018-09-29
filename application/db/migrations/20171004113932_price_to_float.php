<?php

use Phinx\Migration\AbstractMigration;

class PriceToFloat extends AbstractMigration
{

    public function up()
    {
        $this->execute("
          ALTER TABLE quote_milestone_cost CHANGE COLUMN price price DECIMAL(10,2) NOT NULL DEFAULT '0' ;
        ");

    }
}
