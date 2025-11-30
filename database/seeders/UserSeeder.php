<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@inventaris.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Gudang',
                'email' => 'petugas@inventaris.com',
                'username' => 'petugas',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ],
            [
                'name' => 'Pimpinan',
                'email' => 'pimpinan@inventaris.com',
                'username' => 'pimpinan',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: username=admin, password=password');
        $this->command->info('Petugas: username=petugas, password=password');
        $this->command->info('Pimpinan: username=pimpinan, password=password');
    }
}