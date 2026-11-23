<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrgStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgStructureController extends Controller
{
    public function index()
    {
        $structures = OrgStructure::orderBy('year', 'desc')->paginate(10);
        return view('admin.structures.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.structures.form', ['structure' => new OrgStructure()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        
        if ($request->hasFile('head_photo')) $data['head_photo'] = $request->file('head_photo')->store('structures', 'public');
        if ($request->hasFile('secretary_photo')) $data['secretary_photo'] = $request->file('secretary_photo')->store('structures', 'public');
        if ($request->hasFile('chart_image')) $data['chart_image'] = $request->file('chart_image')->store('structures', 'public');

        OrgStructure::create($data);
        return redirect()->route('admin.structures.index')->with('success', 'Data struktur berhasil ditambahkan.');
    }

    public function edit(OrgStructure $structure)
    {
        return view('admin.structures.form', compact('structure'));
    }

    public function update(Request $request, OrgStructure $structure)
    {
        $data = $this->validated($request);

        if ($request->hasFile('head_photo')) {
            if ($structure->head_photo) Storage::disk('public')->delete($structure->head_photo);
            $data['head_photo'] = $request->file('head_photo')->store('structures', 'public');
        }
        if ($request->hasFile('secretary_photo')) {
            if ($structure->secretary_photo) Storage::disk('public')->delete($structure->secretary_photo);
            $data['secretary_photo'] = $request->file('secretary_photo')->store('structures', 'public');
        }
        if ($request->hasFile('chart_image')) {
            if ($structure->chart_image) Storage::disk('public')->delete($structure->chart_image);
            $data['chart_image'] = $request->file('chart_image')->store('structures', 'public');
        }

        $structure->update($data);
        return redirect()->route('admin.structures.index')->with('success', 'Data struktur berhasil diperbarui.');
    }

    public function destroy(OrgStructure $structure)
    {
        if ($structure->head_photo) Storage::disk('public')->delete($structure->head_photo);
        if ($structure->secretary_photo) Storage::disk('public')->delete($structure->secretary_photo);
        if ($structure->chart_image) Storage::disk('public')->delete($structure->chart_image);
        
        $structure->delete();
        return back()->with('success', 'Data struktur berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'year' => 'required|integer',
            'title' => 'required|string|max:200',
            'head_name' => 'nullable|string|max:150',
            'secretary_name' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'head_photo' => 'nullable|image|max:2048',
            'secretary_photo' => 'nullable|image|max:2048',
            'chart_image' => 'nullable|image|max:5120', // Max 5MB untuk bagan
            'is_active' => 'nullable|boolean',
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}