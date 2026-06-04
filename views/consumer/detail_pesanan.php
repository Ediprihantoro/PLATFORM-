<div style="font-family: 'Segoe UI', sans-serif; color: #051F20; padding: 20px; max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px;">
        <a href="index.php?area=consumer&action=pesanan_saya" style="background: #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.95rem; display: inline-block;">
            &larr; Kembali
        </a>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
        
        <div style="flex: 1; min-width: 300px; background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <h4 style="color: #163832; margin-top: 0; font-size: 1.1rem; border-bottom: 2px dashed #e2e8f0; padding-bottom: 10px;">Informasi Pengiriman</h4>
            
            <table style="width: 100%; font-size: 0.95rem; margin-top: 15px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="color: #64748b; width: 35%;">Nama Penerima</td>
                    <td style="font-weight: bold; color: #0f172a;">: <?= htmlspecialchars($detail_pesanan['nama_penerima'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b;">No. WhatsApp</td>
                    <td style="font-weight: bold; color: #0f172a;">: <?= htmlspecialchars($detail_pesanan['no_hp'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b; vertical-align: top;">Alamat Lengkap</td>
                    <td style="font-weight: bold; color: #0f172a; line-height: 1.5;">: <?= htmlspecialchars($detail_pesanan['alamat_lengkap'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b;">Pembayaran</td>
                    <td style="font-weight: bold; color: #0f172a;">: 
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem;">
                            <?= htmlspecialchars($detail_pesanan['metode_pembayaran'] ?? '-') ?>
                        </span>
                    </td>
                </tr>
                <?php if(!empty($detail_pesanan['catatan'])): ?>
                <tr>
                    <td style="color: #64748b; vertical-align: top;">Catatan</td>
                    <td>: <span style="font-style: italic; color: #d97706; background: #fef3c7; padding: 4px 8px; border-radius: 4px;">"<?= htmlspecialchars($detail_pesanan['catatan']) ?>"</span></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <div style="flex: 1.5; min-width: 300px; background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <h4 style="color: #163832; margin-top: 0; font-size: 1.1rem; border-bottom: 2px dashed #e2e8f0; padding-bottom: 10px;">Rincian Barang Belanjaan</h4>
            
            <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 15px;">
                <thead>
                    <tr style="color: #64748b; font-size: 0.85rem;">
                        <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-transform: uppercase;">Barang / Produk</th>
                        <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: center; text-transform: uppercase;">Qty</th>
                        <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: right; text-transform: uppercase;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $subtotal_produk = 0;
                    $daftar_item = $detail_pesanan['items'] ?? [];
                    if(!empty($daftar_item)): 
                        foreach($daftar_item as $item): 
                            $harga_sub = $item['subtotal'] ?? ($item['harga'] * $item['jumlah']); 
                            $subtotal_produk += $harga_sub;
                    ?>
                        <tr>
                            <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-weight: 500;">
                                <?= htmlspecialchars($item['nama_produk'] ?? $item['namaProduk'] ?? 'Nama Produk') ?>
                            </td>
                            <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; text-align: center; color: #64748b;">
                                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 15px; font-size: 0.9rem;"><?= htmlspecialchars($item['jumlah'] ?? 0) ?>x</span>
                            </td>
                            <td style="padding: 15px 10px; border-bottom: 1px solid #e2e8f0; text-align: right; color: #0f172a; font-weight: bold;">
                                Rp <?= number_format($harga_sub, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8; font-style: italic;">
                                -- Rincian barang belum tersedia --
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php 
                        $total_keseluruhan = $detail_pesanan['total_harga'] ?? 0;
                        $ongkos_kirim = $total_keseluruhan - $subtotal_produk;
                        if ($ongkos_kirim < 0) $ongkos_kirim = 0; 
                    ?>
                    
                    <tr>
                        <td colspan="2" style="padding: 15px 10px; text-align: right; font-weight: bold; color: #64748b; border-bottom: 1px solid #e2e8f0;">Total Harga Produk</td>
                        <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                            Rp <?= number_format($subtotal_produk, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 15px 10px; text-align: right; font-weight: bold; color: #d97706; border-bottom: 1px solid #e2e8f0;">Ongkos Kirim</td>
                        <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #d97706; border-bottom: 1px solid #e2e8f0;">
                            Rp <?= number_format($ongkos_kirim, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <tr style="background: #DAF1DE;">
                        <td colspan="2" style="padding: 15px 10px; font-weight: bold; color: #163832; font-size: 1.05rem; text-align: right;">TOTAL KESELURUHAN</td>
                        <td style="padding: 15px 10px; text-align: right; font-weight: bold; color: #163832; font-size: 1.15rem;">
                            Rp <?= number_format($total_keseluruhan, 0, ',', '.') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        
        <div style="background: #e0f2fe; color: #0369a1; padding: 12px; border-radius: 8px; text-align: center; font-weight: bold; font-size: 0.95rem; margin-bottom: 20px;">
            Sistem Membaca Metode: [ <?= htmlspecialchars($detail_pesanan['metode_pembayaran'] ?? 'Kosong') ?> ]
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px; margin-bottom: 25px;">
            <h3 style="margin: 0; font-size: 1.2rem; color: #0f172a;">Order #LZT-<?= str_pad($detail_pesanan['idPesanan'] ?? $detail_pesanan['idOrder'] ?? 0, 4, '0', STR_PAD_LEFT) ?></h3>
            
            <?php
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
</div>