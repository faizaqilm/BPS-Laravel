<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('galeris')->insert([
            ['judul' => 'Sensus Penduduk', 'foto' => '1.jpg'],
            ['judul' => 'Petani Kaltara', 'foto' => '2.jpg'],
            ['judul' => 'Sosialisasi', 'foto' => '3.png'],
            ['judul' => 'Survei Lapangan', 'foto' => '4.jpg'],
            ['judul' => 'Kegiatan Internal', 'foto' => '5.jpg'],
            ['judul' => 'Gedung BPS', 'foto' => '6.jpg'],
        ]);
    }
}
