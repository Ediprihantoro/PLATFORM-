<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lezaat Frozen Food</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0B2B26; /* Latar kanan hijau gelap ala FEB Mart */
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* GAMBAR LOGIN */
        .left-side {
            flex: 1.2;
            background: url('assets/images/latarLogin.jpg') no-repeat left center;
            background-size: cover;
            border-radius: 0 15% 15% 0 / 0 50% 50% 0;
            position: relative;
            box-shadow: 15px 0 30px rgba(0,0,0,0.3);
            z-index: 2;
        }

        /* BAGIAN KANAN (Area Form Login) */
        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            padding: 40px;
            background: #0B2B26;
        }

        .login-wrapper {
            width: 100%;
            max-width: 320px;
        }

        .logo-text {
            text-align: center;
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 900;
            margin: 0 0 40px 0;
            letter-spacing: 2px;
        }

        .form-group { margin-bottom: 25px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-size: 0.95rem; 
            color: #DAF1DE; 
            font-weight: 500;
            padding-left: 5px; 
        }

        .form-control {
            width: 100%; 
            padding: 14px 20px; 
            border-radius: 30px; 
            background: rgba(142, 182, 155, 0.15); 
            border: 2px solid transparent;
            color: #ffffff; 
            box-sizing: border-box; 
            outline: none;
            transition: 0.3s;
            font-size: 1rem;
        }
        .form-control::placeholder {
            color: rgba(218, 241, 222, 0.5);
        }
        .form-control:focus { 
            border: 2px solid #5A8F7B; 
            background: rgba(142, 182, 155, 0.25);
        }

        .btn-login {
            width: 50%; 
            padding: 12px; 
            border-radius: 30px;
            background: #5A8F7B; 
            border: none; 
            color: #ffffff; 
            font-weight: bold; 
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer; 
            transition: 0.3s;
            display: block;
            margin: 30px auto 0 auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn-login:hover {
            background: #6eb097;
            transform: translateY(-2px);
        }

        .link-text { 
            text-align: center; 
            margin-top: 40px; 
            font-size: 0.9rem; 
            color: #8EB69B; 
        }
        .link-text a { 
            color: #f2d472; 
            text-decoration: none; 
            font-weight: bold; 
        }
        .link-text a:hover {
            text-decoration: underline;
        }

        /* RESPONSIF UNTUK TAMPILAN HP */
        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .left-side {
                flex: unset;
                height: 250px;
                /* Lengkungan dipindah ke bawah saat di HP */
                border-radius: 0 0 50% 50% / 0 0 15% 15%;
            }
            .right-side { flex: 1; padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div class="left-side"></div>

    <div class="right-side">
        <div class="login-wrapper">
            <h1 class="logo-text">LOGIN</h1>
            
            <form action="index.php?area=auth&action=proses_login" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                </div>
                <button type="submit" class="btn-login">MASUK</button>
            </form>

            <div class="link-text">
                Belum punya akun? <a href="index.php?area=auth&action=register">Daftar di sini</a>
            </div>
        </div>
    </div>

</body>
</html>