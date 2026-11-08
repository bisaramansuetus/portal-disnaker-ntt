<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model {
    protected $fillable = ['title', 'category', 'file_path', 'download_count'];
}