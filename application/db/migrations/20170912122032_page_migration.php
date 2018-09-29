<?php

use Phinx\Migration\AbstractMigration;

class PageMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE page ENGINE = InnoDB ;
						CREATE UNIQUE INDEX page_url_uindex ON m_marketplace.page (url);");
	}

	public function down()
	{

	}
}
