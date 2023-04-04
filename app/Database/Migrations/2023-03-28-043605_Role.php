<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],                        
            'role' => [
                'type'          => 'VARCHAR',                
                'constraint'     => 20,
                'null'         => FALSE,
            ],            
            'akses' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'         => FALSE,
            ],                                                
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],        
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ]        
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role');

    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}
