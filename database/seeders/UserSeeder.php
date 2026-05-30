<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun ADMIN BUMDes  -> login: admin.bumdes / admin123
        User::create([
            'name'     => 'Suryadi',
            'username'  => 'admin.bumdes',
            'role'      => 'admin',
            'email'     => 'admin@desaibru.id',
            'password'  => Hash::make('admin123'),
        ]);

        // Akun PENGGUNA biasa -> login: user123 / password123
        User::create([
            'name'     => 'Arman',
            'username'  => 'user123',
            'role'      => 'user',
            'email'     => 'arman@desaibru.id',
            'password'  => Hash::make('password123'),
        ]);
    }
}
