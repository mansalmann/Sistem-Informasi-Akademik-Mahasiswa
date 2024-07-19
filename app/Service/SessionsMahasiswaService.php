<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service{

use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\LoginMahasiswa;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Domain\SessionsMahasiswa;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\SessionsMahasiswaRepository;

    class SessionsMahasiswaService {

        // logic untuk sessions diproses di dalam service
        // manajemen sessions menggunakan cookie

        // nama cookie untuk tiap data sessions
        public static string $cookie_name = "cookie_siam_account";

        // service membutuhkan sessions repository dan login mahasiswa repository
        private SessionsMahasiswaRepository $sessionsMahasiswaRepository;
        private LoginMahasiswaRepository $loginMahasiswaRepository;

        public function __construct(SessionsMahasiswaRepository $sessionsMahasiswaRepository, LoginMahasiswaRepository $loginMahasiswaRepository){
            // akan dihandle oleh controller
            $this->sessionsMahasiswaRepository = $sessionsMahasiswaRepository;
            $this->loginMahasiswaRepository = $loginMahasiswaRepository;
        }

        // membuat sessions
        public function createSession(string $nim):SessionsMahasiswa{
            $session = new SessionsMahasiswa();
            $session->id = uniqid();
            $session->nim_mahasiswa = $nim;

            // simpan ke database session
            $this->sessionsMahasiswaRepository->saveSessions($session);

            // buat cookie supaya data sessions bisa disimpan di browser selama 30 hari
            setcookie(self::$cookie_name, $session->id, time() + (60*60*24*30),"/");
            return $session;
        }

        // fungsi untuk menghapus data session
        public function destroySession(){
            // cek apakah ada cookie sessions di browser
            $cookieSession = $_COOKIE[self::$cookie_name] ?? "";

            // hapus cookie dari database
            $this->sessionsMahasiswaRepository->deleteById($cookieSession);
            setcookie(self::$cookie_name, null, 1, "/");
        }

        // fungsi untuk mengecek sessions saat ini (ketika pengguna sudah login dan mengakses halaman web)
        public function currentSession():?LoginMahasiswa{
            // cek apakah ada cookie sessions di browser
            $cookieSession = $_COOKIE[self::$cookie_name] ?? "";
            $session = $this->sessionsMahasiswaRepository->findById($cookieSession);

            // jika cookie sessions tidak ada di browser
            if($session == null){
                return null;
            }

            // jika ada data cookie session di browser maka cek data tsb menggunakan data login mahasiswa dengan parameter nim dari data session yang berhasil didapat sebelumnya
            return $this->loginMahasiswaRepository->findByNIM($session->nim_mahasiswa);
        }
    }
}