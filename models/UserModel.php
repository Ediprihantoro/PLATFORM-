<?php
require_once 'config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Fungsi Mendaftar Akun Baru (Untuk Consumer)
    public function register($nama, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Pendaftar web otomatis mendapat tipe_akun 'customer'
        $query = "INSERT INTO customer (nama, email, password, tipe_akun, is_active) 
                  VALUES (:nama, :email, :password, 'customer', 1)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        
        return $stmt->execute();
    }

    // Fungsi Mengecek Login (Bisa untuk Admin maupun Consumer)
    public function login($email, $password) {
        $query = "SELECT * FROM customer WHERE email = :email AND is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // TRIK: Cek password terenkripsi (pembeli) ATAU password teks biasa (admin manual)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false; 
    }
}
?>