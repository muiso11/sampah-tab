<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mesin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'mesinID' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],                        
            'kode_mesin' => [
                'type'          => 'VARCHAR',
                'constraint'     => 20,
                'null'         => FALSE,
            ],            
            'nama_mesin' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
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
        $this->forge->addKey('mesinID', true);
        $this->forge->createTable('mesin');

    }

    public function down()
    {
        $this->forge->dropTable('mesin');
    }
}
