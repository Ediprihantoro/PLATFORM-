<?php
require_once 'models/ProdukModel.php';
require_once 'models/TransaksiModel.php';

class KatalogController {
    public function index() {
        $produkModel = new ProdukModel();
        $data_produk = $produkModel->getAllProduk();

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/katalog/index.php';
        require_once 'views/consumer/layout/footer.php';
    }
    public function tambahKeranjang() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?area=auth&action=login");
        exit();
    }
    if (isset($_SESSION['tipe_akun']) && strtolower($_SESSION['tipe_akun']) === 'admin') {
        echo "<script>
                alert('Akses Ditolak! Admin tidak perlu memasukkan barang ke keranjang.');
                window.location.href = 'index.php?area=consumer&action=katalog';
              </script>";
        exit();
    }

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProduk'])) {
        $id_produk = $_POST['idProduk'];
        $jumlah = (int)$_POST['jumlah'];
        $variasi = isset($_POST['variasi']) ? $_POST['variasi'] : 'Reguler';
        $kunci_unik = $id_produk . '-' . $variasi;

        if (isset($_SESSION['keranjang'][$kunci_unik])) {
            $_SESSION['keranjang'][$kunci_unik]['jumlah'] += $jumlah;
        } else {
            $_SESSION['keranjang'][$kunci_unik] = [
                'idProduk' => $id_produk,
                'jumlah' => $jumlah,
                'variasi' => $variasi
            ];
        }
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
        foreach ($keranjang as $kunci_unik => $item_sesi) {    
            if (!is_array($item_sesi)) {
                continue; 
            }

            $id_produk_asli = $item_sesi['idProduk'];
            $qty = $item_sesi['jumlah'];
            $variasi = $item_sesi['variasi'];

            $produk = $produkModel->getProdukById($id_produk_asli);
            
            if ($produk) {
                $produk['jumlah'] = $qty; 
                $produk['variasi'] = $variasi; 
                
                $produk['subtotal'] = $produk['harga_eceran'] * $qty; 
                
                $total_belanja += $produk['subtotal']; 
                $data_keranjang[] = $produk;
            }
        }
        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/keranjang.php'; 
        require_once 'views/consumer/layout/footer.php';
    }

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

        foreach ($keranjang as $kunci_unik => $item_sesi) {
            if (!is_array($item_sesi)) continue;
            
            $produk = $produkModel->getProdukById($item_sesi['idProduk']);
            if ($produk) {
                $subtotal = $produk['harga_eceran'] * $item_sesi['jumlah'];
                $total_belanja += $subtotal;
                
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

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/checkout.php';
        require_once 'views/consumer/layout/footer.php';
    }

    public function proses_checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/TransaksiModel.php';
            $transaksiModel = new TransaksiModel();
            $produkModel = new ProdukModel();
            
            $idUser = $_SESSION['user_id'];
            
            $nama_penerima = $_POST['nama_penerima'];
            $no_hp = $_POST['no_hp'];
            $alamat_lengkap = $_POST['alamat_lengkap'];
            $metode_pengiriman = $_POST['metode_pengiriman'];
            $metode_pembayaran = $_POST['metode_pembayaran'];
            $catatan = $_POST['catatan'];

            $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
            $data_pesanan_db = [];
            $total_belanja = 0;

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

            if ($metode_pengiriman === 'Kurir Toko') {
                $total_belanja += 10000;
            }

            $idPesananBaru = $transaksiModel->simpanPesanan($idUser, $total_belanja, $data_pesanan_db, $nama_penerima, $no_hp, $alamat_lengkap, $metode_pengiriman, $metode_pembayaran, $catatan);
            
            if ($idPesananBaru) {
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
        
        if (!isset($_GET['id'])) {
            header("Location: index.php?area=consumer&action=pesanan_saya");
            exit();
        }

        $idPesanan = $_GET['id'];
        $idUser = $_SESSION['user_id'];

        require_once 'models/TransaksiModel.php';
        $transaksiModel = new TransaksiModel();
        
        $detail_pesanan = $transaksiModel->getDetailPesanan($idPesanan, $idUser);

        if (!$detail_pesanan) {
            header("Location: index.php?area=consumer&action=pesanan_saya");
            exit();
        }

        require_once 'views/consumer/layout/header.php';
        require_once 'views/consumer/detail_pesanan.php'; 
        require_once 'views/consumer/layout/footer.php';
    }


    public function uploadBukti() {
        // 1. Proteksi keamanan
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?area=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === UPLOAD_ERR_OK) {
                $idPesanan = $_POST['idPesanan'];
                $target_dir = "uploads/"; 
                
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true); 
                }

                $filename = time() . '_' . basename($_FILES["bukti_transfer"]["name"]);
                $target_file = $target_dir . $filename;
                
                if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $target_file)) {
                    require_once 'models/TransaksiModel.php';
                    $transaksiModel = new TransaksiModel();
                    
                    $transaksiModel->updateBuktiTransfer($idPesanan, $filename);
                    
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
            
            require_once 'models/ProdukModel.php';
            $produkModel = new ProdukModel();
            $produk = $produkModel->getProdukById($id);

            if (!$produk) {
                header("Location: index.php?area=consumer&action=katalog");
                exit();
            }

            require_once 'views/consumer/layout/header.php';
            require_once 'views/consumer/detail_produk.php'; 
            require_once 'views/consumer/layout/footer.php';
        } else {
            header("Location: index.php?area=consumer&action=katalog");
            exit();
        }
    }
    public function updateKeranjang() {
        if (isset($_GET['id']) && isset($_GET['aksi'])) {
            $kunci_unik = $_GET['id']; 
            $aksi = $_GET['aksi'];

            if (isset($_SESSION['keranjang'][$kunci_unik])) {
                if ($aksi == 'tambah') {
                    $_SESSION['keranjang'][$kunci_unik]['jumlah'] += 1;
                } elseif ($aksi == 'kurang') {
                    $_SESSION['keranjang'][$kunci_unik]['jumlah'] -= 1;
                    
                    if ($_SESSION['keranjang'][$kunci_unik]['jumlah'] <= 0) {
                        unset($_SESSION['keranjang'][$kunci_unik]);
                    }
                }
            }
        }
        header("Location: index.php?area=consumer&action=keranjang");
        exit();
    }

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