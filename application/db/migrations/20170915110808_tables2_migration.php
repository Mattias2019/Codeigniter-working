<?php

use Phinx\Migration\AbstractMigration;

class Tables2Migration extends AbstractMigration
{
	public function up()
	{
		$this->execute("DROP TABLE admins;");

		$this->execute("ALTER TABLE banned_users CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE bans CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE bids CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE bookmark CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE chat_last_seen CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE chat_messages CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE cities CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE country CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE currency CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE custom_rss_feed_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE custom_rss_feeds CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE email CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE email_templates CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE employee_milestone CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE escrow_fee CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE faq_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE faqs CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE favorite_users CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE feedback CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE groups CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE import_matrix CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE invoice CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_attachments CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_case_message_status CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_case_messages CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_case_reason CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_case_status CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_case_type CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_cases CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_invitation CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_review_type CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE job_status CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE jobs CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE login_failure_reason CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE machinery_custom_item_values CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE machinery_standard_item_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE machinery_standard_item_values CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE machinery_standard_items CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE messages CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE milestone_attachments CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE milestone_cost_description CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE milestone_cost_type CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE milestones CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE packages CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE page CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE payment_methods CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE phinxlog CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE portfolio CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE portfolio_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE portfolio_uploads CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE project_bid_upload CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_attachments CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_milestone_attachments CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_milestone_cost CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_milestones CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_requests CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quote_status CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE quotes CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE rating_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE ratings CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE report_violation CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE reviews CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE roles CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE settings CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE slider CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE subscriptionuser CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE support CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE suspend CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE team_groups CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE team_members CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE transaction_item_direction CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE transaction_items CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE transaction_status CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE transaction_type CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE transactions CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE user_balance CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE user_categories CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE user_file_type CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE user_files CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE user_logins CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE users CHARACTER SET = utf8, ENGINE = InnoDB;
						ALTER TABLE vat_matrix CHARACTER SET = utf8, ENGINE = InnoDB;");
	}

	public function down()
	{

	}
}