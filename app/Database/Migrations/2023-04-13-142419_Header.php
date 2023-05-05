<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Header extends Migration
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
            'edit' => [
                'type'          => 'BOOLEAN',                
                'default'       => TRUE,
            ],                
            'tipe' => [
                'type'          => 'VARCHAR',
                'constraint'     => 10,
                'null'         => FALSE,
            ],            
            // 'panjang_karakter' => [
            //     'type'          => 'INT',
            //     'constraint'     => 4,
            //     'null'         => TRUE,
            // ],            
            'nama_header' => [
                'type'          => 'VARCHAR',
                'constraint'     => 100,
                'null'         => FALSE,
            ],            
            'panjang_inputbox' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
                'null'         => FALSE,
            ],                                                                            
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('header');

    }

    public function down()
    {
        $this->forge->dropTable('header');
    }
}
