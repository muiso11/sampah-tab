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
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],        
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],
            'kode_mesin' => [
                'type'         => 'VARCHAR',
                'constraint'   => 20,
                'null'         => FALSE,
            ],            
            'nama_mesin' => [
                'type'         => 'VARCHAR',
                'constraint'   => 100,
                'null'         => FALSE,
            ],                                                                    
            'nama_sheet' => [
                'type'         => 'VARCHAR',                
                'null'         => FALSE,
            ],
            'sheetID' => [
                'type'         => 'TEXT',                
                'null'         => FALSE,
            ],
            'gid' => [
                'type'         => 'VARCHAR',                
                'null'         => FALSE,
            ],
            'totalRow' => [
                'type'         => 'INT',                
                'null'         => FALSE,
            ],                                                                                                                                      
        ]);
        $this->forge->addKey('mesinID', true);
        $this->forge->createTable('mesin');

    }

    public function down()
    {
        $this->forge->dropTable('mesin');
    }
}
