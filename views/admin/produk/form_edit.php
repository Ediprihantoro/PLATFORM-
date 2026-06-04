<div style="font-family: 'Segoe UI', sans-serif; max-width: 700px; margin: 0 auto; padding-top: 10px;">
    
    <h2 style="color: #051F20; border-bottom: 2px solid #8EB69B; padding-bottom: 10px; text-align: center;">
        Edit Produk
    </h2>

    <div style="background: #ffffff; padding: 40px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05); margin-top: 20px;">
        
        <form action="index.php?area=admin&action=update_produk" method="POST">
            
            <input type="hidden" name="idProduk" value="<?= $produk['idProduk'] ?>">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #163832; font-weight: bold;">Nama Produk</label>
                <input type="text" name="namaProduk" value="<?= htmlspecialchars($produk['namaProduk']) ?>" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #8EB69B; background: #F7FAF8; color: #051F20; box-sizing: border-box; font-size: 1rem;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #163832; font-weight: bold;">Kategori</label>
                <input type="text" name="kategori" value="<?= htmlspecialchars($produk['kategori']) ?>" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #8EB69B; background: #F7FAF8; color: #051F20; box-sizing: border-box; font-size: 1rem;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #163832; font-weight: bold;">Harga Eceran (Rp)</label>
                <input type="number" name="harga_eceran" value="<?= $produk['harga_eceran'] ?>" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #8EB69B; background: #F7FAF8; color: #051F20; box-sizing: border-box; font-size: 1rem;">
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #163832; font-weight: bold;">Deskripsi</label>
                <textarea name="deskripsiProduk" rows="4" style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #8EB69B; background: #F7FAF8; color: #051F20; box-sizing: border-box; font-size: 1rem; resize: vertical;"><?= htmlspecialchars($produk['deskripsiProduk']) ?></textarea>
            </div>
            
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; color: #163832; font-weight: bold;">Stok Barang</label>
                <input type="number" name="stok" value="<?= htmlspecialchars($produk['stok']) ?>" min="0" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #8EB69B; background: #F7FAF8; color: #051F20; box-sizing: border-box; font-size: 1rem;">
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #f2d472; color: #051F20; border: none; border-radius: 6px; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(242, 212, 114, 0.3)';">
                Simpan Perubahan
            </button>
            
        </form>
    </div>
</div>