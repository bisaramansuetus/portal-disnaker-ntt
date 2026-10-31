<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model {
    protected $fillable = ['setting_key', 'setting_value'];

    public static function get(string $key, $default = null) {
        return static::where('setting_key', $key)->value('setting_value') ?? $default;
    }

    public static function set(string $key, $value): void {
        static::updateOrCreate(['setting_key' => $key], ['setting_value' => $value]);
    }
}