<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Account extends Migration
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
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],        
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],
            'nama' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'         => FALSE,
            ],            
            'password' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'         => FALSE,
            ],
            'mesinID' => [
                'type'          => 'INT',            
                'null'         => false
            ],
            'role' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
                'null'         => FALSE,
                'default'       => 'user'
            ]                    
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('account');

    }

    public function down()
    {
        $this->forge->dropTable('account');
    }
}
