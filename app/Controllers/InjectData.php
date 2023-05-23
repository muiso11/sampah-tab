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
    protected $get_datas;
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
        $this->get_datas = $this->formModel->where($data)->findAll();   
        foreach($this->get_datas as $data){
            $this->get_data = $data;
        }
        
        // var_dump($this->get_data);die;
        $this->get_status = ($this->get_data == NULL ? 'nope': $this->get_data['status']);        
        // var_dump($this->get_status);die;        
    }
    public function cobaFix()
    {        
        foreach($this->get_datas as $data){
            $this->formModel->update($data['id'],['status' => TRUE]);
        }
        session()->setFlashdata('pesan','Gagal Input Ke Spreadsheet, Silahkan Segera Check Spreadsheet');
        return redirect()->to(base_url('DashboardV3'));

    }
    public function cobaDelete()
    {
        try{
            $form_data = $this->get_data;            
            $nomor = $this->request->getVar('nomor');
            $oldJoin = $this->request->getVar('oldJoin');
            
            $checkJoin = count($this->formModel->getData($oldJoin,FALSE));
            $countData = count($this->formModel->getAll($form_data['mesinID'],FALSE));

            $sheet = $this->mesinModel->find($form_data['mesinID']);
            $range = $sheet['totalRow'] - $countData + $nomor - 2;

            $this->formModel->deleteData('kegiatan',$this->request->getVar('oldID'));
            $this->gSheets->deleteCells($this->idSheets,$range);
            $this->mesinModel->update($sheet['mesinID'],['totalRow' => $sheet['totalRow']-1] );
            if($checkJoin == 1){
                $this->formModel->deleteData('form',$form_data['id']);
            }

        }catch(Error $e){
            var_dump("GAGAL".$e);
        }
    }   
    
    public function cobaFixWithEdit()
    {        
        $headerName = ['tanggal','shift','nama'];
        
        $headersName = $this->headerModel->findAll();                
        foreach($headersName as $name){
            array_push($headerName,'kegiatan.'.$name['nama_header']);
        }
        $dataKegiatan = $this->formModel->savedAll($headerName,$this->get_data['mesinID']);    

        $datas = [
            'tanggal'   => $this->request->getVar('tanggal'),
            'nama'      => $this->request->getVar('nama'),
            'shift'     => $this->request->getVar('shift'),
            'status'    => FALSE,
        ];
        foreach($this->get_datas as $data){
            $this->formModel->update($data['id'],$datas);
        }
        $noCol = 2;
        foreach($dataKegiatan as $dataskeg){
            $noCell = 0;            
            foreach($dataskeg as $data){
                $this->gSheets->appendValues($this->idSheets,'Sheet1!'.chr(65+$noCell).$noCol,'RAW',[$data]);
                $noCell = $noCell + 1;   
                sleep(1);
            } 
            // sleep(2);
            $noCol++;
            if($noCol == 8){
                break;
            }
        }        
    }
    public function cobaEdit()
    {                            
        try{                        
            $form_data = $this->get_data;
            $oldID = $this->request->getVar('old_id');
            $oldJoinkeg = $this->request->getVar('joinkeg');
            $idForm = $this->formModel->where(['joinkeg' => $oldJoinkeg, 'status' => FALSE])->findAll();               
            $kode_kegiatan = $this->request->getVar('kode_kegiatan');
            $newNo = $this->request->getVar('newNo');
            $newKode = $this->request->getVar('newKode');
            $newBatch = $this->request->getVar('newBatch');               
            $nomorData = $this->request->getVar('nomor');
            $noSche = $this->request->getVar('no_schedule');
            $sheet = $this->mesinModel->find($form_data['mesinID']);            
            $countData = count($this->formModel->getAll($form_data['mesinID'],FALSE));
            $range = $sheet['totalRow'] - $countData + $nomorData - 1;                        
            $totalRow = $sheet['totalRow'] - $countData;            
            $fix_save = [];
            $newData = [];
            $newjoinkeg = str_replace('-','',$form_data['tanggal']).$form_data['shift'].$newNo;
            
            if($kode_kegiatan == "Pilih" || ($noSche == "Pilih" && $newNo == NULL && $newKode == NULL && $newBatch == NULL)){
                session()->setFlashdata('pesan','Silahkan pilih Kode Kegiatan dan No Schedule dengan benar');
                return redirect()->to(base_url('DashboardV3'));
            }elseif(isset($newNo,$newKode,$newBatch)){
                $kegiatanDB = $this->kegiatanModel->where('joinkeg',$oldJoinkeg)->findAll();
                $newDataSheet = [                    
                    ($newNo == NULL? $kegiatanDB[0]['no_schedule'] : $newNo ),
                    ($newKode == NULL? $kegiatanDB[0]['kode_produk'] : $newKode ),
                    ($newBatch == NULL? $kegiatanDB[0]['batch'] : $newBatch ),                    
                ];                
                $newDataKegiatan = [
                    'no_schedule'   => ($newNo == NULL? $kegiatanDB[0]['no_schedule'] : $newNo ),
                    'kode_produk'   => ($newKode == NULL? $kegiatanDB[0]['kode_produk'] : $newKode ),
                    'batch'         => ($newBatch == NULL? $kegiatanDB[0]['batch'] : $newBatch ),
                    'joinkeg'       => ($newNo == NULL? $oldJoinkeg : $newjoinkeg),
                ];
                
                foreach($this->get_datas as $data){                                  
                    if($data['joinkeg'] == $this->request->getVar('joinkeg')){
                        $getdatas = $this->formModel->getData($this->request->getVar('joinkeg'));
                        foreach($getdatas as $getdata){                            
                            $this->kegiatanModel->update($getdata['id'],$newDataKegiatan);
                            $this->gSheets->valueUpdate($sheet['sheetID'],$sheet['nama_sheet'].'!M'.$totalRow.':O'.$totalRow,'RAW',$newDataSheet);
                            $totalRow++;                        
                        }
                        break;
                    }
                    $totalRow = $totalRow + count($this->formModel->getData($this->request->getVar('joinkeg'))) + 1;                    
                }
                $this->formModel->update($idForm[0]['id'],$newDataKegiatan);
                $newData = array_merge($newData,$newDataKegiatan);
            }                        
            $headers = $this->headerModel->findAll();                        
            foreach($headers as $header){
                $key = $header['nama_header']; $value = (strlen($this->request->getVar($key)) == 0 ? NULL:$this->request->getVar($key));
    
                $save_data = array($key => $value);
                $fix_save = array_merge($fix_save, $save_data);
            }
            $fix_save = array_merge($fix_save,$newData);                        
            $this->kegiatanModel->update($oldID,$fix_save);                              
            unset($fix_save['joinkeg']);
            $front_data = [
                'tanggal'   => $form_data['tanggal'],
                'shift'     => $form_data['shift'],
                'nama'      => $form_data['nama'],
            ];
            $fix_save = array_merge($front_data,$fix_save);            
            $dataSheet = [];
            foreach($fix_save as $save){  
                $filterData = ($save != NULL? $save :'');
                array_push($dataSheet,$filterData);
            }            
            $pushSpreadsheet = $this->gSheets->valueUpdate($sheet['sheetID'],$sheet['nama_sheet'].'!A2:'.chr(65 + count($headers)+2).$range,'RAW',$dataSheet);
            if($pushSpreadsheet == 'Success'){
                session()->setFlashdata('pesan','Gagal Input Ke Spreadsheet, Silahkan Segera Check Spreadsheet');
                return redirect()->to(base_url('DashboardV3'));
            }else{
                session()->setFlashdata('pesan','Data Berhasil Diubah Dengan Mulus');
                return redirect()->to(base_url('DashboardV3'));
            }
            
            

        }catch(Error $e){
            var_dump("Gagal" . $e);die;
            session()->setFlashdata('pesan','Terdapat Kegagalan Pada System Atau Periksa Kembali Jaringan Anda');
            return redirect()->to(base_url('DashboardV3'));
        }
    }
    public function cobaAdd()
    {                  
        try{
            $form_data = $this->get_data;              
            $sheet = $this->mesinModel->find($form_data['mesinID']);            
            $kode_kegiatan = $this->request->getVar('kode_kegiatan');            
            $aktivitas = $this->request->getVar('aktivitas');            
            $no_schedule = $this->request->getVar('no_schedule');            
            $newNo = $this->request->getVar('newNo');
            $newKode = $this->request->getVar('newKode');
            $newBatch = $this->request->getVar('newBatch');            
            $oldjoinkeg = $form_data['joinkeg'];
            $newjoinkeg = str_replace('-','',$form_data['tanggal']).$form_data['shift'].$newNo;            

            $fix_save = [
                'mesinID'   => intval($form_data['mesinID']),            
            ];
                        
            if(($kode_kegiatan == "Pilih") || ($no_schedule == "Pilih" && $kode_kegiatan != '7')){
                session()->setFlashdata('pesan','Silahkan pilih kode kegiatan dengan benar atau No Schedule dengan benar');
                return redirect()->to(base_url('DashboardV3'));
            }elseif($newBatch != NULL && $newNo != NULL && $newKode != NULL){
                $gbn = [                    
                    'no_schedule'   =>  $newNo,
                    'kode_produk'   =>  $newKode,
                    'batch'         =>  $newBatch,
                ];
                $fix_save = array_merge($gbn,$fix_save);
                $firstFormData = [
                    'username'      => $this->get_data['username'],
                    'mesinID'       => intval($this->get_data['mesinID']),
                    'tanggal'       => $this->get_data['tanggal'],
                    'nama'          => $this->get_data['nama'],
                    'shift'         => $this->get_data['shift'],                    
                    'status'        => FALSE,                    
                    'joinkeg'       => $newjoinkeg,                    
                ];
                $save_form = array_merge($firstFormData,$gbn);                
                $this->formModel->insert($save_form);

                $joinkeg = ['joinkeg'   => $newjoinkeg];
                $fix_save = array_merge($fix_save,$joinkeg);            
            }elseif(isset($newBatch,$newNo,$newKode) && $aktivitas != 'cusu'){
                session()->setFlashdata('pesan','Silahkan Isi No Schedule, Kode Produk, dan Batch Dengan Benar');
                return redirect()->to(base_url('DashboardV3'));
            }elseif($no_schedule == "Pilih"){
                session()->setFlashdata('pesan','Silahkan Pilih No Schedule Dengan Benar');
                return redirect()->to(base_url('DashboardV3'));
            }else{
                $joinkeg = ['joinkeg'   => $oldjoinkeg];
                $fix_save = array_merge($fix_save,$joinkeg);
            }
            
            // Untuk melakukan add data secara otomatis jika field berubah ubah                        
            $headers = $this->headerModel->findAll();                        
            foreach($headers as $header){
                $key = $header['nama_header']; $value = (strlen($this->request->getVar($key)) == 0 ? NULL:$this->request->getVar($key));
    
                $save_data = array($key => $value);
                $fix_save = array_merge($save_data, $fix_save);
            }                       
            $this->kegiatanModel->insert($fix_save);                
            unset($fix_save['mesinID'],$fix_save['joinkeg']);
            $fix_save = array_reverse($fix_save);
            $front_data = [
                'tanggal'   => $form_data['tanggal'],
                'shift'     => $form_data['shift'],
                'nama'      => $form_data['nama'],
            ];
            $fix_save = array_merge($front_data, $fix_save);
            $dataSheet = [];
            foreach($fix_save as $save){  
                $filterData = ($save != NULL? $save :'');
                array_push($dataSheet,$filterData);
            }                        
            $noCell = count($this->headerModel->findAll()) + 2;            
            $this->gSheets->appendValues($sheet['sheetID'],$sheet['nama_sheet'].'!A'.$sheet['totalRow'].':'.chr(65 + $noCell).$sheet['totalRow'],'RAW',$dataSheet);            
            $totalRow = [
                'totalRow' => intval($sheet['totalRow']) + 1,
            ];
            $this->mesinModel->update($form_data['mesinID'],$totalRow);
            
            // die;
            session()->setFlashdata('pesan','Sukses Menambahkan Data');
            return redirect()->to(base_url('DashboardV3'));
        }catch(Error $e){            
            session()->setFlashdata('pesan','ERROR! Data Gagal Ditambahkan');
            return redirect()->to(base_url('DashboardV3'));
        }
    }
    public function addLov()
    {
        
    }
    public function addForm()
    {
        try{
            $form_data = $this->get_data;                        
            $kode_kegiatan = $this->request->getVar('kode_kegiatan');
            $fix_save = [];
            if($kode_kegiatan == "Pilih"){
                session()->setFlashdata('pesan','Silahkan masukkan kode kegiatan dengan benar');
                return redirect()->to(base_url('DashboardV3'));
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
            session()->setFlashdata('pesan','Data Berhasil Ditambahkan');
            return redirect()->to(base_url('DashboardV3'));      
        }catch(Error){

        }
        
    }
    public function dashV3()
    {   
        // $totalRow = 6;
        // $noCell = 17;
        // $coba = ['2023-05-17','1','Imam','2','07:56','','','07:57','1','Run','','','431221','KODES','12211','',''];
        // var_dump($coba);die;
        // $this->gSheets->appendValues($this->idSheets,'Sheet1!A'.$totalRow.':'.chr(65 + $noCell).$totalRow,'RAW',$coba);                   
        // die;
        if($this->get_status == 'nope'){            
            return redirect()->to('first');
        }                
        $form_data = $this->get_data;                
        $form = $this->formModel->getAll(2,FALSE);
        $lovs = $this->lovModel->findAll();        
        $header = $this->headerModel->findAll();         
        
        if($form == NULL){
            if($form_data['shift'] == 1){
                $dari = '07:00:00';
            }
            elseif($form_data['shift'] == 2){
                $dari = '15:30:00';
            }
            elseif($form_data['shift'] == 3){
                $dari = '21:15:00';
            }
            else{
                var_dump("Terjadi Kesalahan, Silahkan Hubungi Saya");die;
            }
        }else{
            $change = array_reverse($form);
            $dari = $change[0]['selesai'];
        }
        $data = [
            'tittle'    => 'Dashboard',
            'data_awal' => $this->get_data,
            'header'    => $header,
            'longkap'   => '0',
            'data_form' => $form,
            'data_awal' => $form_data,            
            'dari'      => $dari
        ];        
                
        return   view('template/header',$data)
                .view('template/sidebar')
                .view('template/navbar')
                .view('modals/addFormV3',$data)
                .view('coba/modals/deleteTklV3')
                .view('coba/modals/editTklV3',$data)
                .view('pages/formV2',$data)
                .view('template/footer');
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
            session()->setFlashdata('pesan','Isi Pada Panjang Input Box Salah');
            return redirect()->to(base_url('struktur-table'));
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
            return redirect()->to(base_url('struktur-table'));
        }catch(ErrorException $e){
            session()->setFlashdata('pesan','Data gagal dihapus');
            return redirect()->to(base_url('struktur-table'));
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
            return redirect()->to(base_url('struktur-table'));
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

            $this->gSheets->valueUpdate($this->idSheets,'Sheet1!'.chr(67+count($this->headerModel->findAll())).'1','RAW',[$this->request->getVar('nama_header')]);

            session()->setFlashdata('pesan','Data berhasil ditambahkan');
            return redirect()->to(base_url('struktur-table'));        
        }catch(Error $e){
            session()->setFlashdata('pesan','Data gagal ditambahkan');
            return redirect()->to(base_url('struktur-table'));        
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
            'tittle'    => 'Struktur-Table',            
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
                'tipe'              => 'OPTION',
                'nama_header'       => 'no_schedule',
                // 'panjang_karakter'  => 10,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'OPTION',
                'nama_header'       => 'kode_produk',
                // 'panjang_karakter'  => 10,
                'panjang_inputbox'  => 'col-2',
                'edit'              => FALSE
            ],[
                'tipe'              => 'OPTION',
                'nama_header'       => 'batch',
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
            'nama_mesin'=> 'all',
            'nama_sheet'=> 'all',
            'sheetID'   => 'all',
            'gid'       => 'all',
            'totalRow'  => 2
        ],[
            'kode_mesin'=> 'K21B',                    
            'nama_mesin'=> 'IMA L11',
            'nama_sheet'=> 'Sheet1',
            'sheetID'   => '1oQN2C-Qa2KDOaADrfCO16OidIxOQiQBXX741KdtXNe0',
            'gid'       => '0',
            'totalRow'  => 2
        ],[
            'kode_mesin'=> 'K219',                    
            'nama_mesin'=> 'HM3 L8A',
            'nama_sheet'=> '2020',
            'sheetID'   => '1oQN2C-Qa2KDOaADrfCO16OidIxOQiQBXX741KdtXNe0',
            'gid'       => '0',
            'totalRow'  => 2            
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
        // $halo = $this->formModel->getAll(2,FALSE));
        $keg = $this->kegiatanModel->findAll();
        print_r($akun);
        echo '<br>';
        print_r($mesin);
        echo '<br>';
        print_r($role);
        echo '<br>';
        print_r($lov);
        echo '<br>';
        // print_r($halo);
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
        $data = [
            'message'   => 'success',
            'lov'       => $this->lovModel->findAll(),
            // 'data'      => $this->get_data,
            'form'      => $this->formModel->getNoSchedule(session()->get('mesinID')),
        ];
        return $this->respond($data,200);
    }
    public function form1()
    {
        // $mesin = $this->formModel->getAll(2,FALSE));
        $lovs = $this->lovModel->findAll();        
        $data = [
            'tittle'    => 'Dashboard',
            // 'data_mesin'=> $mesin,
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
        // $mesin = $this->formModel->getAll(2,FALSE));
        $lovs = $this->lovModel->findAll();        
        $data = [
            'tittle'    => 'Dashboard',
            // 'data_mesin'=> $mesin,
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
        // $mesin = $this->formModel->getAll(2,FALSE));
        $lovs = $this->lovModel->findAll();        
        $data = [
            'tittle'    => 'Dashboard',
            // 'data_mesin'=> $mesin,
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