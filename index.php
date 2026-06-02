<?php
session_start();

// Fungsi format rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Menangkap URL: Jika tidak ada, jadikan Katalog Consumer sebagai beranda utama (Landing Page)
$area = isset($_GET['area']) ? $_GET['area'] : 'consumer';
$action = isset($_GET['action']) ? $_GET['action'] : 'katalog';

if ($area === 'auth') {
    require_once 'controllers/AuthController.php';
    $authController = new AuthController();
    
    switch ($action) {
        case 'login': $authController->login(); break;
        case 'proses_login': $authController->prosesLogin(); break;
        case 'register': $authController->register(); break;
        case 'proses_register': $authController->prosesRegister(); break;
        case 'logout': $authController->logout(); break;
    }
}

// AREA ADMIN 
elseif ($area === 'admin') {
    // Keamanan: Tendang jika belum login atau bukan admin
    if (!isset($_SESSION['user_id']) || $_SESSION['tipe_akun'] !== 'admin') {
        header("Location: index.php?area=auth&action=login");
        exit();
    }
    
    require_once 'controllers/Admin/ProdukAdminController.php';
    $adminController = new ProdukAdminController();
    
    switch ($action) {
        case 'tambah_produk':
            $adminController->create();
            break;
        case 'simpan_produk':
            $adminController->store();
            break;
        case 'hapus_produk':
            $adminController->delete();
            break;
        case 'restore_produk':
            $adminController->restore();
            break;
        case 'edit_produk':
            $adminController->edit();
            break;
        case 'update_produk':
            $adminController->update();
            break;
        case 'kelola_pesanan':
            $adminController->kelolaPesanan();
            break;
        case 'verifikasi_pesanan':
            $adminController->verifikasiPesanan();
            break;
        case 'etalase': // <--- INI RUTE BARU UNTUK PREVIEW ETALASE ADMIN
            $adminController->etalase();
            break;
        default:
            $adminController->index();
            break;
    }

// AREA CONSUMER 
} else {
    require_once 'controllers/Consumer/KatalogController.php';
    $katalogController = new KatalogController(); 
    
    switch ($action) {
        case 'home':
        case 'katalog':
            $katalogController->index();
            break;
        case 'tambah_keranjang':
            $katalogController->tambahKeranjang();
            break;
        case 'keranjang':
            $katalogController->keranjang();
            break;
        case 'checkout':
            $katalogController->checkout();
            break;
        case 'proses_checkout':               // <--- TAMBAHKAN BARIS INI
            $katalogController->proses_checkout(); // <--- TAMBAHKAN BARIS INI
            break;
        case 'pesanan_saya':
            $katalogController->pesananSaya();
            break;
        case 'detail_pesanan':
            $katalogController->detailPesanan();
            break;
        case 'detail_produk':
            $katalogController->detailProduk();
            break;
        case 'upload_bukti':
            $katalogController->uploadBukti();
            break;
        case 'update_keranjang':
            $katalogController->updateKeranjang();
            break;
        case 'hapus_keranjang':
            $katalogController->hapusKeranjang();
            break;
        default:
            echo "<h1>404 - Halaman tidak ditemukan.</h1>";
            break;
    }
}
?>