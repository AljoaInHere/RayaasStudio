@extends('layouts.premium')

@section('title', 'Profil Teknisi - ' . $teknisi->username . ' - Raya Studio')

@section('styles')
    <style>
        .profile-hero-card {
            background: linear-gradient(135deg, rgba(18, 18, 37, 0.6) 0%, rgba(25, 15, 45, 0.4) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 15px rgba(157, 78, 221, 0.1);
        }

        .avatar-glow {
            position: relative;
            width: 240px;
            height: 240px;
            border-radius: var(--radius-premium);
            overflow: hidden;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
        }

        .avatar-glow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: var(--radius-premium);
        }

        .avatar-glow::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: calc(var(--radius-premium) + 4px);
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent-cyan) 100%);
            z-index: -1;
            opacity: 0.6;
            filter: blur(4px);
            transition: var(--transition-smooth);
        }

        .profile-hero-card:hover .avatar-glow::after {
            opacity: 1;
            filter: blur(8px);
        }

        .tech-badge {
            background: rgba(157, 78, 221, 0.15);
            border: 1px solid rgba(157, 78, 221, 0.3);
            color: #d8b4fe;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-badge {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 12px 18px;
            text-align: center;
            transition: var(--transition-smooth);
        }

        .stat-badge:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .section-gradient-title {
            background: linear-gradient(135deg, #ffffff 40%, var(--primary-glow) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .setup-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: var(--transition-smooth);
        }

        .setup-card:hover {
            transform: translateY(-6px);
        }

        .platform-pill {
            background: rgba(0, 240, 255, 0.06);
            border: 1px solid rgba(0, 240, 255, 0.15);
            color: #22d3ee;
        }
    </style>
@endsection

@section('content')
    <!-- BACK BUTTON -->
    <div class="mb-8">
        <a href="{{ route('dashboard.customer') }}" class="text-primary-premium no-underline font-semibold text-[15px] transition-all hover:text-[#b372f9] hover:-translate-x-1 inline-flex items-center gap-1.5">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- PROFILE HERO SECTION -->
    <div class="p-6 md:p-10 mb-12 profile-hero-card">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Avatar -->
            <div class="avatar-glow">
                @if($teknisi->profile_photo)
                    <img src="/storage/{{ $teknisi->profile_photo }}" alt="{{ $teknisi->username }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-5xl">👨‍🔧</div>
                @endif
            </div>

            <!-- Profile Info -->
            <div class="flex-grow text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center gap-3 mb-3">
                    <h1 class="text-3xl font-bold font-heading text-text-primary">{{ $teknisi->username }}</h1>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold tech-badge uppercase">Mitra Teknisi</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Online
                    </span>
                </div>

                <p class="text-text-secondary text-sm md:text-base leading-relaxed max-w-2xl">
                    {{ $teknisi->bio ?: 'Teknisi profesional berpengalaman dalam konfigurasi software & hardware streaming (OBS, vMix, Soundcard, dll). Siap membantu setup workspace Anda menjadi lebih rapi dan optimal.' }}
                </p>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
                    <div class="stat-badge">
                        <span class="block text-2xl font-bold font-heading text-primary-premium">⭐ 4.9</span>
                        <span class="text-[11px] text-text-muted uppercase font-semibold tracking-wider">Rating Client</span>
                    </div>
                    <div class="stat-badge">
                        <span class="block text-2xl font-bold font-heading text-accent-cyan">{{ $teknisi->setupPackages->count() }}</span>
                        <span class="text-[11px] text-text-muted uppercase font-semibold tracking-wider">Paket Jasa</span>
                    </div>
                    <div class="stat-badge">
                        <span class="block text-2xl font-bold font-heading text-text-primary">100%</span>
                        <span class="text-[11px] text-text-muted uppercase font-semibold tracking-wider">Success Rate</span>
                    </div>
                    <div class="stat-badge">
                        <span class="block text-2xl font-bold font-heading text-text-primary">~1 Jam</span>
                        <span class="text-[11px] text-text-muted uppercase font-semibold tracking-wider">Respon Chat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SERVICES TITLE -->
    <div class="mb-8 border-b border-white/8 pb-4">
        <h2 class="text-2xl font-semibold font-heading text-text-primary section-gradient-title">
            🛠️ Jasa Setup yang Ditawarkan
        </h2>
        <p class="text-text-secondary text-sm mt-1">Pilih paket setup yang sesuai dengan kebutuhan streaming atau workspace Anda.</p>
    </div>

    <!-- PACKAGES GRID -->
    @if($teknisi->setupPackages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($teknisi->setupPackages as $package)
                <div class="p-6 glass-card setup-card group">
                    <div>
                        <!-- Package Image -->
                        <div class="w-full h-44 rounded-xl overflow-hidden mb-5 border border-white/5 relative">
                            @if($package->image)
                                <img src="/storage/{{ $package->image }}" alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.06]">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-white/3 to-white/1 flex items-center justify-center text-text-muted text-4xl">
                                    ⚙️
                                </div>
                            @endif
                            <!-- Category Badge -->
                            @if($package->category)
                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-xs font-semibold bg-black/60 backdrop-blur-md text-text-primary border border-white/10 uppercase tracking-wider">
                                    {{ $package->category }}
                                </span>
                            @endif
                        </div>

                        <!-- Package Title -->
                        <h3 class="text-xl font-bold font-heading text-text-primary mb-2 flex items-center gap-2 group-hover:text-primary-premium transition-colors">
                            {{ $package->name }}
                        </h3>

                        <!-- Platforms Tag -->
                        @if($package->platforms)
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach(explode(',', $package->platforms) as $plat)
                                    @if(trim($plat))
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider platform-pill">
                                            {{ trim($plat) }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Description -->
                        <p class="text-text-secondary text-sm leading-relaxed mb-6">
                            {{ $package->description }}
                        </p>
                    </div>

                    <div>
                        <!-- Pricing & Estimation -->
                        <div class="flex justify-between items-end mb-5 pt-4 border-t border-white/5">
                            <div>
                                <span class="text-[10px] text-text-muted uppercase font-bold tracking-wider block">Biaya Jasa</span>
                                <span class="text-2xl font-extrabold font-heading text-primary-premium price-premium">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </span>
                            </div>
                            @if($package->estimation)
                                <div class="text-right">
                                    <span class="text-[10px] text-text-muted uppercase font-bold tracking-wider block">Estimasi</span>
                                    <span class="text-xs font-semibold text-text-secondary">
                                        ⏱️ {{ $package->estimation }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('payment.setup', $package->id) }}" class="btn btn-primary w-full py-3 rounded-xl inline-flex justify-center items-center gap-2">
                            Pesan Layanan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-16 text-center glass-card">
            <span class="text-5xl block mb-4">📭</span>
            <h3 class="text-xl font-bold font-heading text-text-primary mb-2">Belum Ada Paket</h3>
            <p class="text-text-secondary text-sm max-w-md mx-auto">
                Teknisi ini belum menambahkan paket setup yang aktif saat ini. Silakan hubungi admin atau kembali ke dashboard untuk memilih teknisi lainnya.
            </p>
            <a href="{{ route('dashboard.customer') }}" class="btn btn-secondary mt-6 px-6">
                Kembali ke Dashboard
            </a>
        </div>
    @endif
@endsection
