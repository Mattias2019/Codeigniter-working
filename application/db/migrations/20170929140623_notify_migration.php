<?php

use Phinx\Migration\AbstractMigration;

class NotifyMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE notification_types (
						  id tinyint(4) NOT NULL AUTO_INCREMENT,
						  notification_key varchar(128) NOT NULL,
						  message text NOT NULL,
						  PRIMARY KEY (id)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("CREATE TABLE notifications (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  type tinyint(4) NOT NULL,
						  receiver_id bigint(20) unsigned NOT NULL,
						  message text NOT NULL,
						  url varchar(128),
						  time bigint(20) NOT NULL,
						  notified tinyint(1) NOT NULL DEFAULT '0',
						  PRIMARY KEY (id),
						  KEY fk_notifications_type_idx (type),
						  KEY fk_notifications_receiver_idx (receiver_id),
						  CONSTRAINT fk_notifications_receiver FOREIGN KEY (receiver_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_notifications_type FOREIGN KEY (type) REFERENCES notification_types (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->execute("INSERT INTO notification_types (notification_key, message) VALUES ('quote_request', '!entrepreneur has sent you a quote request');
						INSERT INTO notification_types (notification_key, message) VALUES ('quote', '!user has published a quote on project !project');");
	}
}