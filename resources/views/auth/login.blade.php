<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Raya Studio</title>
    <link rel="stylesheet" href="/css/auth.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="flex flex-col md:flex-row h-screen relative z-10 auth-container">
    <!-- LEFT -->
    <div class="w-full md:w-[45%] bg-gradient-to-br from-[#090916] via-[#150926] to-[#22093a] border-b md:border-b-0 md:border-r border-white/8 flex flex-col justify-center items-center text-center p-10 md:p-[60px] relative auth-left">
        <h2 class="font-heading font-bold text-[38px] leading-tight z-10 bg-gradient-to-r from-white via-primary-premium to-accent-cyan bg-clip-text text-transparent bg-[size:200%_auto] animate-[shineText_5s_ease-in-out_infinite]">Welcome Back!</h2>
    </div>

    <!-- RIGHT -->
    <div class="w-full md:w-[55%] bg-bg-base flex flex-col justify-center p-10 md:p-[80px_100px] auth-right">
        <h2 class="font-heading font-bold text-3xl md:text-[32px] mb-[30px] text-text-primary tracking-tight">Login to Your Account</h2>

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}" class="flex flex-col">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}" class="py-3.5 px-4 mb-5 bg-white/3 border border-white/8 rounded-premium text-text-primary font-body text-[15px] transition-all duration-300 focus:outline-none focus:border-primary-premium focus:bg-white/5 focus:ring-4 focus:ring-primary-premium/15">
            <input type="password" name="password" placeholder="Enter your password" required class="py-3.5 px-4 mb-5 bg-white/3 border border-white/8 rounded-premium text-text-primary font-body text-[15px] transition-all duration-300 focus:outline-none focus:border-primary-premium focus:bg-white/5 focus:ring-4 focus:ring-primary-premium/15">
            <button type="submit" class="py-3.5 border-none bg-primary-premium text-white font-semibold text-base font-heading rounded-premium cursor-pointer shadow-[0_4px_15px_var(--primary-soft)] transition-all duration-300 hover:bg-primary-hover hover:shadow-[0_6px_20px_var(--primary-glow)] hover:-translate-y-[2px]">SIGN IN</button>
        </form>

        <div id="loginLoader" class="auth-login-loader" aria-hidden="true">
            <div class="login-progress-bar"><span></span></div>
        </div>

        <p class="mt-[25px] text-center text-text-secondary text-[14px]">Don't have an account? <a href="{{ route('choose.role') }}" class="text-primary-premium font-semibold transition-colors duration-300 hover:text-[#b372f9] hover:underline">Sign Up</a></p>

        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var loader = document.getElementById('loginLoader');
                loader.classList.add('visible');
                setTimeout(function() {
                    event.target.submit();
                }, 1200);
            });
        </script>
    </div>
</div>

</body>
</html>