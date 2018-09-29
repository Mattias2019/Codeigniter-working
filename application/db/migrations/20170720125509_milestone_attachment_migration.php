<?php

use Phinx\Migration\AbstractMigration;

class MilestoneAttachmentMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE milestone_attachments (
						id bigint(20) NOT NULL AUTO_INCREMENT,
						milestone_id bigint(20) unsigned NOT NULL,
						name varchar(50) NOT NULL,
						url varchar(50) NOT NULL,
						PRIMARY KEY (id),
						KEY fk_milestone_attachments_milestone_idx (milestone_id),
						CONSTRAINT fk_milestone_attachments_milestone FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;");

		$this->execute("ALTER TABLE job_attachments
						DROP FOREIGN KEY fk_job_attachments_job;
						ALTER TABLE job_attachments
						ADD CONSTRAINT fk_job_attachments_job
						FOREIGN KEY (job_id)
						REFERENCES jobs (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION;");
	}

	public function down()
	{

	}
}
