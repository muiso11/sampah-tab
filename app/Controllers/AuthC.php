<?php

namespace App\Controllers;

use App\Models\AccountModel;

class AuthC extends BaseController
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }
    public function login()
    {
        $data = [
            'tittle' => 'login'
        ];
        $accounts = $this->accountModel;
        $login = $this->request->getPost('login');
        if($login){            
            $username = $this->request->getPost('nama');            
            $password = $this->request->getPost('password');
            // var_dump($this->request->getPost('nama'));die;// Untuk mengubah tulisan menjadi huruf kecil
            $user = strtolower($username); //biarkan errornya
            $err = null;
            if($username == '' or $password == ''){
                $err = "Silahkan Masukkan username dan password";
            }
            // var_dump($accounts->where('nama',$user)->first());die; //Digunakan untuk mengambil data dari database
            // Syntax dibawah digunakan untuk mencocokkan data username dan password yang diterima dari form login
            // username dicheck melalui apakah username tersebut ada didalam data atau tidak
            if($account = $accounts->where('nama',$user)->first()){                            
                if($account['password'] == md5($password)){ //biarkan errornya
                    // var_dump($account['password'] == $password);die; // Check apakah berhasil atau tidak
                    $dataAkun = [
                        // 'id'        => $account['id'],
                        'username'      => $account['nama'],
                        // 'password'  => $account['password'],
                        'role'      => $account['role'],
                        'mesinID'   => $account['mesinID']
                    ];
                    session()->set($dataAkun);                    
                    return redirect()->to('form');
                }else{
                    $err = "Username atau Password Salah";                    
                }                
            }else{
                $err = "Macam Tak Betul Lah";
            }
            if($err){
                session()->setFlashdata('username', $username);
                session()->setFlashdata('password', $password);
                session()->setFlashdata('error', $err);
                return redirect()->to('login');
            }
        }
        return   view('template/header',$data)
                .view('pages/login')
                .view('template/footer');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('login');
    }

    public function regisAsal(){
        $this->accountModel->save([
            'nama'      => 'muiso',
            'password'  => md5('123'),
            'kode_mesin'=> '',
            'role'      => 'admin'
        ]);
        var_dump("Berhasil gannn");die;
    }
}
