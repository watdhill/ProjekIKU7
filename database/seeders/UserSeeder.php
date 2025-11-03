<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role (jika belum ada)
        $roles = ['admin', 'dosen', 'prodi', 'universitas'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        // Buat user Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@iku7.test'],
            [
                'name' => 'Admin IKU7',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
        $admin->assignRole('admin');

        // Buat user Dosen
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@iku7.test'],
            [
                'name' => 'Dosen Demo',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ]
        );
        $dosen->assignRole('dosen');

        // Buat user Prodi
        $prodi = User::firstOrCreate(
            ['email' => 'prodi@iku7.test'],
            [
                'name' => 'Prodi Demo',
                'password' => Hash::make('password123'),
            ]
        );
        $prodi->assignRole('prodi');

        // Buat user Universitas
        $univ = User::firstOrCreate(
            ['email' => 'univ@iku7.test'],
            [
                'name' => 'Rektorat Demo',
                'password' => Hash::make('password123'),
            ]
        );
        $univ->assignRole('universitas');
    }
}
