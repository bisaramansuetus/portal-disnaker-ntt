<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ppid_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 50)->unique();
            $table->enum('type', ['permohonan', 'keberatan']);
            $table->string('name', 150);
            $table->string('nik', 20);
            $table->string('email', 150);
            $table->string('phone', 20);
            $table->text('address');
            $table->text('info_needed'); // Informasi yang dibutuhkan / alasan keberatan
            $table->text('purpose')->nullable(); // Tujuan penggunaan informasi
            $table->enum('status', ['pending', 'proses', 'selesai', 'ditolak'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ppid_requests'); }
};