<?php

use Phinx\Migration\AbstractMigration;

class InvitationEmailTemplate extends AbstractMigration
{
    public function up()
    {
        $this->execute("
          INSERT INTO email_templates (type, title, mail_subject, mail_body) VALUES ('invite_supplier', 'Invite Machine Supplier', 'Machine Supplier Invitation', '!custom_body\nPlease click here to complete the signup process. <br>\nYour activation link: !activation_url <br><br>\n\nFor any questions contact our support team at !contact_url our team will help on any issue.');
        ");


    }

    public function down()
    {

    }
}
