<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ppid_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->enum('category', ['DIP', 'Berkala', 'Setiap Saat', 'Serta-Merta', 'Regulasi']);
            $table->string('file_path');
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('ppid_documents');
    }
};