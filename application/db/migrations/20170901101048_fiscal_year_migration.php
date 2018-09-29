<?php

use Phinx\Migration\AbstractMigration;

class FiscalYearMigration extends AbstractMigration
{
	public function up()
	{
//		$this->execute("DELIMITER $$
//						CREATE DEFINER=`m_marketplace`@`localhost` FUNCTION `get_fiscal_date`(for_date BIGINT) RETURNS BIGINT(20)
//							DETERMINISTIC
//						BEGIN
//
//							DECLARE fiscal_year_start_date VARCHAR(4) DEFAULT '0101';
//
//							DECLARE for_year VARCHAR(4);
//							DECLARE for_month_day VARCHAR(4);
//
//							SET for_year = FROM_UNIXTIME(for_date, '%Y');
//							SET for_month_day = FROM_UNIXTIME(for_date, '%m%d');
//
//							IF for_month_day < fiscal_year_start_date THEN
//								SET for_year = for_year - 1;
//							END IF;
//
//							RETURN UNIX_TIMESTAMP(CONCAT(for_year, fiscal_year_start_date));
//
//						END$$
//						DELIMITER ;
//						");
	}

	public function down()
	{

	}
}