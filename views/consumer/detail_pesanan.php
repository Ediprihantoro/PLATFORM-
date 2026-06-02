<div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; margin-top: 30px; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);">
    <h3 style="color: #051F20; margin-top: 0; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; font-size: 1.3rem;">
        💳 Instruksi Pembayaran
    </h3>

    <div style="margin-bottom: 20px;">
        <span style="color: #64748b; font-size: 0.95rem;">Metode Pembayaran yang Dipilih:</span><br>
        <strong style="color: #16a34a; font-size: 1.2rem;"><?= htmlspecialchars($pesanan['metode_pembayaran'] ?? 'Belum ditentukan') ?></strong>
    </div>

    <?php if(($pesanan['metode_pembayaran'] ?? '') === 'Transfer Bank'): ?>
        
        <div style="background: #F7FAF8; border: 1px solid #DAF1DE; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <p style="color: #475569; margin-top: 0; margin-bottom: 10px;">Silakan transfer sesuai <strong>Total Tagihan</strong> ke rekening berikut:</p>
            <div style="font-size: 1.2rem; color: #051F20; font-weight: 900; letter-spacing: 1px; margin-bottom: 5px;">
                BCA - 1234567890
            </div>
            <div style="color: #163832; font-weight: bold;">a.n. Lezaat Frozen Food</div>
        </div>

        <?php if(empty($pesanan['bukti_transfer'])): ?>
            <form action="index.php?area=consumer&action=upload_bukti" method="POST" enctype="multipart/form-data" style="border-top: 1px dashed #cbd5e1; padding-top: 20px;">
                <input type="hidden" name="idPesanan" value="<?= $pesanan['idPesanan'] ?>">
                
                <label style="display: block; color: #051F20; font-weight: bold; margin-bottom: 10px;">Upload Bukti Transfer</label>
                <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                    <input type="file" name="bukti_transfer" accept="image/jpeg, image/png, image/jpg" required style="padding: 10px; border: 1px solid #8EB69B; border-radius: 6px; background: #ffffff; flex: 1; min-width: 200px;">
                    <button type="submit" style="background: #f2d472; color: #051F20; padding: 12px 25px; border: none; border-radius: 6px; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: 0.2s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Kirim Bukti ➔
                    </button>
                </div>
                <small style="color: #64748b; display: block; margin-top: 8px;">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
            </form>
        <?php else: ?>
            <div style="background: #DAF1DE; color: #163832; padding: 15px; border-radius: 6px; text-align: center; font-weight: bold;">
                ✅ Bukti transfer sudah diunggah. Menunggu verifikasi admin.
            </div>
        <?php endif; ?>

    <?php elseif(($pesanan['metode_pembayaran'] ?? '') === 'COD'): ?>
        
        <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 20px; border-radius: 8px;">
            <p style="color: #b45309; margin: 0; font-weight: bold; line-height: 1.6;">
                ⚠️ Anda memilih Bayar di Tempat (COD).<br>
                Silakan siapkan uang tunai pas sejumlah <strong>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></strong> untuk diserahkan kepada kurir kami saat pesanan tiba.
            </p>
        </div>

    <?php else: ?>
        <p style="color: #64748b;">Silakan hubungi admin untuk melanjutkan pembayaran.</p>
    <?php endif; ?>
</div>