<?php
// Memanggil tata letak header admin
require_once 'views/admin/layout/header.php';
require_once 'config/database.php';

// Inisialisasi koneksi database menggunakan PDO
$database = new Database();
$db = $database->getConnection();

// Menangkap ID pesanan dari parameter URL
$id_pesanan = $_GET['id'] ?? '';

// Mengambil data utama pesanan beserta info pengiriman pelanggan
$query_pesanan = "SELECT * FROM pesanan WHERE idPesanan = :id";
$stmt_pesanan = $db->prepare($query_pesanan);
$stmt_pesanan->bindParam(':id', $id_pesanan);
$stmt_pesanan->execute();
$data = $stmt_pesanan->fetch(PDO::FETCH_ASSOC);

// Mengambil daftar produk yang dibeli dalam pesanan tersebut
$query_detail = "
    SELECT dp.*, p.namaProduk as nama_produk 
    FROM detail_pesanan dp 
    JOIN produk p ON dp.idProduk = p.idProduk 
    WHERE dp.idPesanan = :id
";
$stmt_detail = $db->prepare($query_detail);
$stmt_detail->bindParam(':id', $id_pesanan);
$stmt_detail->execute();
$detail_pesanan_list = $stmt_detail->fetchAll(PDO::FETCH_ASSOC);

// Menghitung total harga produk murni (tanpa ongkir)
$total_subtotal_produk = 0;
foreach($detail_pesanan_list as $row) {
    $total_subtotal_produk += $row['subtotal'];
}

// Mendapatkan nilai ongkir dari selisih total tagihan dan subtotal produk
$ongkir = ($data['total_harga'] ?? 0) - $total_subtotal_produk;
if ($ongkir < 0) { 
    $ongkir = 0; 
}
?>

<div style="font-family: 'Segoe UI', sans-serif; color: #051F20; padding: 20px; max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; padding-bottom: 5px; border-bottom: 1px solid #e2e8f0;">
        <h2 style="color: #051F20; margin: 0; padding-bottom: 8px; position: relative; display: inline-block; font-size: 1.8rem;">
            Detail Pesanan #LZT-<?= str_pad($id_pesanan, 4, '0', STR_PAD_LEFT) ?>
            <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background-color: #8EB69B;"></div>
        </h2>
        
        <a href="index.php?area=admin&action=kelola_pesanan" style="background: #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.95rem; margin-bottom: 5px; transition: 0.2s;" onmouseover="this.style.background='#cbd5e1'" onmouseout="this.style.background='#e2e8f0'">
            &larr; Kembali
        </a>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        
        <div style="flex: 1; min-width: 300px;">
            
            <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                <h4 style="color: #163832; margin-top: 0; font-size: 1.1rem;">Informasi Pengiriman</h4>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;">
                
                <table style="width: 100%; font-size: 0.95rem; table-layout: fixed;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; width: 35%;">Nama Penerima</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a; word-wrap: break-word;">: <?= htmlspecialchars($data['nama_penerima'] ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">No. WhatsApp</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a; word-wrap: break-word;">: <?= htmlspecialchars($data['no_hp'] ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; vertical-align: top;">Alamat Lengkap</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a; line-height: 1.5; word-break: break-word; overflow-wrap: anywhere;">: <?= htmlspecialchars($data['alamat_lengkap'] ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Pembayaran</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a;">: 
                            <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; display: inline-block; margin-top: 4px;">
                                <?= htmlspecialchars($data['metode_pembayaran'] ?? '-'); ?>
                            </span>
                            <?php if(!empty($data['bukti_transfer'])): ?>
                                <a href="uploads/<?= htmlspecialchars($data['bukti_transfer']) ?>" target="_blank" style="margin-left: 5px; background: #e0f2fe; color: #0284c7; border: 1px solid #7dd3fc; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; display: inline-block; margin-top: 4px;">Lihat Struk</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if(!empty($data['catatan'])): ?>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; vertical-align: top;">Catatan</td>
                        <td style="padding: 8px 0; word-break: break-word; overflow-wrap: anywhere;">: <span style="font-style: italic; color: #d97706; background: #fef3c7; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 4px;">"<?= htmlspecialchars($data['catatan']); ?>"</span></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div style="background: #fffdf5; padding: 25px; border-radius: 12px; border: 1px solid #fde68a;">
                <h4 style="color: #b45309; margin-top: 0; font-size: 1.1rem;">Kendali Status</h4>
                <hr style="border: 0; border-top: 1px solid #fde68a; margin: 15px 0;">
                
                <form action="index.php?area=admin&action=update_status_proses" method="POST">
                    <input type="hidden" name="idPesanan" value="<?= $id_pesanan ?>">
                    
                    <div style="margin-bottom: 15px; background: #ffffff; padding: 15px; border-radius: 8px; border: 1px solid #fde68a;">
                        <label style="color: #64748b; font-size: 0.9rem; display: block; margin-bottom: 8px;">Status Saat Ini:</label>
                        <?php 
                            // Penentuan warna background dan teks berdasarkan status pesanan
                            $bg_status = '#e2e8f0'; $text_status = '#475569'; 
                            $status_raw = strtolower($data['status_pesanan'] ?? '');
                            if($status_raw == 'pending' || $status_raw == 'menunggu pembayaran') { $bg_status = '#fef3c7'; $text_status = '#d97706'; } 
                            elseif($status_raw == 'menunggu verifikasi') { $bg_status = '#fef08a'; $text_status = '#854d0e'; } 
                            elseif($status_raw == 'diproses') { $bg_status = '#dbeafe'; $text_status = '#1d4ed8'; } 
                            elseif($status_raw == 'dikirim') { $bg_status = '#DAF1DE'; $text_status = '#163832'; } 
                            elseif($status_raw == 'selesai') { $bg_status = '#dcfce7'; $text_status = '#166534'; } 
                        ?>
                        <span style="background: <?= $bg_status ?>; color: <?= $text_status ?>; padding: 6px 15px; border-radius: 20px; font-weight: bold; display: inline-block; font-size: 0.95rem; text-transform: capitalize;">
                            <?= htmlspecialchars($data['status_pesanan'] ?? '-'); ?>
                        </span>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="color: #0f172a; font-weight: bold; display: block; margin-bottom: 8px; font-size: 0.95rem;">Ubah Status Menjadi:</label>
                        <select name="status_baru" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; color: #334155; font-size: 0.95rem;" required>
                            <option value="">-- Pilih Progres Terbaru --</option>
                            <option value="pending">Pending</option>
                            <option value="menunggu verifikasi">Menunggu Verifikasi</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" style="width: 100%; background: #f59e0b; color: #ffffff; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div style="flex: 1.5; min-width: 300px;">
            
            <div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; height: 100%;">
                <h4 style="color: #163832; margin-top: 0; font-size: 1.1rem;">Rincian Barang Belanjaan</h4>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;">
                
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="color: #64748b; font-size: 0.85rem;">
                            <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-transform: uppercase;">Barang / Produk</th>
                            <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: center; text-transform: uppercase;">Qty</th>
                            <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: right; text-transform: uppercase;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($detail_pesanan_list) > 0): ?>
                            <?php foreach($detail_pesanan_list as $row_detail): ?>
                                <tr>
                                    <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-weight: 500;">
                                        <?= htmlspecialchars($row_detail['nama_produk'] ?? 'Produk Tidak Diketahui'); ?>
                                    </td>
                                    <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; text-align: center; color: #64748b;">
                                        <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 15px; font-size: 0.9rem;"><?= htmlspecialchars($row_detail['jumlah'] ?? 0); ?>x</span>
                                    </td>
                                    <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-weight: bold;">
                                        Rp <?= number_format($row_detail['subtotal'] ?? 0, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 30px; color: #ef4444;">Data produk tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                        
                        <tr>
                            <td colspan="2" style="padding: 15px 10px; text-align: right; font-weight: bold; color: #64748b; border-bottom: 1px solid #e2e8f0;">Total Harga Produk</td>
                            <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                Rp <?= number_format($total_subtotal_produk, 0, ',', '.'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 15px 10px; text-align: right; font-weight: bold; color: #d97706; border-bottom: 1px solid #e2e8f0;">Ongkos Kirim</td>
                            <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #d97706; border-bottom: 1px solid #e2e8f0;">
                                Rp <?= number_format($ongkir, 0, ',', '.'); ?>
                            </td>
                        </tr>

                        <tr style="background: #DAF1DE;">
                            <td colspan="2" style="padding: 15px 10px; font-weight: bold; color: #163832; font-size: 1.05rem; text-align: right;">TOTAL KESELURUHAN</td>
                            <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #163832; font-size: 1.15rem;">
                                Rp <?= number_format($data['total_harga'] ?? 0, 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php 
// Memanggil tata letak footer admin
require_once 'views/admin/layout/footer.php'; 
?>