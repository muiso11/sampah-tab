<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\KegiatanModel;
use App\Models\LovModel;
use App\Models\MesinModel;
use Error;
use Exception;

class FormC extends BaseController
{    
    protected $mesinModel;
    protected $formModel;    
    protected $kegiatanModel;
    protected $get_status;
    protected $lovModel;

    public function __construct()
    {
        $this->mesinModel = new MesinModel();        
        $this->formModel = new FormModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->lovModel = new LovModel();

        // Untuk Mengecheck status pada table form apakah bernilai 1 dengan username yang sudah di set dengan session        
        $session_login = session()->get();        
        try{
            $data = ['username' => $session_login['nama'], 'status' => 2];                
        }catch(Exception $e){
            // echo 'Message: ' .$e->getMessage();
            echo '<br><br>Mau Coba Hack Ya Bang? Balik dah ke Login';die;      
        }            
            $get_data = $this->formModel->where($data)->first();        
            $this->get_status = ($get_data == NULL ? NULL: $get_data['status']);        
        
    }
    public function index()
    {                
        if($this->get_status != 1){            
            return redirect()->to('first');
        }
        $mesin = $this->formModel->getAll();   
        $lovs = $this->lovModel->findAll();        
        $data = [
            'tittle'    => 'Dashboard',
            'data_mesin'=> $mesin,
            'lovs' => $lovs        
        ];        
                
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')
                .view('modals/add_tkl')
                .view('modals/edit_tkl',$data)
                .view('pages/dashboard',$data)
                .view('template/footer');
    }
    public function first()
    {
        $data = [
            'tittle' => 'First'
        ];
        
        if($this->get_status == 1){            
            return redirect()->to('form');
        }
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')                
                .view('pages/first_input')
                .view('template/footer');
    }
    public function isi()
    {
        $lovs = $this->lovModel->findAll();        
        $data = [
            'tittle' => 'Isi Form',
            'lovs' => $lovs
        ];
                
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')                
                .view('pages/form_input')
                .view('template/footer');
    }
    public function add_data(){

        $this->mesinModel->save([            
            'tanggal'   => $this->request->getVar('tanggal'),
            'shift'   => $this->request->getVar('shift'),
            'nama'   => $this->request->getVar('nama'),
            'kode_keg'   => $this->request->getVar('kode_keg'),
            'mulai'   => $this->request->getVar('mulai'),
            'panggil_teknik'   => $this->request->getVar('panggil_teknik'),
            'datang_teknik'   => $this->request->getVar('datang_teknik'),
            'selesai'   => $this->request->getVar('selesai'),
            'durasi'   => $this->request->getVar('durasi'),
            'aktivitas'   => $this->request->getVar('aktivitas'),
            'masalah'   => $this->request->getVar('masalah'),
            'tindakan'   => $this->request->getVar('tindakan'),
            'no_schedule'   => $this->request->getVar('no_schedule'),
            'kode_produk'   => $this->request->getVar('kode_produk'),
            'batch'   => $this->request->getVar('batch'),
            'good'   => $this->request->getVar('good'),
            'defect'   => $this->request->getVar('defect'),
            'keterangan'   => 'Success'
        ]);    

        session()->setFlashdata('pesan','Data berhasil ditambahkan');
        return redirect()->to(base_url('dashboard'));
    }    
    public function edit_data(){        

    }
}
