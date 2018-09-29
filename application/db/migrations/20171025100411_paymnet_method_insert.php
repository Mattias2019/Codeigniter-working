<?php

use Phinx\Migration\AbstractMigration;

class PaymnetMethodInsert extends AbstractMigration
{

    public function up()
    {
        $this->execute("INSERT INTO `payment_method_credentials` (`id`, `payment_method_id`, `credential_key`, `credential_name`, `credential_value`) VALUES (6, 2, 'recipient', 'Recipient', '');
INSERT INTO `payment_method_credentials` (`id`, `payment_method_id`, `credential_key`, `credential_name`, `credential_value`) VALUES (7, 2, 'bank_account_number', 'Bank account number', '');
INSERT INTO `payment_method_credentials` (`id`, `payment_method_id`, `credential_key`, `credential_name`, `credential_value`) VALUES (8, 2, 'bic_swift_code_aba', 'BIC / Swift-Code / ABA', '');
INSERT INTO `payment_method_credentials` (`id`, `payment_method_id`, `credential_key`, `credential_name`, `credential_value`) VALUES (9, 2, 'credit_institution', 'Credit institution', '');
INSERT INTO `payment_method_credentials` (`id`, `payment_method_id`, `credential_key`, `credential_name`, `credential_value`) VALUES (10, 2, 'target_country', 'Target country', '');
"
        );
    }
}
