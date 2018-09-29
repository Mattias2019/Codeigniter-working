<?php

use Phinx\Migration\AbstractMigration;

class RatingMigration extends AbstractMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE rating_categories (
						  id tinyint(4) NOT NULL AUTO_INCREMENT,
						  role_id int(10) NOT NULL,
						  name varchar(50) NOT NULL,
						  min_value tinyint(4) NOT NULL,
						  max_value tinyint(4) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_rating_categories_role_idx (role_id),
						  CONSTRAINT fk_rating_categories_role FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE NO ACTION ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('1', 'Professionality', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('1', 'Communication', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('1', 'Payment in time', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('1', 'Spec accuracy', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('1', 'Response speed', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('2', 'Professionality', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('2', 'Communication', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('2', 'Quality', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('2', 'Cost accuracy', '1', '5');
						INSERT INTO rating_categories (role_id, name, min_value, max_value) VALUES ('2', 'Delivery in time', '1', '5');");

		$this->execute("ALTER TABLE reviews 
						ENGINE = InnoDB,
						DROP COLUMN hold,
						DROP COLUMN review_type,
						DROP COLUMN rating,
						CHANGE COLUMN owner_id reviewer_id BIGINT(20) UNSIGNED NOT NULL AFTER id,
						CHANGE COLUMN employee_id reviewee_id BIGINT(20) UNSIGNED NOT NULL AFTER reviewer_id,
						CHANGE COLUMN job_id job_id BIGINT(20) UNSIGNED NOT NULL AFTER reviewee_id,
						CHANGE COLUMN id id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
						CHANGE COLUMN review_time review_time BIGINT(20) NOT NULL ;");

		$this->execute("delete from reviews;");

		$this->execute("ALTER TABLE reviews 
						ADD UNIQUE INDEX job_id_UNIQUE (job_id ASC),
						ADD INDEX fk_reviews_reviewer_idx (reviewer_id ASC),
						ADD INDEX fk_reviews_reviewee_idx (reviewee_id ASC),
						ADD INDEX fk_reviews_job_idx (job_id ASC);
						ALTER TABLE reviews 
						ADD CONSTRAINT fk_reviews_reviewer
						  FOREIGN KEY (reviewer_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_reviews_reviewee
						  FOREIGN KEY (reviewee_id)
						  REFERENCES users (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION,
						ADD CONSTRAINT fk_reviews_job
						  FOREIGN KEY (job_id)
						  REFERENCES jobs (id)
						  ON DELETE CASCADE
						  ON UPDATE NO ACTION;");

		$this->execute("CREATE TABLE ratings (
						  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						  user_id bigint(20) unsigned NOT NULL,
						  review_id bigint(20) unsigned NOT NULL,
						  rating_category_id tinyint(4) NOT NULL,
						  rating tinyint(4) NOT NULL,
						  PRIMARY KEY (id),
						  KEY fk_ratings_user_idx (user_id),
						  KEY fk_ratings_category_idx (rating_category_id),
						  KEY fk_ratings_review_idx (review_id),
						  CONSTRAINT fk_ratings_category FOREIGN KEY (rating_category_id) REFERENCES rating_categories (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
						  CONSTRAINT fk_ratings_review FOREIGN KEY (review_id) REFERENCES reviews (id) ON DELETE CASCADE ON UPDATE NO ACTION,
						  CONSTRAINT fk_ratings_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE NO ACTION
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->execute("ALTER TABLE users 
						CHANGE COLUMN user_rating user_rating FLOAT NOT NULL DEFAULT 0 ;");
	}

	public function down()
	{

	}
}