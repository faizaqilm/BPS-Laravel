<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $fillable = [
        'judul', 
        'tanggal_rilis', 
        'sampul', 
        'abstract', 
        'kategori', 
        'pdf_link', 
        'pub_id'
    ];
}