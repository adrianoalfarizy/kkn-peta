<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing admin user
        User::where('email', 'admin@gunungsari.id')->update([
            'role' => 'super_admin',
            'phone' => '081234567890',
            'address' => 'Kantor Desa Gunungsari',
            'is_active' => true,
        ]);

        // Create demo users for different roles
        $users = [
            [
                'name' => 'Kepala Desa',
                'email' => 'kades@gunungsari.id',
                'password' => Hash::make('password123'),
                'role' => 'admin_desa',
                'phone' => '081234567891',
                'address' => 'Kantor Desa Gunungsari',
                'is_active' => true,
            ],
            [
                'name' => 'Operator Desa',
                'email' => 'operator@gunungsari.id',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'phone' => '081234567892',
                'address' => 'Kantor Desa Gunungsari',
                'is_active' => true,
            ],
            [
                'name' => 'Ketua RT 01',
                'email' => 'rt01@gunungsari.id',
                'password' => Hash::make('password123'),
                'role' => 'rt_rw',
                'phone' => '081234567893',
                'address' => 'RT 01 Desa Gunungsari',
                'is_active' => true,
            ],
            [
                'name' => 'Viewer Publik',
                'email' => 'viewer@gunungsari.id',
                'password' => Hash::make('password123'),
                'role' => 'viewer',
                'phone' => '081234567894',
                'address' => 'Desa Gunungsari',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}