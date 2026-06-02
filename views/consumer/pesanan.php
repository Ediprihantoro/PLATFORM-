<h2 style="color: #051F20; margin-top: 0; margin-bottom: 20px; font-family: 'Segoe UI', sans-serif; border-bottom: 2px solid #8EB69B; padding-bottom: 10px;">📦 Riwayat Pesanan Saya</h2>

<!-- Kotak Pembungkus Tabel (Background Putih Bersih) -->
<div style="background: #ffffff; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 5px 15px rgba(5, 31, 32, 0.05); overflow: hidden; font-family: 'Segoe UI', sans-serif;">
    
    <?php if(empty($data_pesanan)): ?>
        <div style="text-align: center; padding: 50px 20px;">
            <p style="color: #235347; font-size: 1.2rem; font-weight: bold;">Kamu belum memiliki riwayat pesanan.</p>
            <p style="color: #163832; margin-bottom: 20px;">Yuk, mulai penuhi keranjangmu dengan makanan lezat!</p>
            <a href="index.php?area=consumer&action=katalog" style="display: inline-block; background: #f2d472; color: #051F20; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; text-transform: uppercase; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; color: #051F20;"> <!-- Teks diubah jadi hijau sangat gelap -->
            <thead>
                <!-- Bagian Kepala Tabel (Background Hijau Gelap) -->
                <tr style="background: #163832; color: #DAF1DE;">
                    <th style="padding: 18px 15px; text-align: left;">No. Tagihan</th>
                    <th style="padding: 18px 15px; text-align: left;">Tanggal</th>
                    <th style="padding: 18px 15px; text-align: right;">Total Belanja</th>
                    <th style="padding: 18px 15px; text-align: center;">Status</th>
                    <th style="padding: 18px 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_pesanan as $row): ?>
                    <!-- Baris Tabel dengan Border Sage Green -->
                    <tr style="border-bottom: 1px solid #DAF1DE; transition: background 0.2s;" onmouseover="this.style.background='#F7FAF8'" onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 15px; color: #235347; font-weight: bold;">#LZT-<?= str_pad($row['idOrder'], 4, '0', STR_PAD_LEFT) ?></td>
                        
                        <td style="padding: 15px;"><?= date('d M Y, H:i', strtotime($row['tanggal_pesanan'])) ?></td>
                        
                        <td style="padding: 15px; text-align: right; font-weight: bold; color: #051F20;">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        
                        <td style="padding: 15px; text-align: center;">
                            <?php 
                                // Penyesuaian warna label agar elegan
                                $bg_warna = '#e2e8f0'; $text_warna = '#475569'; // Default / Pending
                                if(strtolower($row['status']) == 'menunggu pembayaran') { $bg_warna = '#fef3c7'; $text_warna = '#d97706'; }
                                if(strtolower($row['status']) == 'menunggu verifikasi') { $bg_warna = '#f2d472'; $text_warna = '#051F20'; } 
                                if(strtolower($row['status']) == 'diproses')            { $bg_warna = '#dbeafe'; $text_warna = '#2563eb'; } 
                                if(strtolower($row['status']) == 'dikirim')             { $bg_warna = '#8EB69B'; $text_warna = '#051F20'; } 
                                if(strtolower($row['status']) == 'selesai')             { $bg_warna = '#dcfce7'; $text_warna = '#16a34a'; } 
                            ?>
                            <span style="background: <?= $bg_warna ?>; color: <?= $text_warna ?>; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; display: inline-block;">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        
                        <td style="padding: 15px; text-align: center;">
                            <!-- Tombol Aksi (Outline Emas ke Solid Emas) -->
                            <a href="index.php?area=consumer&action=detail_pesanan&id=<?= $row['idOrder'] ?>" style="color: #d97706; text-decoration: none; font-size: 0.9rem; border: 1px solid #f2d472; font-weight: bold; padding: 6px 15px; border-radius: 5px; transition: 0.3s; display: inline-block;" onmouseover="this.style.background='#f2d472'; this.style.color='#051F20'" onmouseout="this.style.background='transparent'; this.style.color='#d97706'">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>