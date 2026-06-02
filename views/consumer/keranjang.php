<a href="index.php?area=consumer&action=katalog" style="color: #235347; text-decoration: none; font-size: 0.95rem; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#051F20'" onmouseout="this.style.color='#235347'">
    &larr; Lanjut Belanja
</a>

<div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #DAF1DE; padding-bottom: 15px;">
    <span style="font-size: 2.5rem;">🛒</span>
    <h1 style="color: #051F20; margin: 0; font-family: 'Segoe UI', sans-serif; font-size: 2.2rem; font-weight: 900; letter-spacing: 1px;">Keranjang Belanja</h1>
</div>

<div style="background: #ffffff; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05); padding: 30px; font-family: 'Segoe UI', sans-serif;">
    
    <?php if(empty($data_keranjang)): ?>
        
        <div style="text-align: center; padding: 60px 0;">
            <div style="font-size: 5rem; margin-bottom: 20px; opacity: 0.5;">🛒</div>
            <p style="color: #475569; font-size: 1.2rem; font-weight: bold; margin-bottom: 20px;">Keranjang belanjamu masih kosong nih.</p>
            <a href="index.php?area=consumer&action=katalog" style="display: inline-block; background: #f2d472; color: #051F20; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                Mulai Belanja
            </a>
        </div>
        
    <?php else: ?>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="background: #DAF1DE; color: #051F20;">
                        <th style="padding: 15px; text-align: left; font-weight: 900; border-top-left-radius: 8px;">Produk</th>
                        <th style="padding: 15px; text-align: center; font-weight: 900;">Harga Satuan</th>
                        <th style="padding: 15px; text-align: center; font-weight: 900;">Kuantitas</th>
                        <th style="padding: 15px; text-align: right; font-weight: 900; border-top-right-radius: 8px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data_keranjang as $item): ?>
                        <?php $kunci_unik = $item['idProduk'] . '-' . (isset($item['variasi']) ? $item['variasi'] : ''); ?>
                        
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 20px 15px;">
                                <div style="font-weight: bold; font-size: 1.1rem; color: #051F20;">
                                    <?= htmlspecialchars($item['namaProduk']) ?>
                                </div>
                                <?php if(isset($item['variasi']) && $item['variasi'] != ''): ?>
                                    <div style="font-size: 0.85rem; color: #64748b; margin-top: 5px;">
                                        Variasi: <span style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 2px 8px; border-radius: 4px; font-weight: bold; color: #b48600;"><?= htmlspecialchars($item['variasi']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            
                            <td style="padding: 20px 15px; text-align: center; color: #475569; font-weight: bold;">
                                Rp <?= number_format($item['harga_eceran'], 0, ',', '.') ?>
                            </td>
                            
                            <td style="padding: 20px 15px; text-align: center;">
                                <div style="display: inline-flex; align-items: center; background: #ffffff; border: 1px solid #8EB69B; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                    
                                    <a href="#" onclick="kurangiAtauHapus('<?= urlencode($kunci_unik) ?>', <?= $item['jumlah'] ?>); return false;" style="padding: 8px 15px; color: <?= $item['jumlah'] > 1 ? '#051F20' : '#ef4444' ?>; text-decoration: none; background: <?= $item['jumlah'] > 1 ? '#f8fafc' : '#fef2f2' ?>; font-weight: bold; transition: background 0.2s; border-right: 1px solid #8EB69B;" onmouseover="this.style.background='<?= $item['jumlah'] > 1 ? '#e2e8f0' : '#fecaca' ?>'" onmouseout="this.style.background='<?= $item['jumlah'] > 1 ? '#f8fafc' : '#fef2f2' ?>'">
                                        <?= $item['jumlah'] > 1 ? '−' : '🗑️' ?>
                                    </a>
                                    
                                    <span style="padding: 8px 20px; font-weight: 900; color: #051F20; min-width: 30px; text-align: center;">
                                        <?= $item['jumlah'] ?>
                                    </span>
                                    
                                    <a href="index.php?area=consumer&action=update_keranjang&aksi=tambah&id=<?= urlencode($kunci_unik) ?>" style="padding: 8px 15px; color: #051F20; text-decoration: none; background: #f8fafc; font-weight: bold; transition: background 0.2s; border-left: 1px solid #8EB69B;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'">
                                        +
                                    </a>
                                </div>
                            </td>
                            
                            <td style="padding: 20px 15px; text-align: right; font-weight: 900; color: #051F20; font-size: 1.1rem;">
                                Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; background: #F7FAF8; border: 1px solid #DAF1DE; padding: 25px; border-radius: 8px; display: flex; justify-content: flex-end; align-items: center; gap: 30px;">
            <div style="text-align: right;">
                <span style="display: block; color: #64748b; font-weight: bold; margin-bottom: 5px;">Total Tagihan:</span>
                <span style="color: #16a34a; font-size: 1.8rem; font-weight: 900;">
                    Rp <?= number_format($total_belanja, 0, ',', '.') ?>
                </span>
            </div>
        </div>

        <div style="margin-top: 25px; text-align: right;">
            <a href="index.php?area=consumer&action=checkout" onclick="return cekKeranjang(<?= count($data_keranjang) ?>)" style="display: inline-block; background: #f2d472; color: #051F20; text-decoration: none; padding: 15px 35px; border-radius: 6px; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                Checkout Pesanan ➔
            </a>
        </div>
        
    <?php endif; ?>

</div>

<script>
    // 1. Fungsi saat tombol minus/tong sampah diklik
    function kurangiAtauHapus(idKunci, jumlahSaatIni) {
        if (jumlahSaatIni <= 1) {
            let konfirmasi = confirm("⚠️ Hapus produk ini dari keranjang?");
            if (konfirmasi) {
                window.location.href = "index.php?area=consumer&action=hapus_keranjang&id=" + idKunci;
            }
        } else {
            window.location.href = "index.php?area=consumer&action=update_keranjang&aksi=kurang&id=" + idKunci;
        }
    }

    // 2. Keamanan ganda mencegah checkout jika kosong
    function cekKeranjang(jumlahItem) {
        if (jumlahItem < 1) {
            alert("Keranjang belanjamu masih kosong! Silakan tambah produk terlebih dahulu.");
            return false; 
        }
        return true; 
    }
</script>