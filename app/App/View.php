<?php

namespace ProgrammerSalman\SistemInformasiAkademikMahasiswa\App{

    class View{

        // function untuk merender halaman web
        public static function renderPage(string $view, $responseData){
            // parameter $view untuk menghandle nama halaman mana yang mau dibuka pada file halaman web di folder View sesuai dengan request url nya
            // parameter $data untuk mengirim semua response data ke halaman web

            // tampilkan tiga halaman utama
            require(__DIR__."/../../public/view/header.php");
            require(__DIR__."/../../public/view/" . $view . ".php");
            require(__DIR__."/../../public/view/footer.php");
        }

        // function untuk redirect ke halaman tertentu berdasarkan request url di parameter
        public static function redirect(string $url){
            header("Location: $url");
            if(getenv("mode") != "test"){
                exit();
            }
        }
    }
}