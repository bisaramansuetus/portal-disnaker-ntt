<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidDocumentController extends Controller
{
    public function index()
    {
        $documents = PpidDocument::latest()->paginate(15);
        return view('admin.ppid.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.ppid.form', ['document' => new PpidDocument()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['file_path'] = $request->file('file')->store('ppid', 'public');
        PpidDocument::create($data);
        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function edit(PpidDocument $document)
    {
        return view('admin.ppid.form', compact('document'));
    }

    public function update(Request $request, PpidDocument $document)
    {
        $data = $this->validated($request, false);
        
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $data['file_path'] = $request->file('file')->store('ppid', 'public');
        }

        $document->update($data);
        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen diperbarui.');
    }

    public function destroy(PpidDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Dokumen dihapus.');
    }

    private function validated(Request $request, $requireFile = true): array
    {
        return $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|in:DIP,Berkala,Setiap Saat,Serta-Merta,Regulasi',
            'file' => $requireFile ? 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240' : 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);
    }
}