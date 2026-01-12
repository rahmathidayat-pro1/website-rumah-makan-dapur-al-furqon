<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe
        ];
    }

    public static function flash()
    {
        if( isset($_SESSION['flash']) ) {
            echo "
                <script>
                    Swal.fire({
                        title: 'Data " . $_SESSION['flash']['pesan'] . "',
                        text: 'Berhasil " . $_SESSION['flash']['aksi'] . "',
                        icon: '" . $_SESSION['flash']['tipe'] . "',
                        confirmButtonColor: '#4f46e5'
                    });
                </script>
            ";
            unset($_SESSION['flash']);
        }
    }
    
    // Custom flash for general messages (not just CRUD)
    public static function setLoginFlash($title, $text, $icon) {
         $_SESSION['flash_login'] = [
            'title' => $title,
            'text'  => $text,
            'icon'  => $icon
        ];
    }

    public static function loginFlash() {
        if( isset($_SESSION['flash_login']) ) {
            echo "
                <script>
                    Swal.fire({
                        title: '" . $_SESSION['flash_login']['title'] . "',
                        text: '" . $_SESSION['flash_login']['text'] . "',
                        icon: '" . $_SESSION['flash_login']['icon'] . "',
                        confirmButtonColor: '#4f46e5'
                    });
                </script>
            ";
            unset($_SESSION['flash_login']);
        }
    }
}
