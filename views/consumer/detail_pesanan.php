<div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
    
    <div style="background: #e0f2fe; color: #0369a1; padding: 12px; border-radius: 8px; text-align: center; font-weight: bold; font-size: 0.95rem; margin-bottom: 20px;">
        Sistem Membaca Metode: [ <?= htmlspecialchars($detail_pesanan['metode_pembayaran'] ?? 'Kosong') ?> ]
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px; margin-bottom: 25px;">
        <h3 style="margin: 0; font-size: 1.2rem; color: #0f172a;">Order #LZT-<?= str_pad($detail_pesanan['idPesanan'] ?? $detail_pesanan['idOrder'] ?? 0, 4, '0', STR_PAD_LEFT) ?></h3>
        
        <?php
            // Warna label status otomatis
            $bg_badge = '#fef08a'; $text_badge = '#854d0e';
            $status_cek = strtolower($detail_pesanan['status_pesanan'] ?? $detail_pesanan['status'] ?? '');
            if($status_cek == 'selesai') { $bg_badge = '#dcfce7'; $text_badge = '#166534'; }
            if($status_cek == 'dikirim') { $bg_badge = '#dbeafe'; $text_badge = '#1e40af'; }
        ?>
        <span style="background: <?= $bg_badge ?>; color: <?= $text_badge ?>; padding: 6px 15px; border-radius: 20px; font-weight: bold; font-size: 0.85rem; text-transform: uppercase;">
            <?= htmlspecialchars($detail_pesanan['status_pesanan'] ?? $detail_pesanan['status'] ?? 'DIPROSES') ?>
        </span>
    </div>

    <?php 
        // JURUS SAKTI: Baca huruf kecilnya aja biar kebal error
        $metode = strtolower($detail_pesanan['metode_pembayaran'] ?? '');
    ?>

    <?php if(strpos($metode, 'cod') !== false || strpos($metode, 'tempat') !== false): ?>
        
        <div style="background: #dcfce7; padding: 40px 20px; border-radius: 12px; text-align: center; border: 1px solid #bbf7d0;">
            <div style="font-size: 3.5rem; margin-bottom: 10px;">🚚</div>
            <h2 style="color: #166534; margin-top: 0; margin-bottom: 15px; font-size: 1.5rem;">Pesanan Berhasil Dibuat!</h2>
            <p style="color: #15803d; font-size: 1.05rem; margin-bottom: 20px;">Anda memilih metode <strong>Bayar di Tempat (COD)</strong>.</p>
            
            <p style="color: #166534; margin-bottom: 10px;">Silakan siapkan uang tunai sebesar:</p>
            <div style="background: #ffffff; color: #16a34a; font-size: 1.8rem; font-weight: 900; display: inline-block; padding: 12px 30px; border-radius: 8px; border: 2px solid #22c55e; box-shadow: 0 4px 10px rgba(34,197,94,0.15);">
                Rp <?= number_format($detail_pesanan['total_harga'] ?? 0, 0, ',', '.') ?>
            </div>
        </div>

    <?php elseif(strpos($metode, 'transfer') !== false || strpos($metode, 'bank') !== false): ?>
        
        <div style="background: #fffbeb; padding: 30px 20px; border-radius: 12px; text-align: center; border: 1px solid #fde68a;">
            <div style="font-size: 3.5rem; margin-bottom: 10px;">💳</div>
            <h2 style="color: #b45309; margin-top: 0; margin-bottom: 15px; font-size: 1.5rem;">Menunggu Pembayaran</h2>
            <p style="color: #92400e; font-size: 1.05rem; margin-bottom: 20px;">Anda memilih metode <strong>Transfer Bank</strong>.</p>
            
            <p style="color: #b45309; margin-bottom: 10px;">Total yang harus ditransfer:</p>
            <div style="background: #ffffff; color: #d97706; font-size: 1.8rem; font-weight: 900; display: inline-block; padding: 12px 30px; border-radius: 8px; border: 2px solid #f59e0b; box-shadow: 0 4px 10px rgba(245,158,11,0.15); margin-bottom: 25px;">
                Rp <?= number_format($detail_pesanan['total_harga'] ?? 0, 0, ',', '.') ?>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-bottom: 25px;">
                <div style="background: #ffffff; border: 1px solid #fcd34d; border-radius: 8px; padding: 15px; min-width: 200px;">
                    <div style="font-weight: 900; color: #0f172a; font-size: 1.1rem; margin-bottom: 5px;">BCA</div>
                    <div style="font-size: 1.3rem; color: #16a34a; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px;">1234-5678-90</div>
                    <div style="color: #64748b; font-size: 0.85rem;">a.n Lezaat Frozen Food</div>
                </div>
                <div style="background: #ffffff; border: 1px solid #fcd34d; border-radius: 8px; padding: 15px; min-width: 200px;">
                    <div style="font-weight: 900; color: #0f172a; font-size: 1.1rem; margin-bottom: 5px;">MANDIRI</div>
                    <div style="font-size: 1.3rem; color: #16a34a; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px;">0987-6543-21</div>
                    <div style="color: #64748b; font-size: 0.85rem;">a.n Lezaat Frozen Food</div>
                </div>
            </div>

            <div style="background: #ffffff; border: 1px dashed #cbd5e1; padding: 20px; border-radius: 12px; text-align: left;">
                <?php if(empty($detail_pesanan['bukti_transfer'])): ?>
                    <h4 style="color: #0f172a; margin-top: 0; margin-bottom: 15px;">Upload Bukti Transfer</h4>
                    <form action="index.php?area=consumer&action=upload_bukti" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idPesanan" value="<?= $detail_pesanan['idPesanan'] ?? $detail_pesanan['idOrder'] ?? '' ?>">
                        
                        <div style="margin-bottom: 15px;">
                            <input type="file" name="bukti_transfer" accept="image/jpeg, image/png, image/jpg" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc; cursor: pointer;">
                        </div>
                        
                        <button type="submit" style="width: 100%; background: #0891b2; color: #ffffff; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#06b6d4'" onmouseout="this.style.background='#0891b2'">
                            Kirim Bukti Pembayaran ➔
                        </button>
                    </form>
                <?php else: ?>
                    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 6px; text-align: center; font-weight: bold; border: 1px solid #bbf7d0;">
                        ✅ Bukti transfer sudah diunggah. Menunggu verifikasi admin.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <div style="background: #fef2f2; padding: 30px 20px; border-radius: 12px; text-align: center; border: 1px solid #fecaca;">
            <p style="color: #dc2626; font-weight: bold; margin-bottom: 0;">⚠️ Silakan hubungi Admin untuk instruksi pembayaran lebih lanjut.</p>
        </div>
    <?php endif; ?>

</div>