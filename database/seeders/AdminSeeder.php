<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // PENTING: Ganti password ini setelah deployment!
        // Password default hanya untuk setup awal
        User::firstOrCreate(
            ['email' => 'admin@gunungsari.id'],
            [
                'name' => 'Admin Kelurahan',
                'password' => Hash::make('Gunungsari@2025!Secure'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}
