<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Oops! Terjadi Kesalahan - MoneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 500px;
            padding: 40px;
            background: rgba(255,255,255,0.05);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 72px;
            margin: 0;
            color: #38bdf8;
        }

        h2 {
            margin: 10px 0;
            font-weight: 600;
        }

        p {
            color: #cbd5f5;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary {
            background: #38bdf8;
            color: #0f172a;
        }

        .btn-primary:hover {
            background: #0ea5e9;
        }

        .btn-secondary {
            margin-left: 10px;
            border: 1px solid #38bdf8;
            color: #38bdf8;
        }

        .btn-secondary:hover {
            background: #38bdf8;
            color: #0f172a;
        }

        .logo img {
            max-width: 20%;
            height: auto;
            border-radius: 8px; /* Sudut tumpul */
            margin-bottom: 18px;
        }

        .emoji {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/moneymate-original.png') }}">
        </div>
        <div class="emoji">😵</div>
        <h1>500</h1>
        <h2>Terjadi Kesalahan Server</h2>
        <p>
            Maaf, sepertinya ada masalah di sistem kami. 
            Tim kami sudah diberi tahu dan sedang memperbaikinya.
        </p>

        <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
        <a href="javascript:location.reload()" class="btn btn-secondary">Coba Lagi</a>
    </div>
</body>
</html>