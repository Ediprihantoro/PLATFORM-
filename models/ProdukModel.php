<?php
require_once 'config/database.php';

class ProdukModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProduk() {
        $query = "SELECT * FROM produk WHERE is_active = 1 ORDER BY idProduk ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahProduk($data) {
        $query = "INSERT INTO produk (namaProduk, kategori, harga_eceran, deskripsiProduk, is_active) 
                  VALUES (:namaProduk, :kategori, :harga_eceran, :deskripsiProduk, 1)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':namaProduk', $data['namaProduk']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':harga_eceran', $data['harga_eceran']);
        $stmt->bindParam(':deskripsiProduk', $data['deskripsiProduk']);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function hapusProduk($id) {
        $query = "UPDATE produk SET is_active = 0 WHERE idProduk = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getProdukById($id) {
        $query = "SELECT * FROM produk WHERE idProduk = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduk($id, $data) {
        $query = "UPDATE produk SET namaProduk=:namaProduk, kategori=:kategori, 
                  harga_eceran=:harga_eceran, stok=:stok, deskripsiProduk=:deskripsiProduk 
                  WHERE idProduk=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':namaProduk', $data['namaProduk']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':harga_eceran', $data['harga_eceran']);
        
        $stmt->bindParam(':stok', $data['stok']); 
        
        $stmt->bindParam(':deskripsiProduk', $data['deskripsiProduk']);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getSemuaProdukAdmin() {
        $query = "SELECT * FROM produk ORDER BY idProduk DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function restoreProduk($id) {
        $query = "UPDATE produk SET is_active = 1 WHERE idProduk = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>