<div style="font-family: 'Segoe UI', sans-serif;">

    <a href="index.php?area=consumer&action=katalog" style="color: #235347; text-decoration: none; font-size: 0.95rem; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#051F20'" onmouseout="this.style.color='#235347'">
        &larr; Kembali ke Katalog
    </a>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 5px;">

        <div style="flex: 2; min-width: 300px;">
            
            <div style="width: 100%; height: 350px; background: #DAF1DE; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid #8EB69B; margin-bottom: 25px; overflow: hidden; padding: 20px; box-sizing: border-box;">
                <?php if (!empty($produk['gambar'])): ?>
                    <img src="assets/images/produk/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['namaProduk']) ?>" style="width: 100%; height: 100%; object-fit: contain;">
                <?php else: ?>
                    <span style="color: #8EB69B; font-size: 4rem; opacity: 0.5;">📦</span>
                <?php endif; ?>
            </div>

            <h1 style="color: #051F20; margin-top: 0; margin-bottom: 5px; font-size: 2.2rem;"><?= htmlspecialchars($produk['namaProduk']) ?></h1>
            <div style="font-size: 2.2rem; font-weight: 900; color: #16a34a; margin-bottom: 20px;">
                Rp <?= number_format($produk['harga_eceran'], 0, ',', '.') ?>
            </div>

            <?php 
            if(!empty($produk['variasi'])): 
                $list_variasi = explode(',', $produk['variasi']);
            ?>
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #051F20; margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid #DAF1DE; padding-bottom: 10px;">
                        Pilih variasi: <span id="teks-variasi-terpilih" style="color: #ef4444; font-weight: bold; font-size: 1rem;">(Wajib dipilih)</span>
                    </h3>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <?php foreach($list_variasi as $var): ?>
                            <?php 
                                $var = trim($var);
                                if(empty($var)) continue; 
                            ?>
                            <button type="button" class="btn-variasi" onclick="pilihVariasi(this, '<?= htmlspecialchars($var) ?>')" style="padding: 10px 18px; background: #ffffff; border: 1px solid #cbd5e1; color: #475569; border-radius: 25px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                                <?= htmlspecialchars($var) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 30px; border-bottom: 1px solid #DAF1DE; padding-bottom: 10px;">
                    <span style="color: #64748b; font-size: 0.95rem;">Varian: <strong style="color: #16a34a;">Standard / Tanpa Variasi</strong></span>
                </div>
            <?php endif; ?>

            <div style="border-bottom: 2px solid #DAF1DE; padding-bottom: 10px; margin-bottom: 15px;">
                <span style="color: #163832; font-weight: bold; font-size: 1.1rem; border-bottom: 3px solid #8EB69B; padding-bottom: 10px;">Informasi Produk</span>
            </div>

            <p style="color: #334155; line-height: 1.7; font-size: 1rem;">
                <strong style="color: #051F20;">Kategori:</strong> <span style="background: #DAF1DE; color: #163832; padding: 2px 8px; border-radius: 4px; font-size: 0.9rem; font-weight: bold;"><?= htmlspecialchars($produk['kategori']) ?></span><br><br>
                <?= nl2br(htmlspecialchars($produk['deskripsiProduk'])) ?>

                <br><br>
                <strong style="color: #051F20;">Detail Rasa & Tekstur:</strong><br>
                <?php if ($produk['namaProduk'] == 'Bakso Sapi Urat 500g'): ?>
                    Terbuat dari olahan daging sapi segar pilihan dengan ekstra urat yang bikin teksturnya makin kenyal, garing, 
                    dan <i>meaty</i> banget di mulut. Cita rasa daging sapinya kuat, super mantap buat dibikin kuah kaldu hangat, pelengkap mi ayam, atau dibakar pakai bumbu kecap pedas!

                <?php elseif ($produk['namaProduk'] == 'Nugget Ayam Crispy 500g'): ?>
                    Potongan daging ayam asli yang <i>juicy</i> dan padat di dalam, berpadu dengan balutan tepung roti ekstra renyah di luar.
                     Rasanya gurih pas, nggak gampang lembek walaupun sudah agak dingin. Pilihan sempurna buat lauk cepat saji atau camilan sore hari!

                <?php elseif ($produk['namaProduk'] == 'Sosis Sapi Bratwurst 300g'): ?>
                    Sosis ala Jerman dengan ukuran jumbo dan tekstur daging sapi yang super padat. Nggak perlu ribet dibumbuin lagi, 
                    percayalah karena rasanya udah gurih maksimal dengan sensasi rempah dan aroma <i>smokey</i> yang khas. Paling enak dipanggang, di-<i>grill</i> untuk BBQ, atau jadi isian hotdog.

                <?php elseif ($produk['namaProduk'] == 'Siomay Ayam Udang Isi 20'): ?>
                    Perpaduan sempurna antara daging ayam cincang gurih dan potongan udang manis yang kerasa banget teksturnya. 
                    Dibungkus dengan kulit pangsit yang lembut tipis, isiannya padat dan kenyal. Dikukus anget-anget plus cocolan saus dimsum atau saus kacang, dijamin langsung lumer di mulut!

                <?php elseif ($produk['namaProduk'] == 'Kentang Goreng Shoestring 1kg'): ?>
                    Potongan kentang memanjang dan tipis yang garing maksimal setelah digoreng. Bagian luarnya super <i>crunchy</i>, 
                    tapi dalamnya tetap lembut. Cukup tabur sedikit garam atau cocol saus sambal, rasanya dijamin persis kayak kentang goreng di kafe-kafe hits!

                <?php endif; ?>
            </p>
        </div>

        <div style="flex: 1; min-width: 300px; position: sticky; top: 20px; align-self: flex-start;">
            <div style="background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05);">
                <h3 style="margin-top: 0; color: #051F20; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px; margin-bottom: 20px;">Atur Jumlah</h3>

                <?php if ($produk['stok'] > 0): ?>
                    <form action="index.php?area=consumer&action=tambah_keranjang" method="POST" id="form-keranjang">
                        <input type="hidden" name="idProduk" value="<?= $produk['idProduk'] ?>">
                        
                        <input type="hidden" name="variasi" id="input-variasi-tersembunyi" value="<?= !empty($produk['variasi']) ? '' : 'Standard' ?>">
                        
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
            
            <div style="margin-top: 20px; background: #ffffff; padding: 25px; border-radius: 12px; border: 1px solid #8EB69B; box-shadow: 0 4px 15px rgba(5, 31, 32, 0.05); font-family: 'Segoe UI', Arial, sans-serif;">
                <h3 style="margin-top: 0; color: #051F20; margin-bottom: 15px; font-size: 1.2rem;">Keunggulan Layanan Kami</h3>
                <div style="border-bottom: 1px dashed #cbd5e1; margin-bottom: 25px;"></div>

                <div style="display: flex; gap: 18px; margin-bottom: 22px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3b82f6" width="26" height="26">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 6px 0; color: #051F20; font-size: 1rem;">Aman & Terpercaya</h4>
                        <p style="margin: 0; color: #475569; font-size: 0.9rem; line-height: 1.5;">Kami berkomitmen memastikan paket Anda sampai dengan aman.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 18px; margin-bottom: 22px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#22c55e" width="28" height="28">
                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm13.5-8.5l1.96 2.5H17V9.5h2.5zM18 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 6px 0; color: #051F20; font-size: 1rem;">Pengiriman Cepat & Tepat Waktu</h4>
                        <p style="margin: 0; color: #475569; font-size: 0.9rem; line-height: 1.5;">Nikmati pilihan pengiriman untuk kebutuhan anda</p>
                    </div>
                </div>

                <div style="display: flex; gap: 18px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #fce7f3; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ec4899" width="28" height="28">
                            <path d="M12 15.36l-3.76 2.27 1-4.28-3.32-2.88 4.38-.37L12 6.1l1.71 4.04 4.38.37-3.32 2.88 1 4.28M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 6px 0; color: #051F20; font-size: 1rem;">Kualitas Terjamin</h4>
                        <p style="margin: 0; color: #475569; font-size: 0.9rem; line-height: 1.5;">Produk kami dibuat dari bahan pilihan, higienis, and halal.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function pilihVariasi(elemenTombol, namaVariasi) {
        let semuaTombol = document.querySelectorAll('.btn-variasi');
        semuaTombol.forEach(function(tombol) {
            tombol.style.borderColor = '#cbd5e1';
            tombol.style.color = '#475569';
            tombol.style.background = '#ffffff';
        });

        elemenTombol.style.borderColor = '#d4af37';
        elemenTombol.style.color = '#051F20';
        elemenTombol.style.background = '#f2d472';

        document.getElementById('teks-variasi-terpilih').innerText = '(' + namaVariasi + ')';
        document.getElementById('teks-variasi-terpilih').style.color = '#b48600';
        document.getElementById('teks-variasi-terpilih').style.fontWeight = 'bold';

        document.getElementById('input-variasi-tersembunyi').value = namaVariasi;
    }

    function validasiVariasi() {
        // PERBAIKAN VALIDASI: Cek jika produk memiliki variasi, user wajib memilih salah satu sebelum submit
        let inputVariasi = document.getElementById('input-variasi-tersembunyi').value;
        if (inputVariasi === '') {
            alert('Silakan pilih variasi produk terlebih dahulu!');
            return false;
        }
        return true;
    }
</script>