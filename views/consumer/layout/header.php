<?php
$total_item_keranjang = 0;
if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        if (is_array($item) && isset($item['jumlah'])) {
            $total_item_keranjang += $item['jumlah'];
        } 
        elseif (is_numeric($item)) {
            $total_item_keranjang += $item;
        } else {
            $total_item_keranjang++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lezaat Frozen Food </title>
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #F7FAF8; 
            color: #051F20; 
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
    </style>
</head>
<body>

    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 40px; background: #051F20; border-bottom: 4px solid #8EB69B; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000;">
        
        <h2 style="margin: 0; color: #DAF1DE; font-family: 'Limelight', sans-serif; font-weight: 900; font-size: 1.8rem; letter-spacing: 0.5px;">
            Lezaat <span style="color: #f2d472;">Frozen Food</span>
        </h2>
        
        <div style="font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; gap: 20px;">
            <a href="index.php?area=consumer&action=home" style="color: #DAF1DE; text-decoration: none; font-weight: bold; transition: color 0.2s;" onmouseover="this.style.color='#f2d472'" onmouseout="this.style.color='#DAF1DE'">Home</a>
            
            <span style="color: #163832;">|</span> 

            <?php 
            if(isset($_SESSION['user_id']) && isset($_SESSION['tipe_akun']) && strtolower($_SESSION['tipe_akun']) === 'customer'): 
            ?>
                
                <span style="color: #8EB69B; font-size: 0.95rem;">Halo, <b style="color: #DAF1DE;"><?= htmlspecialchars($_SESSION['nama'] ?? 'Customer') ?></b></span>
                
                <a href="index.php?area=consumer&action=pesanan_saya" style="color: #8EB69B; text-decoration: none; font-weight: bold; margin-left: 10px; transition: 0.2s;" onmouseover="this.style.color='#f2d472'" onmouseout="this.style.color='#8EB69B'">
                    📦 Pesanan
                </a>

                <a href="index.php?area=consumer&action=keranjang" style="color: #ffffff; text-decoration: none; font-weight: 900; margin-left: 10px; background: #044c1f; padding: 8px 18px; border-radius: 25px; transition: transform 0.2s, background 0.2s, box-shadow 0.2s; display: flex; align-items: center; gap: 5px; box-shadow: 0 4px 10px rgba(4, 76, 31, 0.3);" onmouseover="this.style.background='#0c5527'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(4, 76, 31, 0.4)';" onmouseout="this.style.background='#044c1f'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(4, 76, 31, 0.3)';">
                    🛒 (<?= $total_item_keranjang ?>)
                </a>
                
                <a href="index.php?area=auth&action=logout" style="color: #ff6b6b; text-decoration: none; font-weight: bold; padding: 7px 18px; border: 1px solid #ff6b6b; background: transparent; border-radius: 6px; transition: 0.2s; margin-left: 10px;" onmouseover="this.style.background='rgba(255, 107, 107, 0.1)'" onmouseout="this.style.background='transparent'">
                    Logout
                </a>
            
            <?php else: ?>
                
                <a href="index.php?area=auth&action=login" style="color: #DAF1DE; text-decoration: none; font-weight: bold; padding: 8px 18px; border: 1px solid #8EB69B; background: transparent; border-radius: 6px; transition: 0.2s;" onmouseover="this.style.background='rgba(142, 182, 155, 0.2)'" onmouseout="this.style.background='transparent'">
                    Masuk
                </a>
                
                <a href="index.php?area=auth&action=register" style="background: #f2d472; color: #051F20; padding: 8px 22px; border-radius: 6px; text-decoration: none; font-weight: 900; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    Daftar Akun
                </a>
            
            <?php endif; ?>
        </div>
    </div>
    
    <div style="padding: 30px 40px;">