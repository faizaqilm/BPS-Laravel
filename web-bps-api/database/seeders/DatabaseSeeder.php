<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Jangan lupa import Hash

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ubah bagian ini untuk menambahkan username dan password (opsional agar bisa dipakai login)
        User::factory()->create([
            'name' => 'Admin BPS',
            'username' => 'admin', // <-- Tambahkan baris ini
            'email' => 'admin@bps.go.id',
            'password' => Hash::make('password123'), // Supaya sekalian bisa dipakai testing login
        ]);

        // Opsional: Panggil GaleriSeeder jika kamu sudah membuatnya di Fase 1 tadi
        // $this->call([GaleriSeeder::class]);
    }
}