<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model{
    protected $table      = 'account';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;    
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['nama','password','mesinID','role'];

    protected $useTimestamps = TRUE;    
}