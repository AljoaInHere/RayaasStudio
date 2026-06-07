<!DOCTYPE html>
<html>
<head>
    <title>Setup Package - Raya</title>
    <link rel="stylesheet" href="style.css?v=20">
    <style>
        body {
            background: #f5f5f5;
            padding: 40px;
            font-family: Arial;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #7b2cbf;
        }

        .card-wrapper {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            background: linear-gradient(135deg, #7b2cbf, #c77dff);
            color: white;
            padding: 25px;
            border-radius: 20px;
            width: 260px;
            text-align: center;
        }

        .price {
            font-size: 18px;
            margin: 10px 0;
            font-weight: bold;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background: white;
            color: #7b2cbf;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #eee;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pilih Setup Package</h2>

    <div class="card-wrapper">

        <!-- VIP -->
        <div class="card">
            <h3>VIP</h3>
            <p>Paket basic untuk pemula</p>
            <div class="price">Rp 100.000</div>
            <button onclick="window.location.href='payment_setup.php?paket=VIP'">
                Pilih VIP
            </button>
        </div>

        <!-- VVIP -->
        <div class="card">
            <h3>VVIP</h3>
            <p>Fitur lebih lengkap & profesional</p>
            <div class="price">Rp 200.000</div>
            <button onclick="window.location.href='payment_setup.php?paket=VVIP'">
                Pilih VVIP
            </button>
        </div>

        <!-- VVIP+ -->
        <div class="card">
            <h3>VVIP+</h3>
            <p>Paket premium full support</p>
            <div class="price">Rp 300.000</div>
            <button onclick="window.location.href='payment_setup.php?paket=VVIP+'">
                Pilih VVIP+
            </button>
        </div>

    </div>
</div>

</body>
</html>