<h2 style="color: #051F20; border-bottom: 2px solid #8EB69B; padding-bottom: 10px;">Preview Etalase Toko</h2>

<div style="background: linear-gradient(135deg, #0B2B26 0%, #051F20 100%); border-radius: 15px; padding: 40px 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; margin-top: 20px; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.2); overflow: hidden; border: 1px solid #163832;">
    <div style="position: relative; z-index: 1;">
        <h1 style="margin: 0 0 10px 0; font-family: 'Arial', sans-serif; font-size: 2.8rem; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">
            <span style="color: #f2d472;">LEZZAT</span> <span style="color: #DAF1DE;">FROZEN FOOD</span>
        </h1>
        <p style="color: #8EB69B; margin: 0 0 20px 0; font-size: 1.1rem; line-height: 1.6; max-width: 550px;">
            <strong style="color: #DAF1DE; letter-spacing: 2px;">TASTY • CONVENIENT • ALWAYS FRESH</strong><br><br>
            Tampilan etalase ini persis seperti yang dilihat oleh pelanggan Anda.
        </p>
        <div style="display: flex; gap: 20px; margin-bottom: 10px;">
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">❄️</span> Freshly Frozen</span>
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">⏱️</span> Ready in Minutes</span>
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">✅</span> 100% Halal</span>
        </div>
    </div>
    
    <div style="font-size: 6rem; position: relative; z-index: 1; display: flex; gap: 10px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3));">
        
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
    
    <?php if(!empty($data_produk)): ?>
        <?php foreach($data_produk as $row): ?>
            
            <div style="background: #ffffff; border: 1px solid #8EB69B; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s, box-shadow 0.3s; box-shadow: 0 4px 10px rgba(5, 31, 32, 0.05);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 25px rgba(5, 31, 32, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(5, 31, 32, 0.05)';">

                <div style="width: 100%; height: 200px; background: #DAF1DE; display: flex; align-items: center; justify-content: center; overflow: hidden; border-bottom: 1px solid #8EB69B;">
                    <?php if(!empty($row['gambar'])): ?>
                        <img src="assets/images/produk/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['namaProduk']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <span style="font-size: 4rem; filter: grayscale(1) opacity(0.2); color: #051F20;">📦</span>
                    <?php endif; ?>
                </div>

                <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                    
                    <h3 style="color: #051F20; margin: 0 0 10px 0; font-size: 1.25rem; font-family: 'Arial', sans-serif; font-weight: bold;">
                        <?= htmlspecialchars($row['namaProduk']) ?>
                    </h3>

                    <p style="color: #235347; font-size: 0.85rem; margin: 0 0 10px 0; font-weight: bold;">
                        Kategori: <?= htmlspecialchars($row['kategori']) ?>
                    </p>
                    
                    <p style="color: #163832; font-size: 0.9rem; margin: 0 0 15px 0; line-height: 1.5; flex-grow: 1;">
                        <?= htmlspecialchars(substr($row['deskripsiProduk'] ?? '', 0, 80)) ?><?= (strlen($row['deskripsiProduk'] ?? '') > 80) ? '...' : '' ?>
                    </p>

                    <h4 style="color: #051F20; margin: 0 0 15px 0; font-size: 1.4rem;">
                        Rp <?= number_format($row['harga_eceran'], 0, ',', '.') ?>
                    </h4>
                    
                    <div style="padding-top: 15px; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.9rem; font-weight: bold; color: #475569;">Stok Tersedia:</span>
                        
                        <?php if ($row['stok'] > 0): ?>
                            <span style="background: #DAF1DE; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-weight: 900; font-size: 0.9rem; border: 1px solid #8EB69B;">
                                <?= htmlspecialchars($row['stok']) ?> Pcs
                            </span>
                        <?php else: ?>
                            <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 20px; font-weight: 900; font-size: 0.9rem; border: 1px solid #fca5a5;">
                                KOSONG
                            </span>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border: 2px dashed #8EB69B; border-radius: 10px;">
            <p style="color: #051F20; font-size: 1.2rem; font-weight: bold; margin: 0;">Belum ada produk di database.</p>
        </div>
    <?php endif; ?>

</div>