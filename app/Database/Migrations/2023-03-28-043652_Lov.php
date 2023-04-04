<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lov extends Migration
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
            'kode_keg' => [
                'type'          => 'INT',
                'constraint'     => 2,
                'null'         => FALSE,
            ],            
            'aktivitas' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'         => FALSE,
            ],                                                
            'durasi' => [
                'type'          => 'INT',
                'constraint'     => 3,
                'null'         => FALSE,
            ],            
            'mesinID' => [
                'type'          => 'INT',                
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
        $this->forge->createTable('lov');

    }

    public function down()
    {
        $this->forge->dropTable('lov');
    }
}
