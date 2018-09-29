<?php

use Phinx\Migration\AbstractMigration;

class FeedbackType extends AbstractMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE feedback_type (
                    feedback_type_id TINYINT(4) NOT NULL,
                    feedback_type_name VARCHAR(255) NOT NULL,
                    PRIMARY KEY (feedback_type_id));"
        );

        $this->execute(
            "INSERT INTO feedback_type (feedback_type_id, feedback_type_name) VALUES ('1', 'Suggestion');
                 INSERT INTO feedback_type (feedback_type_id, feedback_type_name) VALUES ('2', 'Missing Function');
                 INSERT INTO feedback_type (feedback_type_id, feedback_type_name) VALUES ('3', 'Error Report');
                 INSERT INTO feedback_type (feedback_type_id, feedback_type_name) VALUES ('4', 'Question');"
        );

        $this->execute(
        "ALTER TABLE feedback 
              ADD INDEX fk_feedback_1_idx (feedback_type ASC);
              ALTER TABLE feedback 
              ADD CONSTRAINT fk_feedback_1
              FOREIGN KEY (feedback_type)
              REFERENCES feedback_type (feedback_type_id)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION;"
        );
    }
}
