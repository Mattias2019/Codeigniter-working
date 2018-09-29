<?php

use Phinx\Migration\AbstractMigration;

class MessagesMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE messages 
						ENGINE = InnoDB ,
						CHANGE COLUMN from_id from_id BIGINT(20) NOT NULL ,
						CHANGE COLUMN to_id to_id BIGINT(20) NOT NULL ,
						CHANGE COLUMN created created BIGINT(20) NOT NULL ,
						CHANGE COLUMN notification_status notification_status TINYINT(4) NOT NULL DEFAULT '0' ;
						ALTER TABLE messages 
						CHANGE COLUMN from_delete from_delete TINYINT(4) NOT NULL DEFAULT 0 ,
						CHANGE COLUMN to_delete to_delete TINYINT(4) NOT NULL DEFAULT 0 ,
						CHANGE COLUMN from_trash_delete from_trash_delete TINYINT(4) NOT NULL DEFAULT 0 ,
						CHANGE COLUMN to_trash_delete to_trash_delete TINYINT(4) NOT NULL DEFAULT 0 ,
						ADD COLUMN checked_from TINYINT(4) NOT NULL DEFAULT 0 AFTER to_trash_delete,
						ADD COLUMN checked_to TINYINT(4) NOT NULL DEFAULT 0 AFTER checked_from;");

		$this->execute("delete from messages;");

		$this->execute("ALTER TABLE messages 
						CHANGE COLUMN from_id from_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN to_id to_id BIGINT(20) UNSIGNED NOT NULL ,
						ADD INDEX fk_messages_job_idx (job_id ASC),
						ADD INDEX fk_messages_from_idx (from_id ASC),
						ADD INDEX fk_messages_to_idx (to_id ASC);
						ALTER TABLE messages 
						ADD CONSTRAINT fk_messages_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_messages_from
						  FOREIGN KEY (from_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_messages_to
						  FOREIGN KEY (to_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("ALTER TABLE messages DROP COLUMN deluserid;");
	}

	public function down()
	{

	}
}
