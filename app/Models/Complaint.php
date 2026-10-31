<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model {
    protected $fillable = [
        'ticket_number', 'category_id', 'name', 'nik', 'job', 'address', 
        'phone', 'email', 'is_anonymous', 'title', 'content', 
        'photo_proof', 'status', 'rating'
    ];

    public function category() { return $this->belongsTo(ComplaintCategory::class, 'category_id'); }
    public function responses() { return $this->hasMany(ComplaintResponse::class)->latest(); }

    // Fungsi pembuat nomor tiket otomatis
    public static function generateTicketNumber() {
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        return "REQ-{$date}-{$random}";
    }
}