<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data uji coba budi lama jika ada agar tidak duplikat
        DB::table('users')->where('email', 'budi@rayastudio.com')->delete();

        // 1. Buat User dengan role 'mitra' langsung menggunakan DB Query (menghindari double-hashing dari Eloquent casts)
        $mitraId = DB::table('users')->insertGetId([
            'name' => 'Budi Setup Pro',
            'username' => 'budisetup',
            'email' => 'budi@rayastudio.com',
            'password' => Hash::make('password123'),
            'role' => 'mitra',
            'bio' => 'Spesialis setup workspace gaming, podcast, dan live streaming profesional. Pengalaman lebih dari 5 tahun.',
            'skills' => 'OBS, vMix, Soundcard, Cable Management, 3D Design',
            'social_links' => json_encode([
                'instagram' => 'https://instagram.com/budisetup',
                'tiktok' => 'https://tiktok.com/@budisetup'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Hapus paket lama budi
        DB::table('setup_packages')->where('user_id', $mitraId)->delete();

        // 2. Buat Paket Setup untuk Mitra ini
        DB::table('setup_packages')->insert([
            [
                'user_id' => $mitraId,
                'name' => 'Setup Podcast Standard',
                'description' => 'Konfigurasi audio mixer, setup OBS 2 kamera, dan panduan dasar rekaman podcast.',
                'price' => 350000,
                'estimation' => '2 Jam',
                'category' => 'PODCAST',
                'platforms' => 'Youtube, Spotify',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $mitraId,
                'name' => 'Setup Streamer Premium',
                'description' => 'Optimasi full stream setup (Dual PC), custom OBS overlay, alert setup, audio routing (Voicemeeter), dan setting hardware.',
                'price' => 750000,
                'estimation' => '4 Jam',
                'category' => 'STREAMING',
                'platforms' => 'Twitch, Youtube, TikTok',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Hapus portofolio lama budi
        DB::table('portfolios')->where('user_id', $mitraId)->delete();

        // 3. Buat Portofolio untuk Mitra ini
        DB::table('portfolios')->insert([
            [
                'user_id' => $mitraId,
                'title' => 'Minimalist Workspace Setup v1',
                'client_name' => 'Andi Wijaya',
                'description' => 'Merapikan kabel (cable management) dan konfigurasi pencahayaan pintar untuk produktivitas.',
                'image_after' => 'portfolios/marpthon.avif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $mitraId,
                'title' => 'Setup Studio Podcast Deddy',
                'client_name' => 'Deddy C.',
                'description' => 'Setup audio routing mixer Rodecaster Pro II dan konfigurasi output multi-kamera.',
                'image_after' => 'portfolios/dedycorbuzier.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
