<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PpidDocument;
use Illuminate\Support\Facades\Storage;

class PpidController extends Controller
{
    public function profile()
    {
        $page = Post::published()->where('type', 'page')->where('slug', 'profil-ppid')->first();
        return view('site.pages.show', ['page' => $page, 'pageTitle' => 'Profil PPID']);
    }

    public function standards()
    {
        $page = Post::published()->where('type', 'page')->where('slug', 'standar-layanan-ppid')->first();
        return view('site.pages.show', ['page' => $page, 'pageTitle' => 'Standar Layanan & Regulasi']);
    }

    public function documents()
    {
        // Mengelompokkan dokumen berdasarkan kategorinya
        $categories = ['DIP', 'Berkala', 'Setiap Saat', 'Serta-Merta', 'Regulasi'];
        $documents = PpidDocument::latest()->get()->groupBy('category');
        
        return view('site.ppid.documents', compact('categories', 'documents'));
    }

    public function download(PpidDocument $document)
    {
        $document->increment('download_count');
        $path = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path);
    }
}