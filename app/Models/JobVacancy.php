<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobVacancy extends Model {
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'company_name', 'location', 'job_type', 'education',
        'description', 'requirements', 'application_url', 'deadline',
        'status', 'is_featured', 'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'deadline' => 'date',
        'published_at' => 'datetime',
    ];

    public function isClosed(): bool {
        return $this->deadline->toDateString() < now()->toDateString();
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }
        return $slug;
    }

    public function scopePublished($q) {
        return $q->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeActive($q) {
        return $q->published()->whereDate('deadline', '>=', now()->toDateString());
    }
}