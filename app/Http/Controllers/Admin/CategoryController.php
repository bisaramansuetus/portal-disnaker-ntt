<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::withCount('posts')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request) {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(Category $category) {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }

    private function validated(Request $request): array {
        return $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);
    }
}