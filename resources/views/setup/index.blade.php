@extends('layouts.premium')

@section('title', 'Setup Package - Raya Studio')

@section('styles')
    <style>
        .page-title {
            text-align: center;
            margin: 20px 0 40px 0;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-wrapper {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .package-card {
            padding: 35px 30px;
            width: 300px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: 380px;
        }

        .package-card h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .package-card p {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .price-tag {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            font-family: var(--font-heading);
            margin-bottom: 30px;
            text-shadow: 0 0 10px var(--primary-soft);
        }

        .package-card .btn {
            width: 100%;
            margin-top: auto;
        }

        .back-button {
            margin-bottom: 30px;
        }

        .back-button a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-button a:hover {
            color: #b372f9;
            transform: translateX(-3px);
        }
    </style>
@endsection

@section('content')
    <div class="mb-[30px] back-button">
        <a href="{{ route('dashboard.customer') }}" class="text-primary-premium no-underline font-semibold text-[15px] transition-all hover:text-[#b372f9] hover:-translate-x-1 inline-flex items-center gap-1.5">← Kembali ke Dashboard</a>
    </div>

    <h2 class="text-center mt-5 mb-10 bg-gradient-to-r from-white to-primary-premium bg-clip-text text-transparent page-title">💎 Pilih Setup Package</h2>

    <div class="flex gap-[30px] justify-center flex-wrap card-wrapper">
        @forelse($packages as $package)
            <div class="p-5 w-[300px] text-center flex flex-col justify-between items-center min-h-[380px] glass-card package-card">
                <div class="product-image-wrapper" style="width: 100%; height: 160px; border-radius: 8px; overflow: hidden; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05);">
                    @if($package->image)
                        <img src="/storage/{{ $package->image }}" alt="{{ $package->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/250x160?text=Setup" alt="Default" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div>
                    <h3>{{ $package->name }}</h3>
                    <p>{{ $package->description }}</p>
                </div>
                <div>
                    <div class="price-tag">
                        <span class="price-premium">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('payment.setup', $package->id) }}" class="btn btn-primary">
                        Pilih {{ $package->name }}
                    </a>
                </div>
            </div>
        @empty
            <div class="glass-card" style="width: 100%; text-align: center; padding: 60px; color: var(--text-secondary);">
                <p>Paket setup tidak tersedia</p>
            </div>
        @endforelse
    </div>
@endsection
