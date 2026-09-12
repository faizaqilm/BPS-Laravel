<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Karena di seeder dan migration kita pakai nama tabel 'galeris'
    protected $table = 'galeris'; 

    protected $fillable = [
        'judul',
        'foto',
    ];
}