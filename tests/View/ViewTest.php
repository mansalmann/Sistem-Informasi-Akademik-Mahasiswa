<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\View{
use PHPUnit\Framework\TestCase;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\App\View;

    class ViewTest extends TestCase{

        public function testRenderPage(){
            View::renderPage("login",[
                "title" => "Testing"
            ]);
            self::expectOutputRegex("/Testing/");
        }

    }
}