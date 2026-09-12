<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('galeris', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' INT AUTO_INCREMENT PRIMARY KEY
            $table->string('judul'); // Membuat kolom 'judul' VARCHAR(255)
            $table->string('foto'); // Membuat kolom 'foto' VARCHAR(255)
            $table->timestamps(); // Opsional: membuat kolom 'created_at' dan 'updated_at' otomatis
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
