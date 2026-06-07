@extends('layouts.app')

@section('content')
<div class="card">
    <h2>{{ $product->name }}</h2>
    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" style="width:400px; border-radius:8px;">
    @endif
    <p>{{ $product->description }}</p>
    <p><strong>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
    <p>Kategori: {{ $product->category }}</p>

    @auth
    <h3>Form Pemesanan</h3>
    <form method="POST" action="/orders">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div style="margin-bottom:10px;">
            <label>Nama Lengkap:</label><br>
            <input type="text" name="nama" style="width:100%; padding:8px;" required>
        </div>
        <div style="margin-bottom:10px;">
            <label>Metode Pembayaran:</label><br>
            <select name="metode" style="width:100%; padding:8px;">
                <option value="qris">QRIS</option>
                <option value="transfer">Transfer Bank</option>
                <option value="tunai">Tunai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Pesan Sekarang</button>
    </form>
    @else
        <p><a href="/login" class="btn btn-primary">Login untuk memesan</a></p>
    @endauth
</div>
@endsection