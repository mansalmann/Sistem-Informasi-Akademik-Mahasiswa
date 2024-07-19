<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository{
use PHPUnit\Framework\TestCase;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;

    class LoginMahasiswaRepositoryTest extends TestCase{

        private LoginMahasiswaRepository $loginMahasiswaRepository;
        protected function setUp():void{
            // ketika memanggil repository maka butuh koneksi ke database
            $this->loginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            }

        public function testFindByNIM(){
            $result = $this->loginMahasiswaRepository->findByNIM("24040119130088");
            self::assertNotNull($result->nim);
        }
            



    }

}