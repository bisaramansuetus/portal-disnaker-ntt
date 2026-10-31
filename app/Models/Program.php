<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Program extends Model {
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'type', 'description', 'requirements', 'schedule_info',
        'start_date', 'end_date', 'quota', 'fee', 'registration_url',
        'status', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'fee' => 'decimal:2',
    ];

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
        return $q->where('status', 'published');
    }
}