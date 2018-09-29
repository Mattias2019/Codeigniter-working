<?php

use Phinx\Migration\AbstractMigration;

class QuoteMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE quote_status (
						  id tinyint(2) NOT NULL,
						  name varchar(50) NOT NULL,
						  comment varchar(200) DEFAULT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO quote_status VALUES ('0', 'Draft', 'Incomplete; minimal validation');
						INSERT INTO quote_status VALUES ('1', 'New', 'Complete but not published');
						INSERT INTO quote_status VALUES ('2', 'Active', 'Published, not accepted by entrepreneur');
						INSERT INTO quote_status VALUES ('3', 'Accepted', 'Accepted by entrepreneur');
						INSERT INTO quote_status VALUES ('4', 'Rejected', 'Rejected by provider');");

		$this->execute("CREATE TABLE quotes (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  job_id bigint(20) unsigned NOT NULL,
						  machinery_id bigint(20) DEFAULT NULL,
						  name varchar(200) NOT NULL,
						  description text,
						  status tinyint(2) NOT NULL,
						  loop int(10) NOT NULL,
						  creator_id bigint(20) unsigned NOT NULL,
						  provider_id bigint(20) unsigned NOT NULL,
						  amount int(10) DEFAULT NULL,
						  amount bigint(20) NOT NULL DEFAULT 0,
						  created bigint(20) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_quotes_jobs_idx (job_id),
						  KEY fk_quotes_creator_idx (creator_id),
						  KEY fk_quotes_status_idx (status),
						  KEY fk_quotes_machinery_idx (machinery_id),
						  KEY fk_quotes_provider_idx (provider_id),
						  CONSTRAINT fk_quotes_creator FOREIGN KEY (creator_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quotes_jobs FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quotes_machinery FOREIGN KEY (machinery_id) REFERENCES portfolio (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quotes_provider FOREIGN KEY (provider_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quotes_status FOREIGN KEY (status) REFERENCES quote_status (id) ON DELETE NO ACTION ON UPDATE NO ACTION
						) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE quote_milestones (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  quote_id bigint(20) unsigned NOT NULL,
						  name varchar(200) DEFAULT NULL,
						  description text,
						  due_date bigint(20) DEFAULT NULL,
						  amount int(10) DEFAULT NULL,
						  is_added tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Milestone was added in previous loop',
						  is_deleted tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Milestone was deleted in previous loop',
						  is_added_cur tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Milestone was added in current loop',
						  is_deleted_cur tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Milestone was deleted in current loop',
						  PRIMARY KEY (id),
						  KEY fk_quote_milestone_quote_idx (quote_id),
						  CONSTRAINT fk_quote_milestone_quote FOREIGN KEY (quote_id) REFERENCES quotes (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;
						");

		$this->execute("CREATE TABLE quote_attachments (
						  id bigint(20) NOT NULL AUTO_INCREMENT,
						  quote_id bigint(20) unsigned NOT NULL,
						  name varchar(50) NOT NULL,
						  url varchar(50) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_quote_attachments_quote_idx (quote_id),
						  CONSTRAINT fk_quote_attachments_quote FOREIGN KEY (quote_id) REFERENCES quotes (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE quote_milestone_attachments (
						  id bigint(20) NOT NULL AUTO_INCREMENT,
						  quote_milestone_id bigint(20) unsigned NOT NULL,
						  name varchar(50) NOT NULL,
						  url varchar(50) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_quote_milestone_attachments_quote_milestone_idx (quote_milestone_id),
						  CONSTRAINT fk_quote_milestone_attachments_quote_milestone FOREIGN KEY (quote_milestone_id) REFERENCES quote_milestones (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE quote_milestone_cost (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  quote_id bigint(20) unsigned NOT NULL,
						  quote_milestone_id bigint(20) unsigned DEFAULT NULL,
						  cost_type tinyint(4) NOT NULL,
						  description text,
						  amount int(10) NOT NULL DEFAULT 0,
						  price int(10) NOT NULL DEFAULT 0,
						  unit varchar(20) DEFAULT NULL,
						  vat tinyint(3) NOT NULL DEFAULT 0,
						  PRIMARY KEY (id),
						  KEY fk_quote_milestone_cost_quote_idx (quote_id),
						  KEY fk_quote_milestone_cost_milestone_idx (quote_milestone_id),
						  KEY fk_quote_milestone_cost_cost_idx (cost_type),
						  CONSTRAINT fk_quote_milestone_cost_cost FOREIGN KEY (cost_type) REFERENCES milestone_cost_type (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quote_milestone_cost_milestone FOREIGN KEY (quote_milestone_id) REFERENCES quote_milestones (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_quote_milestone_cost_quote FOREIGN KEY (quote_id) REFERENCES quotes (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO milestone_cost_type (id, name) VALUES ('1', 'Labor cost');
						INSERT INTO milestone_cost_type (id, name) VALUES ('2', 'Material cost');
						INSERT INTO milestone_cost_type (id, name) VALUES ('3', 'Third party cost');
						INSERT INTO milestone_cost_type (id, name) VALUES ('4', 'Travel cost');");

		$this->execute("ALTER TABLE quote_requests
						ADD COLUMN job_id BIGINT(20) UNSIGNED NOT NULL AFTER id,
						ADD INDEX fk_quote_requests_job_idx (job_id ASC);
						ALTER TABLE quote_requests
						ADD CONSTRAINT fk_quote_requests_job
						FOREIGN KEY (job_id)
						REFERENCES jobs (id)
						ON DELETE CASCADE
						ON UPDATE NO ACTION;");

		$this->execute("INSERT INTO job_status (id, name, comment)
						VALUES ('8', 'Quote Request', 'Dummy project for quote request, visible only for requestee');");
	}

	public function down()
	{

	}
}