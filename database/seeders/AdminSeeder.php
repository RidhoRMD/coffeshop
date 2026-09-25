<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // ganti sesuai email yang kamu mau
            [
                'name'     => 'Admin',
                'password' => 'admin123', // otomatis ke-hash karena cast 'hashed' di Model User
                'role'     => 'admin',
                'status'   => 'aktif',
            ]
        );
    }
}