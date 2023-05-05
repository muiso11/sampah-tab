<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\CobaModel;
use App\Models\FormModel;
use App\Models\HeaderModel;
use App\Models\KegiatanModel;
use App\Models\LovModel;
use App\Models\MesinModel;
use App\Models\RoleModel;
use \Config\Database;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use CodeIgniter\API\ResponseTrait;
use Error;
use ErrorException;
use Exception;

class InjectData extends BaseController
{
    protected $accountModel;
    protected $roleModel;
    protected $mesinModel;
    protected $lovModel;
    protected $formModel;
    protected $kegiatanModel;
    protected $headerModel;    
    protected $forge; 
    protected $cobaModel;   
    protected $db;   
    protected $gSheets;
    protected $idSheets;
    protected $get_data;
    protected $get_status;
    use ResponseTrait;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->roleModel = new RoleModel();
        $this->mesinModel = new MesinModel();
        $this->lovModel = new LovModel();        
        $this->formModel = new FormModel();            
        $this->kegiatanModel = new KegiatanModel(); 
        $this->headerModel = new HeaderModel();
        $this->cobaModel = new CobaModel();
        $this->forge = new Database();
        $this->db = db_connect();
        $this->gSheets = new SheetsApi();
        $this->idSheets = '1oQN2C-Qa2KDOaADrfCO16OidIxOQiQBXX741KdtXNe0';        

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
    public function addForm()
    {
        try{
            $form_data = $this->get_data;                        
            $kode_kegiatan = $this->request->getVar('kode_kegiatan');
            $fix_save = [];
            if($kode_kegiatan == "Pilih"){
                session()->setFlashdata('pesan','Silahkan pilih kode kegiatan dengan benar');
                return redirect()->to(base_url('form'));
            }elseif($kode_kegiatan != 7){
                $fix_save = [
                    'mesinID'       =>  $form_data['mesinID'],
                    'no_schedule'   =>  $form_data['no_schedule'],
                    'kode_produk'   =>  $form_data['kode_produk'],
                    'batch'         =>  $form_data['batch'],
                ];
            }
            // Untuk melakukan add data secara otomatis jika field berubah ubah            
            $coba = $this->request->getVar();
            $keys = array_keys($coba);            
            for($i = 0; $i < count($keys); $i++){                
                $key = $keys[$i]; $value = $this->request->getVar($keys[$i]);
                // var_dump("Coba " . $key . " => " . $value);die;

                $save_data = array($key => $value);
                $fix_save = array_merge($save_data,$fix_save); 
            }
            $this->kegiatanModel->insert($fix_save);                    
            var_dump('berhasil');die;            
        }catch(Error){

        }
        
    }
    public function editStruktur()
    {
        if($this->request->getVar('panjang_inputbox') == '1'){
            $datas = 'col-2';
        }elseif($this->request->getVar('panjang_inputbox') == '2'){
            $datas = 'col-3';
        }elseif($this->request->getVar('panjang_inputbox') == '3'){
            $datas = 'col-4';
        }elseif($this->request->getVar('panjang_inputbox') == '4'){
            $datas = 'col-6';
        }elseif($this->request->getVar('panjang_inputbox') == '5'){
            $datas = 'col-12';
        }elseif($this->request->getVar('panjang_inputbox') != '5'){
            session()->setFlashdata('pesan','Inputan Pada Panjang Inputbox Salah');
            return redirect()->to(base_url('edit-struktur'));
        }

        $forge = $this->forge::forge();
        $id = $this->request->getVar('id_data');        
        $old_name = $this->headerModel->find($id);

        $data = [
            'nama_header'       => $this->request->getVar('nama_header'),
            'panjang_inputbox'  => $datas,
        ];
        $fields = [
            $old_name['nama_header'] => [
                'name' => $this->request->getVar('nama_header')                                
            ],
        ];
        if($old_name['nama_header'] == $this->request->getVar('nama_header')){
            $this->headerModel->update($id,$data);  
            var_dump("Sama");die;
        }
        
        $forge->modifyColumn('kegiatan', $fields);  
        $this->headerModel->update($id,$data);  
        var_dump("berhasil");die;
    }
    public function deleteStruktur()    
    {
        $forge = $this->forge::forge();        
        try{
            $id = $_GET['id'];            
            $id_header = $this->headerModel->where('edit',TRUE)->find($id);
            $forge->dropColumn('kegiatan',$id_header['nama_header']);
            $this->headerModel->delete($id);

            session()->setFlashdata('pesan','Data berhasil dihapus');
            return redirect()->to(base_url('edit-struktur'));
        }catch(ErrorException $e){
            session()->setFlashdata('pesan','Data gagal dihapus');
            return redirect()->to(base_url('edit-struktur'));
        }

    }

    public function addStruktur()
    {        
        $forge = $this->forge::forge();                   
        
        // Untuk check inputan Panjang Input Box
        if($this->request->getVar('panjang_inputbox') == '1'){
            $datas = 'col-2';
        }elseif($this->request->getVar('panjang_inputbox') == '2'){
            $datas = 'col-3';
        }elseif($this->request->getVar('panjang_inputbox') == '3'){
            $datas = 'col-4';
        }elseif($this->request->getVar('panjang_inputbox') == '4'){
            $datas = 'col-6';
        }elseif($this->request->getVar('panjang_inputbox') == '5'){
            $datas = 'col-12';
        }elseif($this->request->getVar('panjang_inputbox') != '5'){
            session()->setFlashdata('pesan','Inputan Pada Panjang Inputbox Salah');
            return redirect()->to(base_url('edit-struktur'));
        }        
        try{      
            // Untuk melakukan add data secara otomatis jika field berubah ubah
            // $longkap = 4;$j=0;             
            // $header_data = $this->db->getFieldNames('header');
            // $fix_save = [];
            // foreach($header_data as $data){            
            //     if($j < $longkap){
            //         $j++;continue;
            //     }else{                                                                                                    
            //         $save_data = array($data => $this->request->getVar($data));
            //         $fix_save = array_merge($save_data,$fix_save);
            //     }
            // }                               
            $fix_save = [
                'tipe'              => 'TEXT',
                'nama_header'       => $this->request->getVar('nama_header'),
                'panjang_inputbox'  => $datas
            ];                        
            $fields = [
                $this->request->getVar('nama_header') => ['type' => 'TEXT']
            ];
            $forge->addColumn('kegiatan',$fields);
            $this->headerModel->insert($fix_save);

            $this->gSheets->valueUpdate($this->idSheets,'Sheet1!'.chr(68+count($this->headerModel->findAll())).'1','RAW',[$this->request->getVar('nama_header')]);

            session()->setFlashdata('pesan','Data berhasil ditambahkan');
            return redirect()->to(base_url('edit-struktur'));        
        }catch(Error $e){
            session()->setFlashdata('pesan','Data gagal ditambahkan');
            return redirect()->to(base_url('edit-struktur'));        
        }        
    }
    public function Struktur()
    {        
        $header_data = $this->db->getFieldNames('header');        
        $header = $this->headerModel->findAll();                
        $lov = $this->lovModel->getMesin();        
        for($i = 0; $i < count($header);$i++){            
            if($header[$i]['panjang_inputbox'] == 'col-2'){
                $header[$i]['panjang_inputbox'] = 1;
            }elseif($header[$i]['panjang_inputbox'] == 'col-3'){
                $header[$i]['panjang_inputbox'] = 2;
            }elseif($header[$i]['panjang_inputbox'] == 'col-4'){
                $header[$i]['panjang_inputbox'] = 3;
            }elseif($header[$i]['panjang_inputbox'] == 'col-6'){
                $header[$i]['panjang_inputbox'] = 4;
            }elseif($header[$i]['panjang_inputbox'] == 'col-12'){
                $header[$i]['panjang_inputbox'] = 5;
            }                                  
        }        
        $lov_header = ['Kode Kegiatan','Aktivitas', 'Durasi','Mesin'];
        $data = [
            'tittle'    => 'Edit-Struktur',            
            'longkap'   => '5',
            'header'    => $header_data,
            'body'      => $header,
            'lov'       => $lov,
        ];        
        // var_dump($header);die;

        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')                                
                .view('coba/modals/HeaderEdit',$data)
                .view('coba/modals/HeaderModals',$data)
                .view('coba/modals/lovModals')
                .view('coba/form/editStruktur',$data)
                .view('template/footer');
    }

    public function header()
    {
        $forge = $this->forge::forge();        
        // $forge->dropTable('coba', true);die;
        $fieldsFix = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],            
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ],        
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true
            ]
        ];        
        $header_data = $this->headerModel->findAll();
        // var_dump($header_data);die;
        // $forge->addKey('id', true);
        // $forge->addField($fieldsFix);
        // $forge->createTable('coba',true); echo "yeay";die;        
        // $forge->addColumn('coba',$fieldsFix);                  
                
        // foreach($header_data as $data){
        //     $nama = strtolower($data['nama_header']);
        // $fieldsNew = array($nama =>['type' =>$data['tipe'],'constraint'=>$data['panjang_karakter']]);
        //     $nama = str_replace(' ','_',$nama);
            // $forge->addColumn('coba',$fieldsNew);
        //     // var_dump($fieldsNew);die;
        // }

        $coba_tambah = [
            'mesinID' => [
                'type'           => 'INT',
                'constraint'     => 2,                
            ],
        ];
        $forge->addColumn('coba',$coba_tambah);
        var_dump("berhasil");die;        
        // return view()
    }

    public function isiCoba()
    {
        $this->cobaModel->save([
            'kode_kegiatan'  => '1',
            'dari'      => '01:01:00',            
            'selesai'   => '01:11:00',
            'durasi'    => 10,
            'aktivitas' => 'run',
            'no_schedule' => '2341241',
            'kode_produk' => 'TPGRS',
            'batch' => 'TP123S'
        ]);        
        var_dump("keisi");die;
    }

    public function regisAsal(){
        $header = [
            [
                'tipe'              => 'OPTION',
                'nama_header'       => 'kode_kegiatan',
                // 'panjang_karakter'  => 1,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TIME',
                'nama_header'       => 'dari',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TIME',
                'nama_header'       => 'panggil_teknik',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TIME',
                'nama_header'       => 'datang_teknik',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TIME',
                'nama_header'       => 'selesai',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'INT',
                'nama_header'       => 'durasi',
                // 'panjang_karakter'  => 3,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'OPTION',
                'nama_header'       => 'aktivitas',
                // 'panjang_karakter'  => 100,
                'panjang_inputbox'  => 'col-4',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TEXT',
                'nama_header'       => 'masalah',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-4',
                'edit'              => FALSE
            ],[
                'tipe'              => 'TEXT',
                'nama_header'       => 'tindakan',
                // 'panjang_karakter'  => NULL,
                'panjang_inputbox'  => 'col-4',
                'edit'              => FALSE
            ],[
                'tipe'              => 'VARCHAR',
                'nama_header'       => 'no_schedule',
                // 'panjang_karakter'  => 10,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'VARCHAR',
                'nama_header'       => 'batch',
                // 'panjang_karakter'  => 10,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'VARCHAR',
                'nama_header'       => 'kode_produk',
                // 'panjang_karakter'  => 10,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'INT',
                'nama_header'       => 'good',
                // 'panjang_karakter'  => 11,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'INT',
                'nama_header'       => 'defect',
                // 'panjang_karakter'  => 11,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ]
        ];
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
            'kode_kegiatan'  => 2,            
            'aktivitas' => 'run',
            'durasi'    => 10,
            'mesinID'   => 1,
        ],[
            'kode_kegiatan'  => 3,            
            'aktivitas' => 'Blistering web control area',
            'durasi'    => 10,
            'mesinID'   => 2,
        ],[
            'kode_kegiatan'  => 3,            
            'aktivitas' => 'Blistering sealing roll area',
            'durasi'    => 20,
            'mesinID'   => 2,
        ],[
            'kode_kegiatan'  => 3,            
            'aktivitas' => 'Cartoning blister magazine area',
            'durasi'    => 20,
            'mesinID'   => 3,
        ],[
            'kode_kegiatan'  => 7,            
            'aktivitas' => 'cusu',
            'durasi'    => 20,
            'mesinID'   => 1,
        ],[
            'kode_kegiatan'  => 7,            
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
        //     'kode_kegiatan'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '2341241',
        //     'kode_produk' => 'TPGRS',
        //     'batch' => 'TP123S'
        //     ],[
        //     'kode_kegiatan'  => '2',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'Goo',
        //     'no_schedule' => '2341242',
        //     'kode_produk' => 'TPGRE',
        //     'batch' => 'TP123W'
        //     ],[
        //     'kode_kegiatan'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '2341242',
        //     'kode_produk' => 'TPGRE',
        //     'batch' => 'TP123W',
        //     ],[
        //     'kode_kegiatan'  => '1',
        //     'dari'      => '01:01:00',            
        //     'selesai'   => '01:11:00',
        //     'durasi'    => 10,
        //     'aktivitas' => 'run',
        //     'no_schedule' => '234124',
        //     'kode_produk' => 'TPGR',
        //     'batch' => 'TP123',
        //     ]
        // ];
        $this->headerModel->insertBatch($header);
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
        // $session_login = session()->get();
        // $mesinID = $session_login['mesinID'];
        // if($mesinID == 1){
        //     $dataku = $this->lovModel->findAll();    
        // }else{
        //     $dataku = $this->lovModel->getAll(1);
        //     $datas = $this->lovModel->getAll($mesinID);       
        //     foreach($datas as $data){
        //         array_push($dataku,$data);
        //     }
        // }
        // var_dump($session_login);die;
        // var_dump($dataku);die;
        $dataku = $this->lovModel->findAll();
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