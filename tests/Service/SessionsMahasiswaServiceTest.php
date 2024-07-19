<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service{
    use PHPUnit\Framework\TestCase;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\SessionsMahasiswa;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;
    
    function setcookie(string $name, ?string $value, string $date, string $url){
        echo "$name : $value";
    }
    
    class SessionsMahasiswaServiceTest extends TestCase{

        private SessionsMahasiswaService $service;
        private SessionsMahasiswaRepository $session;
        private LoginMahasiswaRepository $loginMahasiswaRepository;

        protected function setUp(): void{
            $this->session = new SessionsMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->loginMahasiswaRepository = new LoginMahasiswaRepository(DatabaseCall::getDatabaseConnection());
            $this->service = new SessionsMahasiswaService($this->session, $this->loginMahasiswaRepository);
        }

        // test ketika membuat session baru
        public function testCreateSession(){
            $newSession = $this->service->createSession("24040119130088");
            self::expectOutputRegex("/cookie_siam_account : $newSession->id/");

            // cek di database session
            $result = $this->session->findById($newSession->id);
            self::assertEquals($newSession->nim_mahasiswa,$result->nim_mahasiswa);
        }

        // test untuk menghapus session
        public function testDestroySession(){
            $newSession = new SessionsMahasiswa();
            $newSession->id = uniqid();
            $newSession->nim_mahasiswa = "24040119130088";
            $this->session->saveSessions($newSession);

            /// buat cookie
            $_COOKIE[SessionsMahasiswaService::$cookie_name] = $newSession->id;
            $this->service->destroySession();

            self::expectOutputRegex("/cookie_siam_account :/");

            // memastikan bahwa data session dengan id di atas sudah dihapus dari database
            $result = $this->session->findById($newSession->id);
            self::assertNull($result);
        }
    }
}