<?php

namespace App\Models;

use CodeIgniter\Model;

class CobaModel extends Model{
    protected $table      = 'coba';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = [];
    
    protected $useTimestamps = TRUE;

    public function __construct()
    {        
        $db = db_connect();
        // $query = $db->query('SELECT * FROM coba');
        $nama = $db->getFieldNames('coba');
        // $fields = array();
        for($i = 3; $i < count($nama);$i++){
            array_push($this->allowedFields,$nama[$i]);
        }        
        // var_dump($this->allowedFields);die;
    }
}