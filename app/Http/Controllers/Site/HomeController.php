<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Models\Post;
use App\Models\Program;

class HomeController extends Controller
{
    public function index()
    {
        $latestBerita = Post::published()->where('type', 'berita')->latest('published_at')->take(3)->get();
        $latestPengumuman = Post::published()->where('type', 'pengumuman')->latest('published_at')->take(3)->get();
        $featuredJobs = JobVacancy::active()->latest('published_at')->take(3)->get();
        $featuredPrograms = Program::published()->latest()->take(3)->get();

        return view('site.home', compact('latestBerita', 'latestPengumuman', 'featuredJobs', 'featuredPrograms'));
    }
}