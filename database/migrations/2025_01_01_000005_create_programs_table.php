<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->enum('type', ['program', 'pelatihan', 'transmigrasi']);
            $table->longText('description');
            $table->longText('requirements');
            $table->text('schedule_info')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('quota')->nullable();
            $table->decimal('fee', 12, 2)->nullable();
            $table->string('registration_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('start_date');
        });
    }
    public function down(): void {
        Schema::dropIfExists('programs');
    }
};