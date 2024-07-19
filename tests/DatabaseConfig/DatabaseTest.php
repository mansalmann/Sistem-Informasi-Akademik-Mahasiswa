<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\DatabaseConfig{
use PHPUnit\Framework\TestCase;
use ProgrammerSalman\SistemInformasiAkademikMahasiswa\Config\DatabaseCall;

   class DatabaseTest extends TestCase{
    
        // tes koneksi ke database
        public function testGetConnetion(){
            $connection = DatabaseCall::getDatabaseConnection();
            self::assertNotNull($connection);
        }

         // memastikan ketika kita panggil fungsi testGetConnection() maka dia tetap mengembalikan object pdo
        public function testGetConnetionCheck(){
            $connection1 = DatabaseCall::getDatabaseConnection();
            $connection2 = DatabaseCall::getDatabaseConnection();
            self::assertSame($connection1, $connection2);
        }
   }
}