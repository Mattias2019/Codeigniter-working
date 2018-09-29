<?php

use Phinx\Migration\AbstractMigration;

class InsertEmailTemplate extends AbstractMigration
{
    public function up()
    {
        $this->execute("INSERT INTO `email_templates` (`id`, `type`, `title`, `mail_subject`, `mail_body`) VALUES (45, 'invite_supplier_user', 'Invite Machine Supplier', 'Machine Supplier Invitation', 'Hello!<br>\nThe text should just say that he is invited by !from to join the team of !company  <br>\nPlease confirm you agree to this invitation with the following link !activation_url<br>\nJob Title: !job_title<br>\nTelephone: !telephone<br>\n\nFor any questions contact our support team at !contact_url our team will help on any issue.');");

    }
}
