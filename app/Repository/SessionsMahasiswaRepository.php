<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\SessionsMahasiswa;

    class SessionsMahasiswaRepository{

        // sessions repository untuk akses ke database login sessions mahasiswa
        private \PDO $SessionDatabaseConnection;

        // ketika memanggil repository maka wajib ada koneksi ke database login sessions dulu
        public function __construct(\PDO $pdo){
            $this->SessionDatabaseConnection = $pdo;
        }

        // fungsi untuk simpan data sessions ke database (disimpan pada saat login berhasil)
        public function saveSessions(SessionsMahasiswa $sessionsMahasiswa):SessionsMahasiswa{
            $statement = $this->SessionDatabaseConnection->prepare("INSERT INTO sessions_mahasiswa (id, nim_mahasiswa) VALUES (?,?)");
            $statement->execute([$sessionsMahasiswa->id,$sessionsMahasiswa->nim_mahasiswa]);
            return $sessionsMahasiswa;
        }

        // fungsi untuk memastikan bahwa data sessions tsb sudah ada di database
        public function findById(?string $id):?SessionsMahasiswa{
            $statement = $this->SessionDatabaseConnection->prepare("SELECT id, nim_mahasiswa FROM sessions_mahasiswa WHERE id = ?");
            $statement->execute([$id]);

            try{
                // jika datanya ada
                if($data = $statement->fetch()){
                    $sessionsData = new SessionsMahasiswa();
                    $sessionsData->id = $data["id"];
                    $sessionsData->nim_mahasiswa = $data["nim_mahasiswa"];

                    // kembalikan dalam bentuk data session mahasiswa
                    return $sessionsData;
                }else {
                    return null;
                }
            }finally{
                $statement->closeCursor();
            }
        }

        // fungsi untuk menghapus data sessions ketika logout
        public function deleteById(string $id){
            $statement = $this->SessionDatabaseConnection->prepare("DELETE FROM sessions_mahasiswa WHERE id = ?");
            $statement->execute([$id]);
        }

        // fungsi untuk menghapus semua data session di database
        public function deleteSessions(): void{
            $this->SessionDatabaseConnection->exec("DELETE FROM sessions_mahasiswa");
        }
    }
}