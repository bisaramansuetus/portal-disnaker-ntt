<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->constrained('users');
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->enum('type', ['berita', 'pengumuman', 'page'])->default('berita');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['type', 'status']);
            $table->fullText(['title', 'content']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('posts');
    }
};