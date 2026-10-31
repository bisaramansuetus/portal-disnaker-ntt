<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::active()->latest('published_at');

        if ($request->filled('q'))        $query->where('title', 'like', '%'.$request->q.'%');
        if ($request->filled('job_type')) $query->where('job_type', $request->job_type);
        if ($request->filled('location')) $query->where('location', 'like', '%'.$request->location.'%');

        $jobs = $query->paginate(9)->withQueryString();
        return view('site.jobs.index', compact('jobs'));
    }

    public function show(string $slug)
    {
        $job = JobVacancy::published()->where('slug', $slug)->firstOrFail();
        $others = JobVacancy::active()->where('id', '!=', $job->id)->latest('published_at')->take(3)->get();
        return view('site.jobs.show', compact('job', 'others'));
    }
}