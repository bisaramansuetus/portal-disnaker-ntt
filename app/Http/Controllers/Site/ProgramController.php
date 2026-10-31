<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::published()->whereIn('type', ['program', 'pelatihan'])->latest();
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('q'))    $query->where('title', 'like', '%'.$request->q.'%');
        $programs = $query->paginate(9)->withQueryString();
        return view('site.programs.index', compact('programs'))
            ->with('pageTitle', 'Program & Pelatihan');
    }

    public function show(string $slug)
    {
        $program = Program::published()->where('slug', $slug)->firstOrFail();
        return view('site.programs.show', compact('program'));
    }

    public function transmigrasi()
    {
        $programs = Program::published()->where('type', 'transmigrasi')->latest()->paginate(9);
        return view('site.programs.index', compact('programs'))
            ->with('pageTitle', 'Transmigrasi');
    }
}