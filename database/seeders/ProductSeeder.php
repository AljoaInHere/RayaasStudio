<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Live Streaming Basic',
                'description' => 'Pelajari dasar-dasar live streaming dari nol hingga mahir.',
                'price' => 40000,
                'category' => 'course',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Streaming Production',
                'description' => 'Kelas ini ditujukan untuk meningkatkan kualitas live streaming kamu.',
                'price' => 50000,
                'category' => 'course',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Overlay Pack - Neon Purple',
                'description' => 'Paket overlay stream bertema neon purple. Cocok untuk gaming.',
                'price' => 75000,
                'category' => 'digital',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Setup VIP',
                'description' => 'Paket setup streaming lengkap untuk pemula.',
                'price' => 100000,
                'category' => 'setup',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bersiaplah',
                'description' => 'Siap berkarya bersama Raya Studio.',
                'price' => 300000,
                'category' => 'digital',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}