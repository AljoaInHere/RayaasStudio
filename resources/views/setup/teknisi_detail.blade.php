@extends('layouts.premium')

@section('title', 'Profil Teknisi - ' . $teknisi->username . ' - Raya Studio')

@section('styles')
    <style>
        .profile-hero-compact {
            background: linear-gradient(135deg, rgba(18, 18, 37, 0.4) 0%, rgba(25, 15, 45, 0.2) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 10px rgba(157, 78, 221, 0.05);
        }

        .avatar-glow-compact {
            position: relative;
            width: 96px; /* w-24 */
            height: 96px; /* h-24 */
            border-radius: 50%;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid var(--primary-premium);
            padding: 2px;
        }

        .avatar-glow-compact img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-glow-compact::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent-cyan) 100%);
            z-index: -1;
            opacity: 0.5;
            filter: blur(8px);
            transition: var(--transition-smooth);
        }

        .glow-badge {
            background: rgba(157, 78, 221, 0.1);
            border: 1px solid rgba(157, 78, 221, 0.25);
            color: #d8b4fe;
            box-shadow: 0 0 8px rgba(157, 78, 221, 0.15);
        }

        .portfolio-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .portfolio-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4), 0 0 15px rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .setup-card-compact {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            transition: var(--transition-smooth);
        }

        .setup-card-compact:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }
    </style>
@endsection

@section('content')
    <!-- BACK BUTTON -->
    <div class="mb-6">
        <a href="{{ route('dashboard.customer') }}" class="text-text-secondary no-underline font-medium text-sm transition-all hover:text-primary-premium inline-flex items-center gap-1.5">
            ← Kembali
        </a>
    </div>

    <!-- PROFILE HERO SECTION (COMPACT) -->
    <div class="p-8 mb-10 profile-hero-compact text-center max-w-3xl mx-auto">
        <!-- Avatar -->
        <div class="avatar-glow-compact mb-4">
            @if($teknisi->profile_photo)
                <img src="/storage/{{ $teknisi->profile_photo }}" alt="{{ $teknisi->username }}">
            @else
                <div class="w-full h-full flex items-center justify-center text-3xl bg-white/5 rounded-full">👨‍🔧</div>
            @endif
        </div>

        <!-- Name & Badge -->
        <div class="flex items-center justify-center gap-2 mb-2">
            <h1 class="text-2xl font-bold font-heading text-text-primary">{{ $teknisi->username }}</h1>
            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>

        <!-- Bio -->
        <p class="text-text-secondary text-sm leading-relaxed mb-5 max-w-xl mx-auto">
            {{ $teknisi->bio ?: 'Profesional Setup & Konfigurasi Workspace. Siap membantu kebutuhan instalasi dan optimasi sistem Anda.' }}
        </p>

        <!-- Skills & Social Links -->
        <div class="flex flex-col items-center gap-4">
            @if($teknisi->skills)
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach(explode(',', $teknisi->skills) as $skill)
                        @if(trim($skill))
                            <span class="px-3 py-1 bg-primary-soft/10 text-primary-premium rounded-full text-xs font-semibold uppercase tracking-wider glow-badge">
                                {{ trim($skill) }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @endif

            @if($teknisi->social_links)
                <div class="flex items-center justify-center gap-3">
                    @php $socials = json_decode($teknisi->social_links, true); @endphp
                    @if(isset($socials['instagram']))
                        <a href="{{ $socials['instagram'] }}" target="_blank" class="text-text-muted hover:text-pink-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if(isset($socials['tiktok']))
                        <a href="{{ $socials['tiktok'] }}" target="_blank" class="text-text-muted hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- PORTFOLIO SECTION -->
    @if($teknisi->portfolios && $teknisi->portfolios->count() > 0)
        <div class="mb-14">
            <h2 class="text-xl font-bold font-heading text-text-primary mb-6 flex items-center gap-2">
                <span>🎨</span> Portofolio & Hasil Setup
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($teknisi->portfolios as $portfolio)
                    <div class="portfolio-card group">
                        <div class="w-full h-48 overflow-hidden relative bg-black/50">
                            @if($portfolio->image_after)
                                <img src="/storage/{{ $portfolio->image_after }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-text-muted">No Image</div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-white font-bold text-lg leading-tight">{{ $portfolio->title }}</h3>
                                @if($portfolio->client_name)
                                    <p class="text-white/70 text-xs mt-1">Klien: {{ $portfolio->client_name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- SERVICES SECTION -->
    <div class="mb-8 border-b border-white/5 pb-4 flex items-center justify-between">
        <h2 class="text-xl font-bold font-heading text-text-primary flex items-center gap-2">
            <span>💼</span> Layanan Tersedia
        </h2>
    </div>

    <!-- PACKAGES GRID (COMPACT) -->
    @if($teknisi->setupPackages->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-12">
            @foreach($teknisi->setupPackages as $package)
                <div class="p-5 glass-card setup-card-compact flex flex-col sm:flex-row gap-5 items-center sm:items-start group">
                    <!-- Package Image (Smaller) -->
                    <div class="w-full sm:w-32 h-32 rounded-xl overflow-hidden shrink-0 relative bg-black/40">
                        @if($package->image)
                            <img src="/storage/{{ $package->image }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl border border-white/10 rounded-xl">⚙️</div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex-grow w-full flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-lg font-bold font-heading text-text-primary leading-tight group-hover:text-primary-premium transition-colors mb-2">
                                {{ $package->name }}
                            </h3>
                            <p class="text-text-secondary text-xs line-clamp-2 mb-4">
                                {{ $package->description }}
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-lg font-extrabold font-heading text-primary-premium">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('payment.setup', $package->id) }}" class="px-5 py-2.5 bg-primary-premium hover:bg-[#b372f9] text-white text-xs font-bold rounded-lg transition-colors inline-flex items-center gap-2">
                                Pesan Layanan
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-10 text-center glass-card setup-card-compact">
            <span class="text-4xl block mb-3">📭</span>
            <h3 class="text-lg font-bold font-heading text-text-primary mb-1">Belum Ada Layanan</h3>
            <p class="text-text-secondary text-sm">Teknisi belum menambahkan paket jasa yang aktif.</p>
        </div>
    @endif
@endsection
