<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model{
    protected $table      = 'form';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;    
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['username','mesinID','tanggal','nama','shift','no_schedule','kode_produk','batch','status'];
    
    protected $useTimestamps = TRUE;

    public function getAll($nama = NULL,$mesinID = 1,$status = TRUE)
    {
        $builder = $this->db->table('form');
        $builder->select('kegiatan.*');
        $builder->join('kegiatan', 'kegiatan.no_schedule = form.no_schedule','right');
        $builder->where('form.nama',$nama);        
        $builder->where('form.mesinID',$mesinID);        
        $builder->where('status',$status);
        $query = $builder->get();
        return $query->getResultArray();
    }
}