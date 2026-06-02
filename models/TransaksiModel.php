<?php
require_once 'config/database.php';

class TransaksiModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Fungsi baru dengan parameter lengkap dari form checkout
    public function simpanPesanan($idUser, $totalBelanja, $detailPesanan, $namaPenerima, $noHp, $alamatLengkap, $metodePengiriman, $metodePembayaran, $catatan) {
        try {
            $this->conn->beginTransaction();

            // 1. VALIDASI STOK EKSTRA KETAT
            foreach ($detailPesanan as $item) {
                $stmtCek = $this->conn->prepare("SELECT stok, namaProduk FROM produk WHERE idProduk = :id FOR UPDATE");
                $stmtCek->bindParam(':id', $item['idProduk']);
                $stmtCek->execute();
                $produkDb = $stmtCek->fetch(PDO::FETCH_ASSOC);

                if (!$produkDb || $produkDb['stok'] < $item['jumlah']) {
                    throw new Exception("Maaf, stok " . $produkDb['namaProduk'] . " tidak mencukupi. Sisa stok: " . $produkDb['stok']);
                }
            }

            // 2. SIMPAN KE TABEL PESANAN INDUK LENGKAP DENGAN ALAMAT
            // PERHATIKAN NAMA KOLOM STATUS_PESANAN, pastikan namanya sama dengan yang ada di database-mu
            $queryPesanan = "INSERT INTO pesanan 
                (idUser, nama_penerima, no_hp, alamat_lengkap, metode_pengiriman, metode_pembayaran, catatan, tanggal_pesanan, total_harga, status_pesanan) 
                VALUES 
                (:idUser, :nama, :hp, :alamat, :kurir, :bayar, :catatan, NOW(), :total, 'Menunggu Pembayaran')";
            
            $stmtPesanan = $this->conn->prepare($queryPesanan);
            $stmtPesanan->bindParam(':idUser', $idUser);
            $stmtPesanan->bindParam(':nama', $namaPenerima);
            $stmtPesanan->bindParam(':hp', $noHp);
            $stmtPesanan->bindParam(':alamat', $alamatLengkap);
            $stmtPesanan->bindParam(':kurir', $metodePengiriman);
            $stmtPesanan->bindParam(':bayar', $metodePembayaran);
            $stmtPesanan->bindParam(':catatan', $catatan);
            $stmtPesanan->bindParam(':total', $totalBelanja);
            
            // Eksekusi jika berhasil
            if(!$stmtPesanan->execute()) {
                throw new Exception("Gagal menyimpan ke tabel pesanan");
            }
            
            $idPesananBaru = $this->conn->lastInsertId();

            // 3. SIMPAN DETAIL PESANAN & KURANGI STOK
            foreach ($detailPesanan as $item) {
                // Insert detail
                $queryDetail = "INSERT INTO detail_pesanan (idPesanan, idProduk, jumlah, harga_satuan, subtotal) VALUES (:idPesanan, :idProduk, :jumlah, :harga, :subtotal)";
                $stmtDetail = $this->conn->prepare($queryDetail);
                $stmtDetail->bindParam(':idPesanan', $idPesananBaru);
                $stmtDetail->bindParam(':idProduk', $item['idProduk']);
                $stmtDetail->bindParam(':jumlah', $item['jumlah']);
                $stmtDetail->bindParam(':harga', $item['harga']);
                $stmtDetail->bindParam(':subtotal', $item['subtotal']);
                $stmtDetail->execute();

                // Potong stok
                $queryStok = "UPDATE produk SET stok = stok - :jumlah WHERE idProduk = :idProduk";
                $stmtStok = $this->conn->prepare($queryStok);
                $stmtStok->bindParam(':jumlah', $item['jumlah']);
                $stmtStok->bindParam(':idProduk', $item['idProduk']);
                $stmtStok->execute();
            }

            // 4. COMMIT & SELESAI
            $this->conn->commit();
            return $idPesananBaru;

        } catch (Exception $e) {
            $this->conn->rollBack();
            $_SESSION['error_checkout'] = $e->getMessage(); 
            return false;
        }
    }
    // Fungsi untuk menambahkan stok berdasarkan ID pesanan yang dibatalkan
    public function tambahkanStokBatal($idPesanan) {
        // 1. Ambil detail barang dari pesanan yang dibatalkan
        $queryDetail = "SELECT idProduk, jumlah FROM detail_pesanan WHERE idPesanan = :idPesanan";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bindParam(':idPesanan', $idPesanan);
        $stmtDetail->execute();
        $items = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

        // 2. Kembalikan stok ke tabel produk
        $queryUpdate = "UPDATE produk SET stok = stok + :jumlah WHERE idProduk = :id_produk";
        $stmtUpdate = $this->conn->prepare($queryUpdate);

        foreach ($items as $item) {
            $stmtUpdate->bindParam(':jumlah', $item['jumlah']);
            $stmtUpdate->bindParam(':id_produk', $item['idProduk']);
            $stmtUpdate->execute();
        }
    }
   public function getPesananByUser($idUser) {
        // PERBAIKAN: 
        // 1. Urutkan berdasarkan idPesanan DESC (paling aman dari typo tanggal)
        // 2. Gunakan SQL ALIAS (AS) agar namanya otomatis berubah dan cocok dengan file pesanan.php!
        $query = "SELECT 
                    idPesanan AS idOrder, 
                    tanggal_pesanan, 
                    total_harga AS total, 
                    status_pesanan AS status 
                  FROM pesanan 
                  WHERE idUser = :idUser 
                  ORDER BY idPesanan DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailPesanan($idPesanan, $idUser) {
        // Ambil data pesanan utama
        $queryPesanan = "SELECT * FROM pesanan WHERE idPesanan = :idPesanan AND idUser = :idUser";
        $stmtPesanan = $this->conn->prepare($queryPesanan);
        $stmtPesanan->bindParam(':idPesanan', $idPesanan);
        $stmtPesanan->bindParam(':idUser', $idUser);
        $stmtPesanan->execute();
        $pesanan = $stmtPesanan->fetch(PDO::FETCH_ASSOC);

        if (!$pesanan) return null;

        // Ambil detail item + nama produk
        $queryDetail = "SELECT dp.*, p.namaProduk FROM detail_pesanan dp JOIN produk p ON dp.idProduk = p.idProduk WHERE dp.idPesanan = :idPesanan";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bindParam(':idPesanan', $idPesanan);
        $stmtDetail->execute();
        $pesanan['items'] = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

        return $pesanan;
    }
    // Fungsi untuk memperbarui status dan nama file bukti transfer
    public function updateBuktiTransfer($idPesanan, $namaFile) {
        // Update nama file dan ubah statusnya otomatis
        $query = "UPDATE pesanan SET bukti_transfer = :bukti, status_pesanan = 'Menunggu Verifikasi' WHERE idPesanan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bukti', $namaFile);
        $stmt->bindParam(':id', $idPesanan);
        return $stmt->execute();
    }
   // INI ADALAH FUNGSI YANG DICARI OLEH CONTROLLER ADMIN!
    public function getAllPesananAdmin() {
        // Menggabungkan tabel pesanan dan customer agar nama pembeli muncul di tabel admin
        $query = "SELECT p.idPesanan AS idOrder, p.tanggal_pesanan, p.total_harga AS total, p.status_pesanan AS status, p.bukti_transfer, u.nama AS nama_pembeli 
                  FROM pesanan p 
                  JOIN customer u ON p.idUser = u.idUser 
                  ORDER BY p.idPesanan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk memperbarui status pesanan dari tombol admin
    public function updateStatusPesanan($idPesanan, $status) {
        $query = "UPDATE pesanan SET status_pesanan = :status WHERE idPesanan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $idPesanan);
        return $stmt->execute();
    }
}
?>