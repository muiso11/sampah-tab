<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Form extends Migration
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
            'username' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'         => FALSE,
            ],                     
            'mesinID' => [
                'type'          => 'INT',
                'constraint'     => 2,
                'null'         => FALSE,
            ],            
            'tanggal' => [
                'type'          => 'DATE',
                'null'         => FALSE,                
            ],
            'nama' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'         => FALSE,
            ],             
            'shift' => [
                'type'          => 'TINYINT',                
                'null'         => FALSE,
            ],                             
            'status' => [
                'type'          => 'TINYINT',                
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
        $this->forge->createTable('form');

    }

    public function down()
    {
        $this->forge->dropTable('form');
    }


}
