<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Controller{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\App\View;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Exception\ValidationException;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model\LoginRequestData;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service\LoginMahasiswaService;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service\SessionsMahasiswaService;
    class LoginMahasiswaController {

        // controller untuk menghandle request dari user saat terjadi login dengan akun mahasiswa
        // tujuan utamanya adalah menampilkan halaman lewat View dan melakukan proses pengiriman data form login dari user ke service

        private LoginMahasiswaService $loginMahasiswaService;
        private SessionsMahasiswaService $sessionMahasiswaService;

        public function __construct(){
            $repository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->loginMahasiswaService = new LoginMahasiswaService($repository);

            $sessionRepository = new SessionsMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->sessionMahasiswaService = new SessionsMahasiswaService($sessionRepository, $repository);
            
        }
        // fungsi untuk tampilkan halaman login
        public function loginPage(){
            View::renderPage("login",[
                "title" => "Login Akun Mahasiswa"
            ]);
        }

        // fungsi untuk menhandle pengiriman data form login akun mahasiswa
        public function postLoginMahasiswa(){
            $requestData = new LoginRequestData();

            // dapatkan data dari form login
            $requestData->nim = $_POST["nim"];
            $requestData->password = $_POST["password"];

            try{
                $responseData = $this->loginMahasiswaService->loginMahasiswa($requestData);

                // jika tidak ada masalah dengan login maka buat sessions
                $this->sessionMahasiswaService->createSession($responseData->loginMahasiswa->nim);            

                // redirect ke halaman dashboard
                View::redirect("/dashboard");
            }
            catch(ValidationException $exception){
                // jika ada error maka tampilkan lagi halaman login
                    View::renderPage("login",[
                        "title" => "Login Akun Mahasiswa",
                        "error" => $exception->getMessage()
                    ]);
                }
        }
    }
}