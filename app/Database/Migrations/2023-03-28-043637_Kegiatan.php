<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kegiatan extends Migration
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
                'null'         => false,
            ],            
            'kode_keg' => [
                'type'          => 'VARCHAR',
                'constraint'    => 1,
                'null'         => false,
            ],
            'dari' => [
                'type'          => 'TIME',
                'null'         => false,                
            ],
            'panggil_teknik' => [
                'type'          => 'TIME',
                'null'         => true,
            ],
            'datang_teknik' => [
                'type'          => 'TIME',
                'null'         => true,
            ],
            'selesai' => [
                'type'          => 'TIME',
                'null'         => false,                
            ],            
            'durasi' => [
                'type'          => 'INT',
                'constraint'    => 3,
                'null'         => false,                
            ],            
            'aktivitas' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'         => false,
            ],
            'masalah' => [
                'type'          => 'TEXT',                
                'null'         => true,                
            ],
            'tindakan' => [
                'type'          => 'TEXT',                
                'null'         => true,                
            ],
            'no_schedule' => [
                'type'          => 'VARCHAR',                
                'constraint'    => 10,
                'null'         => true,                
            ],
            'batch' => [
                'type'          => 'VARCHAR',                
                'constraint'    => 10,
                'null'         => true,                
            ],
            'kode_produk' => [
                'type'          => 'VARCHAR',                
                'constraint'    => 10,
                'null'         => true,                
            ],
            'good' => [
                'type'          => 'VARCHAR',                
                'constraint'    => 10,
                'null'         => true,                
            ],
            'defect' => [
                'type'          => 'VARCHAR',                
                'constraint'    => 10,
                'null'         => true,                
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
        $this->forge->createTable('kegiatan');

    }

    public function down()
    {
        $this->forge->dropTable('kegiatan');
    }
}