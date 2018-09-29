<?php

use Phinx\Migration\AbstractMigration;

class CaseMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE job_case_type (
						  id tinyint(4) NOT NULL,
						  name varchar(200) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO job_case_type VALUES ('1', 'Dispute');
						INSERT INTO job_case_type VALUES ('2', 'Cancelation');");

		$this->execute("CREATE TABLE job_case_reason (
						  id tinyint(4) NOT NULL,
						  name varchar(200) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO job_case_reason VALUES ('1', 'Dispute Over Quality of Service');
						INSERT INTO job_case_reason VALUES ('2', 'Service Not Rendered');
						INSERT INTO job_case_reason VALUES ('3', 'Project Description Has Changed');
						INSERT INTO job_case_reason VALUES ('4', 'Payment Not Recieved (Service Rendered)');
						INSERT INTO job_case_reason VALUES ('5', 'No Communication (for over 3 business days)');
						INSERT INTO job_case_reason VALUES ('6', 'Mutual Cancellation (both parties agree to cancel Project)');
						INSERT INTO job_case_reason VALUES ('99', 'Other');");

		$this->execute("CREATE TABLE job_review_type (
						  id tinyint(4) NOT NULL,
						  name varchar(200) NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO job_review_type VALUES ('1', 'Add Review');
						INSERT INTO job_review_type VALUES ('2', 'Remove Review');
						INSERT INTO job_review_type VALUES ('3', 'Don&#39;t Change');");

		$this->execute("CREATE TABLE job_case_status (
						  id tinyint(4) NOT NULL,
						  name varchar(50) NOT NULL,
						  description varchar(200) DEFAULT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO job_case_status VALUES ('0', 'New', 'Not approved by admin');
						INSERT INTO job_case_status VALUES ('1', 'Open', 'Approved by admin');
						INSERT INTO job_case_status VALUES ('2', 'Closed', 'Closed by admin');");
		
		$this->execute("delete from job_cases;");

		$this->execute("ALTER TABLE job_cases ENGINE = InnoDB ;
						ALTER TABLE job_cases 
						DROP COLUMN updates,
						DROP COLUMN parent,
						DROP COLUMN problem_subject,
						DROP COLUMN owner_delete,
						DROP COLUMN employee_delete,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN job_id job_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN admin_id admin_id BIGINT(20) UNSIGNED NULL ,
						CHANGE COLUMN case_type case_type TINYINT(4) NOT NULL ,
						CHANGE COLUMN case_reason case_reason TINYINT(4) NOT NULL ,
						CHANGE COLUMN problem_description comments VARCHAR(256) CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN private_comments private_comments VARCHAR(256) CHARACTER SET 'utf8' NULL ,
						CHANGE COLUMN review_type review_type TINYINT(4) NOT NULL ,
						CHANGE COLUMN created created BIGINT(20) NOT NULL ,
						CHANGE COLUMN status status TINYINT(4) NOT NULL DEFAULT '0',
						CHANGE COLUMN notification_status notification_status TINYINT(4) NOT NULL DEFAULT '0' ;");

		$this->execute("ALTER TABLE job_cases 
						ADD INDEX fk_job_cases_job_idx (job_id ASC),
						ADD INDEX fk_job_cases_user_idx (user_id ASC),
						ADD INDEX fk_job_cases_admin_idx (admin_id ASC),
						ADD INDEX fk_job_cases_type_idx (case_type ASC),
						ADD INDEX fk_job_cases_reason_idx (case_reason ASC),
						ADD INDEX fk_job_cases_review_idx (review_type ASC),
						ADD INDEX fk_job_cases_status_idx (status ASC);
						ALTER TABLE job_cases 
						ADD CONSTRAINT fk_job_cases_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_admin
						  FOREIGN KEY (admin_id)
						  REFERENCES users (id)
						  ON DELETE SET NULL
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_type
						  FOREIGN KEY (case_type)
						  REFERENCES job_case_type (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_reason
						  FOREIGN KEY (case_reason)
						  REFERENCES job_case_reason (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_review
						  FOREIGN KEY (review_type)
						  REFERENCES job_review_type (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_job_cases_status
						  FOREIGN KEY (status)
						  REFERENCES job_case_status (id)
						  ON DELETE NO ACTION
						  ON UPDATE NO ACTION;");

		$this->execute("CREATE TABLE job_case_messages (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  case_id bigint(20) unsigned NOT NULL,
						  user_id bigint(20) unsigned NOT NULL,
						  subject varchar(256) NOT NULL,
						  message varchar(256) NOT NULL,
						  created bigint(20) NOT NULL,
						  notification_status tinyint(4) NOT NULL DEFAULT '0',
						  admin_approved tinyint(4) NOT NULL DEFAULT '0',
						  PRIMARY KEY (id),
						  KEY fk_job_case_messages_case_idx (case_id),
						  KEY fk_job_case_messages_user_idx (user_id),
						  CONSTRAINT fk_job_case_messages_case FOREIGN KEY (case_id) REFERENCES job_cases (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_job_case_messages_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}
}
