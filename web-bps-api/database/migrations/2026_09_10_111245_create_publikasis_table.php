<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publikasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal_rilis');
            $table->string('sampul')->nullable();
            
            // Tambahan kolom baru
            $table->text('abstract')->nullable();
            $table->string('kategori')->nullable();
            $table->text('pdf_link')->nullable();
            $table->string('pub_id')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publikasis');
    }
};