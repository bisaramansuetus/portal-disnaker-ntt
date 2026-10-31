<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()->where('type', 'berita')->latest('published_at')->paginate(9);
        $categories = Category::orderBy('name')->get();
        return view('site.posts.index', compact('posts', 'categories', 'categories'))
            ->with('pageTitle', 'Berita');
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