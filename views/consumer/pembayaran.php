<div style="font-family: 'Segoe UI', sans-serif; max-width: 800px; margin: 0 auto; padding-top: 20px;">
    
    <a href="index.php?area=consumer&action=katalog" style="color: #235347; text-decoration: none; font-size: 0.95rem; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#051F20'" onmouseout="this.style.color='#235347'">
        &larr; Kembali Belanja
    </a>

    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #DAF1DE; padding-bottom: 15px;">
        <span style="font-size: 2.5rem;">💳</span>
        <h1 style="color: #051F20; margin: 0; font-size: 2.2rem; font-weight: 900; letter-spacing: 1px;">Pembayaran Pesanan</h1>
    </div>

    <div style="background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05); margin-bottom: 50px;">
        
        <?php 
        $status = $detail_pesanan['status_pesanan'] ?? '';
        $metode = $detail_pesanan['metode_pembayaran'] ?? ''; 
        $kurir  = $detail_pesanan['metode_pengiriman'] ?? ''; 
        $total  = $detail_pesanan['total_harga'] ?? 0;

        
        $metode_kecil = strtolower($metode);
        $is_tunai = (strpos($metode_kecil, 'cod') !== false || strpos($metode_kecil, 'tempat') !== false || $metode == 'Bayar di Tempat (COD)');
        ?>

        <div style="background: #e0f2fe; border: 1px solid #38bdf8; color: #0369a1; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; text-align: center;">
            Sistem Membaca Metode: [ <?= htmlspecialchars($metode) ?> ]
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; margin-bottom: 25px; flex-wrap: wrap; gap: 10px;">
            <h3 style="color: #051F20; margin: 0; font-size: 1.3rem;">Order #LZT-<?= str_pad($detail_pesanan['idPesanan'], 4, '0', STR_PAD_LEFT) ?></h3>
            <span style="background: #f2d472; color: #051F20; padding: 6px 15px; border-radius: 20px; font-weight: 900; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                <?= htmlspecialchars($status) ?>
            </span>
        </div>

        <?php if ($is_tunai): ?>
            
            <div style="background: #DAF1DE; border: 1px solid #8EB69B; padding: 30px; border-radius: 8px; text-align: center;">
                <span style="font-size: 4rem; margin-bottom: 15px; display: block;">
                    <?= ($kurir == 'Ambil Sendiri') ? '🏪' : '🚚' ?>
                </span>
                
                <h3 style="color: #051F20; margin-top: 0; font-size: 1.5rem; font-weight: 900;">Pesanan Berhasil Dibuat!</h3>
                <p style="color: #163832; font-size: 1.1rem; line-height: 1.6; margin-bottom: 0;">
                    Anda memilih metode 
                    <strong><?= ($kurir == 'Ambil Sendiri') ? 'Ambil & Bayar Langsung di Toko' : 'Bayar di Tempat (COD)' ?></strong>.<br><br>
                    
                    Silakan siapkan uang tunai sebesar:<br>
                    <strong style="font-size: 1.8rem; color: #16a34a; background: #ffffff; padding: 5px 15px; border-radius: 8px; display: inline-block; margin-top: 10px; border: 1px solid #8EB69B;">Rp <?= number_format($total, 0, ',', '.') ?></strong><br>
                    
                    <span style="font-size: 0.9rem; display: block; margin-top: 10px; font-weight: bold;">
                        <?php if ($kurir == 'Ambil Sendiri'): ?>
                            * Diserahkan kepada kasir kami saat Anda mengambil pesanan di toko.
                        <?php else: ?>
                            * Diserahkan kepada kurir kami saat pesanan tiba di lokasi Anda.
                        <?php endif; ?>
                    </span>
                </p>
            </div>

        <?php else: ?>
            
            <?php if ($status == 'Menunggu Pembayaran' || $status == 'pending'): ?>
                <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 25px;">
                    <h3 style="color: #b45309; margin-top: 0; font-weight: 900;">Menunggu Pembayaran</h3>
                    <p style="color: #92400e; font-size: 1.1rem; margin-bottom: 20px;">
                        Total yang harus ditransfer: <br>
                        <strong style="font-size: 2rem; color: #d97706; display: block; margin-top: 5px;">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                    </p>
                    
                    <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                        <div style="background: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #fcd34d; min-width: 220px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                            <strong style="color: #051F20; font-size: 1.2rem; display: block; margin-bottom: 5px;">BCA</strong>
                            <span style="font-size: 1.4rem; font-weight: 900; color: #16a34a; letter-spacing: 2px; display: block; margin-bottom: 5px;">1234-5678-90</span>
                            <span style="color: #64748b; font-size: 0.95rem; font-weight: bold;">a.n Lezaat Frozen Food</span>
                        </div>
                        <div style="background: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #fcd34d; min-width: 220px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                            <strong style="color: #051F20; font-size: 1.2rem; display: block; margin-bottom: 5px;">MANDIRI</strong>
                            <span style="font-size: 1.4rem; font-weight: 900; color: #16a34a; letter-spacing: 2px; display: block; margin-bottom: 5px;">0987-6543-21</span>
                            <span style="color: #64748b; font-size: 0.95rem; font-weight: bold;">a.n Lezaat Frozen Food</span>
                        </div>
                    </div>
                    <p style="color: #ef4444; font-size: 0.9rem; margin-top: 20px; font-weight: bold;">*Pastikan nominal transfer sesuai hingga 3 digit terakhir.</p>
                </div>

                <div style="background: #F7FAF8; border: 1px solid #8EB69B; padding: 25px; border-radius: 8px;">
                    <h4 style="color: #051F20; margin-top: 0; margin-bottom: 15px; font-size: 1.2rem;">Upload Bukti Transfer</h4>
                    
                    <form action="index.php?area=consumer&action=upload_bukti" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
                        <input type="hidden" name="idPesanan" value="<?= $detail_pesanan['idPesanan'] ?>">
                        <input type="file" name="bukti_transfer" accept="image/png, image/jpeg, image/jpg" required style="padding: 12px; border: 1px dashed #8EB69B; border-radius: 6px; background: #ffffff; color: #475569; outline: none; cursor: pointer;">
                        
                        <button type="submit" style="padding: 15px; background: #f2d472; color: #051F20; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; border: none; border-radius: 6px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(242, 212, 114, 0.3)';">
                            Kirim Bukti Pembayaran 
                        </button>
                    </form>
                </div>

            <?php elseif ($status == 'Menunggu Verifikasi'): ?>
                <div style="background: #F7FAF8; border: 1px solid #8EB69B; padding: 40px 20px; border-radius: 8px; text-align: center;">
                    <h3 style="color: #051F20; margin-top: 0; font-weight: 900;">Bukti Transfer Sedang Diverifikasi</h3>
                    <p style="color: #235347; font-size: 1.1rem; max-width: 500px; margin: 0 auto; line-height: 1.5;">Terima kasih! Bukti pembayaranmu sudah kami terima dan sedang dicek oleh tim kami. Silakan cek status pesananmu secara berkala.</p>
                </div>

            <?php else: ?>
                <div style="background: #DAF1DE; border: 1px solid #8EB69B; padding: 40px 20px; border-radius: 8px; text-align: center;">
                    <h3 style="color: #051F20; margin-top: 0; font-weight: 900;">Status Saat Ini: <?= htmlspecialchars($status) ?></h3>
                    <p style="color: #163832; font-size: 1.1rem;">Pesananmu sedang dalam pantauan sistem.</p>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>