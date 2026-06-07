<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Raya Studio')</title>
    <link rel="stylesheet" href="/css/premium.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>
        @if(Auth::check() && Auth::user()->role == 'mitra')
            RAYA STUDIO - MITRA
        @else
            RAYA
        @endif
    </h2>
    <div class="menu">
        @auth
            @if(Auth::user()->role == 'mitra')
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Produk</a>
                <a href="{{ route('dashboard.mitra') }}" class="{{ request()->routeIs('dashboard.mitra') ? 'active' : '' }}">Dashboard</a>
            @else
                <a onclick="goCategory('')" class="{{ request()->routeIs('dashboard.customer') && !request('category') ? 'active' : '' }}">All Product</a>
                <a onclick="goCategory('digital')" class="{{ request('category') == 'digital' ? 'active' : '' }}">Digital Product</a>
                <a onclick="goCategory('course')" class="{{ request('category') == 'course' ? 'active' : '' }}">Course</a>
                <a onclick="goCategory('setup')" class="{{ request('category') == 'setup' ? 'active' : '' }}">Setup</a>
            @endif
            <a href="#" onclick="triggerLogout(); return false;">Logout</a>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('choose.role') }}" class="{{ request()->routeIs('choose.role') ? 'active' : '' }}">Register</a>
        @endauth
    </div>
    
    @auth
        <a href="{{ route('profile') }}" class="profile" title="Profil">
            @if(Auth::user()->profile_photo)
                <img src="/storage/{{ Auth::user()->profile_photo }}" alt="Avatar" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; border: 1px solid var(--primary);">
            @else
                👤
            @endif
            {{ Auth::user()->username }}
        </a>
    @endauth
</div>

<!-- MAIN CONTAINER -->
<div class="container animate-fade-up">
    @yield('content')
</div>

<!-- FOOTER -->
<div class="footer" id="footer" style="margin-top: 80px; padding: 40px 0; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
    <div class="footer-col">
        <h3 style="font-family: var(--font-heading); font-weight: 700; margin-bottom: 15px; color: var(--text-primary);">Raya Creative Studio</h3>
        <p style="color: var(--text-secondary); font-size: 14px;">Helper for your streaming needs</p>
    </div>

    <div class="footer-col">
        <h4 style="font-family: var(--font-heading); font-weight: 600; margin-bottom: 12px; color: var(--text-primary);">Address</h4>
        <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">Jl. Kenangan No.123<br>Surabaya, Indonesia</p>
    </div>

    <div class="footer-col">
        <h4 style="font-family: var(--font-heading); font-weight: 600; margin-bottom: 12px; color: var(--text-primary);">Contact</h4>
        <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">Phone: 0812-3456-7890<br>Email: rayastudio@gmail.com</p>
    </div>
</div>

<!-- Logout Overlay -->
<div id="logoutOverlay" class="logout-overlay">
    <div class="logout-box">
        <div class="logout-spinner"></div>
        <h3>Logging Out</h3>
        <p>Leaving the space, please wait...</p>
    </div>
</div>

<!-- Global scripts -->
<script>
function goCategory(cat) {
    var base = "{{ route('dashboard.customer') }}";
    if (cat === '') {
        window.location.href = base + "#products";
    } else {
        window.location.href = base + "?category=" + encodeURIComponent(cat) + "#products";
    }
}

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

            const observer = new MutationObserver(() => {
                updatePill(getActive());
            });
            observer.observe(container, { attributes: true, subtree: true, attributeFilter: ['class'] });
        });
    }

    initSlidingPill('.navbar .menu', 'a, button');
});
</script>

@yield('scripts')
</body>
</html>
