<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1459973537_addRoles
    extends Migration
{

    public function up()
    {
        $this->createTable('roles', [
            'name' => ['type' => 'string'],
        ]);

        $this->addColumn('users', [
            'role_id' => ['type' => 'relation']
        ]);

        $idAdminRole = $this->insert('roles', ['name' => 'Admin']);
        $this->insert('roles', ['name' => 'User']);
        $this->db->execute('UPDATE users set role_id = ? where __id = 1', [$idAdminRole]);
    }

    public function down()
    {
        $this->dropColumn('users', ['role_id']);
        $this->dropTable('roles');
    }
    
}