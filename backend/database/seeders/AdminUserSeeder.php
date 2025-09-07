<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user yang ada jika sudah ada
        User::where('email', 'admin@ekinerja.com')->delete();
        User::where('email', 'user@ekinerja.com')->delete();
        
        // Buat admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ekinerja.com',
            'password' => Hash::make('password12'),
            'role' => 'admin',
            'phone' => null,
            'nip' => null,
            'golongan' => null,
            'instansi' => null,
            'ruangan' => null
        ]);

        // Buat regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@ekinerja.com',
            'password' => Hash::make('password12'),
            'role' => 'user',
            'phone' => null,
            'nip' => null,
            'golongan' => null,
            'instansi' => null,
            'ruangan' => null
        ]);
        
        echo "Users created successfully!\n";
        echo "Admin: admin@ekinerja.com / password12\n";
        echo "User: user@ekinerja.com / password12\n";
    }
}
