@extends('layouts.premium')

@section('title', 'Profil Saya - Raya Studio')

@section('styles')
    <style>
        .profile-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            overflow: hidden;
            border: 2px solid var(--primary);
            box-shadow: 0 0 20px var(--primary-soft);
            margin-bottom: 20px;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .profile-info .email {
            color: var(--primary);
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .profile-info .bio {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
            max-width: 400px;
            margin: auto;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .actions a {
            flex: 1;
            text-decoration: none;
        }

        .actions button {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="profile-container glass-card">
        <div class="profile-header">
            <div class="avatar">
                @if($user->profile_photo)
                    <img src="/storage/{{ $user->profile_photo }}" alt="Avatar">
                @else
                    <img src="https://via.placeholder.com/100?text=User" alt="Avatar">
                @endif
            </div>
            <div class="profile-info">
                <h1>{{ $user->username }}</h1>
                <p class="email">{{ $user->email }}</p>
                <p class="bio">{{ $user->bio ?? 'Belum ada bio' }}</p>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('profile.edit') }}">
                <button class="btn btn-primary">Edit Profil</button>
            </a>
            <a href="{{ strtolower(trim(Auth::user()->role)) == 'mitra' ? route('dashboard.mitra') : route('dashboard.customer') }}">
                <button class="btn btn-secondary">Kembali</button>
            </a>
        </div>
    </div>
@endsection
