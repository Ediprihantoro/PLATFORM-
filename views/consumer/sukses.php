<div style="background: rgba(11, 69, 48, 0.3); backdrop-filter: blur(10px); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 50px; text-align: center; max-width: 600px; margin: 40px auto; color: #fff; font-family: 'Segoe UI', sans-serif;">
    
    <div style="font-size: 4rem; margin-bottom: 20px;">🎉</div>
    <h2 style="color: #f2d472; margin-top: 0;">Checkout Berhasil!</h2>
    <p style="color: #aaa; font-size: 1.1rem; line-height: 1.6;">
        Terima kasih, <b><?= htmlspecialchars($_SESSION['nama']) ?></b>. <br>
        Pesananmu telah masuk ke dapur Lezaat Frozen Food dan sedang menunggu proses.
    </p>
    
    <div style="margin: 30px 0; padding: 20px; background: rgba(0,0,0,0.3); border-radius: 8px; border: 1px dashed #4facfe;">
        <span style="color: #888;">Nomor Tagihan:</span><br>
        <b style="font-size: 1.5rem; color: #14694a;">#LZT-<?= str_pad($idPesananBaru, 4, '0', STR_PAD_LEFT) ?></b>
    </div>

    <a href="index.php?area=consumer&action=katalog" style="display: inline-block; background: linear-gradient(90deg, #4facfe, #f2d472); color: #041a12; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; transition: 0.3s;">
        Kembali ke Katalog
    </a>

</div>
</div> </body>
</html>