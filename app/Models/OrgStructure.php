<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrgStructure extends Model {
    protected $fillable = [
        'year', 'title', 'head_name', 'head_photo', 'secretary_name', 
        'secretary_photo', 'chart_image', 'description', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
}