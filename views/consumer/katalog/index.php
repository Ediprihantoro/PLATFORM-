<h2 style="color: #051F20; border-bottom: 2px solid #8EB69B; padding-bottom: 10px;">Katalog Produk</h2>

<div style="background: linear-gradient(135deg, #0B2B26 0%, #051F20 100%); border-radius: 15px; padding: 40px 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; margin-top: 20px; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.2); overflow: hidden; border: 1px solid #163832;">
    
    <div style="position: relative; z-index: 1;">
        <h1 style="margin: 0 0 10px 0; font-family: 'Arial', sans-serif; font-size: 2.8rem; font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">
            <span style="color: #f2d472;">FROZEN</span> <span style="color: #DAF1DE;">FOOD RANGE</span>
        </h1>
        <p style="color: #8EB69B; margin: 0 0 20px 0; font-size: 1.1rem; line-height: 1.6; max-width: 550px;">
            <strong style="color: #DAF1DE; letter-spacing: 2px;">TASTY • CONVENIENT • ALWAYS FRESH</strong><br><br>
            Temukan berbagai pilihan menu praktis premium untuk kehangatan keluarga. Tinggal goreng atau kukus, siap saji dalam hitungan menit!
        </p>
        
        <div style="display: flex; gap: 20px; margin-bottom: 25px;">
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">❄️</span> Freshly Frozen</span>
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">⏱️</span> Ready in Minutes</span>
            <span style="color: #DAF1DE; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 5px;"><span style="font-size: 1.2rem;">✅</span> 100% Halal</span>
        </div>
        
        <a href="#area-produk" style="display: inline-block; padding: 12px 30px; background: #f2d472; color: #051F20; text-decoration: none; border-radius: 5px; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            Order Online 🛒
        </a>
    </div>
    
    <div style="font-size: 6rem; position: relative; z-index: 1; display: flex; gap: 10px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.3));">
        🍟 🍗
    </div>
</div>

<div id="area-produk"></div>

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

                    <h4 style="color: #051F20; margin: 0 0 5px 0; font-size: 1.4rem;">
                        Rp <?= number_format($row['harga_eceran'], 0, ',', '.') ?>
                    </h4>
                    
                    <?php if ($row['stok'] > 0): ?>
                        
                        <p style="font-size: 0.85rem; margin: 0 0 15px 0; font-weight: bold; color: #163832;">
                            Sisa stok: <?= htmlspecialchars($row['stok']) ?>
                        </p>
                        
                        <?php 
                        // Cek apakah user sudah login DAN bertipe 'customer'
                        $is_customer = (isset($_SESSION['tipe_akun']) && strtolower($_SESSION['tipe_akun']) == 'customer'); 
                        ?>
                        
                        <?php if($is_customer): ?>
                            
                            <!-- CUSTOMER: Tombol normal, lanjut ke halaman Detail Produk -->
                            <a href="index.php?area=consumer&action=detail_produk&id=<?= $row['idProduk'] ?>" style="display: block; text-align: center; background: #f2d472; color: #051F20; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; transition: background 0.2s; box-sizing: border-box;" onmouseover="this.style.background='#e3c153'" onmouseout="this.style.background='#f2d472'">
                                Beli Sekarang
                            </a>
                            
                        <?php else: ?>
                            
                            <!-- NON-CUSTOMER (Guest/Admin): Panggil fungsi customAlertRedirect -->
                            <a href="index.php?area=auth&action=login" onclick="customAlertRedirect(event, this.href)" style="display: block; text-align: center; background: #f2d472; color: #051F20; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; transition: background 0.2s; box-sizing: border-box;" onmouseover="this.style.background='#e3c153'" onmouseout="this.style.background='#f2d472'">
                                Beli Sekarang
                            </a>
                            
                        <?php endif; ?>
                        
                    <?php else: ?>
                        
                        <p style="font-size: 0.85rem; margin: 0 0 15px 0; font-weight: bold; color: #ff6b6b;">
                            Stok sedang kosong
                        </p>
                        
                        <div style="text-align: center; background: rgba(255, 107, 107, 0.1); color: #ff6b6b; padding: 12px; border-radius: 6px; font-weight: bold; border: 1px solid rgba(255, 107, 107, 0.3); text-transform: uppercase; box-sizing: border-box;">
                            Stok Habis
                        </div>
                        
                    <?php endif; ?>
                    
                </div>
            </div>
            
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border: 2px dashed #8EB69B; border-radius: 10px;">
            <p style="color: #051F20; font-size: 1.2rem; font-weight: bold; margin: 0;">Belum ada produk di database.</p>
        </div>
    <?php endif; ?>

</div>

<script>
    function customAlertRedirect(event, url) {
        // Tahan klik agar tidak langsung pindah halaman seketika
        event.preventDefault(); 
        
        // Cegah alert menumpuk jika user menekan tombol Beli berkali-kali
        if (document.getElementById('custom-toast-alert')) return;
        
        // Buat elemen notifikasi (Toast) yang elegan
        let alertBox = document.createElement('div');
        alertBox.id = 'custom-toast-alert';
        alertBox.style.position = 'fixed';
        alertBox.style.top = '30px';
        alertBox.style.left = '50%';
        alertBox.style.transform = 'translateX(-50%)';
        alertBox.style.background = '#051F20';
        alertBox.style.color = '#DAF1DE';
        alertBox.style.padding = '20px 25px';
        alertBox.style.borderRadius = '8px';
        alertBox.style.boxShadow = '0 10px 25px rgba(5, 31, 32, 0.5)';
        alertBox.style.zIndex = '9999';
        alertBox.style.fontFamily = "'Segoe UI', sans-serif";
        alertBox.style.transition = 'opacity 0.2s ease-in-out';
        alertBox.style.opacity = '0'; // Mulai dari transparan untuk efek fade-in
        alertBox.style.textAlign = 'center';
        alertBox.style.minWidth = '280px';
        
        // Isi struktur teks dan tombol OK emas
        alertBox.innerHTML = `
            <div style="margin-bottom: 18px; font-size: 0.95rem; line-height: 1.5;">
                ⚠️ <strong>Akses Terbatas</strong><br>Silakan login sebagai pembeli terlebih dahulu.
            </div>
            <button id="btn-toast-ok" style="background: #f2d472; color: #051F20; border: none; padding: 10px 20px; border-radius: 5px; font-weight: 900; cursor: pointer; width: 100%; text-transform: uppercase; letter-spacing: 1px; transition: background 0.2s;">
                OK, Mengerti
            </button>
        `;
        
        // Munculkan di layar
        document.body.appendChild(alertBox);
        
        // Beri sedikit jeda agar animasi fade-in berjalan mulus
        setTimeout(() => { alertBox.style.opacity = '1'; }, 10);
        
        // Efek hover untuk tombol OK
        let btnOk = document.getElementById('btn-toast-ok');
        btnOk.onmouseover = function() { this.style.background = '#e3c153'; };
        btnOk.onmouseout = function() { this.style.background = '#f2d472'; };
        
        // Logika saat tombol OK ditekan: Fade-out lalu pindah ke halaman Login
        btnOk.onclick = function() {
            alertBox.style.opacity = '0';
            setTimeout(() => {
                window.location.href = url;
            }, 200);
        };
    }
</script>