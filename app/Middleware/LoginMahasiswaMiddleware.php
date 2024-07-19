<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Middleware{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\App\View;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service\SessionsMahasiswaService;

    class LoginMahasiswaMiddleware implements Middleware{

        // middleware untuk pengecekan status login
        private SessionsMahasiswaService $session;

        public function __construct(){
            $sessionMahasiswaRepository = new SessionsMahasiswaRepository(DatabaseCall::getDatabaseConnection());

            $LoginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());

            $this->session = new SessionsMahasiswaService($sessionMahasiswaRepository, $LoginMahasiswaRepository);
        }
        
        public function beforeController(): void{
            // pemeriksaan kondisi login user menggunakan function currentSession milik service
            $user = $this->session->currentSession();
            if($user == null){
                View::redirect("/login");
            }
        }
    }
}