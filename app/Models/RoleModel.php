<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model{
    protected $table      = 'role';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    // protected $returnType     = 'array'; ini adalah nilai default nya
    // Untuk menggunakan tipe array harus dibuat seperti ini $data['nama']
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['role','akses'];

    // Dates
    protected $useTimestamps = TRUE;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';    
}