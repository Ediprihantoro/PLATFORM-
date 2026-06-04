<div style="background: linear-gradient(135deg, #0B2B26 0%, #051F20 100%); border-radius: 12px; padding: 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.15); border-left: 8px solid #f2d472;">
    <div>
        <h1 style="color: #f2d472; margin: 0 0 10px 0; font-family: 'Arial', sans-serif; font-size: 2.2rem; font-weight: bold; text-transform: uppercase;">
            Halo, <span style="color: #DAF1DE;">Admin!</span> 👋
        </h1>
        <p style="color: #8EB69B; margin: 0; font-size: 1.1rem; line-height: 1.5;">
            Selamat datang di pusat kendali <strong>Lezaat Frozen Food</strong>. <br>
            Pantau pesanan masuk, kelola stok produk, dan pastikan stok selalu segar hari ini!
        </p>
    </div>
</div>

<div style="font-family: 'Segoe UI', sans-serif; color: #051F20;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #051F20; margin: 0; border-bottom: 2px solid #8EB69B; padding-bottom: 5px;">Manajemen Pesanan Masuk</h2>
    </div>

    <div style="background: #ffffff; padding: 0; border-radius: 12px; border: 1px solid #8EB69B; margin-top: 20px; overflow-x: auto; box-shadow: 0 5px 15px rgba(5, 31, 32, 0.05);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #163832; color: #DAF1DE;">
                    <th style="padding: 18px 15px;">ID Nota</th>
                    <th style="padding: 18px 15px;">Nama Pembeli</th>
                    <th style="padding: 18px 15px;">Tanggal</th>
                    <th style="padding: 18px 15px; text-align: center;">Bukti Transfer</th>
                    <th style="padding: 18px 15px; text-align: center;">Status</th>
                    <th style="padding: 18px 15px; text-align: center;">Aksi / Update</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($data_pesanan)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 60px 20px;">
                            <div style="font-size: 3rem; color: #8EB69B; margin-bottom: 15px;">💤</div>
                            <h3 style="color: #235347; margin: 0 0 5px 0;">Belum ada pesanan</h3>
                            <p style="color: #64748b; margin: 0;">Toko sedang sepi. Tunggu pembeli datang ya!</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($data_pesanan as $row): ?>
                        <tr style="border-bottom: 1px solid #DAF1DE; transition: background 0.2s;" onmouseover="this.style.background='#F7FAF8'" onmouseout="this.style.background='transparent'">
                            
                            <td style="padding: 15px; color: #235347; font-weight: bold;">#LZT-<?= str_pad($row['idOrder'], 4, '0', STR_PAD_LEFT) ?></td>
                            
                            <td style="padding: 15px; font-weight: bold; color: #051F20;"><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                            
                            <td style="padding: 15px; font-size: 0.9rem; color: #475569;"><?= date('d M Y, H:i', strtotime($row['tanggal_pesanan'])) ?></td>
                            
                            <td style="padding: 15px; text-align: center;">
                                <?php if(!empty($row['bukti_transfer'])): ?>
                                    <a href="uploads/<?= $row['bukti_transfer'] ?>" target="_blank" style="color: #0284c7; text-decoration: none; border: 1px solid #7dd3fc; background: #e0f2fe; padding: 6px 12px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; display: inline-block; transition: 0.2s;" onmouseover="this.style.background='#bae6fd'" onmouseout="this.style.background='#e0f2fe'">
                                        Lihat Struk
                                    </a>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-style: italic; font-size: 0.85rem;">Belum diunggah</span>
                                <?php endif; ?>
                            </td>
                            
                            <td style="padding: 15px; text-align: center;">
                                <?php 
                                    // Pewarnaan Label Status Dinamis
                                    $bg_status = '#e2e8f0'; $text_status = '#475569'; 
                                    $status_raw = strtolower($row['status']);
                                    if($status_raw == 'menunggu pembayaran') { $bg_status = '#fef3c7'; $text_status = '#d97706'; }
                                    if($status_raw == 'menunggu verifikasi') { $bg_status = '#fef08a'; $text_status = '#854d0e'; } 
                                    if($status_raw == 'diproses')            { $bg_status = '#dbeafe'; $text_status = '#1d4ed8'; } 
                                    if($status_raw == 'dikirim')             { $bg_status = '#DAF1DE'; $text_status = '#163832'; } 
                                    if($status_raw == 'selesai')             { $bg_status = '#dcfce7'; $text_status = '#166534'; } 
                                ?>
                                <span style="background: <?= $bg_status ?>; color: <?= $text_status ?>; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; display: inline-block;">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            
                            <td style="padding: 15px; text-align: center;">
                                <a href="index.php?area=admin&action=detail_pesanan&id=<?= $row['idOrder'] ?>" style="background: #0891b2; color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.85rem; display: inline-block; box-shadow: 0 2px 4px rgba(8,145,178,0.2); transition: 0.2s;" onmouseover="this.style.background='#06b6d4'" onmouseout="this.style.background='#0891b2'">
                                    Detail Pesanan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>