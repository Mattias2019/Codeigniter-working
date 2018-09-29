<?php

use Phinx\Migration\AbstractMigration;

class JobMigration extends AbstractMigration
{
	public function up()
	{
        // Due date
        $this->execute("ALTER TABLE jobs
						CHANGE COLUMN due_date due_date VARCHAR(50) NULL DEFAULT NULL;");

        $this->execute("update jobs set due_date = unix_timestamp();");

        $this->execute("ALTER TABLE jobs
						CHANGE COLUMN due_date due_date BIGINT(20) NOT NULL;");

		$this->execute("ALTER TABLE jobs
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;");

        $this->execute("ALTER TABLE jobs
						ENGINE = InnoDB;");

		// Status
		$this->execute("CREATE TABLE job_status (
						id tinyint(2) NOT NULL AUTO_INCREMENT,
						name varchar(50) NOT NULL,
						comment VARCHAR(200) NULL,
						PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO job_status VALUES (0, 'Draft', 'Incomplete; minimal validation');
						INSERT INTO job_status VALUES (1, 'New', 'Complete but not published');
						INSERT INTO job_status VALUES (2, 'Pending', 'Published, no quote accepted by entrepreneur');
						INSERT INTO job_status VALUES (3, 'Placed', 'Quote accepted by entrepreneur but not confirmed by supplier');
						INSERT INTO job_status VALUES (4, 'In Progress', 'Quote accepted; includes \"To be completed\", \"Overdue\", \"Dispute\", \"Assigned to Competition\"');
						INSERT INTO job_status VALUES (5, 'Completed', 'Accepted by entrepreneur');
						INSERT INTO job_status VALUES (6, 'Canceled', 'Canceled after dispute');
						INSERT INTO job_status VALUES (7, 'Declined', 'Declined by entrepreneur');");

		$this->execute("ALTER TABLE jobs
						CHANGE COLUMN job_status job_status TINYINT(2) NOT NULL;");

		$this->execute("ALTER TABLE jobs 
						ADD INDEX fk_jobs_status_idx (job_status ASC);
						ALTER TABLE jobs
						ADD CONSTRAINT fk_jobs_status
						FOREIGN KEY (job_status)
						REFERENCES job_status (id)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION;");

		// Country
		$this->execute("ALTER TABLE country
						ENGINE = InnoDB;");

		$this->execute("ALTER TABLE jobs 
						ADD COLUMN country_temp INT(10) UNSIGNED NULL AFTER due_date,
						ADD INDEX fk_jobs_country_idx (country_temp ASC);");

		$this->execute("update jobs set country_temp = (select id from country where country.country_name = jobs.country);");

		$this->execute("ALTER TABLE jobs
						DROP COLUMN country,
						CHANGE COLUMN country_temp country INT(10) UNSIGNED NULL DEFAULT NULL;
						ALTER TABLE jobs
						ADD CONSTRAINT fk_jobs_country
						  FOREIGN KEY (country)
						  REFERENCES country (id)
						  ON DELETE SET NULL
						  ON UPDATE SET NULL;");


		// Attachments
		$this->execute("CREATE TABLE job_attachments (
						id bigint(20) NOT NULL AUTO_INCREMENT,
						job_id bigint(20) unsigned NOT NULL,
						name varchar(50) NOT NULL,
						url varchar(50) NOT NULL,
						PRIMARY KEY (id),
						KEY fk_job_attachments_job_idx (job_id),
						CONSTRAINT fk_job_attachments_job FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;");

		$this->execute("insert into job_attachments (job_id, name, url)
						select id, attachment_name, attachment_url from jobs where attachment_name is not null and attachment_url is not null");

		$this->execute("ALTER TABLE jobs
						DROP COLUMN attachment_name,
						DROP COLUMN attachment_url,
						DROP COLUMN attachment_name1,
						DROP COLUMN attachment_url1,
						DROP COLUMN attachment_name2,
						DROP COLUMN attachment_url2");
		
		$this->execute("ALTER TABLE jobs 
						CHANGE COLUMN description description TEXT CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN country country INT(10) UNSIGNED NULL ,
						CHANGE COLUMN state state VARCHAR(50) NULL ,
						CHANGE COLUMN city city VARCHAR(50) NULL ,
						CHANGE COLUMN milestone milestone VARCHAR(50) NULL ,
						CHANGE COLUMN mile_notify mile_notify INT(50) NULL ,
						CHANGE COLUMN manual_job manual_job TEXT CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN is_hide_bids is_hide_bids INT(1) NULL DEFAULT '0' ,
						CHANGE COLUMN created created INT(11) NULL ,
						CHANGE COLUMN enddate enddate INT(11) NULL ,
						CHANGE COLUMN employee_id employee_id INT(11) NULL ,
						CHANGE COLUMN checkstamp checkstamp VARCHAR(50) CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN owner_rated owner_rated ENUM('0', '1') CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN employee_rated employee_rated ENUM('0', '1') CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN job_paid job_paid ENUM('0', '1') CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN job_award_date job_award_date INT(11) NULL ,
						CHANGE COLUMN notification_status notification_status INT(11) NULL DEFAULT '0' ,
						CHANGE COLUMN is_private is_private INT(11) NULL DEFAULT '0' ,
						CHANGE COLUMN contact contact TEXT NULL ,
						CHANGE COLUMN salary salary VARCHAR(15) NULL ,
						CHANGE COLUMN flag flag INT(1) NULL ,
						CHANGE COLUMN salarytype salarytype VARCHAR(100) NULL ,
						CHANGE COLUMN escrow_due escrow_due INT(11) NULL ,
						CHANGE COLUMN invite_suppliers invite_suppliers VARCHAR(124) NULL ,
						CHANGE COLUMN team_member_id team_member_id INT(11) NULL ;");
	}

	public function down()
	{

	}
}
