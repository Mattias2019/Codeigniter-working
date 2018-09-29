<?php

use Phinx\Migration\AbstractMigration;

class UsersFkeyMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("INSERT INTO user_files (user_id, file_type, name, url, description, expire_date)
						SELECT user_id, 1, original_name, location, description, unix_timestamp(date(expiry_date)) FROM files");

		$this->execute("DROP TABLE files;");
		$this->execute("DROP TABLE folders;");
		$this->execute("DROP TABLE group_permission;");
		$this->execute("DROP TABLE invite_suppliers;");
		$this->execute("DROP TABLE rating_hold;");
		$this->execute("DROP TABLE user_contacts;");
		$this->execute("DROP TABLE user_list;");
		
		$this->execute("ALTER TABLE bids 
						ENGINE = InnoDB ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						ADD INDEX fk_bids_user_idx (user_id ASC);
						ALTER TABLE bids 
						ADD CONSTRAINT fk_bids_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE chat_last_seen 
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						ADD INDEX fk_chat_last_seen_user_idx (user_id ASC);
						ALTER TABLE chat_last_seen 
						ADD CONSTRAINT fk_chat_last_seen_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE feedback 
						ENGINE = InnoDB ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						ADD INDEX fk_feedback_user_idx (user_id ASC);
						ALTER TABLE feedback 
						ADD CONSTRAINT fk_feedback_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE user_categories 
						ENGINE = InnoDB ,
						CHANGE COLUMN user_id user_id BIGINT(20) UNSIGNED NOT NULL ,
						ADD INDEX fk_user_categories_user_idx (user_id ASC);
						ALTER TABLE user_categories 
						ADD CONSTRAINT fk_user_categories_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE banned_users 
						DROP FOREIGN KEY fk_banned_users_owner,
						DROP FOREIGN KEY fk_banned_users_user;
						ALTER TABLE banned_users 
						ADD CONSTRAINT fk_banned_users_owner
						  FOREIGN KEY (owner_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_banned_users_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE custom_rss_feeds 
						DROP FOREIGN KEY fk_custom_rss_feeds_user;
						ALTER TABLE custom_rss_feeds 
						ADD CONSTRAINT fk_custom_rss_feeds_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE favorite_users 
						DROP FOREIGN KEY fk_favorite_users_owner,
						DROP FOREIGN KEY fk_favorite_users_user;
						ALTER TABLE favorite_users 
						ADD CONSTRAINT fk_favorite_users_owner
						  FOREIGN KEY (owner_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_favorite_users_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE invoice 
						DROP FOREIGN KEY fk_invoice_reciever,
						DROP FOREIGN KEY fk_invoice_sender;
						ALTER TABLE invoice 
						ADD CONSTRAINT fk_invoice_reciever
						  FOREIGN KEY (reciever_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_invoice_sender
						  FOREIGN KEY (sender_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE job_case_messages 
						DROP FOREIGN KEY fk_job_case_messages_user;
						ALTER TABLE job_case_messages 
						ADD CONSTRAINT fk_job_case_messages_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE job_cases 
						DROP FOREIGN KEY fk_job_cases_admin,
						DROP FOREIGN KEY fk_job_cases_user;
						ALTER TABLE job_cases 
						ADD CONSTRAINT fk_job_cases_admin
						  FOREIGN KEY (admin_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_job_cases_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE messages 
						DROP FOREIGN KEY fk_messages_from,
						DROP FOREIGN KEY fk_messages_to;
						ALTER TABLE messages 
						ADD CONSTRAINT fk_messages_from
						  FOREIGN KEY (from_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_messages_to
						  FOREIGN KEY (to_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE milestone_cost_description 
						DROP FOREIGN KEY fk_mcd_user;
						ALTER TABLE milestone_cost_description 
						ADD CONSTRAINT fk_mcd_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE portfolio 
						DROP FOREIGN KEY fk_portfolio_user;
						ALTER TABLE portfolio 
						ADD CONSTRAINT fk_portfolio_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE quotes 
						DROP FOREIGN KEY fk_quotes_creator,
						DROP FOREIGN KEY fk_quotes_provider;
						ALTER TABLE quotes 
						ADD CONSTRAINT fk_quotes_creator
						  FOREIGN KEY (creator_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_quotes_provider
						  FOREIGN KEY (provider_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE ratings 
						DROP FOREIGN KEY fk_ratings_user;
						ALTER TABLE ratings 
						ADD CONSTRAINT fk_ratings_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE reviews 
						DROP FOREIGN KEY fk_reviews_reviewee,
						DROP FOREIGN KEY fk_reviews_reviewer;
						ALTER TABLE reviews 
						ADD CONSTRAINT fk_reviews_reviewee
						  FOREIGN KEY (reviewee_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_reviews_reviewer
						  FOREIGN KEY (reviewer_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE subscriptionuser 
						DROP FOREIGN KEY fk_subscriptionuser_user;
						ALTER TABLE subscriptionuser 
						ADD CONSTRAINT fk_subscriptionuser_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE team_groups 
						DROP FOREIGN KEY fk_team_groups_leader;
						ALTER TABLE team_groups 
						ADD CONSTRAINT fk_team_groups_leader
						  FOREIGN KEY (team_leader_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE team_members 
						DROP FOREIGN KEY fk_team_members_leader,
						DROP FOREIGN KEY fk_team_members_user;
						ALTER TABLE team_members 
						ADD CONSTRAINT fk_team_members_leader
						  FOREIGN KEY (team_leader_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_team_members_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE user_balance 
						DROP FOREIGN KEY fk_user_balance_user;
						ALTER TABLE user_balance 
						ADD CONSTRAINT fk_user_balance_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE user_balance 
						DROP FOREIGN KEY fk_user_balance_user;
						ALTER TABLE user_balance 
						ADD CONSTRAINT fk_user_balance_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE user_files 
						DROP FOREIGN KEY fk_user_files_user;
						ALTER TABLE user_files 
						ADD CONSTRAINT fk_user_files_user
						  FOREIGN KEY (user_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE jobs 
						CHANGE COLUMN creator_id creator_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN employee_id employee_id BIGINT(20) UNSIGNED NULL DEFAULT NULL ,
						ADD INDEX fk_jobs_creator_idx (creator_id ASC),
						ADD INDEX fk_jobs_provider_idx (employee_id ASC);
						ALTER TABLE jobs 
						ADD CONSTRAINT fk_jobs_creator
						  FOREIGN KEY (creator_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_jobs_provider
						  FOREIGN KEY (employee_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");

		$this->execute("ALTER TABLE job_invitation 
						ENGINE = InnoDB ,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN job_id job_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN sender_id sender_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN receiver_id receiver_id BIGINT(20) UNSIGNED NOT NULL ,
						CHANGE COLUMN invite_date invite_date BIGINT(20) NOT NULL ,
						CHANGE COLUMN notification_status notification_status TINYINT(1) NOT NULL DEFAULT '0' ,
						ADD INDEX fk_job_invitation_sender_idx (sender_id ASC),
						ADD INDEX fk_job_invitation_job_idx (job_id ASC),
						ADD INDEX fk_job_invitation_reciever_idx (receiver_id ASC);
						ALTER TABLE job_invitation 
						ADD CONSTRAINT fk_job_invitation_sender
						  FOREIGN KEY (sender_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_job_invitation_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE CASCADE
						  ON UPDATE RESTRICT,
						ADD CONSTRAINT fk_job_invitation_reciever
						  FOREIGN KEY (receiver_id)
						  REFERENCES users (id)
						  ON DELETE RESTRICT
						  ON UPDATE RESTRICT;");
	}

	public function down()
	{

	}
}