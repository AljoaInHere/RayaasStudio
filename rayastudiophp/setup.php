<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set up Teknisi - Raya Studio</title>
    
    <style>
        /* Menggunakan base style yang sama dengan mitra.php */
        body.mitra-page {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f6f6;
        }

        .mitra-layout { display: flex; min-height: 100vh; }

        /* --- SIDEBAR --- */
        .mitra-sidebar {
            width: 280px; background-color: #4f1d70; color: white;
            padding: 40px 30px; box-sizing: border-box;
            position: relative;
        }
        .mitra-logo-text { font-size: 38px; font-weight: 900; letter-spacing: 4px; margin: 0; }
        .mitra-logo-sub { font-size: 9px; letter-spacing: 1px; margin-bottom: 50px; display: block; }
        .mitra-nav-list { list-style: none; padding: 0; }
        .mitra-nav-list li { margin-bottom: 25px; }
        .mitra-nav-list a { color: white; text-decoration: none; font-size: 20px; font-weight: bold; }

        /* --- CONTENT --- */
        .mitra-content { flex: 1; padding: 60px 50px; }
        .mitra-content h1 { font-size: 34px; font-weight: 800; color: #111; margin-bottom: 30px; }

        .setup-container {
            display: grid;
            grid-template-columns: 1.2fr 1fr; /* Kiri form, Kanan hasil/syarat */
            gap: 30px;
            max-width: 1100px;
        }

        .mitra-card {
            background: white; border-radius: 16px; padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        /* --- FORM STYLE --- */
        .setup-form-title { font-size: 18px; font-weight: bold; margin-bottom: 20px; color: #4f1d70; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12px; font-weight: bold; text-transform: uppercase; color: #888; margin-bottom: 5px; }
        .form-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        
        .btn-submit-setup {
            width: 100%; background-color: #4f1d70; color: white; border: none;
            padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px;
        }

        /* --- HASIL TEKNISI (PREVIEW CARD) --- */
        .preview-card {
            background: linear-gradient(135deg, #855799 0%, #4f1d70 100%);
            border-radius: 20px; padding: 25px; color: white; text-align: center;
        }
        .preview-avatar {
            width: 100px; height: 100px; background: rgba(255,255,255,0.2);
            border-radius: 50%; margin: 0 auto 15px; border: 3px solid white;
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .preview-name { font-size: 20px; font-weight: bold; margin-bottom: 5px; }
        .preview-price { background: rgba(255,255,255,0.2); display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 14px; margin-bottom: 15px; }
        .preview-desc { font-size: 13px; opacity: 0.9; line-height: 1.5; }

        /* --- SYARAT SECTION --- */
        .terms-box { margin-top: 20px; font-size: 13px; color: #666; background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #4f1d70; }

        /* --- RESPONSIVENESS --- */
        @media (max-width: 768px) {
            .mitra-layout {
                flex-direction: column;
            }
            .mitra-sidebar {
                width: 100% !important;
                height: auto !important;
                position: relative !important;
                padding: 20px !important;
            }
            .mitra-logo-sub {
                margin-bottom: 20px !important;
            }
            .mitra-menu-label {
                display: none !important;
            }
            .mitra-nav-list {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 15px !important;
                margin-bottom: 0 !important;
            }
            .mitra-nav-list li {
                margin-bottom: 0 !important;
            }
            .logout-item {
                position: relative !important;
                bottom: auto !important;
                left: auto !important;
                margin-top: 0 !important;
            }
            .mitra-content {
                padding: 30px 20px !important;
            }
            .setup-container {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }

        /* Sliding Active Pill/Tab Indicator */
        .sliding-pill-indicator {
            position: absolute;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 0;
            transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            pointer-events: none;
            opacity: 0;
        }

        /* Ensure menu items stack above the pill */
        .mitra-nav-list {
            position: relative !important;
        }

        .mitra-nav-list li, .mitra-nav-list a {
            position: relative;
            z-index: 1;
        }

        .mitra-nav-list li.active a {
            background: transparent !important;
        }
        
        .mitra-nav-list li.active a {
            color: #ffffff;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 10px 14px;
        }
        
        .mitra-nav-list li.active a {
            background: transparent !important;
        }
    </style>
</head>
<body class="mitra-page">

    <div class="mitra-layout">
        <aside class="mitra-sidebar">
            <div style="margin-bottom: 40px;">
                <h1 class="mitra-logo-text">R°Y°/</h1>
                <span class="mitra-logo-sub">CREATIVE STUDIO</span>
            </div>
             <div class="mitra-menu-label">MENU</div>
            <ul class="mitra-nav-list">
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'mitra.php' ? 'active' : '' ?>"><a href="mitra.php">Home</a></li>
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'setup.php' ? 'active' : '' ?>"><a href="setup.php">Set up</a></li>
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><a href="profile.php">Profil</a></li>
                <br>
                <li class="logout-item">
                    <a href="logout.php" onclick="triggerLogout(event)">Log out</a>
                </li>
            </ul>
        </aside>

        <main class="mitra-content">
            <h1>Pendaftaran Teknisi</h1>

            <div class="setup-container">
                <div class="mitra-card">
                    <div class="setup-form-title">Registration Form</div>
                    <form action="proses_setup.php" method="POST" enctype="multipart/form-data" onsubmit="return validateSetup()">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Nama Lengkap Anda" required>
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="tech_photo" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Description / Expertise</label>
                            <textarea name="description" class="form-input" rows="3" placeholder="Contoh: Ahli setting OBS dan Stream Deck..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Service Price (IDR)</label>
                            <input type="number" id="price" name="price" class="form-input" placeholder="50000" required>
                        </div>
                        
                        <div class="terms-box">
                            <strong>Syarat & Ketentuan:</strong><br>
                            1. Teknisi wajib memiliki alat sendiri.<br>
                            2. Bersedia dipanggil ke lokasi mitra jika diperlukan.<br>
                            3. Komisi 10% untuk platform Raya Studio.
                        </div>

                        <button type="submit" class="btn-submit-setup">Register as Technician</button>
                        <button type="button" onclick="resetForm()" style="
        width: 100%;
        background-color: #ccc;
        color: black;
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
    ">
        Cancel
    </button>
                    </form>
                </div>

                <div>
                    <div style="font-weight: bold; margin-bottom: 10px; color: #888;">PREVIEW CARD</div>
                    <div class="preview-card" id="previewCard">
                        <div class="preview-avatar">
                            <span id="initials">👤</span>
                        </div>
                        <div class="preview-name" id="prevName">Your Name</div>
                        <div class="preview-price" id="prevPrice">Rp 0</div>
                        <p class="preview-desc" id="prevDesc">Deskripsi keahlian kamu akan muncul di sini setelah formulir diisi lengkap.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // JavaScript Interaktif untuk Preview Langsung (Nambah nilai ETS)
        const nameInput = document.getElementById('fullname');
        const priceInput = document.getElementById('price');
        
        nameInput.addEventListener('input', function() {
            document.getElementById('prevName').innerText = this.value || "Your Name";
        });

        priceInput.addEventListener('input', function() {
            let val = this.value ? parseInt(this.value).toLocaleString('id-ID') : "0";
            document.getElementById('prevPrice').innerText = "Rp " + val;
        });

        function validateSetup() {
    const price = document.getElementById('price').value;
    if (price < 10000) {
        alert("Harga jasa minimal Rp 10.000");
        return false;
    }
    if (price > 1000000) {
        alert("Harga jasa maksimal Rp 1.000.000");
        return false;
    }
    return true;
}
function resetForm() {
    // reset form
    document.querySelector("form").reset();

    // reset preview
    document.getElementById('prevName').innerText = "Your Name";
    document.getElementById('prevPrice').innerText = "Rp 0";
    document.getElementById('prevDesc').innerText = "Deskripsi keahlian kamu akan muncul di sini setelah formulir diisi lengkap.";
    document.getElementById('initials').innerText = "👤";
}
    </script>
    <style> .mitra-menu-label { font-size: 13px; font-weight: bold; margin-bottom: 40px; letter-spacing: 1px; }
        .logout-item {
    position: absolute;
    bottom: 20px;
    left: 15px;
}

.logout-item a {
    font-size: 20px;
    color: white;
    text-decoration: none;
}

.logout-item a:hover {
    color: red;
}

        /* Fullscreen Logout Overlay Loader */
        .logout-overlay {
            position: fixed;
            inset: 0;
            background: rgba(4, 4, 8, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .logout-overlay.visible {
            display: flex;
            opacity: 1;
        }
        .logout-box {
            text-align: center;
            animation: logoutPulse 1.2s infinite ease-in-out;
            font-family: Arial, sans-serif;
        }
        .logout-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(157, 78, 221, 0.15);
            border-top: 3px solid #9d4edd;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            animation: logoutSpin 1s linear infinite;
            box-shadow: 0 0 15px rgba(157, 78, 221, 0.15);
        }
        .logout-box h3 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: #fff;
        }
        .logout-box p {
            color: #9ca3af;
            font-size: 14px;
        }
        @keyframes logoutSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes logoutPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
    </style>

    <!-- Logout Overlay -->
    <div id="logoutOverlay" class="logout-overlay">
        <div class="logout-box">
            <div class="logout-spinner"></div>
            <h3>Logging Out</h3>
            <p>Leaving the space, please wait...</p>
        </div>
    </div>

    <script>
    function triggerLogout(event) {
        event.preventDefault();
        if (confirm("Apakah Anda yakin ingin logout?")) {
            var overlay = document.getElementById('logoutOverlay');
            if (overlay) {
                overlay.classList.add('visible');
            }
            setTimeout(function() {
                window.location.href = 'logout.php';
            }, 1200);
        }
    }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initSlidingPill(containerSelector, itemSelector) {
        const containers = document.querySelectorAll(containerSelector);
        containers.forEach(container => {
            const computedStyle = window.getComputedStyle(container);
            if (computedStyle.position === 'static') {
                container.style.position = 'relative';
            }

            let pill = container.querySelector('.sliding-pill-indicator');
            if (!pill) {
                pill = document.createElement('div');
                pill.className = 'sliding-pill-indicator';
                container.appendChild(pill);
            }

            const items = container.querySelectorAll(itemSelector);
            
            function updatePill(target) {
                if (!target) {
                    pill.style.opacity = '0';
                    return;
                }
                pill.style.opacity = '1';
                
                const containerRect = container.getBoundingClientRect();
                const targetRect = target.getBoundingClientRect();
                
                const left = targetRect.left - containerRect.left + container.scrollLeft;
                const top = targetRect.top - containerRect.top + container.scrollTop;
                
                pill.style.left = left + 'px';
                pill.style.width = targetRect.width + 'px';
                pill.style.top = top + 'px';
                pill.style.height = targetRect.height + 'px';
                
                const targetStyle = window.getComputedStyle(target);
                pill.style.borderRadius = targetStyle.borderRadius;
            }

            function getActive() {
                return container.querySelector(itemSelector + '.active') || container.querySelector('li.active');
            }

            // Initial positioning
            setTimeout(() => {
                updatePill(getActive());
            }, 200);

            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    updatePill(item);
                });
            });

            container.addEventListener('mouseleave', () => {
                updatePill(getActive());
            });

            window.addEventListener('resize', () => {
                updatePill(getActive());
            });

            // Handle dynamically updated active states (e.g. scrollspy or tab clicks)
            const observer = new MutationObserver(() => {
                updatePill(getActive());
            });
            observer.observe(container, { attributes: true, subtree: true, attributeFilter: ['class'] });
        });
    }

    initSlidingPill('.navbar .menu', 'a, button');
    initSlidingPill('.tabs-container', '.tab-btn');
    initSlidingPill('.mitra-nav-list', 'li, a');
    initSlidingPill('.menu', 'a');
    initSlidingPill('.filter-container', '.filter-chip');
});
</script>

</body>
</html>