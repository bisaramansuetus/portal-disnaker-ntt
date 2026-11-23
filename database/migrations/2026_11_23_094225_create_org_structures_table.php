<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('org_structures', function (Blueprint $table) {
            $table->id();
            $table->integer('year'); // Contoh: 2024, 2023
            $table->string('title')->default('Struktur Organisasi'); 
            
            // Data Kepala Dinas
            $table->string('head_name')->nullable();
            $table->string('head_photo')->nullable();
            
            // Data Sekretaris
            $table->string('secretary_name')->nullable();
            $table->string('secretary_photo')->nullable();
            
            // Bagan & Keterangan
            $table->string('chart_image')->nullable(); // Gambar bagan penuh
            $table->text('description')->nullable(); // Konten teks tambahan
            
            $table->boolean('is_active')->default(false); // Tanda untuk tahun berjalan
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('org_structures'); }
};