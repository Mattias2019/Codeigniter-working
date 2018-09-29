<?php

use Phinx\Migration\AbstractMigration;

class MilestoneCostMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE milestone_cost_type (
						id TINYINT(4) NOT NULL,
						name VARCHAR(50) NOT NULL,
						PRIMARY KEY (id));");

		$this->execute("DELETE FROM milestone_cost_description;");

		$this->execute("ALTER TABLE milestone_cost_description
						 CHANGE COLUMN milestone_cost_description_id id BIGINT(20) UNSIGNED NOT NULL,
						 CHANGE COLUMN job_id job_id BIGINT(20) UNSIGNED NOT NULL,
						 CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL,
						 CHANGE COLUMN milestone_id milestone_id BIGINT(20) UNSIGNED NULL,
						 ADD INDEX fk_mcd_job_idx (job_id ASC),
						 ADD INDEX fk_mcd_user_idx (user_id ASC),
						 ADD INDEX fk_mcd_milestone_idx (milestone_id ASC),
						 ADD INDEX fk_mcd_type_idx (cost_type ASC);
						ALTER TABLE milestone_cost_description
						 ADD CONSTRAINT fk_mcd_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						 ADD CONSTRAINT fk_mcd_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						 ADD CONSTRAINT fk_mcd_milestone
						  FOREIGN KEY (milestone_id)
						  REFERENCES milestones (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						 ADD CONSTRAINT fk_mcd_type
						  FOREIGN KEY (cost_type)
						  REFERENCES milestone_cost_type (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}
