<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 50)->unique();
            $table->foreignId('category_id')->constrained('complaint_categories');
            $table->string('name', 150)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('job', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('title', 200);
            $table->text('content');
            $table->string('photo_proof')->nullable();
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('complaints'); }
};