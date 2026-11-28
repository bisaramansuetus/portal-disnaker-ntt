<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function show(string $path)
    {
        // Cek apakah file ada di folder storage/app/public
        abort_unless(Storage::disk('public')->exists($path), 404);
        
        // Tampilkan file
        return response()->file(Storage::disk('public')->path($path));
    }
}