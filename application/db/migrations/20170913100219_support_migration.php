<?php

use Phinx\Migration\AbstractMigration;

class SupportMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE users ADD is_site_support TINYINT(1) DEFAULT 0 NOT NULL;");
		$this->execute("INSERT INTO users (user_name, first_name, last_name, name, company_address, vat_id, role_id, password, email, language, profile_desc, activation_key, country_symbol, state, city, zip_code, job_notify, bid_notify, message_notify, rate, logo, created, last_activity, num_reviews, rating_hold, tot_rating, team_owner, country_id, login_series, login_token, is_site_support)
						VALUES ('site_support', '', '', 'Site Support', '', '', 3, '', 'alexey.nekrasov1@gmail.com', '', '', '', '', '', '', '', '', '', '', 0, '', 0, 0, 0, 0, 0, NULL, NULL, '', '', 1);");
	}

	public function down()
	{

	}
}