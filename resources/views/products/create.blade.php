@extends('layouts.premium')

@section('title', 'Tambah Produk - Raya Studio')

@section('content')
<div style="max-width: 650px; margin: 40px auto 60px auto;">
    <div class="glass-card" style="padding: 40px 35px;">
        <h1 style="font-family: var(--font-heading); font-size: 28px; font-weight: 700; margin-bottom: 25px; background: linear-gradient(135deg, #fff 30%, var(--primary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">✨ Tambah Produk Baru</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <strong style="display: block; margin-bottom: 5px;">Terjadi kesalahan:</strong>
                <ul style="list-style: inside; font-size: 14px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" style="margin-top: 10px;">
            @csrf

            <div class="field">
                <label for="name">Nama Produk *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Overlay Pack Cute Sakura" required>
                @error('name')<span style="color: #f87171; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="Tulis deskripsi detail produk...">{{ old('description') }}</textarea>
            </div>

            <div class="field">
                <label for="price">Harga (Rp) *</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="Contoh: 150000" required>
                @error('price')<span style="color: #f87171; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label for="category">Kategori *</label>
                <select id="category" name="category" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="digital" {{ old('category') == 'digital' ? 'selected' : '' }}>Digital Product</option>
                    <option value="course" {{ old('category') == 'course' ? 'selected' : '' }}>Course</option>
                </select>
                @error('category')<span style="color: #f87171; font-size: 12px; display: block; margin-top: 5px;">{{ $message }}</span>@enderror
            </div>

            <div class="field" style="margin-bottom: 30px;">
                <label for="image">Gambar Produk</label>
                <input type="file" id="image" name="image" accept="image/*" style="padding: 10px;">
            </div>

            <div class="form-actions" style="display: flex; gap: 15px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection