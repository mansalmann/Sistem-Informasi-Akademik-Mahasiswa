-- Active: 1718988390761@@127.0.0.1@3306@aplikasi_siam_test
CREATE DATABASE aplikasi_siam;
CREATE DATABASE aplikasi_siam_test;

CREATE TABLE login_mahasiswa(
    nim VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
)

CREATE TABLE sessions_mahasiswa(
    id VARCHAR(255) PRIMARY KEY,
    nim_mahasiswa VARCHAR(255) NOT NULL
)

ALTER TABLE sessions_mahasiswa
ADD CONSTRAINT fk_sessionsMahasiswa_loginMahasiswa
FOREIGN KEY (nim_mahasiswa) REFERENCES login_mahasiswa(nim);

INSERT INTO login_mahasiswa (nim,password) VALUES(24040119130088,123456);

SELECT * FROM login_mahasiswa;
SELECT * FROM sessions_mahasiswa; 
-- $2y$10$G2t16TFzw.qUS9B8HpP8uunmwYD50oJwC44zE0mjfboG7CZfqm3UO
