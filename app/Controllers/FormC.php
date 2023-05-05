<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\HeaderModel;
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
    protected $get_data;
    protected $lovModel;
    protected $headerModel;

    public function __construct()
    {
        $this->mesinModel = new MesinModel();        
        $this->formModel = new FormModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->lovModel = new LovModel();
        $this->headerModel = new HeaderModel();

        // Untuk Mengecheck status pada table form apakah bernilai 1 dengan username yang sudah di set dengan session        
        $session_login = session()->get();        
        try{
            $data = ['username' => $session_login['username'], 'status' => FALSE];                
        }catch(Exception $e){
            // echo 'Message: ' .$e->getMessage();
            echo '<br><br>Mau Coba Hack Ya Bang? Balik dah ke Login';die;      
        }            
        $this->get_data = $this->formModel->where($data)->findAll();   
        foreach($this->get_data as $data){
            $this->get_data = $data;
        }
        // var_dump($this->get_data);die;
        $this->get_status = ($this->get_data == NULL ? 'nope': $this->get_data['status']);        
        // var_dump($this->get_status);die;
        
    }
    public function form()
    {                
        if($this->get_status == 'nope'){            
            return redirect()->to('first');
        }        
        $form_data = $this->get_data;                
        $form = $this->formModel->getAll($form_data['nama'],$form_data['mesinID'],$form_data['status']);           
        // var_dump($form);die;
        $lovs = $this->lovModel->findAll();        
        $header = $this->headerModel->findAll(); 
        // var_dump($header)       ;die;
        $data = [
            'tittle'    => 'Dashboard',
            'data_awal' => $this->get_data,
            'header'    => $header,
            'longkap'   => '0',
            'data_form'=> $form,
            'lovs' => $lovs        
        ];        
                
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')
                .view('modals/addFormV2',$data)
                // .view('modals/edit_tkl',$data)
                .view('pages/formV2',$data)
                .view('template/footer');
    }

    public function formAdd()
    {
        $session_login = session()->get();
        // var_dump($this->request->getVar());die;
        $kode_kegiatan = $this->request->getVar('kode_keg');  
        $form_data = $this->get_data;
        // var_dump($form_data);die;
        if($kode_kegiatan == 7){
            if($this->request->getVar('no_schedule') == $form_data['no_schedule'] ){
                session()->setFlashdata('pesan','Data gagal ditambahkan');
                return redirect()->to(base_url('form'));        
            }
            $this->formModel->save([
                'username'  => $session_login['username'],
                'mesinID'   => $session_login['mesinID'],
                'tanggal'   => $form_data['tanggal'],
                'nama'   => $form_data['nama'],
                'shift'   => $form_data['shift'],
                'no_schedule'   => $this->request->getVar('no_schedule'),
                'kode_produk'   => $this->request->getVar('kode_produk'),
                'batch'   => $this->request->getVar('batch'),
                'status' => FALSE
            ]);
        }

        $dari = $this->request->getVar('dari');
        $panggil_teknik = ($this->request->getVar('panggil_teknik') == NULL ? NULL : $this->request->getVar('panggil_teknik'));
        $datang_teknik = ($this->request->getVar('datang_teknik') == NULL ? NULL : $this->request->getVar('datang_teknik'));
        $selesai = $this->request->getVar('selesai');
        $good = ($this->request->getVar('good') == NULL ? 0 : $this->request->getVar('good'));
        $defect = ($this->request->getVar('defect') == NULL ? 0 : $this->request->getVar('defect'));
                
        try{
            $this->kegiatanModel->save([
                'mesinID'   => $session_login['mesinID'],
                'kode_keg'   => $kode_kegiatan,
                'dari'   => $dari,
                'panggil_teknik'   => $panggil_teknik,
                'datang_teknik'   => $datang_teknik,
                'selesai'   => $selesai,
                'durasi'   => $this->request->getVar('durasi'),
                'aktivitas'   => $this->request->getVar('aktivitas'),
                'masalah'   => $this->request->getVar('masalah'),
                'tindakan'   => $this->request->getVar('tindakan'),
                'no_schedule'   => $this->request->getVar('no_schedule'),
                'kode_produk'   => $this->request->getVar('kode_produk'),
                'batch'   => $this->request->getVar('batch'),
                'good'   => $good,
                'defect'   => $defect,
            ]);
            // var_dump("bisa");die;
            session()->setFlashdata('pesan','Data berhasil ditambahkan');
            return redirect()->to(base_url('form'));
        }catch(Error $e){            
            session()->setFlashdata('pesan','Data gagal ditambahkan, Harap periksa kembali inputan');
            return redirect()->to(base_url('form'));
        }        

    }

    public function formFix()
    {
        $session_login = session()->get();
        $data_where = ['username' => $session_login['username'], 'status' => FALSE]; 
        $data_form = $this->formModel->where($data_where)->findAll();   
        foreach($data_form as $data){
            // var_dump($data);die;
            $id = $data['id'];
            $datas = [
                'tanggal'   => $this->request->getVar('tanggal'),
                'nama'      => $this->request->getVar('nama'),
                'shift'     => intval($this->request->getVar('shift')),
                'status'    => true
            ];
            // var_dump($id);var_dump($datas);die;
            $this->formModel->update($id,$datas);
            return redirect()->to(base_url('tabel-tkl'));
        }
    }

    public function first()
    {
        $data = [
            'tittle' => 'First'
        ];
        
        if($this->get_status != 'nope'){            
            return redirect()->to('form');
        }
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')                
                .view('pages/first_input')
                .view('template/footer');
    }
    public function firstAdd()
    {
        $session_login = session()->get();
        $this->formModel->save([
            'username'  => $session_login['username'],
            'mesinID'   => $session_login['mesinID'],
            'tanggal'   => $this->request->getVar('tanggal'),
            'nama'   => $this->request->getVar('nama'),
            'shift'   => $this->request->getVar('shift'),
            'no_schedule'   => $this->request->getVar('no_schedule'),
            'kode_produk'   => $this->request->getVar('kode_produk'),
            'batch'   => $this->request->getVar('batch'),
            'status' => FALSE
        ]);
        session()->setFlashdata('pesan','Data berhasil ditambahkan');
        return redirect()->to(base_url('form'));
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
