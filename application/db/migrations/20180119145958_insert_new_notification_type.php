<?php

use Phinx\Migration\AbstractMigration;

class InsertNewNotificationType extends AbstractMigration
{

    protected $table = 'notification_types';

    public function up()
    {
        $rows = [
            [
                'notification_key'  => 'invoice',
                'message' => 'New Invoice',
            ],
            [
                'notification_key'  => 'invoice_reminder',
                'message' => 'Invoice overdue!',
            ]
        ];

        $this->insert($this->table, $rows);
    }

    public function down()
    {
        $this->execute('DELETE FROM ' . $this->table . ' WHERE notification_key="invoice"');
        $this->execute('DELETE FROM ' . $this->table . ' WHERE notification_key="invoice_reminder"');

    }
}