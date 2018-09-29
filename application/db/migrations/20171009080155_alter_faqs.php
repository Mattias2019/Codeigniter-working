<?php

use Phinx\Migration\AbstractMigration;

class AlterFaqs extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE faqs 
                              ADD INDEX fk_faqs_1_idx (faq_category_id ASC);
                            ALTER TABLE faqs 
                              ADD CONSTRAINT fk_faqs_1
                                FOREIGN KEY (faq_category_id)
                                REFERENCES faq_categories (id)
                                ON DELETE CASCADE
                                ON UPDATE RESTRICT;");
    }
}
