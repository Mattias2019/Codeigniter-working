<?php

use Phinx\Migration\AbstractMigration;

class AlterForeignKeys extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE banned_users 
                            DROP FOREIGN KEY fk_banned_users_owner,
                            DROP FOREIGN KEY fk_banned_users_user;
                            ALTER TABLE banned_users 
                            ADD CONSTRAINT fk_banned_users_owner
                            FOREIGN KEY (owner_id)
                            REFERENCES users (id)
                            ON DELETE CASCADE
                            ON UPDATE RESTRICT,
                            ADD CONSTRAINT fk_banned_users_user
                            FOREIGN KEY (user_id)
                            REFERENCES users (id)
                            ON DELETE CASCADE;"
        );

        $this->execute("ALTER TABLE user_files 
                            DROP FOREIGN KEY fk_user_files_user;
                            ALTER TABLE user_files 
                            ADD CONSTRAINT fk_user_files_user
                            FOREIGN KEY (user_id)
                            REFERENCES users (id)
                            ON DELETE CASCADE
                            ON UPDATE RESTRICT;"
        );
    }
}
