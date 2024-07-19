<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Middleware{

    // berisi interface dari middleware
    interface Middleware{
        function beforeController():void;
    }
}