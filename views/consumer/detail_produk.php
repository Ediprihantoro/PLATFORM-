<div style="font-family: 'Segoe UI', sans-serif;">
    
    <a href="index.php?area=consumer&action=katalog" style="color: #235347; text-decoration: none; font-size: 0.95rem; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#051F20'" onmouseout="this.style.color='#235347'">
        &larr; Kembali ke Katalog
    </a>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 5px;">
        
        <div style="flex: 2; min-width: 300px;">
            <div style="width: 100%; height: 350px; background: #DAF1DE; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid #8EB69B; margin-bottom: 25px; overflow: hidden;">
                <?php if(!empty($produk['gambar'])): ?>
                    <img src="assets/images/produk/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['namaProduk']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <span style="color: #8EB69B; font-size: 4rem; opacity: 0.5;">📦</span>
                <?php endif; ?>
            </div>

            <h1 style="color: #051F20; margin-top: 0; margin-bottom: 5px; font-size: 2.2rem;"><?= htmlspecialchars($produk['namaProduk']) ?></h1>
            <div style="font-size: 2.2rem; font-weight: 900; color: #16a34a; margin-bottom: 20px;">
                Rp <?= number_format($produk['harga_eceran'], 0, ',', '.') ?>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="color: #051F20; margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid #DAF1DE; padding-bottom: 10px;">
                    Pilih variasi: <span id="teks-variasi-terpilih" style="color: #64748b; font-weight: normal; font-size: 1rem;">(Belum dipilih)</span>
                </h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <button type="button" class="btn-variasi" onclick="pilihVariasi(this, 'Original 500g')" style="padding: 10px 18px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; border-radius: 25px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                        (Original 500g)
                    </button>
                    
                    <button type="button" class="btn-variasi" onclick="pilihVariasi(this, 'Pedas 500g')" style="padding: 10px 18px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; border-radius: 25px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                        (Pedas 500g)
                    </button>
                    
                    <button type="button" class="btn-variasi" onclick="pilihVariasi(this, 'Ekstra Keju 500g')" style="padding: 10px 18px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; border-radius: 25px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                        (Ekstra Keju 500g)
                    </button>
                </div>
            </div>

            <div style="border-bottom: 2px solid #DAF1DE; padding-bottom: 10px; margin-bottom: 15px;">
                <span style="color: #163832; font-weight: bold; font-size: 1.1rem; border-bottom: 3px solid #8EB69B; padding-bottom: 10px;">Informasi Produk</span>
            </div>
            
            <p style="color: #334155; line-height: 1.7; font-size: 1rem;">
                <strong style="color: #051F20;">Kategori:</strong> <span style="background: #DAF1DE; color: #163832; padding: 2px 8px; border-radius: 4px; font-size: 0.9rem; font-weight: bold;"><?= htmlspecialchars($produk['kategori']) ?></span><br><br>
                <?= nl2br(htmlspecialchars($produk['deskripsiProduk'])) ?>
            </p>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05); position: sticky; top: 20px;">
                <h3 style="margin-top: 0; color: #051F20; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px; margin-bottom: 20px;">Atur Jumlah</h3>
                
                <?php if ($produk['stok'] > 0): ?>
                    <form action="index.php?area=consumer&action=tambah_keranjang" method="POST" id="form-keranjang">
                        <input type="hidden" name="idProduk" value="<?= $produk['idProduk'] ?>">
                        <input type="hidden" name="variasi" id="input-variasi-tersembunyi" value="">
                        
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                            <input type="number" name="jumlah" min="1" max="<?= $produk['stok'] ?>" value="1" required style="width: 80px; padding: 10px; background: #F7FAF8; border: 1px solid #8EB69B; color: #051F20; border-radius: 6px; text-align: center; font-weight: bold; font-size: 1.1rem; outline: none;">
                            
                            <span style="color: #64748b; font-size: 0.95rem;">
                                Sisa stok: <strong style="color: #16a34a; font-size: 1.1rem;"><?= $produk['stok'] ?></strong>
                            </span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0;">
                            <span style="color: #475569; font-weight: bold;">Subtotal</span>
                            <span style="font-weight: 900; color: #051F20; font-size: 1.2rem;">Rp <?= number_format($produk['harga_eceran'], 0, ',', '.') ?></span>
                        </div>

                        <button type="submit" onclick="return validasiVariasi()" style="width: 100%; padding: 14px; background: #f2d472; color: #051F20; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; border: none; border-radius: 6px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(242, 212, 114, 0.3)';">
                            Tambahkan Keranjang
                        </button>
                    </form>
                <?php else: ?>
                    <div style="padding: 15px; background: #fef2f2; border: 1px dashed #ef4444; color: #b91c1c; text-align: center; border-radius: 6px; margin-bottom: 20px; font-weight: bold;">
                        Maaf, stok produk ini sedang kosong.
                    </div>
                    <button disabled style="width: 100%; padding: 14px; background: #e2e8f0; color: #94a3b8; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; border: none; border-radius: 6px; cursor: not-allowed;">
                        Stok Habis
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function pilihVariasi(elemenTombol, namaVariasi) {
        // 1. Reset semua tombol ke abu-abu (default theme cerah)
        let semuaTombol = document.querySelectorAll('.btn-variasi');
        semuaTombol.forEach(function(tombol) {
            tombol.style.borderColor = '#cbd5e1';
            tombol.style.color = '#475569';
            tombol.style.background = '#ffffff';
        });

        // 2. Ubah warna tombol yang diklik menjadi Aktif (Warna Emas Premium)
        elemenTombol.style.borderColor = '#d4af37';
        elemenTombol.style.color = '#051F20';
        elemenTombol.style.background = '#f2d472';

        // 3. Ubah teks keterangan pilihan variasi (Warna Emas Gelap)
        document.getElementById('teks-variasi-terpilih').innerText = '(' + namaVariasi + ')';
        document.getElementById('teks-variasi-terpilih').style.color = '#b48600';
        document.getElementById('teks-variasi-terpilih').style.fontWeight = 'bold';

        // 4. Masukkan nama variasi ke dalam form tersembunyi
        document.getElementById('input-variasi-tersembunyi').value = namaVariasi;
    }

    function validasiVariasi() {
        let variasiTerpilih = document.getElementById('input-variasi-tersembunyi').value;
        if (variasiTerpilih === "") {
            alert("Silakan pilih variasi produk terlebih dahulu sebelum memasukkan ke keranjang!");
            return false;
        }
        return true; 
    }
</script>