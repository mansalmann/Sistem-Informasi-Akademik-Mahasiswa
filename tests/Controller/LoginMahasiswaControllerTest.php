<?php
namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\App{
    function header(string $value){
        echo $value;
    }
}

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service{
    function setcookie(string $name, ?string $value, string $date, string $url){
        echo "$name : $value";
    }
}

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Controller{
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;
    
    use PHPUnit\Framework\TestCase;
    
    class LoginMahasiswaControllerTest extends TestCase{
        
        private LoginMahasiswaController $controller;
        private LoginMahasiswaRepository $loginMahasiswaRepository;
        private SessionsMahasiswaRepository $sessionsMahasiswaRepository;
        
        protected function setUp():void{
            $this->controller = new LoginMahasiswaController();
            
            $this->sessionsMahasiswaRepository = new SessionsMahasiswaRepository(DatabaseCall::getDatabaseConnection());

            $this->loginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());

            putenv("mode=test");
            $this->sessionsMahasiswaRepository->deleteSessions();
        }

        // test halaman login
        public function testLoginMahasiswaPage(){
            $this->controller->loginPage();
            self::expectOutputRegex("/Login Akun Mahasiswa/");
        }

        // test jika login sebagai mahasiswa sukses
        public function testLoginMahasiswaSuccess(){

            // kirim data dari user
            $_POST["nim"] = "24040119130088";
            $_POST["password"] = "123456";
            $this->controller->postLoginMahasiswa();

            self::expectOutputRegex("#cookie_siam_account : #");
            self::expectOutputRegex("#Location: /dashboard#");
            
        }

        // test validasi input
        // public function testLoginMahasiswaValidationError(){
        //     $_POST["nim"] = "";
        //     $_POST["password"] = "";
        //     $this->controller->postLoginMahasiswa();

        //     self::expectOutputRegex("/Login Akun Mahasiswa/");
        //     self::expectOutputRegex("/Kosong/");
        //     self::expectOutputRegex("/Nomor Induk Mahasiswa/");
        //     self::expectOutputRegex("/Password/");

        // }

        // // test jika nim tidak ditemukan
        // public function testLoginMahasiswaNIMNotFound(){
        //     $_POST["nim"] = "salah";
        //     $_POST["password"] = "123456";
        //     $this->controller->postLoginMahasiswa();

        //     self::expectOutputRegex("/Login Akun Mahasiswa/");
        //     self::expectOutputRegex("/Salah/");
        //     self::expectOutputRegex("/Nomor Induk Mahasiswa/");
        //     self::expectOutputRegex("/Password/");
        // }

        // // test jika password salah
        // public function testLoginMahasiswaWrongPassword(){
        //     $_POST["nim"] = "24040119130088";
        //     $_POST["password"] = "salah";
        //     $this->controller->postLoginMahasiswa();

        //     self::expectOutputRegex("/Login Akun Mahasiswa/");
        //     self::expectOutputRegex("/Salah/");
        //     self::expectOutputRegex("/Nomor Induk Mahasiswa/");
        //     self::expectOutputRegex("/Password/");
        // }
        
    }
}