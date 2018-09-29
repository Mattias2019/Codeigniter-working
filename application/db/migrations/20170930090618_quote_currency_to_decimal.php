<?php

use Phinx\Migration\AbstractMigration;

class QuoteCurrencyToDecimal extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE quotes 
                CHANGE COLUMN amount amount DECIMAL (10,2) NOT NULL DEFAULT '0.00';
            
            ALTER TABLE quote_milestones 
                CHANGE COLUMN amount amount DECIMAL(10,2) NULL DEFAULT NULL ;

            ALTER TABLE quote_milestone_cost 
                CHANGE COLUMN amount amount DECIMAL(10,2) NOT NULL DEFAULT '0' ;

        ");
    }
}
