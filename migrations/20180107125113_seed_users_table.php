<?php

use Phinx\Migration\AbstractMigration;

class SeedUsersTable extends AbstractMigration
{
    public function up()
    {
        $password_hash = password_hash('wachtwoord123', PASSWORD_DEFAULT);

        $this->execute("
            insert into users (first_name, last_name, email, password, active, access_level)
            values
            ('Yarno', 'van Oort', 'ik@yarnovanoort.nl', '$password_hash', '1', '2')
        ");
    }

    public function down()
    {

    }
}
