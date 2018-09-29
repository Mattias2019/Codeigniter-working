<?php

use Phinx\Migration\AbstractMigration;

class JobDeleteCategories extends AbstractMigration
{
   
    public function up()
    {
        $this->execute('ALTER TABLE jobs DROP COLUMN job_categories_encrypt, DROP COLUMN job_categories;');

        $this->execute('
            delete from jobs 
            where creator_id not in (select id from users);
            
            update jobs set employee_id = NULL 
            where employee_id not in (select id from users) and job_status in (0, 1, 2, 3, 8);
            
            delete from jobs where employee_id not in (select id from users);

            ALTER TABLE jobs 
                ADD CONSTRAINT fk_jobs_creator
                  FOREIGN KEY (creator_id)
                  REFERENCES users (id)
                  ON DELETE CASCADE
                  ON UPDATE CASCADE;
              
              ALTER TABLE jobs 
                ADD CONSTRAINT fk_jobs_employee
                  FOREIGN KEY (employee_id)
                  REFERENCES users (id)
                  ON DELETE SET NULL
                  ON UPDATE CASCADE;

        ');
    }
    
}
