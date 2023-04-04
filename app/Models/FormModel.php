<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model{
    protected $table      = 'form';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;    
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['username','mesinID','tanggal','nama','shift','status'];
    
    protected $useTimestamps = TRUE;

    public function getAll()
    {
        $builder = $this->db->table('form');
        $builder->select('*');
        $builder->join('kegiatan', 'kegiatan.username = form.username','left');
        $query = $builder->get();
        return $query->getResultArray();
    }
}