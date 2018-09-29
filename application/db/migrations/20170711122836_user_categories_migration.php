<?php

use Phinx\Migration\AbstractMigration;

class UserCategoriesMigration extends AbstractMigration
{
	public function up()
	{
		/*$this->execute("ALTER TABLE user_categories
						ADD COLUMN category_id INT(10) UNSIGNED NULL AFTER user_categories;");

		$this->execute("insert into user_categories (user_id, user_categories, category_id)
						select user_categories.user_id, ' ', categories.id
						  from user_categories join categories on concat(',', user_categories.user_categories, ',') like concat('%,', categories.id, ',%');");

		$this->execute("delete from user_categories where user_categories.user_categories != ' ';");

		$this->execute("ALTER TABLE user_categories DROP COLUMN user_categories;");*/
	}

	public function down()
	{

	}
}
