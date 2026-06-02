<?php
require_once 'models/UserModel.php';

class AuthController {
    
    public function login() {
        require_once 'views/auth/login.php';
    }

    public function register() {
        require_once 'views/auth/register.php';
    }

    public function prosesRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = new UserModel();
            
            // --- PROTEKSI XSS (Pembersihan Input) ---
            // htmlspecialchars: Mencegah eksekusi script HTML/JS jahat
            $nama = htmlspecialchars(trim($_POST['nama']), ENT_QUOTES, 'UTF-8');
            // filter_var: Memastikan format email valid dan bersih dari karakter aneh
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            // Password dibiarkan utuh karena mesin Hash butuh karakter aslinya (simbol, dll)
            $password = $_POST['password']; 
            // ----------------------------------------
            
            if ($userModel->register($nama, $email, $password)) {
                header("Location: index.php?area=auth&action=login");
                exit();
            } else {
                echo "Gagal mendaftar. Email mungkin sudah dipakai.";
            }
        }
    }

    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = new UserModel();
            
            // Bersihkan inputan login juga
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
            $password = $_POST['password'];
            
            $user = $userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['idUser'];
                
                // Mencegah XSS saat nama ditampilkan di Navbar
                $_SESSION['nama'] = htmlspecialchars($user['nama'], ENT_QUOTES, 'UTF-8'); 
                $_SESSION['tipe_akun'] = $user['tipe_akun'];

                if ($user['tipe_akun'] === 'admin') {
                    header("Location: index.php?area=admin");
                } else {
                    header("Location: index.php?area=consumer&action=katalog");
                }
                exit();
            } else {
                echo "Email atau Password salah!";
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?area=auth&action=login");
        exit();
    }
}
?>