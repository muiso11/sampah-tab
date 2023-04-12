<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\FormModel;
use App\Models\KegiatanModel;
use App\Models\LovModel;
use App\Models\MesinModel;
use App\Models\RoleModel;
use \Config\Database;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use CodeIgniter\API\ResponseTrait;

class InjectData extends BaseController
{
    protected $accountModel;
    protected $roleModel;
    protected $mesinModel;
    protected $lovModel;
    protected $formModel;
    protected $kegiatanModel;
    use ResponseTrait;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->roleModel = new RoleModel();
        $this->mesinModel = new MesinModel();
        $this->lovModel = new LovModel();        
        $this->formModel = new FormModel();            
        $this->kegiatanModel = new KegiatanModel();                    
    }

    public function regisAsal(){
        $akun = [
            [
                'nama'      => 'admin',
                'password'  => md5('123'),
                'mesinID'   => '1',
                'role'      => '1'                
            ],[
                'nama'      => 'muiso',
                'password'  => md5('123'),
                'mesinID'   => '2',
                'role'      => '2'
            ]
        ];
        $mesin = [
            [
            'kode_mesin'=> 'all',                    
            'nama_mesin'=> 'all'
        ],[
            'kode_mesin'=> 'K21B',                    
            'nama_mesin'=> 'IMA L11'            
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A'
            ]
        ];
        $role = [
            [
            'role'      => 'admin',                        
            'akses'     => 'all'
        ],[
            'role'      => 'user',                        
            'akses'     => 'dashboard,dashboard/add,dashboard/edit'            
            ]
        ];
        $lov = [
            [
            'kode_keg'  => 2,            
            'aktivitas' => 'run',
            'durasi'    => 10,
            'mesinID'   => 1,
        ],[
            'kode_keg'  => 3,            
            'aktivitas' => 'Blistering web control area',
            'durasi'    => 10,
            'mesinID'   => 2,
        ],[
            'kode_keg'  => 3,            
            'aktivitas' => 'Blistering sealing roll area',
            'durasi'    => 20,
            'mesinID'   => 2,
        ],[
            'kode_keg'  => 3,            
            'aktivitas' => 'Cartoning blister magazine area',
            'durasi'    => 20,
            'mesinID'   => 3,
        ],[
            'kode_keg'  => 7,            
            'aktivitas' => 'cusu',
            'durasi'    => 20,
            'mesinID'   => 1,
        ],[
            'kode_keg'  => 7,            
            'aktivitas' => 'gbn',
            'durasi'    => 20,
            'mesinID'   => 1,
            ]
        ];
        // $form = [
        //     [
        //     'username'  => 'muiso',
        //     'mesinID'   => '2',
        //     'tanggal'   => '2023-03-05',
        //     'nama'      => 'mui',
        //     'shift'     => 1,
        //     'no_schedule' => '2341241',
        //     'kode_produk' => 'TPGRS',
        //     'batch' => 'TP123S',
        //     'status'    => FALSE
        //     ],[            
        //     'username'  => 'muiso',
        //     'mesinID'   => '2',
        //     'tanggal'   => '2023-03-05',
        //     'nama'      => 'mui',
        //     'shift'     => 1,
        //     'no_schedule' => '2341242',
        //     'kode_produk' => 'TPGRE',
        //     'batch' => 'TP123W',
        //     'status'    => FALSE
        //     ],[
        //     'username'  => 'admin',
        //     'mesinID'   => '1',
        //     'tanggal'   => '2023-03-05',
        //     'nama'      => 'adm',
        //     'shift'     => 1,
        //     'no_schedule' => '234124',
        //     'kode_produk' => 'TPGR',
        //     'batch' => 'TP123',
        //     'status'    => TRUE
        //     ]
        // ];
        // $keg = [
        //     [
        //     'kode_keg'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '2341241',
        //     'kode_produk' => 'TPGRS',
        //     'batch' => 'TP123S'
        //     ],[
        //     'kode_keg'  => '2',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'Goo',
        //     'no_schedule' => '2341242',
        //     'kode_produk' => 'TPGRE',
        //     'batch' => 'TP123W'
        //     ],[
        //     'kode_keg'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '2341242',
        //     'kode_produk' => 'TPGRE',
        //     'batch' => 'TP123W',
        //     ],[
        //     'kode_keg'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '234124',
        //     'kode_produk' => 'TPGR',
        //     'batch' => 'TP123',
        //     ]
        // ];
        $this->accountModel->insertBatch($akun);
        $this->mesinModel->insertBatch($mesin);
        $this->roleModel->insertBatch($role);
        $this->lovModel->insertBatch($lov);
        // $this->formModel->insertBatch($form);
        // $this->kegiatanModel->insertBatch($keg);        
        var_dump("Berhasil gannn");die;
    }
    public function tampil()
    {
        $akun = $this->accountModel->findAll();
        $mesin = $this->mesinModel->findAll();
        $role = $this->roleModel->findAll();
        $lov = $this->lovModel->getAll('K21B');
        $halo = $this->formModel->getAll();
        $keg = $this->kegiatanModel->findAll();
        print_r($akun);
        echo '<br>';
        print_r($mesin);
        echo '<br>';
        print_r($role);
        echo '<br>';
        print_r($lov);
        echo '<br>';
        print_r($halo);
        echo '<br>';
        print_r($keg);
        echo '<br>';
        var_dump(session()->get());
        // var_dump($halo);die;
        
        // setcookie('username', '', 0, '/');
        

    }
    public function cookie(){
        // $store = new CookieStore([
        //             new Cookie('login_token','Halooo'),
        //             new Cookie('remember_token','Bisaaa'),
        //     ]);

        //     cookies()->get('login_token');
        // $store->has('login_token');
        // $halo = helper('cookie');
        // get_cookie('login_token');
        // var_dump($store);die;

        // $store = cookies()->has('login_token');
        setcookie('username', 'administrator', time() + (60 * 60 * 24 * 5), '/');
        var_dump($_COOKIE["username"]);die;
    }
    public function cobaAjax()
    {
        $session_login = session()->get();
        $mesinID = $session_login['mesinID'];
        if($mesinID == 1){
            $dataku = $this->lovModel->findAll();    
        }else{
            $dataku = $this->lovModel->getAll(1);
            $datas = $this->lovModel->getAll($mesinID);       
            foreach($datas as $data){
                array_push($dataku,$data);
            }
        }
        // var_dump($session_login);die;
        // var_dump($dataku);die;
        return $this->respond($dataku,200);
    }
    public function form1()
    {
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
                .view('coba/modals/addF1')
                .view('modals/edit_tkl',$data)
                .view('coba/form/form1',$data)
                .view('template/footer');
    }
    public function form2()
    {
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
                .view('coba/modals/addF2')
                .view('coba/modals/firstF2')
                .view('modals/edit_tkl',$data)
                .view('coba/form/form2',$data)
                .view('template/footer');
    }
    public function form3()
    {
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
                .view('coba/modals/addF3')
                .view('modals/edit_tkl',$data)
                .view('coba/form/form3',$data)
                .view('template/footer');
    }
}