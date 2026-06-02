<div style="font-family: 'Segoe UI', sans-serif;">
    <h2 style="color: #051F20; border-bottom: 2px solid #8EB69B; padding-bottom: 10px; margin-top: 0;">Daftar Produk</h2>

    <div style="background: #ffffff; padding: 0; border-radius: 12px; border: 1px solid #8EB69B; margin-top: 20px; overflow-x: auto; box-shadow: 0 5px 15px rgba(5, 31, 32, 0.05);">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: #051F20;">
            <thead>
                <tr style="background: #163832; color: #DAF1DE;">
                    <th style="padding: 18px 15px;">ID</th>
                    <th style="padding: 18px 15px;">Nama Produk</th>
                    <th style="padding: 18px 15px;">Kategori</th>
                    <th style="padding: 18px 15px;">Harga Eceran</th>
                    <th style="padding: 18px 15px; text-align: center;">Stok</th>
                    <th style="padding: 18px 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_produk)): ?>
                    <?php foreach($data_produk as $row): ?>
                        
                        <?php $is_inactive = (isset($row['is_active']) && $row['is_active'] == 0); ?>
                        
                        <tr style="border-bottom: 1px solid #DAF1DE; transition: background 0.2s; <?= $is_inactive ? 'background: #f8fafc;' : '' ?>" onmouseover="this.style.background='#F7FAF8'" onmouseout="this.style.background='<?= $is_inactive ? '#f8fafc' : 'transparent' ?>'">
                            
                            <td style="padding: 15px; color: #235347; font-weight: bold;"><?= $row['idProduk'] ?></td>
                            
                            <td style="padding: 15px; font-weight: bold; color: <?= $is_inactive ? '#94a3b8' : '#051F20' ?>; <?= $is_inactive ? 'text-decoration: line-through;' : '' ?>">
                                <?= htmlspecialchars($row['namaProduk']) ?>
                            </td>
                            
                            <td style="padding: 15px; color: #475569;"><?= htmlspecialchars($row['kategori']) ?></td>
                            
                            <td style="padding: 15px; font-weight: 500;">Rp <?= number_format($row['harga_eceran'], 0, ',', '.') ?></td>
                            
                            <td style="padding: 15px; text-align: center; font-weight: 900; font-size: 1.1rem; color: #051F20;">
                                <?= htmlspecialchars($row['stok']) ?>
                            </td>
                            
                            <td style="padding: 15px; text-align: center;">
                                
                                <a href="index.php?area=admin&action=edit_produk&id=<?= $row['idProduk'] ?>" style="background: #f2d472; color: #051F20; border: none; padding: 6px 15px; border-radius: 5px; font-weight: bold; text-decoration: none; margin-right: 5px; display: inline-block; box-shadow: 0 2px 4px rgba(242, 212, 114, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Edit</a>
                                
                                <?php if ($is_inactive): ?>
                                    
                                    <a href="index.php?area=admin&action=restore_produk&id=<?= $row['idProduk'] ?>" style="background: #163832; color: #DAF1DE; text-decoration: none; padding: 6px 15px; border-radius: 5px; font-weight: bold; display: inline-block; box-shadow: 0 2px 4px rgba(22, 56, 50, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Aktifkan</a>
                                    <div style="color: #991b1b; font-size: 0.8rem; margin-top: 8px; font-weight: bold;">(Disembunyikan)</div>
                                    
                                <?php else: ?>
                                    
                                    <a href="index.php?area=admin&action=hapus_produk&id=<?= $row['idProduk'] ?>" onclick="return confirm('Yakin ingin menyembunyikan <?= htmlspecialchars($row['namaProduk']) ?> dari katalog?');" style="background: #991b1b; color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 5px; font-weight: bold; display: inline-block; box-shadow: 0 2px 4px rgba(153, 27, 27, 0.2); transition: 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Hapus</a>
                                    
                                <?php endif; ?>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center;">
                            <div style="font-size: 3rem; color: #8EB69B; margin-bottom: 15px;">📦</div>
                            <h3 style="color: #235347; margin: 0 0 5px 0;">Belum ada produk</h3>
                            <p style="color: #64748b; margin: 0;">Silakan tambahkan produk baru untuk mulai berjualan.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>