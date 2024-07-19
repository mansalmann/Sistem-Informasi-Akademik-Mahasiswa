<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository{
use PHPUnit\Framework\TestCase;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\LoginMahasiswa;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\SessionsMahasiswa;

    class SessionsMahasiswaRepositoryTest extends TestCase{

        private SessionsMahasiswaRepository $session;
        private LoginMahasiswaRepository $loginMahasiswaRepository;

        protected function setUp():void{
            $this->loginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->session = new SessionsMahasiswaRepository(DatabaseCall::getDatabaseConnection());

            $this->session->deleteSessions();
            
        }

        // test ketika data session berhasil dibuat
        // data sessions baru bisa dibuat jika nim mahasiswa sudah ada di database login mahasiswa
        public function testSaveSessionSuccess(){
            $session = new SessionsMahasiswa();
            $session->id = uniqid();
            $session->nim_mahasiswa = "24040119130088";
            
            $this->session->saveSessions($session);

            // cek data session yang baru saja disimpan
            $result = $this->session->findById($session->id);
            self::assertEquals($session->id, $result->id);
            self::assertEquals($session->nim_mahasiswa, $result->nim_mahasiswa);
        }

        // test hapus data sessions berdasarkan input id (akan diproses oleh service)
        public function testDeleteByIdSuccess(){
            $session = new SessionsMahasiswa();
            $session->id = uniqid();
            $session->nim_mahasiswa = "24040119130088";
            
            $this->session->saveSessions($session);

            $result = $this->session->findById($session->id);
            self::assertEquals($session->id, $result->id);
            self::assertEquals($session->nim_mahasiswa, $result->nim_mahasiswa);
            
            // hapus data sessions
            $this->session->deleteById($session->id);
            
            $result = $this->session->findById($session->id);

            // ketika data sessions dihapus maka akan mengembalikan nilai null
            self::assertNull($result);
        }

        // test ketika id tidak ditemukan
        public function testFindByIdNotFound(){
            $result = $this->session->findById("salah");

            // ketika data sessions dihapus maka akan mengembalikan nilai null
            self::assertNull($result);
        }
    }
}