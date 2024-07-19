<?php


namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service{
use PHPUnit\Framework\TestCase;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model\LoginRequestData;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;

    class LoginMahasiswaServiceTest extends TestCase{
        private LoginMahasiswaRepository $loginMahasiswaRepository;
        private LoginMahasiswaService $loginMahasiswaService;

        protected function setUp() : void{
            $this->loginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->loginMahasiswaService = new LoginMahasiswaService($this->loginMahasiswaRepository);
        }

        public function testLoginSuccess(){
            // buat model data dari user
            $akunMahasiswa = new LoginRequestData();
            $akunMahasiswa->nim = "24040119130088";
            $akunMahasiswa->password = "123456";

            // cek data nya ketika login
            $result = $this->loginMahasiswaService->loginMahasiswa($akunMahasiswa);
            self::assertEquals($akunMahasiswa->nim, $result->loginMahasiswa->nim);
            self::assertTrue(password_verify($akunMahasiswa->password, $result->loginMahasiswa->password));
        }
    }
}