<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raya Studio</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        nav { background: #1a1a2e; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: white; text-decoration: none; margin-right: 15px; }
        nav form button { background: #e94560; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 5px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #1a1a2e; color: white; }
        .btn-danger { background: #e94560; color: white; }
        .btn-success { background: #28a745; color: white; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1a1a2e; color: white; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        /* Fullscreen Logout Overlay Loader */
        .logout-overlay {
            position: fixed;
            inset: 0;
            background: rgba(4, 4, 8, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 9999;
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
</head>
<body>
    <nav>
        <div>
            <a href="{{ route('profile') }}" class="profile-btn" title="Profil"></a>
        </div>
        <div>
            @auth
                <a href="/products">Produk</a>
                <a href="/orders">Pesanan Saya</a>
                @if(Auth::user()->role == 'mitra')
                    <a href="/admin/products">Admin</a>
                @endif
                <a href="#" onclick="triggerLogout(); return false;">Logout ({{ Auth::user()->username }})</a>
                <form id="logoutForm" method="POST" action="/logout" style="display:none">
                    @csrf
                </form>
            @else
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            @endauth
        </div>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </div>

    <!-- Logout Overlay -->
    <div id="logoutOverlay" class="logout-overlay">
        <div class="logout-box">
            <div class="logout-spinner"></div>
            <h3>Logging Out</h3>
            <p>Leaving the space, please wait...</p>
        </div>
    </div>

    <script>
    // Page transition handling
    document.addEventListener('DOMContentLoaded', () => {
        // Add enter animation class
        document.body.classList.add('page-transition-enter');
        // Remove after animation completes
        setTimeout(() => {
            document.body.classList.remove('page-transition-enter');
        }, 300);
        // Attach click listeners to navigation links for leave animation
        const navLinks = document.querySelectorAll('.navbar .menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Allow default behavior for anchor with target _blank or hash
                const href = link.getAttribute('href');
                if (!href || href.startsWith('#')) return;
                e.preventDefault();
                document.body.classList.add('page-transition-leave');
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        });
    });
    function triggerLogout() {
        if (confirm("Apakah Anda yakin ingin logout?")) {
            var overlay = document.getElementById('logoutOverlay');
            if (overlay) {
                overlay.classList.add('visible');
            }
            setTimeout(function() {
                document.getElementById('logoutForm').submit();
            }, 1200);
        }
    }
    </script>
</body>
</html>