<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\LoginMahasiswa;

    class LoginMahasiswaRepository{

        // layer repository itu yang berhubungan dengan database
        // maka membutuhkan PDO untuk bisa terhubung ke database
        private \PDO $DatabaseConnection;

        // constructor
        // ketika memanggil repository pastikan bahwa sistem telah terhubung ke database
        public function __construct(\PDO $DatabaseConnection){
            $this->DatabaseConnection = $DatabaseConnection;
        }

        // fungsi untuk mencari data login akun mahasiswa berdasarkan nim yang telah terdaftar di database
        public function findByNIM(string $nim): ?LoginMahasiswa{

            $statement = $this->DatabaseConnection->prepare("SELECT nim, password FROM login_mahasiswa WHERE nim = ?");
            $statement->execute([$nim]);

            // lakukan try catch
            try{
                if($data = $statement->fetch()){
                    $accessLoginMahasiswa = new LoginMahasiswa();
                    
                    $accessLoginMahasiswa->nim = $data["nim"];
                    $accessLoginMahasiswa->password = $data["password"];

                    // jika data ada kembalikan data domain LoginMahasiswa
                    return $accessLoginMahasiswa;
                }else{
                    // jika data yang dicari tidak ada kembalikan nilai null
                    return null;
                }
            }finally{
                // close cursor untuk mengurangi penggunaan memori di server
                $statement->closeCursor();
            }
        }

        // fungsi untuk menghapus semua data loginMahasiswa
        public function deleteAllData(){
            $this->DatabaseConnection->exec("DELETE FROM login_mahasiswa");
        }
    }
}