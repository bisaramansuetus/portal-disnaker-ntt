<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->where('type', 'berita')->latest('published_at');

        // Fitur Pencarian
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $category = \App\Models\Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter Bulan (Format YYYY-MM)
        if ($request->filled('month')) {
            $query->whereYear('published_at', substr($request->month, 0, 4))
                  ->whereMonth('published_at', substr($request->month, 5, 2));
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return view('site.posts.index', compact('posts', 'categories'));
    }

    public function announcements()
    {
        $posts = Post::published()->where('type', 'pengumuman')->latest('published_at')->paginate(9);
        $categories = Category::orderBy('name')->get();
        return view('site.posts.index', compact('posts', 'categories'))
            ->with('pageTitle', 'Pengumuman');
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::published()->where('type', 'berita')->where('category_id', $category->id)
            ->latest('published_at')->paginate(9);
        $categories = Category::orderBy('name')->get();
        return view('site.posts.index', compact('posts', 'categories', 'category'))
            ->with('pageTitle', 'Kategori: '.$category->name);
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $related = Post::published()->where('type', $post->type)
            ->where('id', '!=', $post->id)->latest('published_at')->take(3)->get();
        return view('site.posts.show', compact('post', 'related'));
    }
}