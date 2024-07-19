<?php
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Middleware\LoginMahasiswaMiddleware;

require_once(__DIR__."/../vendor/autoload.php");
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\App\Router;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;

use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Controller\LoginMahasiswaController;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Controller\HomeController;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Middleware\NotLoginMahasiswaMiddleware;

// mode database
DatabaseCall::getDatabaseConnection("production");

// url mapping
Router::add("GET", "/dashboard", HomeController::class, "home",[LoginMahasiswaMiddleware::class]);
Router::add("GET", "/", LoginMahasiswaController::class, "loginPage",[NotLoginMahasiswaMiddleware::class]);
Router::add("GET", "/login", LoginMahasiswaController::class, "loginPage",[NotLoginMahasiswaMiddleware::class]);
Router::add("POST", "/login", LoginMahasiswaController::class, "postLoginMahasiswa",[NotLoginMahasiswaMiddleware::class]);

Router::run();
