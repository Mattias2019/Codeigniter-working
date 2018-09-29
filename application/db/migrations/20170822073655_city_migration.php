<?php

use Phinx\Migration\AbstractMigration;

class CityMigration extends AbstractMigration
{
	public function up()
	{
		$filename = '../application/db/m_marketplace_cities.sql';
		$options = $this->adapter->getOptions();
		echo $options['user'].' '.$options['pass'].' '.$options['host'].' '.$options['name'];
		exec("mysql -u {$options['user']} -p{$options['pass']} -h {$options['host']} -D {$options['name']}< ".$filename);
	}

	public function down()
	{

	}
}