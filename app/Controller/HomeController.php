<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Controller{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\App\View;

    // controller untuk home
    class HomeController{

        public function home(){
            View::renderPage("dashboard",[
                "title" => "Dashboard Mahasiswa"
            ]);
        }
    }

}