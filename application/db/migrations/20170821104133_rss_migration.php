<?php

use Phinx\Migration\AbstractMigration;

class RssMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE custom_rss_feeds (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  user_id bigint(20) unsigned NOT NULL,
						  type tinyint(1) NOT NULL COMMENT '1 - titles only / 2 - titles and descriptions',
						  budget_min decimal(10,2) NOT NULL DEFAULT 0,
						  budget_max decimal(10,2) NOT NULL DEFAULT 0,
						  limit_feed tinyint(3) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_custom_rss_feeds_user_idx (user_id),
						  CONSTRAINT fk_custom_rss_feeds_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("CREATE TABLE custom_rss_feed_categories (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  feed_id bigint(20) unsigned NOT NULL,
						  category_id int(10) unsigned NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY fk_custom_rss_feed_categories_category_idx (category_id),
						  KEY fk_custom_rss_feed_categories_feed_idx (feed_id),
						  CONSTRAINT fk_custom_rss_feed_categories_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_custom_rss_feed_categories_feed FOREIGN KEY (feed_id) REFERENCES custom_rss_feeds (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{

	}
}