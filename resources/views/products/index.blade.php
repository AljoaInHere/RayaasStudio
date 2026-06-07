@extends('layouts.premium')

@section('title', 'Product Management - Raya Studio')

@section('styles')
    <style>
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .header-section h1 {
            margin-bottom: 0;
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .product-actions .btn {
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            .header-section .btn {
                width: 100%;
            }
            .product-actions {
                flex-direction: column;
                width: 100%;
            }
            .product-actions form,
            .product-actions a {
                width: 100%;
            }
            .product-actions .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="header-section">
        <h1>Kelola Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
        @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                                @else
                                    <span style="color: var(--text-muted); font-size: 12px;">No Image</span>
                                @endif
                            </td>
                            <td style="font-weight: 600;">{{ $product->name }}</td>
                            <td>
                                <span class="status-badge status-paid" style="background: rgba(157, 78, 221, 0.15); color: #c77dff; border-color: rgba(157, 78, 221, 0.3);">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </td>
                            <td style="font-family: var(--font-heading); font-weight: 600; color: var(--primary);">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td style="color: var(--text-secondary);">{{ Str::limit($product->description, 50) }}</td>
                            <td>
                                <div class="product-actions">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 60px; color: var(--text-secondary);">
                <h3>📭 Belum Ada Produk</h3>
                <p style="margin-top: 5px; font-size: 14px;">Mulai dengan menambah produk baru</p>
            </div>
        @endif
    </div>
@endsection