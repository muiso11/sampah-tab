<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model{
    protected $table      = 'form';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;    
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['username','mesinID','no_schedule','kode_produk','batch','status','joinkeg','tanggal','nama','shift'];
    
    protected $useTimestamps = TRUE;

    public function getAll($mesinID,$status = TRUE)
    {
        $builder = $this->db->table('form');
        $builder->select('kegiatan.*');
        $builder->join('kegiatan', 'kegiatan.joinkeg = form.joinkeg','right');                
        $builder->where('form.mesinID',$mesinID);
        $builder->where('status',$status);
        $builder->orderBy('kegiatan.id','ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function savedAll($data,$mesinID)
    {
        $builder = $this->db->table('form');
        $builder->select($data);
        $builder->join('kegiatan', 'kegiatan.joinkeg = form.joinkeg','right');
        $builder->where('form.mesinID',$mesinID);
        $builder->orderBy('kegiatan.id','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getFirstData($nama = NULL,$mesinID = 1,$status = TRUE)
    {
        $builder = $this->db->table('form');
        $builder->select('kegiatan.*');
        $builder->join('kegiatan', 'kegiatan.no_schedule = form.no_schedule','right');
        $builder->where('form.nama',$nama);        
        $builder->where('form.mesinID',$mesinID);        
        $builder->where('status',$status);
        $builder->orderBy('form.id','ASC');
        $query = $builder->get(1);
        return $query->getResultArray();
    }
    public function getNoSchedule($mesinID)
    {
        $builder = $this->db->table('form');
        $builder->select('no_schedule,kode_produk,batch');
        $builder->where('mesinID',$mesinID);        
        $builder->where('status',FALSE);
        $builder->orderBy('id','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function updateData($oldNo,$noSchedule,$kodeProduk,$batch)
    {
        $data = [
            'no_schedule'   => $noSchedule,
            'kode_produk'   => $kodeProduk,
            'batch'         => $batch,
        ];
        $builderForm = $this->db->table('form');
        $builderForm->where(['no_schedule'=>$oldNo , 'status'=>FALSE]);
        $builderForm->update($data);
        
    }
    public function deleteData($table,$id)
    {        
        $builderForm = $this->db->table($table);        
        $builderForm->delete(['id' => $id]);
        
    }
    public function getData($joinkeg, $status = FALSE)
    {
        $builder = $this->db->table('form');
        $builder->select('kegiatan.*');
        $builder->join('kegiatan', 'kegiatan.joinkeg = form.joinkeg','right');                
        $builder->where('kegiatan.joinkeg',$joinkeg);
        $builder->where('status',$status);
        $builder->orderBy('kegiatan.id','ASC');
        $query = $builder->get();
        return $query->getResultArray();       
    }
}