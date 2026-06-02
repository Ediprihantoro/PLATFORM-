<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lezaat Frozen Food</title>
    <style>
        body {
            /* Latar belakang cerah dengan hint Sage Green */
            background: linear-gradient(135deg, #DAF1DE 0%, #F7FAF8 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #051F20;
        }
        .register-card {
            /* Desain Card Putih Bersih */
            background: #ffffff;
            border: 1px solid #8EB69B;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 350px;
            box-shadow: 0 10px 25px rgba(5, 31, 32, 0.05);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-size: 0.95rem; 
            color: #163832; 
            font-weight: bold;
        }
        .form-control {
            width: 100%; 
            padding: 12px; 
            border-radius: 6px;
            background: #F7FAF8;
            border: 1px solid #8EB69B;
            color: #051F20; 
            box-sizing: border-box; 
            outline: none;
            transition: border 0.3s, background 0.3s;
            font-size: 1rem;
        }
        .form-control:focus { 
            border: 1px solid #163832; 
            background: #ffffff;
        }
        .btn-gold {
            width: 100%; 
            padding: 12px; 
            border-radius: 6px;
            background: #f2d472;
            border: none; 
            color: #051F20; 
            font-weight: 900; 
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer; 
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(242, 212, 114, 0.3);
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(242, 212, 114, 0.4);
        }
        .link-text { 
            text-align: center; 
            margin-top: 25px; 
            font-size: 0.9rem; 
            color: #475569; 
        }
        .link-text a { 
            color: #163832; 
            text-decoration: none; 
            font-weight: bold; 
            transition: color 0.2s;
        }
        .link-text a:hover {
            color: #051F20;
            text-decoration: underline;
        }
        .logo-text {
            text-align: center;
            color: #f2d472;
            font-size: 1.8rem;
            font-weight: 900;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .logo-sub {
            text-align: center;
            color: #163832;
            margin: 0 0 25px 0;
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h1 class="logo-text">LEZAAT</h1>
        <p class="logo-sub">Daftar Akun Baru</p>
        
        <form action="index.php?area=auth&action=proses_register" method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama kamu..." required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email aktif..." required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat password..." required>
            </div>
            <button type="submit" class="btn-gold">Daftar Sekarang</button>
        </form>

        <div class="link-text">
            Sudah punya akun? <a href="index.php?area=auth&action=login">Masuk di sini</a>
        </div>
    </div>

</body>
</html>