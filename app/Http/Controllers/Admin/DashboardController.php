<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobVacancy;
use App\Models\Post;
use App\Models\Program;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'posts_total' => Post::count(),
            'posts_published' => Post::published()->count(),
            'jobs_active' => JobVacancy::active()->count(),
            'jobs_total' => JobVacancy::count(),
            'programs_total' => Program::count(),
            'categories_total' => Category::count(),
        ];
        $recentPosts = Post::with('category')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}