<?php

use Phinx\Migration\AbstractMigration;

class Support2Migration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE support MODIFY user_id BIGINT(20) UNSIGNED NOT NULL;
						CREATE INDEX in_support_user ON support (user_id);
						ALTER TABLE support
						ADD CONSTRAINT fk_support_user
						FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;
						ALTER TABLE support MODIFY callid VARCHAR(40);
						ALTER TABLE support MODIFY category INT(11);
						ALTER TABLE support MODIFY priority INT(11);
						ALTER TABLE support ALTER COLUMN status SET DEFAULT 0;");
	}

	public function down()
	{

	}
}
