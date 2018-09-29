<?php

use Phinx\Migration\AbstractMigration;

class InsertNewInvoiceEmailTemplate extends AbstractMigration
{

    protected $table = 'email_templates';

    public function up()
    {
        $row = [
            'type'  => 'invoice_reminder',
            'title' => 'Invoice Reminder',
            'mail_subject' => 'Invoice Reminder',
            'mail_body' => 'Invoice !link overdue!',
        ];

        $this->insert($this->table, $row);
    }

    public function down()
    {
        $this->execute('DELETE FROM ' . $this->table . ' WHERE type="invoice_reminder"');
    }
}
