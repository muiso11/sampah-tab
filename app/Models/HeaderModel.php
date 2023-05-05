<?php

namespace App\Models;

use CodeIgniter\Model;

class HeaderModel extends Model{
    protected $table      = 'header';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    // protected $returnType     = 'array'; ini adalah nilai default nya
    // Untuk menggunakan tipe array harus dibuat seperti ini $data['nama']
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['tipe','nama_header','panjang_inputbox','edit'];

    // Dates
    protected $useTimestamps = TRUE;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';    
}