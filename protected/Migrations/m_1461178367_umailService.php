<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1461178367_umailService
    extends Migration
{

    public function up()
    {
        $this->createTable('umail', [
            'to' => ['type' => 'string'],
            'template' => ['type' => 'string'],
            'params' => ['type' => 'string'],
            'status' => ['type' => 'int', 'length' => 'tiny'],
            'created' => ['type' => 'int', 'default' => 0],
        ]);
    }

    public function down()
    {
        $this->dropTable('umail');
    }
    
}