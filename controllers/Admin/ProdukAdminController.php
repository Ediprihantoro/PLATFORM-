<?php
require_once 'models/ProdukModel.php';

class ProdukAdminController {

    // Menampilkan daftar produk di Dashboard Admin
    public function index() {
        $produkModel = new ProdukModel();
        $data_produk = $produkModel->getSemuaProdukAdmin();

        require_once 'views/admin/layout/header.php';
        require_once 'views/admin/produk/index.php'; 
        require_once 'views/admin/layout/footer.php';
    }

    // Fungsi untuk menampilkan preview etalase bagi Admin
    public function etalase() {
        // 1. Panggil class Model-nya terlebih dahulu
        $produkModel = new ProdukModel();
        // 2. Ambil datanya (menggunakan fungsi yang sama dengan halaman index)
        $data_produk = $produkModel->getSemuaProdukAdmin(); 
        
        // 3. Panggil kerangka layout dan halaman etalase admin
        include 'views/admin/layout/header.php';
        include 'views/admin/produk/etalase.php';
        include 'views/admin/layout/footer.php';
    }
    
    // Menampilkan form tambah produk
    public function create() {
        require_once 'views/admin/layout/header.php';
        require_once 'views/admin/produk/form.php';
        require_once 'views/admin/layout/footer.php';
    }

    // Memproses simpan produk baru ke database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $produkModel = new ProdukModel();
            
            // Contoh di dalam fungsi store() atau update()
            $data = [
                'namaProduk' => $_POST['namaProduk'],
                'kategori' => $_POST['kategori'],
                'harga_eceran' => $_POST['harga_eceran'],
                'stok' => $_POST['stok'], // <--- PASTIKAN BARIS INI ADA
                'deskripsiProduk' => $_POST['deskripsiProduk']
            ];

            if ($produkModel->tambahProduk($data)) {
                // Jika sukses, kembalikan ke dashboard admin
                header("Location: index.php?area=admin");
                exit();
            } else {
                echo "Gagal menyimpan produk ke database.";
            }
        }
    }

    // Menampilkan form edit dengan data lama
    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $produkModel = new ProdukModel();
            $produk = $produkModel->getProdukById($id);

            require_once 'views/admin/layout/header.php';
            require_once 'views/admin/produk/form_edit.php'; 
            require_once 'views/admin/layout/footer.php';
        }
    }

        public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['idProduk']; // atau $_POST['id'] tergantung kodemu
            
            // INI JEMBATANNYA! Pastikan 'stok' ada di dalam array ini:
            $data = [
                'namaProduk' => $_POST['namaProduk'],
                'kategori' => $_POST['kategori'],
                'harga_eceran' => $_POST['harga_eceran'],
                'stok' => $_POST['stok'], // <--- PASTIKAN BARIS INI TIDAK TERTINGGAL!
                'deskripsiProduk' => $_POST['deskripsiProduk']
            ];
            
            require_once 'models/ProdukModel.php';
            $produkModel = new ProdukModel();
            
            if ($produkModel->updateProduk($id, $data)) {
                header("Location: index.php?area=admin&action=dashboard_produk");
                exit();
            } else {
                echo "Gagal mengupdate data!";
            }
        }
    }

    // Memproses hapus data produk
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $produkModel = new ProdukModel();
            $produkModel->hapusProduk($id);
        }
        header("Location: index.php?area=admin");
        exit();
    }

    // Menampilkan daftar pesanan masuk di layar Admin
    public function kelolaPesanan() {
        require_once 'models/TransaksiModel.php';
        $transaksiModel = new TransaksiModel();
        
        $data_pesanan = $transaksiModel->getAllPesananAdmin();

        require_once 'views/admin/layout/header.php';
        // Nanti kita buat file ini setelah backend-nya siap
        require_once 'views/admin/pesanan/index.php'; 
        require_once 'views/admin/layout/footer.php';
    }

    // Memproses aksi ketika Admin mengklik tombol "Terima Pembayaran" atau "Kirim"
    public function verifikasiPesanan() {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $idPesanan = $_GET['id'];
            $statusBaru = $_GET['status']; // Contoh: 'Diproses' atau 'Dikirim'

            require_once 'models/TransaksiModel.php';
            $transaksiModel = new TransaksiModel();
            $transaksiModel->updateStatusPesanan($idPesanan, $statusBaru);
        }
        
        // Setelah status diubah, kembalikan layar ke daftar pesanan
        header("Location: index.php?area=admin&action=kelola_pesanan");
        exit();
    }
    // Tambahkan fungsi ini di dalam class ProdukAdminController
    private function kompresGambar($sumberFile, $tujuanFile, $kualitas = 75) {
        $infoGambar = getimagesize($sumberFile);
        
        // Deteksi format gambar
        if ($infoGambar['mime'] == 'image/jpeg') {
            $gambarBaru = imagecreatefromjpeg($sumberFile);
            // Simpan ulang dengan kompresi (kualitas 75 sudah sangat bagus tapi ukuran kecil)
            imagejpeg($gambarBaru, $tujuanFile, $kualitas);
        } elseif ($infoGambar['mime'] == 'image/png') {
            $gambarBaru = imagecreatefrompng($sumberFile);
            imagepng($gambarBaru, $tujuanFile, 8); // PNG compression 0-9
        } else {
            // Jika bukan JPG/PNG, pindahkan secara normal
            move_uploaded_file($sumberFile, $tujuanFile);
            return;
        }
        
        // Bersihkan RAM server setelah kompresi
        imagedestroy($gambarBaru);
    }
    // Memproses pengaktifan kembali produk
    public function restore() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $produkModel = new ProdukModel();
            $produkModel->restoreProduk($id);
        }
        header("Location: index.php?area=admin");
        exit();
    }
// Memproses perubahan status dari form di halaman detail pesanan
    public function updateStatusPesanan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangkap data dari form
            $idPesanan = $_POST['idPesanan'];
            $statusBaru = $_POST['status_baru'];

            // Panggil model transaksi
            require_once 'models/TransaksiModel.php';
            $transaksiModel = new TransaksiModel();
            
            // Jalankan perintah update ke database
            $transaksiModel->updateStatusPesanan($idPesanan, $statusBaru);
            
            // Redirect (kembalikan) ke halaman detail pesanan itu lagi biar admin langsung lihat perubahannya
            header("Location: index.php?area=admin&action=detail_pesanan&id=" . $idPesanan);
            exit();
        }
    }

}
?>