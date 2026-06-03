<?php
require_once 'models/ProdukModel.php';
require_once 'models/TransaksiModel.php';

class KatalogController {
    // ==========================================
    // AREA CONSUMER (B2C & TRANSAKSI)
    // ==========================================
    public function index() {
        $produkModel = new ProdukModel();
        $data_produk = $produkModel->getAllProduk();

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/katalog/index.php';
        require_once 'views/consumer/layout/footer.php';
    }

    public function tambahKeranjang() {
    // 1. Proteksi jika belum login sama sekali
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?area=auth&action=login");
        exit();
    }

    // 2. Proteksi UX: Jika yang mencoba beli adalah Admin
    if (isset($_SESSION['tipe_akun']) && strtolower($_SESSION['tipe_akun']) === 'admin') {
        echo "<script>
                alert('Akses Ditolak! Admin tidak perlu memasukkan barang ke keranjang.');
                window.location.href = 'index.php?area=consumer&action=katalog';
              </script>";
        exit();
    }

    // Buat keranjang kosong jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // ==================================================
    // SKENARIO 1: Menangkap data dari Form Detail Produk (POST)
    // ==================================================
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProduk'])) {
        $id_produk = $_POST['idProduk'];
        $jumlah = (int)$_POST['jumlah'];
        // Jika tidak ada variasi yang dipilih, set string kosong agar tidak error
        $variasi = isset($_POST['variasi']) ? $_POST['variasi'] : 'Reguler';

        // Membuat Kunci Unik (Contoh: "8-Ekstra Keju 500g")
        $kunci_unik = $id_produk . '-' . $variasi;

        // Jika barang & variasi yang sama persis sudah ada di keranjang, tambah jumlahnya
        if (isset($_SESSION['keranjang'][$kunci_unik])) {
            $_SESSION['keranjang'][$kunci_unik]['jumlah'] += $jumlah;
        } else {
            // Jika belum ada, masukkan sebagai barang baru di keranjang
            $_SESSION['keranjang'][$kunci_unik] = [
                'idProduk' => $id_produk,
                'jumlah' => $jumlah,
                'variasi' => $variasi
            ];
        }
        
        // Arahkan ke halaman keranjang setelah berhasil masuk
        header("Location: index.php?area=consumer&action=keranjang");
        exit();
    } 
}

    public function keranjang() {
        if (!isset($_SESSION['user_id']) || $_SESSION['tipe_akun'] !== 'customer') {
            header("Location: index.php?area=auth&action=login");
            exit();
        }

        $produkModel = new ProdukModel();
        
        $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
        $data_keranjang = [];
        $total_belanja = 0;

        // --- INI BAGIAN YANG KITA UBAH ---
        foreach ($keranjang as $kunci_unik => $item_sesi) {
            
            // Proteksi: Jika browser masih menyimpan session versi lama (berupa angka), kita lewati
            if (!is_array($item_sesi)) {
                continue; 
            }

            // Bongkar isi keranjang baru
            $id_produk_asli = $item_sesi['idProduk'];
            $qty = $item_sesi['jumlah'];
            $variasi = $item_sesi['variasi'];

            // Ambil data dari database menggunakan ID yang benar
            $produk = $produkModel->getProdukById($id_produk_asli);
            
            if ($produk) {
                // Masukkan data ke array $produk agar bisa dibaca oleh file keranjang.php
                $produk['jumlah'] = $qty; 
                $produk['variasi'] = $variasi; // <-- Ini yang akan memunculkan tulisan variasi di layarmu!
                
                // Lakukan perkalian matematis yang benar (angka x angka)
                $produk['subtotal'] = $produk['harga_eceran'] * $qty; 
                
                $total_belanja += $produk['subtotal']; 
                $data_keranjang[] = $produk;
            }
        }
        // ---------------------------------

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/keranjang.php'; 
        require_once 'views/consumer/layout/footer.php';
    }

    // 1. FUNGSI MENAMPILKAN HALAMAN CHECKOUT
    public function checkout() {
        if (!isset($_SESSION['user_id']) || $_SESSION['tipe_akun'] !== 'customer') {
            header("Location: index.php?area=auth&action=login");
            exit();
        }

        $produkModel = new ProdukModel();
        $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
        
        if (empty($keranjang)) {
            header("Location: index.php?area=consumer&action=katalog");
            exit();
        }

        $data_keranjang = [];
        $total_belanja = 0;

        // Siapkan data untuk ditampilkan di sebelah kanan layar (Ringkasan Pesanan)
        foreach ($keranjang as $kunci_unik => $item_sesi) {
            if (!is_array($item_sesi)) continue;
            
            $produk = $produkModel->getProdukById($item_sesi['idProduk']);
            if ($produk) {
                $subtotal = $produk['harga_eceran'] * $item_sesi['jumlah'];
                $total_belanja += $subtotal;
                
                // Susun array untuk dipakai di view HTML
                $data_keranjang[] = [
                    'idProduk' => $item_sesi['idProduk'],
                    'namaProduk' => $produk['namaProduk'],
                    'harga_eceran' => $produk['harga_eceran'],
                    'jumlah' => $item_sesi['jumlah'],
                    'variasi' => $item_sesi['variasi'] ?? '',
                    'subtotal' => $subtotal
                ];
            }
        }

        // Panggil view form checkout
        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/checkout.php';
        require_once 'views/consumer/layout/footer.php';
    }

    // 2. FUNGSI MENANGKAP DATA FORM & SIMPAN KE DATABASE
    public function proses_checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/TransaksiModel.php';
            $transaksiModel = new TransaksiModel();
            $produkModel = new ProdukModel();
            
            $idUser = $_SESSION['user_id'];
            
            // Tangkap semua inputan form alamat & kurir
            $nama_penerima = $_POST['nama_penerima'];
            $no_hp = $_POST['no_hp'];
            $alamat_lengkap = $_POST['alamat_lengkap'];
            $metode_pengiriman = $_POST['metode_pengiriman'];
            $metode_pembayaran = $_POST['metode_pembayaran'];
            $catatan = $_POST['catatan'];

            $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
            $data_pesanan_db = [];
            $total_belanja = 0;

            // Hitung ulang total belanja demi keamanan (jangan percaya data dari HTML)
            foreach ($keranjang as $kunci_unik => $item_sesi) {
                if (!is_array($item_sesi)) continue;
                $produk = $produkModel->getProdukById($item_sesi['idProduk']);
                if ($produk) {
                    $subtotal = $produk['harga_eceran'] * $item_sesi['jumlah'];
                    $total_belanja += $subtotal;
                    
                    $data_pesanan_db[] = [
                        'idProduk' => $item_sesi['idProduk'],
                        'jumlah' => $item_sesi['jumlah'],
                        'harga' => $produk['harga_eceran'],
                        'subtotal' => $subtotal
                    ];
                }
            }

            // Tambahkan ongkir jika memilih Kurir Toko
            if ($metode_pengiriman === 'Kurir Toko') {
                $total_belanja += 10000;
            }

            // Lempar SEMUA data (termasuk alamat) ke Model
            $idPesananBaru = $transaksiModel->simpanPesanan($idUser, $total_belanja, $data_pesanan_db, $nama_penerima, $no_hp, $alamat_lengkap, $metode_pengiriman, $metode_pembayaran, $catatan);
            
            if ($idPesananBaru) {
                // Kosongkan keranjang setelah sukses
                unset($_SESSION['keranjang']);
                header("Location: index.php?area=consumer&action=detail_pesanan&id=" . $idPesananBaru);
                exit();
            } else {
                echo "<h1>Gagal Query! Cek kesesuaian kolom database.</h1>";
            }
        }
    }

    public function pesananSaya() {
        if (!isset($_SESSION['user_id']) || $_SESSION['tipe_akun'] !== 'customer') {
            header("Location: index.php?area=auth&action=login");
            exit();
        }

        $transaksiModel = new TransaksiModel();
        $data_pesanan = $transaksiModel->getPesananByUser($_SESSION['user_id']);

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/pesanan.php'; 
        require_once 'views/consumer/layout/footer.php';
    }

    public function detailPesanan() {
        // Proteksi: Pastikan user login
        if (!isset($_SESSION['user_id']) || $_SESSION['tipe_akun'] !== 'customer') {
            header("Location: index.php?area=auth&action=login");
            exit();
        }
        
        // Proteksi: Pastikan ada ID pesanan yang diklik di URL
        if (!isset($_GET['id'])) {
            header("Location: index.php?area=consumer&action=pesanan_saya");
            exit();
        }

        $idPesanan = $_GET['id'];
        $idUser = $_SESSION['user_id'];

        // Panggil model dan ambil rinciannya
        require_once 'models/TransaksiModel.php';
        $transaksiModel = new TransaksiModel();
        
        // Fungsi ini memanggil fungsi getDetailPesanan yang sudah kamu buat di model sebelumnya
        $detail_pesanan = $transaksiModel->getDetailPesanan($idPesanan, $idUser);

        // Jika pesanan tidak ditemukan atau bukan milik user ini, kembalikan ke daftar
        if (!$detail_pesanan) {
            header("Location: index.php?area=consumer&action=pesanan_saya");
            exit();
        }

        // Tampilkan ke layar
        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/pembayaran.php'; // Kita buat file ini di bawah
        require_once 'views/consumer/layout/footer.php';
    }
    // TAMBAHKAN FUNGSI INI DI BAWAH)

// Di dalam class KatalogController, tambahkan fungsi baru berikut di paling bawah:

    public function uploadBukti() {
        // 1. Proteksi keamanan
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?area=auth&action=login");
            exit();
        }

        // 2. Pastikan tombol submit benar-benar diklik
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 3. Pastikan file terdeteksi
            if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === UPLOAD_ERR_OK) {
                $idPesanan = $_POST['idPesanan'];
                $target_dir = "uploads/"; 
                
                // FITUR OTOMATIS: Buat folder 'uploads' jika belum ada!
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true); 
                }

                $filename = time() . '_' . basename($_FILES["bukti_transfer"]["name"]);
                $target_file = $target_dir . $filename;
                
                // 4. Proses pemindahan file
                if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file)) {
                    require_once 'models/TransaksiModel.php';
                    $transaksiModel = new TransaksiModel();
                    
                    // Update database
                    $transaksiModel->updateBuktiTransfer($idPesanan, $filename);
                    
                    // Kembalikan ke halaman detail pesanan yang tadi
                    header("Location: index.php?area=consumer&action=detail_pesanan&id=" . $idPesanan);
                    exit();
                } else {
                    echo "<h1>Gagal memindahkan gambar. Cek hak akses folder.</h1>";
                }
            } else {
                echo "<h1>File tidak terdeteksi! Pastikan form memiliki atribut enctype='multipart/form-data'.</h1>";
            }
        }
    }
    public function detailProduk() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Panggil ProdukModel untuk mengambil data berdasarkan ID
            require_once 'models/ProdukModel.php';
            $produkModel = new ProdukModel();
            $produk = $produkModel->getProdukById($id);

            // Jika produk tidak ditemukan, kembalikan ke katalog
            if (!$produk) {
                header("Location: index.php?area=consumer&action=katalog");
                exit();
            }

            // Tampilkan halaman detail
            require_once 'views/consumer/layout/header.php';
            require_once 'views/consumer/detail_produk.php'; // Kita buat file ini di langkah 4
            require_once 'views/consumer/layout/footer.php';
        } else {
            header("Location: index.php?area=consumer&action=katalog");
            exit();
        }
    }
    // ==================================================
    // FUNGSI UNTUK TOMBOL (+) DAN (-) DI KERANJANG
    // ==================================================
    public function updateKeranjang() {
        if (isset($_GET['id']) && isset($_GET['aksi'])) {
            $kunci_unik = $_GET['id']; // Contoh: "8-Ekstra Keju 500g"
            $aksi = $_GET['aksi'];

            if (isset($_SESSION['keranjang'][$kunci_unik])) {
                if ($aksi == 'tambah') {
                    $_SESSION['keranjang'][$kunci_unik]['jumlah'] += 1;
                } elseif ($aksi == 'kurang') {
                    $_SESSION['keranjang'][$kunci_unik]['jumlah'] -= 1;
                    
                    // Jika jumlahnya jadi 0, otomatis hapus dari keranjang
                    if ($_SESSION['keranjang'][$kunci_unik]['jumlah'] <= 0) {
                        unset($_SESSION['keranjang'][$kunci_unik]);
                    }
                }
            }
        }
        // Kembalikan ke halaman keranjang agar angkanya langsung ter-refresh
        header("Location: index.php?area=consumer&action=keranjang");
        exit();
    }

    // ==================================================
    // FUNGSI UNTUK TOMBOL HAPUS (SAAT MENEKAN YA DI POP-UP)
    // ==================================================
    public function hapusKeranjang() {
        if (isset($_GET['id'])) {
            $kunci_unik = $_GET['id'];
            if (isset($_SESSION['keranjang'][$kunci_unik])) {
                unset($_SESSION['keranjang'][$kunci_unik]);
            }
        }
        header("Location: index.php?area=consumer&action=keranjang");
        exit();
    }
}
?>