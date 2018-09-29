<?php

use Phinx\Migration\AbstractMigration;

class AlterCategories extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE categories 
                            CHANGE COLUMN group_id group_id BIGINT(20) NOT NULL,
                            CHANGE COLUMN created created BIGINT(20) NOT NULL,
                            CHANGE COLUMN modified modified BIGINT(20) NOT NULL;");

        $this->execute("ALTER TABLE categories 
                            ADD INDEX fk_categories_1_idx (group_id ASC);
                            ALTER TABLE m_marketplace.categories 
                            ADD CONSTRAINT fk_categories_1
                              FOREIGN KEY (group_id)
                              REFERENCES m_marketplace.groups (id)
                              ON DELETE CASCADE
                              ON UPDATE CASCADE;");
    }

    public function down()
    {

    }
}
