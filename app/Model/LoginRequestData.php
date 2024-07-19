<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model{

    class LoginRequestData {

        // class ini merupakan representasi dari data form login yang dikirimkan oleh user (request data)
        public ?string $nim = null;
        public ?string $password = null;
    }
}