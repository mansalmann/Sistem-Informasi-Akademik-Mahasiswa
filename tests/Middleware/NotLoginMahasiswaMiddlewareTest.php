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


namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Middleware{
    
    use PHPUnit\Framework\TestCase;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\SessionsMahasiswa;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;
    use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service\SessionsMahasiswaService;

    class NotLoginMahasiswaMiddlewareTest extends TestCase{

        private NotLoginMahasiswaMiddleware $middleware;
        private SessionsMahasiswaRepository $repository;

        protected function setUp():void{
            $this->middleware = new NotLoginMahasiswaMiddleware();
            putenv("mode=test");

            $this->repository = new SessionsMahasiswaRepository(
                DatabaseCall::getDatabaseConnection());

            $this->repository->deleteSessions();
            
        }

        public function testBefore(){
            $this->middleware->beforeController();
            
            self::expectOutputString("");
        }
        
        public function testLoginSuccess(){
            $newSession = new SessionsMahasiswa();
            $newSession->id = uniqid();
            $newSession->nim_mahasiswa = "24040119130088";
            $this->repository->saveSessions($newSession);
            
            $_COOKIE[SessionsMahasiswaService::$cookie_name] = $newSession->id;

            $this->middleware->beforeController();
            
            self::expectOutputRegex("#Location: /dashboard#");
        }
    }
}
