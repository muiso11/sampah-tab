<?php

namespace App\Models;

use CodeIgniter\Model;

class MesinModel extends Model{
    protected $table      = 'mesin';
    protected $primaryKey = 'mesinID';

    protected $useAutoIncrement = true;

    // protected $returnType     = 'array'; ini adalah nilai default nya
    // Untuk menggunakan tipe array harus dibuat seperti ini $data['nama']
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['kode_mesin','nama_mesin'];

    // Dates
    protected $useTimestamps = TRUE;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}