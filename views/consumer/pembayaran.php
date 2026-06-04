<div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 10px;">
    
    <div style="flex: 1; min-width: 300px; background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);">
        <h4 style="color: #051F20; margin-top: 0; border-bottom: 2px solid #DAF1DE; padding-bottom: 10px;">Informasi Pengiriman</h4>
        <p style="margin-bottom: 10px;"><strong>Nama Penerima:</strong><br><?= htmlspecialchars($detail_pesanan['nama_penerima'] ?? '-') ?></p>
        <p style="margin-bottom: 10px;"><strong>No. HP / WhatsApp:</strong><br><?= htmlspecialchars($detail_pesanan['no_hp'] ?? '-') ?></p>
        <p style="margin-bottom: 10px;"><strong>Alamat Lengkap:</strong><br><?= htmlspecialchars($detail_pesanan['alamat_lengkap'] ?? '-') ?></p>
        <p style="margin-bottom: 10px;"><strong>Metode Pembayaran:</strong><br>
            <span style="background: #DAF1DE; color: #163832; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($detail_pesanan['metode_pembayaran'] ?? '-') ?>
            </span>
        </p>
        <p style="margin-bottom: 0;"><strong>Catatan Tambahan:</strong><br>
            <i style="color: #d97706;">"<?= htmlspecialchars($detail_pesanan['catatan'] ?? 'Tidak ada catatan') ?>"</i>
        </p>
    </div>

    <div style="flex: 2; min-width: 300px; background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);">
        <h4 style="color: #051F20; margin-top: 0; border-bottom: 2px solid #DAF1DE; padding-bottom: 10px;">Rincian Produk yang Dibeli</h4>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; text-align: left; color: #163832;">
                    <th style="padding: 10px 5px;">Nama Produk</th>
                    <th style="padding: 10px 5px; text-align: center;">Qty</th>
                    <th style="padding: 10px 5px; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail_pesanan['items'])): ?>
                    <?php foreach ($detail_pesanan['items'] as $item): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 5px; color: #051F20; font-weight: bold;">
                                <?= htmlspecialchars($item['namaProduk']) ?>
                            </td>
                            <td style="padding: 12px 5px; text-align: center; color: #475569;">
                                <?= htmlspecialchars($item['jumlah']) ?>x
                            </td>
                            <td style="padding: 12px 5px; text-align: right; color: #051F20;">
                                Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px; color: #64748b;">
                            Tidak ada detail produk yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr style="background: #DAF1DE; font-weight: 900; color: #051F20;">
                    <td colspan="2" style="padding: 15px 10px; border-radius: 6px 0 0 6px;">Total Tagihan</td>
                    <td style="padding: 15px 10px; text-align: right; border-radius: 0 6px 6px 0;">
                        Rp <?= number_format($detail_pesanan['total_harga'] ?? 0, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php $status_pesanan = $detail_pesanan['status_pesanan'] ?? ''; ?>

<div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; margin-top: 30px; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);">
    <h3 style="color: #051F20; margin-top: 0; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; font-size: 1.3rem;">
        Informasi Status & Pembayaran
    </h3>

    <div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: #F7FAF8; padding: 15px; border-radius: 8px;">
        <div>
            <span style="color: #64748b; font-size: 0.95rem;">Metode Pembayaran:</span><br>
            <strong style="color: #163832; font-size: 1.1rem;"><?= htmlspecialchars($detail_pesanan['metode_pembayaran'] ?? '-') ?></strong>
        </div>
        <div style="text-align: right;">
            <span style="color: #64748b; font-size: 0.95rem;">Status Pesanan Saat Ini:</span><br>
            <?php 
                // Logika Warna Label Status
                $bg_status = '#e2e8f0'; $text_status = '#475569';
                $status_lower = strtolower($status_pesanan);
                if($status_lower == 'menunggu pembayaran') { $bg_status = '#fef3c7'; $text_status = '#d97706'; }
                if($status_lower == 'menunggu verifikasi') { $bg_status = '#f2d472'; $text_status = '#051F20'; } 
                if($status_lower == 'diproses')            { $bg_status = '#dbeafe'; $text_status = '#2563eb'; } 
                if($status_lower == 'dikirim')             { $bg_status = '#8EB69B'; $text_status = '#051F20'; } 
                if($status_lower == 'selesai')             { $bg_status = '#dcfce7'; $text_status = '#16a34a'; } 
            ?>
            <span style="background: <?= $bg_status ?>; color: <?= $text_status ?>; padding: 5px 15px; border-radius: 20px; font-size: 1rem; font-weight: 900; display: inline-block; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">
                <?= htmlspecialchars($status_pesanan) ?>
            </span>
        </div>
    </div>

    <?php if ($status_pesanan === 'Menunggu Pembayaran'): ?>
        
        <?php if(($detail_pesanan['metode_pembayaran'] ?? '') === 'Transfer Bank'): ?>
            <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 30px; border-radius: 12px; margin-bottom: 25px; text-align: center;">
                <h3 style="color: #b45309; margin-top: 0; font-size: 1.2rem; margin-bottom: 5px;">Menunggu Pembayaran</h3>
                <p style="color: #78350f; margin: 0 0 10px 0;">Total yang harus ditransfer:</p>
                <div style="font-size: 2.5rem; color: #d97706; font-weight: 900; margin-bottom: 25px;">
                    Rp <?= number_format($detail_pesanan['total_harga'], 0, ',', '.') ?>
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
                <div style="color: #ef4444; font-weight: bold; font-size: 0.9rem;">*Pastikan nominal transfer sesuai hingga 3 digit terakhir.</div>
            </div>

            <div style="background: #F7FAF8; border: 1px solid #DAF1DE; padding: 25px; border-radius: 12px;">
                <h4 style="color: #051F20; margin-top: 0; margin-bottom: 15px; font-size: 1.1rem;">Upload Bukti Transfer</h4>
                <form action="index.php?area=consumer&action=upload_bukti" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPesanan" value="<?= htmlspecialchars($detail_pesanan['idPesanan']) ?>">
                    <div style="border: 1px dashed #8EB69B; background: #ffffff; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                        <input type="file" name="bukti_transfer" accept="image/jpeg, image/png, image/jpg" required style="width: 100%; outline: none; cursor: pointer;">
                    </div>
                    <button type="submit" style="width: 100%; background: #f2d472; color: #051F20; padding: 15px; border: none; border-radius: 6px; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        Kirim Bukti Pembayaran ➔
                    </button>
                </form>
            </div>

        <?php elseif(($detail_pesanan['metode_pembayaran'] ?? '') === 'COD'): ?>
            <div style="background: #F7FAF8; border: 1px solid #8EB69B; padding: 40px 30px; border-radius: 12px; text-align: center;">
                <div style="font-size: 3.5rem; margin-bottom: 15px;">🤝</div>
                <h3 style="color: #051F20; margin-top: 0; font-size: 1.6rem; margin-bottom: 10px;">Pembayaran Tunai</h3>
                <p style="color: #475569; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">Anda telah memilih metode pembayaran tunai.<br>Silakan siapkan uang pas sebesar:</p>
                <div style="font-size: 3rem; color: #16a34a; font-weight: 900; margin-bottom: 30px;">
                    Rp <?= number_format($detail_pesanan['total_harga'], 0, ',', '.') ?>
                </div>
                <div style="background: #DAF1DE; color: #163832; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 0.95rem; display: inline-block;">
                    💡 Uang diserahkan langsung kepada kurir saat pesanan tiba, atau kepada kasir saat Anda di toko.
                </div>
            </div>
        <?php endif; ?>

    <?php elseif ($status_pesanan === 'Menunggu Verifikasi'): ?>
        <div style="background: #fef9c3; border: 1px solid #fde047; color: #854d0e; padding: 25px; border-radius: 8px; text-align: center; font-size: 1.1rem;">
            <div style="font-size: 3rem; margin-bottom: 10px;">⏳</div>
            <strong style="display: block; font-size: 1.3rem; margin-bottom: 5px;">Bukti Sedang Diverifikasi</strong>
            Bukti pembayaran Anda sudah kami terima dan sedang di-cek oleh Admin. Harap tunggu sebentar ya!
        </div>

    <?php elseif ($status_pesanan === 'Diproses'): ?>
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 25px; border-radius: 8px; text-align: center; font-size: 1.1rem;">
            <div style="font-size: 3rem; margin-bottom: 10px;">👨‍🍳</div>
            <strong style="display: block; font-size: 1.3rem; margin-bottom: 5px;">Pesanan Disiapkan</strong>
            Pembayaran berhasil diverifikasi! Tim kami sedang menyiapkan pesanan frozen food Anda.
        </div>

    <?php elseif ($status_pesanan === 'Dikirim'): ?>
        <div style="background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 25px; border-radius: 8px; text-align: center; font-size: 1.1rem;">
            <div style="font-size: 3rem; margin-bottom: 10px;">🛵</div>
            <strong style="display: block; font-size: 1.3rem; margin-bottom: 5px;">Pesanan Dalam Perjalanan</strong>
            Pesanan Anda sudah diserahkan ke kurir / siap diambil di toko. Bersiaplah!
        </div>

    <?php elseif (strtolower($status_pesanan) === 'selesai'): ?>
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 25px; border-radius: 8px; text-align: center; font-size: 1.1rem;">
            <div style="font-size: 3rem; margin-bottom: 10px;">🎉</div>
            <strong style="display: block; font-size: 1.3rem; margin-bottom: 5px;">Transaksi Selesai</strong>
            
            <?php if (($detail_pesanan['metode_pengiriman'] ?? '') === 'Ambil Sendiri'): ?>
                Pesanan ini telah selesai dan <b>sudah diambil</b> di toko. 
            <?php else: ?>
                Pesanan ini telah selesai dan <b>sudah diterima</b> di alamat pengiriman Anda. 
            <?php endif; ?>
            
            <br>Terima kasih telah mempercayakan belanja frozen food Anda di Lezaat!
        </div>

    <?php else: ?>
        <div style="background: #f1f5f9; color: #475569; padding: 20px; border-radius: 8px; text-align: center; font-weight: bold;">
            Pesanan berada dalam status: <?= htmlspecialchars($status_pesanan) ?>
        </div>
    <?php endif; ?>

</div>