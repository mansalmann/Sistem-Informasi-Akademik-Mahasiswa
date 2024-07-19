<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\LoginMahasiswa;
    class LoginResponseData{

        // class ini merupakan representasi dari data domain yang dikembalikan oleh repository setelah memanggil database
        public LoginMahasiswa $loginMahasiswa;
    }
}