<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->string('company_name', 150);
            $table->string('location', 150);
            $table->string('job_type', 50);
            $table->string('education', 100);
            $table->longText('description');
            $table->longText('requirements');
            $table->string('application_url')->nullable();
            $table->date('deadline');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'deadline']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('job_vacancies');
    }
};