<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - Raya Studio</title>
    <link rel="stylesheet" href="/css/auth.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Fallback Grid & Layout for Choose Role (Independent of Tailwind Compilation) */
        .role-body {
            background-color: #06060c;
            color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        .role-wrapper {
            width: 100%;
            max-width: 1024px;
            padding: 48px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        /* Title Logo Styles */
        .logo-title {
            font-family: 'Outfit', sans-serif;
            font-size: 80px;
            font-weight: 800;
            letter-spacing: 16px;
            margin-bottom: 16px;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 20%, #9d4edd 70%, #00f0ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 30px rgba(157, 78, 221, 0.35));
            animation: pulseLogo 3s infinite ease-in-out;
            user-select: none;
        }

        @media (max-width: 768px) {
            .logo-title {
                font-size: 56px;
                letter-spacing: 10px;
            }
        }

        .logo-subtitle {
            color: #9ca3af;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 48px;
            text-align: center;
            user-select: none;
        }

        /* Role Selection Cards Grid */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            width: 100%;
            max-width: 896px;
            margin-bottom: 40px;
            align-items: stretch;
        }

        @media (min-width: 768px) {
            .role-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Selection Card styling */
        .role-card {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 40px 32px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            overflow: hidden;
            height: 100%;
            box-sizing: border-box;
        }

        .role-card:hover {
            transform: translateY(-6px) scale(1.02);
            background: rgba(255, 255, 255, 0.04);
        }

        .role-card-mitra:hover {
            border-color: rgba(157, 78, 221, 0.4);
            box-shadow: 0 20px 40px rgba(157, 78, 221, 0.15);
        }

        .role-card-customer:hover {
            border-color: rgba(0, 240, 255, 0.4);
            box-shadow: 0 20px 40px rgba(0, 240, 255, 0.12);
        }

        /* Card Content Area */
        .role-card-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        /* Glow Hover Overlay */
        .role-card-glow {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
            z-index: 0;
        }

        .role-card:hover .role-card-glow {
            opacity: 1;
        }

        .role-card-mitra .role-card-glow {
            background: radial-gradient(circle at top left, rgba(157, 78, 221, 0.12), transparent 70%);
        }

        .role-card-customer .role-card-glow {
            background: radial-gradient(circle at top left, rgba(0, 240, 255, 0.1), transparent 70%);
        }

        /* Icon Frame */
        .role-icon-frame {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .role-card-mitra .role-icon-frame {
            background: rgba(157, 78, 221, 0.1);
            border: 1px solid rgba(157, 78, 221, 0.2);
        }

        .role-card-customer .role-icon-frame {
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid rgba(0, 240, 255, 0.2);
        }

        .role-card:hover .role-icon-frame {
            transform: scale(1.1);
        }

        .role-card-mitra:hover .role-icon-frame {
            background: rgba(157, 78, 221, 0.2);
            border-color: rgba(157, 78, 221, 0.4);
            box-shadow: 0 0 20px rgba(157, 78, 221, 0.3);
        }

        .role-card-customer:hover .role-icon-frame {
            background: rgba(0, 240, 255, 0.2);
            border-color: rgba(0, 240, 255, 0.4);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
        }

        /* Icon SVG styles */
        .role-icon {
            width: 32px;
            height: 32px;
        }

        .role-card-mitra .role-icon {
            color: #9d4edd;
        }

        .role-card-customer .role-icon {
            color: #00f0ff;
        }

        /* Typography */
        .role-card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #f3f4f6;
            margin-bottom: 12px;
            letter-spacing: 2px;
            transition: color 0.3s ease;
        }

        .role-card-mitra:hover .role-card-title {
            color: #9d4edd;
        }

        .role-card-customer:hover .role-card-title {
            color: #00f0ff;
        }

        .role-card-desc {
            font-size: 14px;
            line-height: 1.6;
            color: #9ca3af;
            max-width: 280px;
            margin-bottom: 32px;
        }

        /* Action Link Button */
        .role-card-action {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .role-card-mitra .role-card-action {
            color: #9d4edd;
        }

        .role-card-customer .role-card-action {
            color: #00f0ff;
        }

        .role-card:hover .role-card-action {
            gap: 12px;
        }

        .role-card-action svg {
            width: 16px;
            height: 16px;
        }

        /* Footer Text */
        .role-footer {
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
            user-select: none;
        }

        .role-footer-link {
            color: #9d4edd;
            font-weight: 600;
            text-decoration: none;
            margin-left: 4px;
            transition: all 0.3s ease;
        }

        .role-footer-link:hover {
            color: #b372f9;
            text-decoration: underline;
        }
    </style>
</head>
<body class="role-body">

<!-- Background Ambient Decorative Elements -->
<div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
    <div class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-primary-premium/10 blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-accent-cyan/5 blur-[120px]"></div>
</div>

<div class="role-wrapper">
    <!-- Header Logo and Subtitle -->
    <div>
        <h1 class="logo-title">RAYA</h1>
        <p class="logo-subtitle">Helper For Your Streaming Needs</p>
    </div>

    <!-- Selection Cards Container -->
    <div class="role-grid">
        <!-- Mitra Card -->
        <a href="{{ route('register.choose', ['role' => 'mitra']) }}" class="role-card role-card-mitra">
            <!-- Glassmorphism Card Hover Overlay -->
            <div class="role-card-glow"></div>
            
            <div class="role-card-content">
                <!-- Icon Frame -->
                <div class="role-icon-frame">
                    <!-- SVG Icon for Mitra (Microphone/Broadcaster) -->
                    <svg class="role-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                    </svg>
                </div>
                
                <h3 class="role-card-title">MITRA</h3>
                <p class="role-card-desc">
                    Bergabung sebagai penyedia jasa streaming, talent, desainer overlay, operator penyiaran, atau tim teknis event.
                </p>
                
                <div class="role-card-action">
                    <span>Mulai Sebagai Mitra</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Customer Card -->
        <a href="{{ route('register.choose', ['role' => 'customer']) }}" class="role-card role-card-customer">
            <!-- Glassmorphism Card Hover Overlay -->
            <div class="role-card-glow"></div>
            
            <div class="role-card-content">
                <!-- Icon Frame -->
                <div class="role-icon-frame">
                    <!-- SVG Icon for Customer (User/Shopper) -->
                    <svg class="role-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                
                <h3 class="role-card-title">CUSTOMER</h3>
                <p class="role-card-desc">
                    Mencari talent, menyewa operator live streaming, memesan overlay kustom, atau membeli kebutuhan setup broadcasting.
                </p>
                
                <div class="role-card-action">
                    <span>Mulai Sebagai Customer</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Footer Sign In Link -->
    <p class="role-footer">
        Already have an account? 
        <a href="{{ route('login') }}" class="role-footer-link">Sign In</a>
    </p>
</div>

</body>
</html>
