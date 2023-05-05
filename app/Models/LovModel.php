<?php

namespace App\Models;

use CodeIgniter\Model;

class LovModel extends Model{
    protected $table      = 'lov';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    // protected $returnType     = 'array'; ini adalah nilai default nya
    // Untuk menggunakan tipe array harus dibuat seperti ini $data['nama']
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['kode_kegiatan','aktivitas','durasi','mesinID'];

    // Dates
    protected $useTimestamps = TRUE;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';        
    public function getAll($mesin)
    {
        $builder = $this->db->table('lov');
        $builder->select('kode_keg, aktivitas, durasi, kode_mesin');
        $builder->join('mesin', 'mesin.mesinID = lov.mesinID','LEFT');
        $builder->where('lov.mesinID',$mesin);
        // $builder->where('kode_mesin','all');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getMesin()
    {
        $builder = $this->db->table('lov');
        $builder->select('lov.id,kode_kegiatan, aktivitas, durasi, nama_mesin');
        $builder->join('mesin', 'mesin.mesinID = lov.mesinID','LEFT');        
        // $builder->where('kode_mesin','all');
        $query = $builder->get();
        return $query->getResultArray();
    }
}