<div style="font-family: 'Segoe UI', sans-serif;">
    
    <a href="index.php?area=consumer&action=keranjang" style="color: #235347; text-decoration: none; font-size: 0.95rem; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#051F20'" onmouseout="this.style.color='#235347'">
        &larr; Kembali ke Keranjang
    </a>

    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #DAF1DE; padding-bottom: 15px;">
        <span style="font-size: 2.5rem;">📦</span>
        <h1 style="color: #051F20; margin: 0; font-size: 2.2rem; font-weight: 900; letter-spacing: 1px;">Checkout Pesanan</h1>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; align-items: flex-start;">
        
        <div style="flex: 2; min-width: 300px; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05);">
            <h3 style="color: #051F20; margin-top: 0; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; margin-bottom: 25px; font-size: 1.3rem;">Informasi Pengiriman</h3>

            <form action="index.php?area=consumer&action=proses_checkout" method="POST" id="form-checkout">
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Nama Penerima <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nama_penerima" value="<?= htmlspecialchars($_SESSION['nama'] ?? '') ?>" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#cbd5e1'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Nomor WhatsApp / HP <span style="color: #ef4444;">*</span></label>
                    <input type="tel" name="no_hp" placeholder="Contoh: 081234567890" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#cbd5e1'">
                </div>

                <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Metode Pengiriman <span style="color: #ef4444;">*</span></label>
                        <select id="pilih-kurir" name="metode_pengiriman" onchange="aturPengiriman()" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; cursor: pointer;">
                            <option value="" disabled selected>-- Pilih Pengiriman --</option>
                            <option value="Kurir Toko">Diantar Kurir Toko (+ Rp 10.000)</option>
                            <option value="Ambil Sendiri">Ambil Sendiri di Toko (Gratis)</option>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Metode Pembayaran <span style="color: #ef4444;">*</span></label>
                        <select name="metode_pembayaran" required style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; cursor: pointer;">
                            <option value="" disabled selected>-- Pilih Pembayaran --</option>
                            <option value="Transfer Bank">Transfer Bank (BCA/Mandiri)</option>
                            <option id="opsi-tunaivalue="COD">Bayar di Tempat (COD)</option>
                        </select>
                    </div>
                </div>

                <div id="wadah-alamat" style="margin-bottom: 20px; display: none;">
                    <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Alamat Lengkap Pengiriman <span style="color: #ef4444;">*</span></label>
                    <textarea id="input-alamat" name="alamat_lengkap" rows="4" placeholder="Nama Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Patokan Rumah..." style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#cbd5e1'"></textarea>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: block; color: #163832; font-weight: bold; margin-bottom: 8px;">Catatan Tambahan (Opsional)</label>
                    <input type="text" name="catatan" placeholder="Contoh: Tolong packing rapi, kirim jam 3 sore." style="width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#cbd5e1'">
                </div>

            </form>
        </div>
     <!-- Ringkasan pesanan -->
        <div style="flex: 1; min-width: 320px; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05); position: sticky; top: 90px;">
            <h3 style="color: #051F20; margin-top: 0; border-bottom: 2px dashed #DAF1DE; padding-bottom: 15px; margin-bottom: 20px; font-size: 1.3rem;">Ringkasan Pesanan</h3>
            
            <div style="max-height: 300px; overflow-y: auto; padding-right: 10px; margin-bottom: 20px;">
                <?php if(!empty($data_keranjang)): ?>
                    <?php foreach($data_keranjang as $item): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding: 12px 0;">
                            <div>
                                <div style="color: #051F20; font-weight: bold; font-size: 1rem;">
                                    <?= htmlspecialchars($item['namaProduk']) ?>
                                </div>
                                <div style="color: #64748b; font-size: 0.85rem; margin-top: 4px;">
                                    <?= $item['jumlah'] ?>x @ Rp <?= number_format($item['harga_eceran'], 0, ',', '.') ?>
                                </div>
                                <?php if(isset($item['variasi']) && $item['variasi'] != '' && $item['variasi'] != 'Standard'): ?>
                                    <div style="font-size: 0.8rem; color: #b48600; margin-top: 2px; font-weight: bold;">
                                        [<?= htmlspecialchars($item['variasi']) ?>]
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div style="color: #051F20; font-weight: 900;">
                                Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #ef4444; font-weight: bold; text-align: center;">Keranjang kosong!</p>
                <?php endif; ?>
            </div>

            <div style="background: #F7FAF8; padding: 15px; border-radius: 8px; border: 1px solid #DAF1DE; margin-bottom: 25px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #475569;">
                    <span>Total Harga Produk</span>
                    <span style="font-weight: bold;">Rp <?= number_format($total_belanja ?? 0, 0, ',', '.') ?></span>
                </div>
                
                <div id="baris-ongkir" style="display: none; justify-content: space-between; margin-bottom: 10px; color: #475569;">
                    <span>Ongkos Kirim (Kurir Toko)</span>
                    <span style="font-weight: bold;">Rp 10.000</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px dashed #cbd5e1; color: #051F20;">
                    <span style="font-weight: bold; font-size: 1.1rem;">Total Tagihan</span>
                    <span id="total-tagihan-tampil" style="font-weight: 900; font-size: 1.4rem; color: #16a34a;">
                        Rp <?= number_format($total_belanja ?? 0, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <button form="form-checkout" type="submit" style="width: 100%; padding: 15px; background: #f2d472; color: #051F20; font-weight: 900; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; border: none; border-radius: 6px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(242, 212, 114, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(242, 212, 114, 0.3)';">
                Bayar Sekarang ➔
            </button>
            <p style="text-align: center; color: #64748b; font-size: 0.85rem; margin-top: 15px;">
                Pastikan data pengiriman sudah benar sebelum menekan tombol.
            </p>
        </div>
    </div>
</div>

<script>
    // Ambil nilai total asli dari PHP
    const baseTotal = <?= $total_belanja ?? 0 ?>;

    // Fungsi format angka ke Rupiah dengan titik
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka).replace(/,/g, '.');
    }

    // Fungsi yang dipanggil setiap kali dropdown Metode Pengiriman berubah
    function aturPengiriman() {
        let kurir = document.getElementById('pilih-kurir').value;
        let wadahAlamat = document.getElementById('wadah-alamat');
        let inputAlamat = document.getElementById('input-alamat');
        let barisOngkir = document.getElementById('baris-ongkir');
        let totalTampil = document.getElementById('total-tagihan-tampil');
        let opsiTunai = document.getElementById('opsi-tunai'); // Tangkap elemen opsi COD

        if (kurir === 'Ambil Sendiri') {
            // Sembunyikan form alamat & matikan status wajib isinya
            wadahAlamat.style.display = 'none';
            inputAlamat.removeAttribute('required');
            inputAlamat.value = ''; 
            
            // Sembunyikan baris ongkir, kembalikan tagihan ke harga awal
            barisOngkir.style.display = 'none';
            totalTampil.innerText = 'Rp ' + formatRupiah(baseTotal);

            // UBAH TEKS MENJADI BAYAR DI TOKO
            opsiTunai.innerText = 'Bayar Langsung di Toko';
            
        } else if (kurir === 'Kurir Toko') {
            // Tampilkan form alamat dan wajibkan isi
            wadahAlamat.style.display = 'block';
            inputAlamat.setAttribute('required', 'required');
            
            // Tampilkan baris ongkir, tambahkan 10rb ke total layar
            barisOngkir.style.display = 'flex';
            let totalBaru = baseTotal + 10000;
            totalTampil.innerText = 'Rp ' + formatRupiah(totalBaru);

            // KEMBALIKAN TEKS MENJADI COD
            opsiTunai.innerText = 'Bayar di Tempat (COD)';
        }
    }
</script>