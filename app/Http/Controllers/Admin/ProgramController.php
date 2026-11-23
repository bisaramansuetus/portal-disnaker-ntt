<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::latest();
        if ($request->filled('type'))   $query->where('type', $request->type);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('q'))      $query->where('title', 'like', '%'.$request->q.'%');
        $programs = $query->paginate(15)->withQueryString();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.form', [
            'program' => new Program(['status' => 'draft', 'type' => 'program']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Program::generateUniqueSlug($data['title']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        Program::create($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program dibuat.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.form', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $this->validated($request);
        $data['slug'] = Program::generateUniqueSlug($data['title'], $program->id);
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program diperbarui.');
    }

    public function destroy(Program $program)
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        $program->delete();
        return back()->with('success', 'Program dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'         => 'required|string|max:200',
            'type'          => 'required|in:program,pelatihan,transmigrasi',
            'description'   => 'required|string',
            'requirements'  => 'required|string',
            'schedule_info' => 'nullable|string|max:1000',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'quota'         => 'nullable|integer|min:0',
            'fee'           => 'nullable|numeric|min:0',
            'registration_url' => 'nullable|string|max:255',
            'status'        => 'required|in:draft,published',
            'is_featured'   => 'nullable|boolean',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }
}