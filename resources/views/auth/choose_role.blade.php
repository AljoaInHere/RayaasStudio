<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - Raya Studio</title>
    <link rel="stylesheet" href="/css/auth.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="h-screen flex flex-col justify-center items-center relative z-10 landing">
    <h1 class="font-heading text-[80px] font-extrabold tracking-[16px] mb-[15px] bg-gradient-to-br from-white via-primary-premium to-accent-cyan bg-clip-text text-transparent drop-shadow-[0_0_30px_var(--primary-glow)] animate-[pulseLogo_3s_infinite_ease-in-out] logo">RAYA</h1>
    <p class="mb-[45px] text-text-secondary text-[14px] font-medium uppercase tracking-[4px] text-center tagline">Helper For Your Streaming Needs</p>

    <div class="flex gap-6 z-10 buttons flex-col sm:flex-row w-full max-w-[350px] sm:max-w-none px-6 sm:px-0">
        <a href="{{ route('register.choose', ['role' => 'mitra']) }}" class="bg-white/3 text-text-primary py-3.5 px-10 rounded-[30px] border border-white/8 no-underline font-semibold tracking-[1px] font-heading shadow-[0_4px_20px_rgba(0,0,0,0.4)] transition-all duration-300 hover:bg-white hover:text-black hover:-translate-y-[3px] hover:scale-[1.03] hover:shadow-[0_10px_25px_rgba(255,255,255,0.15),0_0_15px_rgba(157,78,221,0.3)] hover:border-white w-full sm:w-auto text-center btn">MITRA</a>
        <a href="{{ route('register.choose', ['role' => 'customer']) }}" class="bg-white/3 text-text-primary py-3.5 px-10 rounded-[30px] border border-white/8 no-underline font-semibold tracking-[1px] font-heading shadow-[0_4px_20px_rgba(0,0,0,0.4)] transition-all duration-300 hover:bg-white hover:text-black hover:-translate-y-[3px] hover:scale-[1.03] hover:shadow-[0_10px_25px_rgba(255,255,255,0.15),0_0_15px_rgba(157,78,221,0.3)] hover:border-white w-full sm:w-auto text-center btn">CUSTOMER</a>
    </div>

    <p class="mt-[30px] text-center text-text-secondary text-[14px]">Already have an account? <a href="{{ route('login') }}" class="text-primary-premium font-semibold transition-colors duration-300 hover:text-[#b372f9] hover:underline">Sign In</a></p>
</div>

</body>
</html>
