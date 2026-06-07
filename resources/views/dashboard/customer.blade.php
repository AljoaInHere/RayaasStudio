@extends('layouts.premium')

@section('title', 'Dashboard - Raya Studio')

@section('styles')
    <style>
        /* Custom layout adjustments for customer dashboard */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 40px 0;
        }

        .stat-item {
            padding: 25px 20px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            font-family: var(--font-heading);
            color: var(--text-primary);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stat-item span.label {
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Search Section */
        .search-section {
            padding: 30px;
            margin-bottom: 40px;
        }

        .search-form {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            width: 100%;
        }

        .search-form form {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .search-form input {
            flex: 1;
        }

        /* Filter chips */
        .filter-container {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-chip {
            padding: 10px 24px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .filter-chip:hover {
            color: var(--text-primary);
            border-color: var(--border-hover);
            background: rgba(255, 255, 255, 0.05);
        }

        .filter-chip.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 15px var(--primary-soft);
        }

        /* Products list */
        .products-header {
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 20px;
        }

        .product-image-wrapper {
            width: 100%;
            height: 180px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .product-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-wrapper img {
            transform: scale(1.06);
        }

        .product-card h3 {
            font-size: 20px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin: 12px 0 20px 0;
            font-family: var(--font-heading);
        }

        .product-card .btn {
            margin-top: auto !important;
            width: 100% !important;
            position: relative !important;
            bottom: auto !important;
            left: auto !important;
            right: auto !important;
            border-radius: 8px !important;
            padding: 12px 20px !important;
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            .search-form form {
                flex-direction: column;
            }
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 my-10 stats-container">
        <div class="flex flex-col items-center justify-center py-[25px] px-5 text-center text-[28px] font-bold font-heading text-text-primary relative overflow-hidden glass-card stat-item" style="animation-delay: 0.05s;">
            237
            <span class="font-sans text-[13px] font-medium text-text-secondary mt-1 uppercase tracking-[1px] label">Customers</span>
        </div>
        <div class="flex flex-col items-center justify-center py-[25px] px-5 text-center text-[28px] font-bold font-heading text-text-primary relative overflow-hidden glass-card stat-item" style="animation-delay: 0.1s;">
            5
            <span class="font-sans text-[13px] font-medium text-text-secondary mt-1 uppercase tracking-[1px] label">Years</span>
        </div>
        <div class="flex flex-col items-center justify-center py-[25px] px-5 text-center text-[28px] font-bold font-heading text-text-primary relative overflow-hidden glass-card stat-item" style="animation-delay: 0.15s;">
            {{ $products->count() }}
            <span class="font-sans text-[13px] font-medium text-text-secondary mt-1 uppercase tracking-[1px] label">Products</span>
        </div>
        <div class="flex flex-col items-center justify-center py-[25px] px-5 text-center text-[28px] font-bold font-heading text-text-primary relative overflow-hidden glass-card stat-item" style="animation-delay: 0.2s;">
            527
            <span class="font-sans text-[13px] font-medium text-text-secondary mt-1 uppercase tracking-[1px] label">Visitors</span>
        </div>
    </div>

    <!-- SEARCH & FILTER SECTION -->
    <div class="p-[30px] mb-10 glass-card search-section">
        <div class="flex gap-[15px] mb-[25px] w-full search-form">
            <form action="{{ route('dashboard.customer') }}" method="GET" class="flex gap-[15px] w-full">
                <input type="text" name="search" placeholder="Cari overlay, course, atau setup..." value="{{ $search }}" class="flex-1 w-full py-[14px] px-4 bg-white/3 border border-white/8 rounded-premium text-text-primary focus:outline-none focus:border-primary-premium">
                <button type="submit" class="btn btn-primary min-w-[100px]">Cari</button>
            </form>
        </div>

        <!-- FILTER -->
        <div class="flex gap-3 flex-wrap filter-container">
            <a href="{{ route('dashboard.customer') }}" class="py-2.5 px-6 rounded-[30px] border border-white/8 bg-white/2 text-text-secondary no-underline text-sm font-medium transition-all duration-300 hover:text-text-primary hover:border-white/15 hover:bg-white/5 filter-chip {{ !$category ? 'active' : '' }}">All</a>
            <a href="{{ route('dashboard.customer', ['category' => 'digital']) }}" class="py-2.5 px-6 rounded-[30px] border border-white/8 bg-white/2 text-text-secondary no-underline text-sm font-medium transition-all duration-300 hover:text-text-primary hover:border-white/15 hover:bg-white/5 filter-chip {{ $category == 'digital' ? 'active' : '' }}">Digital</a>
            <a href="{{ route('dashboard.customer', ['category' => 'course']) }}" class="py-2.5 px-6 rounded-[30px] border border-white/8 bg-white/2 text-text-secondary no-underline text-sm font-medium transition-all duration-300 hover:text-text-primary hover:border-white/15 hover:bg-white/5 filter-chip {{ $category == 'course' ? 'active' : '' }}">Course</a>
            <a href="{{ route('dashboard.customer', ['category' => 'setup']) }}" class="py-2.5 px-6 rounded-[30px] border border-white/8 bg-white/2 text-text-secondary no-underline text-sm font-medium transition-all duration-300 hover:text-text-primary hover:border-white/15 hover:bg-white/5 filter-chip {{ $category == 'setup' ? 'active' : '' }}">Setup</a>
        </div>
    </div>

    <!-- PRODUCTS SECTION -->
    <div class="mb-6 border-b border-white/8 pb-4 products-header" id="products">
        <h2 class="text-2xl font-semibold font-heading text-text-primary">{{ $category ? ucfirst($category) . ' Products' : 'All Products' }}</h2>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[30px] product-grid">
            @foreach($products as $product)
                <div class="flex flex-col h-full p-5 glass-card product-card group">
                    <div class="w-full h-[180px] rounded-lg overflow-hidden mb-5 border border-white/5 product-image-wrapper">
                        @if($product->image)
                            <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.06]">
                        @else
                            <img src="https://via.placeholder.com/250x160?text={{ $product->is_setup ? 'Setup' : 'Product' }}" alt="Default" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.06]">
                        @endif
                    </div>
                    
                    <h3 class="text-xl mb-2 flex items-center gap-2 font-heading font-semibold text-text-primary">{{ $product->icon ?? '' }} {{ $product->name }}</h3>
                    <div class="text-lg font-bold text-primary-premium my-3 font-heading product-price">
                        <span class="price-premium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ $product->is_setup ? route('payment.setup', $product->id) : route('payment.product', $product->id) }}" class="btn btn-primary mt-auto! w-full! relative! bottom-auto! left-auto! right-auto! rounded-lg! py-3! px-5! inline-flex! justify-center! items-center!">Beli</a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="glass-card" style="text-align: center; padding: 60px; color: var(--text-secondary);">
            <p>Produk tidak ditemukan</p>
        </div>
    @endif
@endsection

@section('scripts')
<script>
(function normalizeCategoryUrl() {
    var params = new URLSearchParams(window.location.search);
    var category = params.get('category');
    if (category && category.startsWith('?category=')) {
        params.set('category', category.replace('?category=', ''));
        var newUrl = window.location.pathname + '?' + params.toString() + window.location.hash;
        history.replaceState(null, '', newUrl);
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    function initSlidingPill(containerSelector, itemSelector) {
        const containers = document.querySelectorAll(containerSelector);
        containers.forEach(container => {
            let pill = container.querySelector('.sliding-pill-indicator');
            if (!pill) {
                pill = document.createElement('div');
                pill.className = 'sliding-pill-indicator';
                container.appendChild(pill);
            }
            const items = container.querySelectorAll(itemSelector);
            function updatePill(target) {
                if (!target) { pill.style.opacity = '0'; return; }
                pill.style.opacity = '1';
                const containerRect = container.getBoundingClientRect();
                const targetRect = target.getBoundingClientRect();
                const left = targetRect.left - containerRect.left + container.scrollLeft;
                const top = targetRect.top - containerRect.top + container.scrollTop;
                pill.style.left = left + 'px';
                pill.style.width = targetRect.width + 'px';
                pill.style.top = top + 'px';
                pill.style.height = targetRect.height + 'px';
                pill.style.borderRadius = window.getComputedStyle(target).borderRadius;
            }
            function getActive() {
                return container.querySelector(itemSelector + '.active');
            }
            setTimeout(() => { updatePill(getActive()); }, 200);
            items.forEach(item => {
                item.addEventListener('mouseenter', () => updatePill(item));
            });
            container.addEventListener('mouseleave', () => updatePill(getActive()));
            window.addEventListener('resize', () => updatePill(getActive()));
        });
    }
    initSlidingPill('.filter-container', '.filter-chip');
});
</script>
@endsection
