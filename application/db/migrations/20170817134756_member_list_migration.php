<?php

use Phinx\Migration\AbstractMigration;

class MemberListMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE favorite_users (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  owner_id bigint(20) unsigned NOT NULL,
						  user_id bigint(20) unsigned NOT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY uk_favorite_users (owner_id,user_id),
						  KEY fk_favorite_users_owner_idx (owner_id),
						  KEY fk_favorite_users_user_idx (user_id),
						  CONSTRAINT fk_favorite_users_owner FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_favorite_users_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE banned_users (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  owner_id bigint(20) unsigned NOT NULL,
						  user_id bigint(20) unsigned NOT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY uk_banned_users (owner_id,user_id),
						  KEY fk_banned_users_owner_idx (owner_id),
						  KEY fk_banned_users_user_idx (user_id),
						  CONSTRAINT fk_banned_users_owner FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_banned_users_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}
}