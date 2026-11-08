<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PpidRequest extends Model {
    protected $fillable = [
        'ticket_number', 'type', 'name', 'nik', 'email', 'phone', 
        'address', 'info_needed', 'purpose', 'status', 'admin_response'
    ];

    public static function generateTicketNumber($type) {
        $prefix = $type === 'permohonan' ? 'REQ-PPID' : 'OBJ-PPID';
        return $prefix . '-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
    }
}