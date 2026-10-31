<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    public function index(Request $request) {
        $query = Post::with('category', 'author')->latest();

        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create() {
        return view('admin.posts.form', [
            'post' => new Post(['status' => 'draft', 'type' => 'berita']),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request) {
        $data = $this->validated($request);
        $data['author_id'] = Auth::id();
        $data['slug'] = Post::generateUniqueSlug($data['title']);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Konten dibuat.');
    }

    public function edit(Post $post) {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post) {
        $data = $this->validated($request);
        $data['slug'] = Post::generateUniqueSlug($data['title'], $post->id);

        // set published_at hanya saat transisi draft -> published
        if ($data['status'] === 'published' && $post->status !== 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            if ($post->image) Storage::disk('public')->delete($post->image);
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);
        return redirect()->route('admin.posts.index')->with('success', 'Konten diperbarui.');
    }

    public function destroy(Post $post) {
        $post->delete();
        return back()->with('success', 'Konten dihapus.');
    }

    private function validated(Request $request): array {
        return $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type' => 'required|in:berita,pengumuman,page',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }
}