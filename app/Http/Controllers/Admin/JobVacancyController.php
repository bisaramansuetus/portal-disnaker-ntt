<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('q')) $query->where('title', 'like', '%'.$request->q.'%');
        $jobs = $query->paginate(15)->withQueryString();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.form', [
            'job' => new JobVacancy(['status' => 'draft']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = JobVacancy::generateUniqueSlug($data['title']);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        JobVacancy::create($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan dibuat.');
    }

    public function edit(JobVacancy $job)
    {
        return view('admin.jobs.form', compact('job'));
    }

    public function update(Request $request, JobVacancy $job)
    {
        $data = $this->validated($request);
        $data['slug'] = JobVacancy::generateUniqueSlug($data['title'], $job->id);

        if ($data['status'] === 'published' && $job->status !== 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        $job->update($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan diperbarui.');
    }

    public function destroy(JobVacancy $job)
    {
        $job->delete();
        return back()->with('success', 'Lowongan dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'         => 'required|string|max:200',
            'company_name'  => 'required|string|max:150',
            'location'      => 'required|string|max:150',
            'job_type'      => 'required|string|max:50',
            'education'     => 'required|string|max:100',
            'description'   => 'required|string',
            'requirements'  => 'required|string',
            'application_url' => 'nullable|string|max:255',
            'deadline'      => 'required|date|after_or_equal:today',
            'status'        => 'required|in:draft,published',
            'is_featured'   => 'nullable|boolean',
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }
}