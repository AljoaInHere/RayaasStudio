<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRIS Payment - Raya Studio</title>
    <link rel="stylesheet" href="/css/premium.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .qris-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .qris-card {
            background: rgba(18, 18, 37, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 50px 45px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 40px rgba(157, 78, 221, 0.08);
            position: relative;
            overflow: hidden;
        }

        .qris-card::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(157, 78, 221, 0.05), transparent 30%);
            animation: cardShimmer 8s linear infinite;
            pointer-events: none;
        }

        @keyframes cardShimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .qris-card h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .qris-product-info {
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 8px;
            position: relative;
        }

        .qris-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            font-family: var(--font-heading);
            margin-bottom: 30px;
            text-shadow: 0 0 15px var(--primary-soft);
            position: relative;
        }

        /* QR Container */
        .qr-container {
            position: relative;
            width: 220px;
            height: 220px;
            margin: 0 auto 30px auto;
        }

        .qr-code {
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            inset: 0;
            transition: opacity 0.5s ease, transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .qr-code canvas {
            width: 100%;
            height: 100%;
        }

        .qr-code.fade-out {
            opacity: 0;
            transform: scale(0.75);
        }

        /* Success Checkmark */
        .success-check {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.3);
            transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .success-check.show {
            opacity: 1;
            transform: scale(1);
        }

        .check-circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #34d399);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.4), 0 0 80px rgba(16, 185, 129, 0.15);
        }

        .check-circle svg {
            width: 64px;
            height: 64px;
            stroke: white;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .check-circle svg .checkmark-path {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            transition: stroke-dashoffset 0.6s cubic-bezier(0.65, 0, 0.35, 1) 0.2s;
        }

        .success-check.show .checkmark-path {
            stroke-dashoffset: 0;
        }

        /* Status Text */
        .qris-status {
            font-size: 15px;
            color: var(--text-secondary);
            position: relative;
            min-height: 24px;
            transition: all 0.4s ease;
        }

        .qris-status.success {
            color: #34d399;
            font-weight: 600;
            font-size: 18px;
        }

        /* Pulse ring animation */
        .pulse-ring {
            position: absolute;
            inset: -10px;
            border-radius: 24px;
            border: 2px solid rgba(157, 78, 221, 0.3);
            animation: pulseRing 2s cubic-bezier(0.2, 0.8, 0.2, 1) infinite;
        }

        @keyframes pulseRing {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.15); opacity: 0; }
        }

        .pulse-ring.success-pulse {
            border-color: rgba(16, 185, 129, 0.3);
        }

        /* Progress dots */
        .waiting-dots::after {
            content: '';
            animation: dots 1.5s steps(4, end) infinite;
        }

        @keyframes dots {
            0% { content: ''; }
            25% { content: '.'; }
            50% { content: '..'; }
            75% { content: '...'; }
        }

        /* Timer */
        .qris-timer {
            position: relative;
            margin-top: 12px;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Success redirect text */
        .redirect-text {
            margin-top: 16px;
            font-size: 13px;
            color: var(--text-muted);
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.5s ease 0.3s;
            position: relative;
        }

        .redirect-text.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .qris-card {
                padding: 35px 25px;
                margin: 20px;
            }
            .qr-container {
                width: 180px;
                height: 180px;
            }
            .check-circle {
                width: 110px;
                height: 110px;
            }
            .check-circle svg {
                width: 48px;
                height: 48px;
            }
        }
    </style>
</head>
<body>

<div class="qris-wrapper">
    <div class="qris-card">
        <div class="pulse-ring" id="pulseRing"></div>

        <h2>Pembayaran QRIS</h2>
        <p class="qris-product-info">{{ $itemName }}</p>
        <p class="qris-price">Rp {{ number_format($price, 0, ',', '.') }}</p>

        <div class="qr-container">
            <!-- QR Code -->
            <div class="qr-code" id="qrCode">
                <canvas id="qrCanvas" width="188" height="188"></canvas>
            </div>

            <!-- Success Checkmark -->
            <div class="success-check" id="successCheck">
                <div class="check-circle">
                    <svg viewBox="0 0 64 64">
                        <polyline class="checkmark-path" points="16 33 28 45 48 20"/>
                    </svg>
                </div>
            </div>
        </div>

        <p class="qris-status" id="qrisStatus">
            <span class="waiting-dots">Menunggu pembayaran</span>
        </p>
        <p class="qris-timer" id="qrisTimer"></p>
        <p class="redirect-text" id="redirectText">Mengalihkan ke dashboard...</p>
    </div>
</div>

<script>
// Generate a convincing QR-like pattern on the canvas
function drawQR(canvas) {
    var ctx = canvas.getContext('2d');
    var size = canvas.width;
    var moduleCount = 25;
    var moduleSize = size / moduleCount;

    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, size, size);

    ctx.fillStyle = '#1a1a2e';

    // Draw finder patterns (the 3 big squares in corners)
    function drawFinderPattern(x, y) {
        var s = moduleSize;
        // Outer
        ctx.fillRect(x * s, y * s, 7 * s, 7 * s);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect((x + 1) * s, (y + 1) * s, 5 * s, 5 * s);
        ctx.fillStyle = '#1a1a2e';
        ctx.fillRect((x + 2) * s, (y + 2) * s, 3 * s, 3 * s);
    }

    drawFinderPattern(0, 0);
    drawFinderPattern(moduleCount - 7, 0);
    drawFinderPattern(0, moduleCount - 7);

    // Timing patterns
    for (var i = 8; i < moduleCount - 8; i++) {
        if (i % 2 === 0) {
            ctx.fillRect(i * moduleSize, 6 * moduleSize, moduleSize, moduleSize);
            ctx.fillRect(6 * moduleSize, i * moduleSize, moduleSize, moduleSize);
        }
    }

    // Random data modules
    var seed = {{ $price }};
    function pseudoRandom() {
        seed = (seed * 1103515245 + 12345) & 0x7fffffff;
        return seed / 0x7fffffff;
    }

    for (var row = 0; row < moduleCount; row++) {
        for (var col = 0; col < moduleCount; col++) {
            // Skip finder patterns
            if ((row < 9 && col < 9) || (row < 9 && col > moduleCount - 9) || (row > moduleCount - 9 && col < 9)) continue;
            // Skip timing
            if (row === 6 || col === 6) continue;

            if (pseudoRandom() > 0.55) {
                ctx.fillRect(col * moduleSize, row * moduleSize, moduleSize, moduleSize);
            }
        }
    }

    // Center logo area
    var center = Math.floor(moduleCount / 2);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect((center - 2) * moduleSize, (center - 2) * moduleSize, 5 * moduleSize, 5 * moduleSize);
    ctx.fillStyle = '#9d4edd';
    ctx.font = 'bold ' + (moduleSize * 3) + 'px sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText('R', center * moduleSize + moduleSize * 0.5, center * moduleSize + moduleSize * 0.5);
}

// Initialize
var canvas = document.getElementById('qrCanvas');
drawQR(canvas);

// Payment flow
var countdown = 5;
var timerEl = document.getElementById('qrisTimer');

function updateTimer() {
    if (countdown > 0) {
        timerEl.textContent = 'Memproses dalam ' + countdown + ' detik...';
        countdown--;
        setTimeout(updateTimer, 1000);
    } else {
        completePayment();
    }
}

setTimeout(updateTimer, 500);

function completePayment() {
    // Send AJAX to process payment
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/payment/qris/process', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            type: '{{ $type }}',
            id: {{ $itemId }},
            nama: '{{ $nama }}',
            metode: 'qris'
        })
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            animateSuccess();
        }
    })
    .catch(function() {
        // Still animate success for demo purposes
        animateSuccess();
    });
}

function animateSuccess() {
    // 1. Fade out QR
    var qrCode = document.getElementById('qrCode');
    var successCheck = document.getElementById('successCheck');
    var statusEl = document.getElementById('qrisStatus');
    var timerEl = document.getElementById('qrisTimer');
    var pulseRing = document.getElementById('pulseRing');
    var redirectText = document.getElementById('redirectText');

    qrCode.classList.add('fade-out');

    // 2. After QR fades, show checkmark
    setTimeout(function() {
        successCheck.classList.add('show');
        pulseRing.classList.add('success-pulse');

        // 3. Update status text
        statusEl.innerHTML = 'Pembayaran Berhasil!';
        statusEl.classList.add('success');
        timerEl.textContent = '';

        // 4. Show redirect text
        setTimeout(function() {
            redirectText.classList.add('show');
        }, 300);

        // 5. Redirect after 2.5s
        setTimeout(function() {
            window.location.href = '{{ route("dashboard.customer") }}?success=Pembayaran+berhasil!';
        }, 2500);
    }, 500);
}
</script>

</body>
</html>
