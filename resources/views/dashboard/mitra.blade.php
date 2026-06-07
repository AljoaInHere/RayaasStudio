@extends('layouts.premium')

@section('title', 'Dashboard Mitra - Raya Studio')

@section('styles')
    <style>
        /* Custom layout adjustments for mitra dashboard */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0 40px 0;
        }

        .stat-card {
            padding: 25px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin-top: 10px;
            font-family: var(--font-heading);
            text-shadow: 0 0 15px var(--primary-soft);
        }

        .stat-card p {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .dashboard-header {
            padding: 30px;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            margin-bottom: 8px;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-header p {
            color: var(--text-secondary);
            font-size: 15px;
        }

        /* Tabs Menu */
        .tabs-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            padding: 10px 24px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .tab-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.03);
        }

        .tab-btn.active {
            color: white;
            background: var(--primary);
            box-shadow: 0 4px 15px var(--primary-soft);
        }

        /* Services Tab Styles */
        .tab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .tab-header h2 {
            font-size: 24px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 25px;
        }

        .service-card {
            padding: 25px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .service-card h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .service-category {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .service-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
            font-family: var(--font-heading);
        }

        .service-details {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .service-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
            width: 100%;
        }

        .service-actions .btn {
            flex: 1;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Modals */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(4, 4, 8, 0.85);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            width: 100%;
            max-width: 550px;
            padding: 35px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-secondary);
            cursor: pointer;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: var(--text-primary);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .detail-label {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .table-actions .btn {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            .table-actions {
                flex-direction: column;
                width: 100%;
            }
            .table-actions form,
            .table-actions button {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- HEADER -->
    <div class="dashboard-header glass-card">
        <h1>🎬 Dashboard Mitra Raya Studio</h1>
        <p>Kelola produk, jasa setup, dan pesanan Anda di sini</p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 my-[30px] mb-[40px] stats-container">
        <div class="py-[25px] px-5 text-center flex flex-col items-center justify-center glass-card stat-card">
            <p class="text-[13px] uppercase tracking-[1px] text-text-secondary font-medium mb-1">Total Pesanan</p>
            <h3 class="text-[32px] font-bold text-primary-premium font-heading mt-2">{{ $orders->count() }}</h3>
        </div>
        <div class="py-[25px] px-5 text-center flex flex-col items-center justify-center glass-card stat-card">
            <p class="text-[13px] uppercase tracking-[1px] text-text-secondary font-medium mb-1">Pesanan Selesai</p>
            <h3 class="text-[32px] font-bold text-primary-premium font-heading mt-2">{{ $orders->where('status', 'completed')->count() }}</h3>
        </div>
        <div class="py-[25px] px-5 text-center flex flex-col items-center justify-center glass-card stat-card">
            <p class="text-[13px] uppercase tracking-[1px] text-text-secondary font-medium mb-1">Total Pendapatan</p>
            <h3 class="text-[32px] font-bold text-primary-premium font-heading mt-2">Rp {{ number_format($orders->where('status', 'completed')->sum('harga'), 0, ',', '.') }}</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- TABS MENU -->
    <div class="flex gap-[15px] mb-[30px] border-b border-white/8 pb-3 tabs-container">
        <button class="tab-btn active" id="btn-orders" onclick="switchTab('orders-tab', 'btn-orders')">📥 Kelola Order Masuk</button>
        <button class="tab-btn" id="btn-services" onclick="switchTab('services-tab', 'btn-services')">💎 Kelola Jasa Setup</button>
    </div>

    <!-- TAB: ORDERS -->
    <div id="orders-tab" class="tab-content animate-fade-up">
        <div class="table-wrapper">
            <div class="tab-header" style="padding: 20px 24px 0 24px; margin-bottom: 0;">
                <h2>Daftar Order Masuk</h2>
            </div>
            @if($orders->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Pelanggan</th>
                            <th>Platform</th>
                            <th>Keluhan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td style="font-weight: 600;">{{ $order->user->username ?? 'Unknown' }}</td>
                                <td>
                                    <span class="status-badge" style="background: rgba(0, 240, 255, 0.1); color: var(--accent-cyan); border: 1px solid rgba(0, 240, 255, 0.25);">
                                        {{ $order->platform ?? 'N/A' }}
                                    </span>
                                </td>
                                <td style="color: var(--text-secondary);">{{ Str::limit($order->keluhan, 40) ?? 'Tidak ada keluhan.' }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button class="btn btn-secondary" onclick="openOrderDetailModal({{ json_encode($order) }})">Detail</button>
                                        
                                        @if($order->status == 'pending')
                                            <form action="{{ route('admin.orders.accept', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" style="background: #10b981;">Accept</button>
                                            </form>
                                            <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                        @elseif($order->status == 'accepted')
                                            <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Complete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Orders Pagination -->
                <div class="pagination-container" style="padding: 10px 24px;">
                    {{ $orders->appends(request()->except('orders_page'))->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div style="text-align: center; padding: 60px; color: var(--text-secondary);">
                    <h3>📭 Belum ada pesanan masuk</h3>
                    <p style="margin-top: 5px; font-size: 14px;">Pesanan dari pelanggan akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- TAB: SERVICES -->
    <div id="services-tab" class="tab-content animate-fade-up" style="display: none;">
        <div class="tab-header">
            <h2>Jasa Setup Saya</h2>
            <button class="btn btn-primary" onclick="openAddServiceModal()">+ Add Setup Service</button>
        </div>

        @if($services->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 services-grid">
                @foreach($services as $service)
                    <div class="p-6 flex flex-col h-full glass-card service-card">
                        <div class="product-image-wrapper" style="width: 100%; height: 160px; border-radius: 8px; overflow: hidden; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05);">
                            @if($service->image)
                                <img src="/storage/{{ $service->image }}" alt="{{ $service->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/250x160?text=No+Image" alt="Default" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <span class="text-[12px] font-semibold text-primary-premium uppercase tracking-[0.5px] mb-3 service-category">{{ $service->category }}</span>
                        <h3 class="text-[22px] font-bold mb-2 text-text-primary">{{ $service->name }}</h3>
                        <div class="text-[20px] font-bold text-text-primary mb-[15px] font-heading service-price">
                            <span class="price-premium">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="text-[13px] text-text-secondary mb-5 flex flex-col gap-2 service-details">
                            <div><strong>Estimasi:</strong> {{ $service->estimation ?? 'N/A' }}</div>
                            <div><strong>Platform:</strong> {{ $service->platforms ?? 'N/A' }}</div>
                            <div>
                                <strong>Status:</strong> 
                                <span class="status-badge" style="background: {{ $service->status == 'Active' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $service->status == 'Active' ? '#34d399' : '#f87171' }}; border: 1px solid {{ $service->status == 'Active' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' }}; font-size: 10px; padding: 2px 8px;">
                                    {{ $service->status }}
                                </span>
                            </div>
                        </div>

                        <div class="service-actions">
                            <button class="btn btn-secondary" onclick="openEditServiceModal({{ json_encode($service) }})">Edit</button>
                            <form action="{{ route('admin.setup-services.destroy', $service->id) }}" method="POST" style="display:inline; flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus jasa setup ini?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Services Pagination -->
            <div class="pagination-container" style="padding: 10px 0;">
                {{ $services->appends(request()->except('services_page'))->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="glass-card" style="text-align: center; padding: 65px; color: var(--text-secondary);">
                <h3>📭 Belum ada jasa setup</h3>
                <p style="margin-top: 5px; font-size: 14px; margin-bottom: 20px;">Tawarkan jasa setup Anda ke pelanggan dengan menambah jasa baru.</p>
                <button class="btn btn-primary" onclick="openAddServiceModal()">+ Tambah Jasa Pertama</button>
            </div>
        @endif
    </div>

    <!-- MODAL: ADD/EDIT SERVICE -->
    <div id="serviceModal" class="modal">
        <div class="modal-content glass-card animate-fade-up">
            <span class="close-btn" onclick="closeServiceModal()">&times;</span>
            <h2 id="modalTitle">Tambah Jasa Setup</h2>
            <form id="serviceForm" method="POST" action="{{ route('admin.setup-services.store') }}" enctype="multipart/form-data" style="margin-top: 20px;">
                @csrf
                <input type="hidden" id="serviceMethod" name="_method" value="POST">
                
                <div class="field">
                    <label for="name">Nama Jasa *</label>
                    <input type="text" id="name" name="name" required placeholder="Contoh: Premium Audio Streaming Config">
                </div>
                
                <div class="field">
                    <label for="category">Kategori *</label>
                    <select id="category" name="category" required>
                        <option value="OBS Setup">OBS Setup</option>
                        <option value="TikTok Live Setup">TikTok Live Setup</option>
                        <option value="YouTube Streaming Setup">YouTube Streaming Setup</option>
                        <option value="Audio Setup">Audio Setup</option>
                        <option value="Overlay Setup">Overlay Setup</option>
                    </select>
                </div>
                
                <div class="field">
                    <label for="price">Harga (Rp) *</label>
                    <input type="number" id="price" name="price" required placeholder="Contoh: 150000">
                </div>

                <div class="field">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" placeholder="Tulis rincian jasa setup..."></textarea>
                </div>

                <div class="field">
                    <label for="estimation">Estimasi Pengerjaan</label>
                    <input type="text" id="estimation" name="estimation" placeholder="Contoh: 1-2 Hari">
                </div>

                <div class="field">
                    <label>Platform yang Didukung</label>
                    <div style="display: flex; gap: 20px; margin-top: 8px;">
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; font-weight: 500; font-size: 14px;">
                            <input type="checkbox" name="platforms[]" value="TikTok" style="width: auto;"> TikTok
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; font-weight: 500; font-size: 14px;">
                            <input type="checkbox" name="platforms[]" value="YouTube" style="width: auto;"> YouTube
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; font-weight: 500; font-size: 14px;">
                            <input type="checkbox" name="platforms[]" value="Twitch" style="width: auto;"> Twitch
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label for="image">Gambar Jasa *</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small id="imageHelp" style="color: var(--text-secondary); font-size: 12px; display: block; margin-top: 5px;"></small>
                </div>

                <div class="field">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px;">Save Service</button>
            </form>
        </div>
    </div>

    <!-- MODAL: ORDER DETAIL -->
    <div id="orderDetailModal" class="modal">
        <div class="modal-content glass-card animate-fade-up" style="max-width: 500px;">
            <span class="close-btn" onclick="closeOrderDetailModal()">&times;</span>
            <h2>Detail Order</h2>
            <div style="margin-top: 25px;">
                <div class="detail-row">
                    <span class="detail-label">Order ID</span>
                    <span class="detail-value" id="detailId"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Customer</span>
                    <span class="detail-value" id="detailCustomer"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Produk / Jasa</span>
                    <span class="detail-value" id="detailProduct"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Platform</span>
                    <span class="detail-value" id="detailPlatform"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Order</span>
                    <span class="detail-value" id="detailDate"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Metode Pembayaran</span>
                    <span class="detail-value" id="detailMethod"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Harga</span>
                    <span class="detail-value" id="detailPrice" style="color: var(--primary); font-weight: 700;"></span>
                </div>
                <div class="detail-row" style="flex-direction: column; align-items: flex-start; gap: 8px;">
                    <span class="detail-label">Keluhan / Catatan Khusus</span>
                    <div class="detail-value" id="detailComplaint" style="background: rgba(255,255,255,0.01); border: 1px solid var(--border-color); padding: 12px; border-radius: 8px; width: 100%; white-space: pre-wrap; line-height: 1.5; font-size: 13px; color: var(--text-secondary);"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function switchTab(tabId, btnId) {
    document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(tabId).style.display = 'block';
    document.getElementById(btnId).classList.add('active');
}

function openAddServiceModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Jasa Setup';
    document.getElementById('serviceForm').action = "{{ route('admin.setup-services.store') }}";
    document.getElementById('serviceMethod').value = 'POST';
    document.getElementById('name').value = '';
    document.getElementById('category').value = 'OBS Setup';
    document.getElementById('price').value = '';
    document.getElementById('description').value = '';
    document.getElementById('estimation').value = '';
    document.querySelectorAll('input[name="platforms[]"]').forEach(el => el.checked = false);
    document.getElementById('status').value = 'Active';
    document.getElementById('image').value = '';
    document.getElementById('image').required = true;
    document.getElementById('imageHelp').innerText = 'Wajib upload gambar untuk jasa baru.';
    document.getElementById('serviceModal').style.display = 'flex';
}

function openEditServiceModal(service) {
    document.getElementById('modalTitle').innerText = 'Edit Jasa Setup';
    document.getElementById('serviceForm').action = "/admin/setup-services/" + service.id;
    document.getElementById('serviceMethod').value = 'PUT';
    document.getElementById('name').value = service.name;
    document.getElementById('category').value = service.category;
    document.getElementById('price').value = service.price;
    document.getElementById('description').value = service.description || '';
    document.getElementById('estimation').value = service.estimation || '';
    
    // Checkboxes platforms
    var platforms = service.platforms ? service.platforms.split(',') : [];
    document.querySelectorAll('input[name="platforms[]"]').forEach(el => {
        el.checked = platforms.includes(el.value);
    });
    
    document.getElementById('status').value = service.status;
    document.getElementById('image').value = '';
    document.getElementById('image').required = false;
    if (service.image) {
        document.getElementById('imageHelp').innerHTML = 'Gambar saat ini: <a href="/storage/' + service.image + '" target="_blank" style="color: var(--primary); font-weight: 600;">Lihat Gambar</a>. Biarkan kosong jika tidak ingin diubah.';
    } else {
        document.getElementById('imageHelp').innerText = 'Biarkan kosong jika tidak ingin mengubah gambar.';
    }
    document.getElementById('serviceModal').style.display = 'flex';
}

function closeServiceModal() {
    document.getElementById('serviceModal').style.display = 'none';
}

function openOrderDetailModal(order) {
    document.getElementById('detailId').innerText = '#' + order.id;
    document.getElementById('detailCustomer').innerText = order.user ? order.user.username : 'Unknown';
    document.getElementById('detailProduct').innerText = order.product ? order.product.name : (order.paket || 'Unknown Product');
    document.getElementById('detailPlatform').innerText = order.platform || 'N/A';
    
    // Format Date
    var rawDate = new Date(order.created_at);
    var options = { day: 'numeric', month: 'short', year: 'numeric' };
    document.getElementById('detailDate').innerText = rawDate.toLocaleDateString('id-ID', options);
    
    document.getElementById('detailMethod').innerText = (order.metode || 'N/A').toUpperCase();
    document.getElementById('detailPrice').innerText = 'Rp ' + Number(order.harga).toLocaleString('id-ID');
    document.getElementById('detailComplaint').innerText = order.keluhan || 'Tidak ada keluhan khusus.';
    document.getElementById('orderDetailModal').style.display = 'flex';
}

function closeOrderDetailModal() {
    document.getElementById('orderDetailModal').style.display = 'none';
}

// Close modals on clicking outside content
window.onclick = function(event) {
    var serviceModal = document.getElementById('serviceModal');
    var orderModal = document.getElementById('orderDetailModal');
    if (event.target == serviceModal) {
        closeServiceModal();
    }
    if (event.target == orderModal) {
        closeOrderDetailModal();
    }
}

// Auto-switch to services tab if we paginated services
window.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('services_page')) {
        switchTab('services-tab', 'btn-services');
    }
});

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
    initSlidingPill('.tabs-container', '.tab-btn');
});
</script>
@endsection
