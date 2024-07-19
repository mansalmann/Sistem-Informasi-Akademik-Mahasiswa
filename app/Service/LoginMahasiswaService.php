<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\Service{
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Exception\ValidationException;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model\LoginRequestData;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Model\LoginResponseData;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Repository\LoginMahasiswaRepository;

    class LoginMahasiswaService{

        // layer service membutuhkan repository
        private LoginMahasiswaRepository $loginMahasiswaRepository;
        
        // ketika membuat instansiasi class service maka wajib mengirim parameter class repository
        public function __construct(LoginMahasiswaRepository $loginMahasiswaRepository){
            $this->loginMahasiswaRepository = $loginMahasiswaRepository;
        }

        // kode logic untuk memproses alur login akun sebagai mahasiswa
        // function loginMahasiswa perlu request data dari user (id dan password) yang dikirimkan melalui parameter
        public function loginMahasiswa(LoginRequestData $loginRequestData):LoginResponseData{
            // melakukan validasi data dari login mahasiswa
            $this->validationLoginData($loginRequestData);

            // jika tidak ada error yang terjadi maka lanjut proses pengecekan data login akun mahasiswa ke database
            // cek nim di database
            $data = $this->loginMahasiswaRepository->findByNIM($loginRequestData->nim);

            // jika query data nya tidak ada di database
            if($data == null){
                throw new ValidationException("NIM atau Password salah!");
            }

            // jika ada hasil query data di database
            // cek password
            if(password_verify($loginRequestData->password,$data->password)){
                $response = new LoginResponseData();
                $response->loginMahasiswa = $data; // simpan dan kirim datanya ke controller
                return $response;
            }else{
                throw new ValidationException("NIM atau Password salah!");
            }
        }   

        // function untuk melakukan valdiasi
        public function validationLoginData(LoginRequestData $requestData){
            // cek jika nim dan password nya kosong atau tidak ada
            $nimValidation = htmlentities(strip_tags(trim($requestData->nim)));
            $passwordValidation = htmlentities(strip_tags(trim($requestData->password)));

            if(empty($nimValidation) || $nimValidation == null || empty($passwordValidation) || $passwordValidation == null){
                throw new ValidationException("NIM atau Password tidak boleh kosong");
            }
        }
    }
}