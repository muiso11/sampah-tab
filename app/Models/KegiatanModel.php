<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model{
    protected $table      = 'kegiatan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['username','kode_keg','dari','panggil_teknik','datang_teknik','selesai','durasi','aktivitas','masalah','tindakan','no_schedule','batch','kode_produk','good','defect'];
    
    protected $useTimestamps = TRUE;
}