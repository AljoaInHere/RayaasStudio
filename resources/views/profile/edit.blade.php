@extends('layouts.premium')

@section('title', 'Edit Profil - Raya Studio')

@section('styles')
    <style>
        .edit-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
        }

        .edit-container h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .form-actions button,
        .form-actions a {
            flex: 1;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="edit-container glass-card">
        <h1>Edit Profil</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="profile_photo">Foto Profil</label>
                <input id="profile_photo" type="file" name="profile_photo" accept="image/*">
                @if($user->profile_photo)
                    <div style="margin-top: 10px; font-size: 13px; color: var(--text-secondary);">
                        Foto Saat Ini: <a href="/storage/{{ $user->profile_photo }}" target="_blank" style="color: var(--primary);">Lihat Foto</a>
                    </div>
                @endif
            </div>

            <div class="field">
                <label for="bio">Bio / Deskripsi Singkat</label>
                <textarea id="bio" name="bio" rows="3" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="field">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
