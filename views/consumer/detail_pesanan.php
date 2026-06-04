<div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; margin-top: 30px; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);">
    <h3 style="color: #051F20; margin-top: 0; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; font-size: 1.3rem;">
        Instruksi Pembayaran
    </h3>

    <div style="margin-bottom: 20px;">
        <span style="color: #64748b; font-size: 0.95rem;">Metode Pembayaran yang Dipilih:</span><br>
        <strong style="color: #16a34a; font-size: 1.2rem;"><?= htmlspecialchars($pesanan['metode_pembayaran'] ?? 'Belum ditentukan') ?></strong>
    </div>

    <?php if(($pesanan['metode_pembayaran'] ?? '') === 'Transfer Bank'): ?>
        
    <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 30px; border-radius: 12px; margin-bottom: 25px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <h3 style="color: #b45309; margin-top: 0; font-size: 1.2rem; margin-bottom: 5px;">Menunggu Pembayaran</h3>
        <p style="color: #78350f; margin: 0 0 10px 0;">Total yang harus ditransfer:</p>
        
        <div style="font-size: 2.5rem; color: #d97706; font-weight: 900; margin-bottom: 25px;">
            Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?>
        </div>

        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 20px;">
            
            <div style="background: #ffffff; border: 1px solid #fde68a; border-radius: 8px; padding: 20px; min-width: 220px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                <div style="font-weight: 900; color: #051F20; font-size: 1.1rem; margin-bottom: 10px;">BCA</div>
                <div style="font-size: 1.4rem; color: #16a34a; font-weight: bold; letter-spacing: 1.5px; margin-bottom: 5px;">1234-5678-90</div>
                <div style="color: #64748b; font-size: 0.9rem; font-weight: bold;">a.n Lezaat Frozen Food</div>
            </div>

            <div style="background: #ffffff; border: 1px solid #fde68a; border-radius: 8px; padding: 20px; min-width: 220px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                <div style="font-weight: 900; color: #051F20; font-size: 1.1rem; margin-bottom: 10px;">MANDIRI</div>
                <div style="font-size: 1.4rem; color: #16a34a; font-weight: bold; letter-spacing: 1.5px; margin-bottom: 5px;">0987-6543-21</div>
                <div style="color: #64748b; font-size: 0.9rem; font-weight: bold;">a.n Lezaat Frozen Food</div>
            </div>
            
        </div>

        <div style="color: #ef4444; font-weight: bold; font-size: 0.9rem;">
            *Pastikan nominal transfer sesuai hingga 3 digit terakhir.
        </div>
    </div>

    <div style="background: #F7FAF8; border: 1px solid #DAF1DE; padding: 25px; border-radius: 12px;">
        <?php if(empty($pesanan['bukti_transfer'])): ?>
            <h4 style="color: #051F20; margin-top: 0; margin-bottom: 15px; font-size: 1.1rem;">Upload Bukti Transfer</h4>
            <form action="index.php?area=consumer&action=upload_bukti" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idPesanan" value="<?= $pesanan['idPesanan'] ?>">
                
                <div style="border: 1px dashed #8EB69B; background: #ffffff; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                    <input type="file" name="bukti_transfer" accept="image/jpeg, image/png, image/jpg" required style="width: 100%; outline: none; cursor: pointer;">
                </div>
                
                <button type="submit" style="width: 100%; background: #f2d472; color: #051F20; padding: 15px; border: none; border-radius: 6px; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(242, 212, 114, 0.3)';">
                    Kirim Bukti Pembayaran ➔
                </button>
            </form>
        <?php else: ?>
            <div style="background: #DAF1DE; color: #163832; padding: 15px; border-radius: 6px; text-align: center; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <span>✅</span> Bukti transfer sudah diunggah. Menunggu verifikasi admin.
            </div>
        <?php endif; ?>
    </div>


<?php elseif(($pesanan['metode_pembayaran'] ?? '') === 'COD'): ?>
    
    <div style="background: #F7FAF8; border: 1px solid #8EB69B; padding: 40px 30px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div style="font-size: 3.5rem; margin-bottom: 15px;">🤝</div>
        <h3 style="color: #051F20; margin-top: 0; font-size: 1.6rem; margin-bottom: 10px;">Pembayaran Tunai</h3>
        
        <p style="color: #475569; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">
            Anda telah memilih metode pembayaran tunai.<br>
            Silakan siapkan uang pas sebesar:
        </p>
        
        <div style="font-size: 3rem; color: #16a34a; font-weight: 900; margin-bottom: 30px; letter-spacing: 1px;">
            Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?>
        </div>
        
        <div style="background: #DAF1DE; color: #163832; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 0.95rem; display: inline-block;">
            💡 Uang diserahkan langsung kepada kurir saat pesanan tiba, atau kepada kasir saat Anda di toko.
        </div>
    </div>


<?php else: ?>
    <div style="padding: 20px; background: #fef2f2; border: 1px dashed #ef4444; color: #b91c1c; border-radius: 8px; text-align: center; font-weight: bold;">
        Silakan hubungi Admin untuk instruksi pembayaran lebih lanjut.
    </div>
<?php endif; ?>