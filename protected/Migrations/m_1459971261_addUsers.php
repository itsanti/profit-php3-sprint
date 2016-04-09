<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1459971261_addUsers
    extends Migration
{

    public function up()
    {
        $this->createTable('users', [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'surname' => ['type' => 'string'],
            'name' => ['type' => 'string'],
            'patronymic' => ['type' => 'string'],
            'created' => ['type' => 'int', 'default' => 0],
        ]);

        $this->insert('users', [
            'email' => 'admin@dev.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'surname' => 'Kurov',
            'name' => 'Aleksandr',
            'created' => $this->getTimestamp(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
    
}