<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Raya Studio</title>
    <link rel="stylesheet" href="/css/premium.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            overflow: hidden;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .payment-container {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        .payment-left {
            width: 50%;
            background: linear-gradient(135deg, #090916 0%, #150926 50%, #22093a 100%);
            border-right: 1px solid var(--border-color);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .payment-left::before {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(157, 78, 221, 0.15) 0%, rgba(0,0,0,0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        /* Product Image */
        .product-image-checkout {
            width: 280px;
            height: 280px;
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid rgba(157, 78, 221, 0.3);
            box-shadow: 0 0 40px rgba(157, 78, 221, 0.15), 0 20px 60px rgba(0,0,0,0.4);
            margin-bottom: 30px;
            z-index: 1;
            position: relative;
        }

        .product-image-checkout img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image-checkout .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.03);
            color: var(--text-muted);
            font-size: 48px;
        }

        .payment-left h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            z-index: 1;
            background: linear-gradient(135deg, #ffffff 40%, var(--primary-glow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .product-name {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 12px;
            z-index: 1;
        }

        .price {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            font-family: var(--font-heading);
            z-index: 1;
            text-shadow: 0 0 15px var(--primary-soft);
        }

        .payment-right {
            width: 50%;
            background: var(--bg-base);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 80px;
        }

        .payment-right h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .payment-right form {
            display: flex;
            flex-direction: column;
        }

        .payment-right label {
            margin-bottom: 8px;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 14px;
        }

        .payment-right input,
        .payment-right select {
            margin-bottom: 20px;
        }

        .payment-right button {
            margin-top: 15px;
        }

        .back-link {
            margin-top: 25px;
            text-align: center;
        }

        .back-link a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .back-link a:hover {
            color: var(--primary);
        }

        /* Confirmation Modal */
        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(4, 4, 8, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .confirm-overlay.visible {
            display: flex;
            opacity: 1;
        }

        .confirm-card {
            background: rgba(18, 18, 37, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 30px rgba(157, 78, 221, 0.1);
            transform: scale(0.9) translateY(20px);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.35s ease;
        }

        .confirm-overlay.visible .confirm-card {
            transform: scale(1) translateY(0);
        }

        .confirm-card h3 {
            font-size: 22px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .confirm-detail {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .confirm-detail .label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .confirm-detail .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 14px;
        }

        .confirm-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .confirm-actions .btn {
            flex: 1;
            padding: 14px 20px;
            font-size: 15px;
        }

        .btn-ghost {
            background: rgba(255,255,255,0.05);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            font-family: var(--font-body);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-ghost:hover {
            background: rgba(255,255,255,0.08);
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            body {
                overflow: auto;
                height: auto;
            }
            .payment-container {
                flex-direction: column;
                height: auto;
                overflow: auto;
            }
            .payment-left,
            .payment-right {
                width: 100%;
                padding: 40px 20px;
            }
            .payment-left {
                min-height: auto;
                padding: 40px 20px;
            }
            .product-image-checkout {
                width: 200px;
                height: 200px;
            }
            .payment-left h2 {
                font-size: 24px;
            }
            .product-name {
                font-size: 18px;
            }
            .price {
                font-size: 28px;
            }
            .payment-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="flex flex-col md:flex-row h-screen w-full overflow-hidden payment-container">
    <!-- LEFT: Product Image + Info -->
    <div class="w-full md:w-1/2 bg-gradient-to-br from-[#090916] via-[#150926] to-[#22093a] border-b md:border-b-0 md:border-r border-white/8 text-white flex flex-col justify-center items-center text-center p-10 md:p-[60px] relative overflow-hidden payment-left">
        <div class="product-image-checkout">
            @if($product->image)
                <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}">
            @else
                <div class="no-image">📦</div>
            @endif
        </div>
        <h2>💳 Checkout Product</h2>
        <p class="product-name">{{ $product->name }}</p>
        <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    </div>

    <!-- RIGHT: Payment Form -->
    <div class="w-full md:w-1/2 bg-bg-base flex flex-col justify-center p-10 md:p-[60px_80px] payment-right animate-fade-up">
        <h2>Payment Details</h2>

        <form id="paymentForm" action="{{ route('payment.product.process', $product->id) }}" method="POST">
            @csrf

            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>

            <label for="produk">Produk</label>
            <input type="text" id="produk" value="{{ $product->name }}" readonly>

            <label for="metode">Metode Pembayaran</label>
            <select id="metode" name="metode" required>
                <option value="">Pilih Metode</option>
                <option value="qris">QRIS</option>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="kartu_kredit">Kartu Kredit</option>
            </select>

            <button type="button" id="payBtn" class="btn btn-primary" onclick="showConfirmation()">Bayar Sekarang</button>
        </form>

        <div class="back-link">
            <a href="{{ route('dashboard.customer') }}">← Kembali</a>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmOverlay" class="confirm-overlay">
    <div class="confirm-card">
        <h3>Konfirmasi Pembayaran</h3>
        <div class="confirm-detail">
            <span class="label">Produk</span>
            <span class="value" id="confirmProduct">{{ $product->name }}</span>
        </div>
        <div class="confirm-detail">
            <span class="label">Harga</span>
            <span class="value" id="confirmPrice" style="color: var(--primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
        <div class="confirm-detail">
            <span class="label">Metode</span>
            <span class="value" id="confirmMethod">-</span>
        </div>
        <div class="confirm-actions">
            <button class="btn btn-ghost" onclick="closeConfirmation()">Batal</button>
            <button class="btn btn-primary" id="confirmPayBtn" onclick="processPayment()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
function showConfirmation() {
    var form = document.getElementById('paymentForm');
    var nama = document.getElementById('nama').value.trim();
    var metode = document.getElementById('metode');
    var metodeValue = metode.value;
    var metodeText = metode.options[metode.selectedIndex].text;

    if (!nama) {
        document.getElementById('nama').focus();
        return;
    }
    if (!metodeValue) {
        metode.focus();
        return;
    }

    document.getElementById('confirmMethod').textContent = metodeText;

    var overlay = document.getElementById('confirmOverlay');
    overlay.style.display = 'flex';
    requestAnimationFrame(function() {
        overlay.classList.add('visible');
    });
}

function closeConfirmation() {
    var overlay = document.getElementById('confirmOverlay');
    overlay.classList.remove('visible');
    setTimeout(function() {
        overlay.style.display = 'none';
    }, 350);
}

function processPayment() {
    var metode = document.getElementById('metode').value;
    if (metode === 'qris') {
        // Redirect to QRIS page
        var productId = {{ $product->id }};
        var nama = encodeURIComponent(document.getElementById('nama').value);
        window.location.href = '/payment/qris/product/' + productId + '?nama=' + nama;
    } else {
        document.getElementById('paymentForm').submit();
    }
}

// Close modal on backdrop click
document.getElementById('confirmOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeConfirmation();
});
</script>

</body>
</html>
