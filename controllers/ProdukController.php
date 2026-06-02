<?php
require_once 'models/ProdukModel.php';

class ProdukController {
    
    // ==========================================
    // AREA B2C (ETALASE PEMBELI)
    // ==========================================
    public function index() {
        $produkModel = new ProdukModel();
        $data_produk = $produkModel->getAllProduk();

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/katalog/index.php'; // Pastikan path ini benar
        require_once 'views/consumer/layout/footer.php';
    }

    // ==========================================
    // AREA ADMIN (DAPUR TOKO)
    // ==========================================
    public function adminIndex() {
        $produkModel = new ProdukModel();
        $data_produk = $produkModel->getAllProduk();

        require_once 'views/admin/layout/header.php';
        require_once 'views/admin/produk/index.php'; 
        require_once 'views/admin/layout/footer.php';
    }
    
    public function tambahProduk() {
        require_once 'views/admin/layout/header.php';
        require_once 'views/admin/produk/form.php';
        require_once 'views/admin/layout/footer.php';
    }

    public function simpanProduk() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $produkModel = new ProdukModel();
            
            $data = [
                'namaProduk' => $_POST['namaProduk'],
                'kategori' => $_POST['kategori'],
                'harga_eceran' => $_POST['harga_eceran'],
                'deskripsiProduk' => $_POST['deskripsiProduk']
            ];

            if ($produkModel->tambahProduk($data)) {
                header("Location: index.php?area=admin");
                exit();
            } else {
                echo "Gagal menyimpan produk ke database.";
            }
        }
    }

    public function hapusProduk($id) {
        if ($id) {
            $produkModel = new ProdukModel();
            $produkModel->hapusProduk($id);
        }
        header("Location: index.php?area=admin");
        exit();
    }
}
?>