<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\HeaderModel;
use App\Models\KegiatanModel;
use App\Models\LovModel;
use App\Models\MesinModel;

class AdminC extends BaseController
{    
    protected $mesinModel;
    protected $formModel;    
    protected $kegiatanModel;
    protected $get_status;
    protected $lovModel;
    protected $headerModel;

    public function __construct()
    {
        $this->mesinModel = new MesinModel();        
        $this->formModel = new FormModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->lovModel = new LovModel();         
        $this->headerModel = new HeaderModel();         
    }
    public function index()
    {                      
        $mesin = $this->mesinModel->findAll();            
        $data = [
            'tittle'    => 'Dashboard',
            'mesin'=> $mesin,                        
        ];        
                
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')               
                .view('coba/tabel/button_tabel')
                .view('template/footer');
    }    
    public function coba($mesinID)
    {                
        $form = $this->formModel->getAll($mesinID);   
        $header = $this->headerModel->findAll();
        $session_login = session()->get();                
        $data = [
            'tittle'    => 'halo',  
            'header'    => $header,
            "data_form"=> $form,            
            'session' => $session_login['role']
        ];
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')               
                .view('coba/tabel/tabel_admin',$data)
                .view('template/footer');
    }
}
