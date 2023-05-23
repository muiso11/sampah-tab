<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model{
    protected $table      = 'kegiatan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = [];
    
    protected $useTimestamps = TRUE;

    public function __construct()
    {        
        parent::__construct();
        $db = \Config\Database::connect();
        $this->builder = $db->table('kegiatan');
        $db = db_connect();

        // $query = $db->query('SELECT * FROM coba');
        $nama = $db->getFieldNames('kegiatan');
        // $fields = array();
        for($i = 3; $i < count($nama);$i++){
            array_push($this->allowedFields,$nama[$i]);
        }        
        // var_dump($this->allowedFields);die;
    }    
}